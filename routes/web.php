<?php

/*Route::get('/', 'LandingPageController@index')->name('landing-page');*/

Route::get('/', 'ShopController@index')->name('shop.index');
Route::get('/shop/{product}', 'ShopController@show')->name('shop.show');
Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/upload/{product}', 'CartController@cartstep')->name('cart.cartstep');
Route::post('/cart/{product}', 'CartController@store')->name('cart.store');
Route::patch('/cart/{product}', 'CartController@update')->name('cart.update');
Route::delete('/cart/{product}', 'CartController@destroy')->name('cart.destroy');
Route::post('/cart/switchToSaveForLater/{product}', 'CartController@switchToSaveForLater')->name('cart.switchToSaveForLater');

Route::delete('/saveForLater/{product}', 'SaveForLaterController@destroy')->name('saveForLater.destroy');
Route::post('/saveForLater/switchToCart/{product}', 'SaveForLaterController@switchToCart')->name('saveForLater.switchToCart');

Route::post('/coupon', 'CouponsController@store')->name('coupon.store');
Route::delete('/coupon', 'CouponsController@destroy')->name('coupon.destroy');

Route::get('/checkout', 'CheckoutController@index')->name('checkout.index')->middleware('auth');
Route::post('/checkout', 'CheckoutController@store')->name('checkout.store');
Route::post('/paypal-checkout', 'CheckoutController@paypalCheckout')->name('checkout.paypal');

Route::post('/checkout-Authorize', 'CheckoutController@AuthorizeCheckout')->name('checkout.Authorize');


Route::get('/guestCheckout', 'CheckoutController@index')->name('guestCheckout.index');


Route::get('/thankyou', 'ConfirmationController@index')->name('confirmation.index');



Route::get('/about-us','PagesController@Aboutus');
Route::get('/returns-and-refund','PagesController@ReturnsRefund');
Route::get('/privacy-policy','PagesController@PrivacyPolicy');
Route::get('/terms-and-conditions','PagesController@TermsConditions');

Route::get('/contact-us','PagesController@ContactUs');
Route::post('contact-us','PagesController@EnviarCorreoContactUs')->name('EmailContact');

Route::get('/work-with-us','PagesController@WorkWithUs');
Route::post('WorkEmail','PagesController@EnviarCorreoWorkWith')->name('WorkEmail');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/jsonconfig', 'ShopController@getjsonconfig')->name('jsonconfig');
Route::get('/search', 'ShopController@search')->name('search');
Route::post('/sendtocart', 'ShopController@sendtocart')->name('sendtocart');
Route::post('/shipingupdate', 'CheckoutController@updateShiping')->name('shipingupdate');
Route::post('/4overproducts', 'ShopController@call_4over_curl')->name('4overproducts');
Route::post('/computeshipping', 'ShopController@Getshipingquotes')->name('computeshipping');
Route::get('/search-algolia', 'ShopController@searchAlgolia')->name('search-algolia');

Route::get('/mailable',function(){
    $order = App\Order::find(1);
    return new App\Mail\OrderPlaced($order);
});

Route::middleware('auth')->group(function () {
    Route::get('/my-profile', 'UsersController@edit')->name('users.edit');
    Route::patch('/my-profile', 'UsersController@update')->name('users.update');

    Route::get('/my-orders', 'OrdersController@index')->name('orders.index');
    Route::get('/my-orders/{order}', 'OrdersController@show')->name('orders.show');
});
