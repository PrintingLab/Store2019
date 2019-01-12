@component('mail::message')
# Order Received

Thank you for your order.

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

**Tax: ** ${{$order->billing_tax }}

**Subtotal: ** ${{$order->billing_subtotal }}

**Pay method: ** {{$order->payment_gateway }}

**Pay method ID: ** {{$order->payment_id }}

#Order Total: ${{$order->billing_total }}#

**-Items Ordered-**

@foreach ($order->products as $product)
Product: {{ $product->name }} <br>
Description: {{ $product->pivot->product_decription }} <br>
Quantity: {{ $product->pivot->quantity }} <br>
Printed Side: {{ getPrintingsides($product->pivot->side) }} <br>
Turnaround: {{ getPrintingTime($product->pivot->tat) }} <br>
____________________________________________________________
@endforeach

You can get further details about your order by logging into our website.

@component('mail::button', ['url' => config('app.url'), 'color' => 'green'])
Go to Website
@endcomponent

Thank you again for choosing us.

@endcomponent
