<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\OrderProduct;
use App\Mail\OrderPlaced; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\CheckoutRequest;
use Gloudemans\Shoppingcart\Facades\Cart;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Cart::instance('default')->count() == 0) {
            return redirect()->route('shop.index');
        }

        if (auth()->user() && request()->is('guestCheckout')) {
            return redirect()->route('checkout.index');
        }

        $gateway = new \Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        try {
            $paypalToken = $gateway->ClientToken()->generate();
        } catch (\Exception $e) {
            $paypalToken = null;
        }

        return view('checkout')->with([
            'paypalToken' => $paypalToken,
            'discount' => getNumbers()->get('discount'),
            'newSubtotal' => getNumbers()->get('newSubtotal'),
            'newTax' => getNumbers()->get('newTax'),
            'newTotal' => getNumbers()->get('newTotal'),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutRequest $request)
    {
        // Check race condition when there are less items available to purchase
        // if ($this->productsAreNoLongerAvailable()) {
        //     return back()->withErrors('Sorry! One of the items in your cart is no longer avialble.');
        // }

  

        try {
            $charge = Stripe::charges()->create([
                'amount' => getNumbers()->get('newTotal'),
                'currency' => 'CAD',
                'source' => $request->stripeToken,
                'description' => 'Order',
                'receipt_email' => $request->email,
                'metadata' => [
                    
                    'quantity' => Cart::instance('default')->count(),
                    'discount' => collect(session()->get('coupon'))->toJson(),
                ],
            ]);

            $order = $this->addToOrdersTables($request, null);
            //Mail::send(new OrderPlaced($order));

            // decrease the quantities of all the products in the cart
            //$this->decreaseQuantities();

            Cart::instance('default')->destroy();
            session()->forget('coupon');

            return redirect()->route('confirmation.index')->with('success_message', 'Thank you! Your payment has been successfully accepted!');
        } catch (CardErrorException $e) {
            $this->addToOrdersTables($request, $e->getMessage());
            return back()->withErrors('Error! ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AuthorizeCheckout(CheckoutRequest $request)
    {

//         API LOGIN ID 
// 6J9W7nvZtm8
// TRANSACTION KEY 
// 284zmBQz6y5KF57f
// KEY 
// Simon
// Simon
        //$merchantAuthentication->setName('2E3z6KruR');
		//$merchantAuthentication->setTransactionKey('48Cy6rk4H82xD6b9');
        //production
		//$merchantAuthentication->setName('3qe3N33vB3');
		//$merchantAuthentication->setTransactionKey('6pu9mhm9Q573N8HR');
        // Common setup for API credentials
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('services.authorize.login'));
        $merchantAuthentication->setTransactionKey(config('services.authorize.key'));
        $refId = 'ref'.time();
// Create the payment data for a credit card
          $creditCard = new AnetAPI\CreditCardType();
          $creditCard->setCardNumber($request->cnumber);
          $expiry = $request->card_expiry_year . '-' . $request->card_expiry_month;
          $creditCard->setExpirationDate($expiry);
          $creditCard->setCardCode($request->ccode);
          $paymentOne = new AnetAPI\PaymentType();
          $paymentOne->setCreditCard($creditCard);
// Set the customer's Bill To address
$customerAddress = new AnetAPI\CustomerAddressType();
$customerAddress->setFirstName($request->card_name);
$customerAddress->setAddress($request->address);
$customerAddress->setCity($request->city);
$customerAddress->setState($request->province);
$customerAddress->setZip($request->postalcode);
$customerAddress->setCountry("USA");
// Create a transaction
          $transactionRequestType = new AnetAPI\TransactionRequestType();
          $transactionRequestType->setTransactionType("authCaptureTransaction");
          $transactionRequestType->setAmount(getNumbers()->get('newTotal'));
          $transactionRequestType->setPayment($paymentOne);
          $transactionRequestType->setBillTo($customerAddress);
          $Transrequest = new AnetAPI\CreateTransactionRequest();
          $Transrequest->setMerchantAuthentication($merchantAuthentication);
          $Transrequest->setRefId( $refId);
          $Transrequest->setTransactionRequest($transactionRequestType);
          $controller = new AnetController\CreateTransactionController($Transrequest);
          $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
           if ($response != null)
            {

              $tresponse = $response->getTransactionResponse();
              if (($tresponse != null) && ($tresponse->getResponseCode()=="1") || ($tresponse->getResponseCode()=="4"))
              {
                $order = $this->addToOrdersTables($request, null,$tresponse->getTransId());
        
                Mail::send(new OrderPlaced($order));
                // decrease the quantities of all the products in the cart
                //$this->decreaseQuantities();
                Cart::instance('default')->destroy();
                session()->forget('coupon');
                return redirect()->route('confirmation.index')->with('success_message', 'Thank you! Your payment has been successfully accepted!');
              }
              else
              {

                    $error =$tresponse->getErrors();
                    return back()->withErrors('An error occurred: '.$error[0]->getErrorText());  
              
               
              }
            }
            else
            {
              echo  "Charge Credit Card Null response returned";
            }
        



            //return back()->withErrors('An error occurred with the message: '.$result->message);
}



public function updateShiping(Request $request)
    {

        if (isset($request->shipingcost) && isset($request->shipingtype)) {
            foreach (Cart::content() as $item){
                $option = $item->options->merge(['shiping' => $request->shipingcost,'shipingTp' => $request->shipingtype]);
                Cart::update($item->rowId, ['options' => $option]);
                
            }
        }
       
        return response()->json(['zuccess' => Cart::content(),'Total'=>getNumbers()->get('newTotal'),'Tax'=>getNumbers()->get('newTax'),'NewSubtotal'=>getNumbers()->get('newSubtotal'),'shiping'=>getNumbers()->get('shiping'),'tax'=>getNumbers()->get('tax')]);
        
    }

    public function paypalCheckout(Request $request)
    {
        // Check race condition when there are less items available to purchase
        // if ($this->productsAreNoLongerAvailable()) {
        //     return back()->withErrors('Sorry! One of the items in your cart is no longer avialble.');
        // }

        $gateway = new \Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey')
        ]);

        $nonce = $request->payment_method_nonce;

        $result = $gateway->transaction()->sale([
            'amount' => number_format(getNumbers()->get('newTotal'),2, '.', ''),
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);
        $transaction = $result->transaction;

        if ($result->success) {
            $order = $this->addToOrdersTablesPaypal(
                $transaction->paypal['payerEmail'],
                $transaction->paypal['payerFirstName'].' '.$transaction->paypal['payerLastName'],
                null,
                $request,
                $transaction->paypal['paymentId']
            );
            
            Mail::send(new OrderPlaced($order));
            // decrease the quantities of all the products in the cart
            //$this->decreaseQuantities();

            Cart::instance('default')->destroy();
            session()->forget('coupon');

            return redirect()->route('confirmation.index')->with('success_message', 'Thank you! Your payment has been successfully accepted!');
        } else {
           
            $order = $this->addToOrdersTablesPaypal(
                $transaction->paypal['payerEmail'],
                $transaction->paypal['payerFirstName'].' '.$transaction->paypal['payerLastName'],
                $result->message,
                $request,
                $transaction->paypal['paymentId']
            );

            return back()->withErrors('An error occurred with the message: '.$result->message);
        }
    }

    protected function addToOrdersTables($request, $error,$TransId)
    {
        // Insert into orders table
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_province' => $request->province,
            'billing_postalcode' => $request->postalcode,
            'billing_phone' => $request->phone,
            'billing_name_on_card' => $request->name_on_card,
            'shipping_Type' => $request->Shippingmethod,
            'shipping_Value' => getNumbers()->get('shiping'),
            'billing_discount' => getNumbers()->get('discount'),
            'billing_discount_code' => getNumbers()->get('code'),
            'billing_subtotal' => getNumbers()->get('newSubtotal'),
            'billing_tax' => getNumbers()->get('newTax'),
            'billing_total' => getNumbers()->get('newTotal'),
            'error' => $error,
            'payment_gateway' => 'Credit card',
            'payment_id' => $TransId,
        ]);

        // Insert into order_product table
        foreach (Cart::content() as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'product_decription' => $item->options->decription,
                'quantity' => $item->options->quantity,
                'colorspecuuid' => $item->options->colorspecuuid,
                'imgF' => $item->options->imgF,
                'imgB' => $item->options->imgB,
                'optionuuid' => $item->options->optionuuid,
                'produtcode' => $item->options->produtcode,
                'produtid' => $item->options->produtid,
                'runsizeuuid' => $item->options->runsizeuuid,
                'side' => $item->options->side,
                'tat' => $item->options->tat,
                'Proofing' => $item->options->ProofingOption,
                'comment' => $item->options->coment,
                'Optionstring' => $item->options->optionstring,
            ]);
        }

        return $order;
    }

    protected function addToOrdersTablesPaypal($email, $name, $error,$request,$paytId)
    {
        // Insert into orders table
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'billing_email' => $email,
            'billing_name' => $name,
            'billing_address' => $request->address,
            'billing_city' => $request->city,
            'billing_province' => $request->province,
            'billing_postalcode' => $request->postalcode,
            'billing_phone' => $request->phone,
            'shipping_Type' => $request->Shippingmethod,
            'shipping_Value' => getNumbers()->get('shiping'),
            'billing_discount' => getNumbers()->get('discount'),
            'billing_discount_code' => getNumbers()->get('code'),
            'billing_subtotal' => getNumbers()->get('newSubtotal'),
            'billing_tax' => getNumbers()->get('newTax'),
            'billing_total' => getNumbers()->get('newTotal'),
            'error' => $error,
            'payment_gateway' => 'paypal',
            'payment_id' => $paytId,
        ]);

        // Insert into order_product table
        foreach (Cart::content() as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'product_decription' => $item->options->decription,
                'quantity' => $item->options->quantity,
                'colorspecuuid' => $item->options->colorspecuuid,
                'imgF' => $item->options->imgF,
                'imgB' => $item->options->imgB,
                'optionuuid' => $item->options->optionuuid,
                'produtcode' => $item->options->produtcode,
                'produtid' => $item->options->produtid,
                'runsizeuuid' => $item->options->runsizeuuid,
                'side' => $item->options->side,
                'tat' => $item->options->tat,
                'Proofing' => $item->options->ProofingOption,
                'comment' => $item->options->coment,
                'Optionstring' => $item->options->optionstring,
            ]);
        }

        return $order;
    }

    protected function decreaseQuantities()
    {
        foreach (Cart::content() as $item) {
            $product = Product::find($item->id);
            $product->update(['quantity' => $product->quantity - $item->options->quantity]);
        }
    }

    // protected function productsAreNoLongerAvailable()
    // {
    //     foreach (Cart::content() as $item) {
    //         $product = Product::find($item->model->id);
    //         if ($product->quantity < $item->qty) {
    //             return true;
    //         }
    //     }

    //     return false;
    // }
}
