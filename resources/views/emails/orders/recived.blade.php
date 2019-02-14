@component('mail::message')
# Order Received

New order recived from printinglab.com.

#Order ID: {{ $order->id }}#

**Customer Email: ** {{ $order->billing_email }} 

**Customer Name: ** {{ $order->billing_name }}

**Customer  phone: ** {{$order->billing_phone }}


**Shipping  address: **
{{$order->billing_address }},
{{$order->billing_city }}, {{$order->billing_province }}
{{$order->billing_postalcode }}  

**Shipping  method: ** {{$order->shipping_Type }}

**Shipping: ** ${{$order->shipping_Value }}

**Tax: ** {{presentPrice($order->billing_tax)}}

**Subtotal: ** ${{$order->billing_subtotal }}

**Pay method: ** {{$order->payment_gateway }}

**Pay method ID: ** {{$order->payment_id }}

#Order Total: {{presentPrice($order->billing_total)}}#

**-Items Ordered-**
@foreach ($order->products as $product)
<P>
@foreach (json_decode($product->pivot->Optionstring, true) as $key)
    @if(isset($key['id']))
    {{Changeoptioname($key['option'])}}: {{Changeoptioname($key['name'])}}<br>
    @endif
 @endforeach
 Proofing:  {{$product->pivot->Proofing}}<br>
 Job: {{getdesignemode($product->pivot->jobtype)}} <br>
 </p>
<div>
    <a href="http://printinglab.com/img/Userfiles/{{$product->pivot->imgF}}" download>Download File Front > </a><br>
     @if ($product->pivot->side == '4/4' )
    <a href="http://printinglab.com/img/Userfiles/{{$product->pivot->imgB}}" download>Download File Back ></a>
   @endif
</div>
____________________________________________________________
@endforeach

You can get further details about your order by logging into our website.

@component('mail::button', ['url' => config('app.url'), 'color' => 'green'])
Go to Website
@endcomponent

Thank you again for choosing us.

@endcomponent
