<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\OrderProduct;
use App\Mail\OrderPlaced;
use App\Mail\OrderRecived;
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
            return view('thankyou')->with([
                'success_message' => 'Thank you! Your payment has been successfully accepted!',
                'successID' => $order->id,
            ]);
           // return redirect()->route('confirmation.index')->with('success_message', 'Thank you! Your payment has been successfully accepted!');
        } catch (CardErrorException $e) {
            $this->addToOrdersTables($request, $e->getMessage());
            return back()->withErrors('Error! ' . $e->getMessage());
        }
    }

    public function AuthorizeauthOnly(Request $request)
    {
   
        //return response()->json(['success'=>$request->card_expiry_month]);
        $mode=config('services.authorize.mode');
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
          $customerAddress = new AnetAPI\CustomerAddressType();
          $customerAddress->setFirstName($request->card_name);
          $customerAddress->setAddress($request->address);
          $customerAddress->setCity($request->city);
          $customerAddress->setState($request->province);
          $customerAddress->setZip($request->postalcode);
          $customerAddress->setCountry("USA");
          // Create a transaction
          $transactionRequestType = new AnetAPI\TransactionRequestType();
          $transactionRequestType->setTransactionType("authOnlyTransaction");
          $transactionRequestType->setAmount(getNumbers()->get('newTotal'));
          $transactionRequestType->setPayment($paymentOne);
          $transactionRequestType->setBillTo($customerAddress);
          $request = new AnetAPI\CreateTransactionRequest();
          $request->setMerchantAuthentication($merchantAuthentication);
          $request->setRefId( $refId);
          $request->setTransactionRequest($transactionRequestType);
          $controller = new AnetController\CreateTransactionController($request);
          if ($mode=='SANDBOX') {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
          }
          if ($mode=='PRODUCTION') {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
          }
          if ($response != null) {
            // Set the customer's Bill To address
			if ($response->getMessages()->getResultCode() == "Ok") {
				$tresponse = $response->getTransactionResponse();

				if ($tresponse != null && $tresponse->getMessages() != null) {
					$array = array(
						"ReferenceCode" => $response->getrefId(),
						"ResultCode" => $response->getMessages()->getResultCode(),
						"getResponseCode" => $tresponse->getResponseCode(),
						"getAuthCode" => $tresponse->getAuthCode(),
						"getTransId" => $tresponse->getTransId(),
						"getCode" => $tresponse->getMessages()[0]->getCode(),
						"getDescription" => $tresponse->getMessages()[0]->getDescription(),
					);
					return response()->json(['success'=>$array]);

				} else {
					if ($tresponse->getErrors() != null) {
						$array = array(
							"ResultCode" => $response->getMessages()->getResultCode(),
							"Result" => 'Transaction Failed',
							"Errorcode" => $tresponse->getErrors()[0]->getErrorCode(),
							"Errormessage" => $tresponse->getErrors()[0]->getErrorText(),
						);
						return response()->json(['success'=>$array]);
					}
				}
			} else {
				$tresponse = $response->getTransactionResponse();
				if ($tresponse != null && $tresponse->getErrors() != null) {
					$array = array(
						"ResultCode" => $response->getMessages()->getResultCode(),
						"Result" => 'Transaction Failed',
						"Errorcode" => $tresponse->getErrors()[0]->getErrorCode(),
						"Errormessage" => $tresponse->getErrors()[0]->getErrorText(),
					);
					return response()->json(['success'=>$array]);
				} else {
					$array = array(
						"ResultCode" => $response->getMessages()->getResultCode(),
						"Result" => 'Transaction Failed',
						"Errorcode" => 'Transaction Failed',
						"Errormessage" => 'Transaction Failed',
					);
					return response()->json(['success'=>$array]);
				}
			}
		} else {
			return response()->json(['success'=>'No response returned']);
		}
    }



    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AuthorizeCheckout(Request $request)
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
        $mode=config('services.authorize.mode');
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $refId = 'ref'.time();
        $merchantAuthentication->setName(config('services.authorize.login'));
        $merchantAuthentication->setTransactionKey(config('services.authorize.key'));
          $transactionRequestType = new AnetAPI\TransactionRequestType();
          $transactionRequestType->setTransactionType("priorAuthCaptureTransaction");
          $transactionRequestType->setRefTransId($request->ID);
          $Transrequest = new AnetAPI\CreateTransactionRequest();
          $Transrequest->setMerchantAuthentication($merchantAuthentication);
          $Transrequest->setRefId( $refId);
          $Transrequest->setTransactionRequest($transactionRequestType);
          $controller = new AnetController\CreateTransactionController($Transrequest);
          if ($mode=='SANDBOX') {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
          }
          if ($mode=='PRODUCTION') {
            $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
          }
          
           if ($response != null)
            {

              $tresponse = $response->getTransactionResponse();
              if (($tresponse != null) && ($tresponse->getResponseCode()=="1") || ($tresponse->getResponseCode()=="4"))
              {
                $order = $this->addToOrdersTables($request, null,$tresponse->getTransId());
        
                Mail::send(new OrderPlaced($order));
                Mail::send(new OrderRecived($order));
                // decrease the quantities of all the products in the cart
                //$this->decreaseQuantities();
                Cart::instance('default')->destroy();
                session()->forget('coupon');
                return view('thankyou')->with([
                    'success_message' => 'Thank you! Your payment has been successfully accepted!',
                    'successID' => $order->id,
                ]);
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


public function CashCheckout(Request $request)
    {
      //  dd($request);
              if ($request)
              {
                $order = $this->addToOrdersTablesCashpay(
                    $request->email,
                    $request->name,
                    null,
                    $request
                );
               // dd($order->id);      
                Mail::send(new OrderPlaced($order));
                Mail::send(new OrderRecived($order));
    
                Cart::instance('default')->destroy();
                session()->forget('coupon');
               return view('thankyou')->with([
                'success_message' => 'Thank you! Your payment has been successfully accepted!',
                'successID' => $order->id,
            ]);
              }
              else
              {
                    $error =$tresponse->getErrors();
                    return back()->withErrors('An error occurred: '.$error[0]->getErrorText());
              }
            
         
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
       // dd($request->nonce);
        // Check race condition when there are less items available to purchase
        // if ($this->productsAreNoLongerAvailable()) {
        //     return back()->withErrors('Sorry! One of the items in your cart is no longer avialble.');
        // }

        // $gateway = new \Braintree\Gateway([
        //     'environment' => config('services.braintree.environment'),
        //     'merchantId' => config('services.braintree.merchantId'),
        //     'publicKey' => config('services.braintree.publicKey'),
        //     'privateKey' => config('services.braintree.privateKey')
        // ]);

        // $nonce = $request->payment_method_nonce;

        // $result = $gateway->transaction()->sale([
        //     'amount' => number_format(getNumbers()->get('newTotal'),2, '.', ''),
        //     'paymentMethodNonce' => $nonce,
        //     'options' => [
        //         'submitForSettlement' => true
        //     ]
        // ]);
        // $transaction = $result->transaction;
            $order = $this->addToOrdersTablesPaypal(
                $request->email,
                $request->name,
                null,
                $request
            );      
            Mail::send(new OrderPlaced($order));
            Mail::send(new OrderRecived($order));
            // decrease the quantities of all the products in the cart
            //$this->decreaseQuantities();

            Cart::instance('default')->destroy();
            session()->forget('coupon');
            
            return view('thankyou')->with([
                'success_message' => 'Thank you! Your payment has been successfully accepted!',
                'successID' => $order->id,
            ]);
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
            'billing_name_on_card' => $request->card_name,
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
                'price' => $item->price,
                'jobtype' => $item->options->typeitem,
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

    protected function addToOrdersTablesPaypal($email, $name, $error,$request)
    {
        // Insert into orders table
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billing_name_on_card' => $name,
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
            'payment_id' =>  $request->payment_method_nonce,
        ]);

        // Insert into order_product table
        foreach (Cart::content() as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'price' => $item->price,
                'jobtype' => $item->options->typeitem,
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


    protected function addToOrdersTablesCashpay($email, $name, $error,$request)
    {
        // Insert into orders table
        $order = Order::create([
            'user_id' => auth()->user() ? auth()->user()->id : null,
            'billing_email' => $request->email,
            'billing_name' => $request->name,
            'billing_name_on_card' => $name,
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
            'payment_gateway' => 'Cash Payment',
            'payment_id' =>  $request->payment_method_nonce,
        ]);

        // Insert into order_product table
        foreach (Cart::content() as $item) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $item->id,
                'price' => $item->price,
                'jobtype' => $item->options->typeitem,
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







// sftpkey
// 5npUGT2vozn9




// Generating public/private rsa key pair.
// Enter passphrase (empty for no passphrase): 
// Enter same passphrase again: 
// Your identification has been saved in /home1/printinglab/.ssh/sftpkey.
// Your public key has been saved in /home1/printinglab/.ssh/sftpkey.pub.
// The key fingerprint is:
// 6d:dd:ac:45:e0:de:66:32:1a:4a:36:c6:97:6e:a5:92 
// The key's randomart image is:
// +--[ RSA 2048]----+
// |            .    |
// |           . .   |
// |            . .  |
// |       . . + =   |
// |        S * * B  |
// |       + B = B   |
// |        E = .    |
// |         o       |
// |                 |
// +-----------------+





// -----BEGIN RSA PRIVATE KEY-----
// Proc-Type: 4,ENCRYPTED
// DEK-Info: DES-EDE3-CBC,DE68D431A50305AD

// z4GXJRHrdRMPYQKVByxAwJIsHoGBGkcKPU3KZ6Ea++moVF31+Qlr9Q6DDplpw0gq
// cxhdCFFcYQTPra0ZGhThB/hRPJ+ok1WDrL5psInG1qzr4yx8KP0KZOReyF8vucpE
// ljJ9FF/7oFVNhy2jolKaejqWwAz+b1htkA1ARU5MgaRgZOoqD0j/OWK8ctUvWBUd
// xth35pKqcMnFH1gTw7K/Ur3UbtnVN2cw+fktsxSAGzY4M2qGMrcJE3KPwiy7yszE
// WA0WOy8mg3Uu1aAYJ5ENiJ+jJ7dllPbPRtwq6My+OcXwgDtLJpOAPE615r/Q7dv5
// 0dpcF3QsYk34NHGogeum0nV/GoTvYy287QFbdFktOksMUzH3TnsQVgBMkaZFW3CS
// EEfZSfbGBCkG3xTvnOmyi3IAp7H4R2Z+2Iwz0qfNL30SE9TBnzC00X6BuV709qdB
// 3LOSNXJoquzHF92ZfA1Fu89ZVWHWxeJ6tzkSxusA7PlKPU23aQrw4PVCQPodNAVq
// 4wkMW51eHODFa3io0/x6LIvHFOQyusM+JbexG0+8juczGxbbJzGzGk5ikNUtOinh
// +y2MTGpT0PTmLcUg8Wgl2kjhw6epiuxygICSAviRJO4CyPupqxFtOB17Byb1lTe4
// gj79eG0o08V5d25ccIvVG0zzPVciU86JN4gd7dLvF4przyqsKF/1XWYnsbN+oVS6
// hJEplhfL7quD7mle4i8oNBS7bCX4MsPXPH0G/H6v2WHkHvp1GCPBIFqEGs6QiXCG
// I9VInXolXVBxQt6Xk3jpGBhznfPRpSxvE9sZmKVs6SXAWCqEaqnmvB6DYJ0lYklk
// tvPnoyLpEi4VNI+XvxHReFXl7NT7CCUM1yd38jvq+H3fKYKiMStHS8XaWez3eh+k
// sJK+Q7n7zQohfIhtZ/bJ/tJqH1F58gon2YRKOqm0xIA+xTJEi0HDq2Mx61imUzoZ
// gq2b9jQPjU+bXxQq/dGejoWm0eSe5akOwoDBK/JDQGQEcTi4fx4Exnng2w+SmySY
// gxspCfpYG45DhId82hZyCsbvNjR3y/yqWD1KdOFnzJyYWUfOLAm1vKsTfB+SvrUM
// 7Bu6ur+XOA1SVY+7n95q79y6NOTSbs9oxu5yYnorg2MikXHInwU/iLBAGSm7FSId
// rFhjNzlrdN3QlZlBi+msZj4Db+taYHToXJZZlei6DRZNLpT1RNMCI55DnD3IQ3zW
// iEu2a1TLcdJRPOHiAuZNB5HvYeXH1s4tzFZqZr9HYovsZ2CMk8RsqZQVFEVjS4b3
// PwmY+09aPG5KTQYpkGZ0soTpolGEA2zXTcai21+ILBP30I3mfaX0ixDUyMJJmhVH
// 1fN2dij77atTiTmHI3GZlcj8WNlnglkq3jALAlCzHc0B7fXk+XPYxkRTats+0i2M
// 27cg85t0Y39YkK85PsO2svs0ms6RNjBGnfZYoULCMxbFEPMiz+xDoF7e9ZXEiUZM
// M5/iwVxvRriiuAww3EFqDJSYtRjZ0PS8L8M4Q3vyrzRKV9S/boiWVj6q8scm1zow
// OpCGhVcJLGpGUQGdJ2M6gRpacnUTU/lL6eZMMpQxNfoqsa7J2WscbA==
// -----END RSA PRIVATE KEY-----