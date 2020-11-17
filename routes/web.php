<?php

use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::redirect('/','/ar/home/1');

Route::get('/test123' , function(){
    $basic  = new \Nexmo\Client\Credentials\Basic('1b880773', 'l7xalNKqR1V56NyD');
    $client = new \Nexmo\Client($basic);

    $message = $client->message()->send([
        'to' => '201092953276',
        'from' => 'Vonage APffffIs',
        'text' => 'Hello from Vonage SMS API'
    ]);
});





Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');

Route::group(['prefix'=> '{lang}'], function(){

    Auth::routes();


    Route::get('/nexmo', 'NexmoController@show')->name('nexmo');
    Route::post('/nexmo', 'NexmoController@verify')->name('nexmo');


    Route::get('email/verify/{country}', 'Auth\VerificationController@show')->name('verification.notice');
    Route::get('email/resend/{country}', 'Auth\VerificationController@resend')->name('verification.resend');


    Route::get('/home/{country}', 'HomeController@index')->name('home');
    Route::get('/learning_systems/{learning_system}/{country}', 'LearningSystemsController@index')->name('learning_systems');
    Route::get('/ed_classes/{ed_class}/{country}', 'EdClassesController@index')->name('ed_classes');
    Route::get('/courses/{course}/{country}', 'CoursesController@index')->name('courses');
    Route::get('/lessons/{lesson}/{country}', 'LessonsController@index')->name('lessons');
    Route::get('/library/{country}', 'LibraryController@index')->name('library');
    Route::get('/library/{category}/products/{country}', 'LibraryController@products')->name('library.products');
    Route::get('/cart/{user}/{country}', 'CartController@index')->name('cart')->middleware('auth');
    Route::get('/cart/{user}/product/{product}/', 'CartController@add')->name('cart.add')->middleware('auth');
    Route::get('/cart/{user}/product/{product}/{country}', 'CartController@remove')->name('cart.remove')->middleware('auth');

    Route::post('/order/{user}/add-order/{country}', 'OrderController@add')->name('order.adding');
    Route::get('/addresses/{user}/{country}', 'AddressesController@index')->name('addresses');
    Route::get('/addresses/{user}/edit/{address}/{country}', 'AddressesController@edit')->name('user.addresses.edit');
    Route::get('/addresses/{user}/address/{address}/{country}', 'AddressesController@destroy')->name('user.addresses.destroy');

    Route::get('/addresses/create-address/{user}/{country}', 'AddressesController@create')->name('user.addresses.create');

    Route::post('/address/{user}/store/{country}/', 'AddressesController@store')->name('addresses.store.user');

    Route::post('/addresses/{user}/{address}/{country}', 'AddressesController@update')->name('user.addresses.update');

    Route::get('/my-orders/{user}/{country}', 'MyOrdersController@index')->name('my-orders');
    Route::get('/my-orders/order/{order}/{country}', 'MyOrdersController@products')->name('my-orders.products');













    // ->middleware('verified')

    // Route::get('/', function () {
    //     return view('welcome');
    // })->name('/'); // naming the route for localization









});











// Route::get('/{locale}', function ($locale) {
//     if (! in_array($locale, ['en', 'ar'])) {
//         abort(400);
//     }

//     App::setLocale($locale);
//     //dd(App::getLocale());
//      return view('welcome');
//     //
// });
