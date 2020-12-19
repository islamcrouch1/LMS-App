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

// Route::get('/test123' , function(){
//     $basic  = new \Nexmo\Client\Credentials\Basic('1b880773', 'l7xalNKqR1V56NyD');
//     $client = new \Nexmo\Client($basic);

//     $message = $client->message()->send([
//         'to' => '201092953276',
//         'from' => 'Vonage APffffIs',
//         'text' => 'Hello from Vonage SMS API'
//     ]);
// });





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
    Route::get('/lessons/{lesson}/{country}', 'LessonsController@index')->name('lessons')->middleware('auth')->middleware('verifiedphone');

    Route::get('/lessons/watched/{user}/{country}', 'LessonsController@lessonWatched')->name('lessons.watch')->middleware('auth')->middleware('verifiedphone');


    Route::get('/library/{country}', 'LibraryController@index')->name('library');

    Route::get('/news/{country}', 'NewsController@index')->name('news');
    Route::get('/news-show/{post}/{country}', 'NewsController@post')->name('news.show');


    Route::get('/library/{category}/products/{country}', 'LibraryController@products')->name('library.products');
    Route::get('/cart/{user}/{country}', 'CartController@index')->name('cart')->middleware('auth')->middleware('verifiedphone');
    Route::get('/cart/{user}/product/{product}/', 'CartController@add')->name('cart.add')->middleware('auth')->middleware('verifiedphone');
    Route::get('/cart/{user}/product/{product}/{country}', 'CartController@remove')->name('cart.remove')->middleware('auth')->middleware('verifiedphone');

    Route::post('/order/{user}/add-order/{country}', 'OrderController@add')->name('order.adding')->middleware('auth')->middleware('verifiedphone');
    Route::get('/success-order-library/{user}/{country}', 'OrderController@PaymentSuccess')->name('success-order-library')->middleware('auth')->middleware('verifiedphone');
    Route::get('/error-order-library/{user}/{country}', 'OrderController@PaymentError')->name('error-order-library')->middleware('auth')->middleware('verifiedphone');
    Route::get('/addresses/{user}/{country}', 'AddressesController@index')->name('addresses')->middleware('auth')->middleware('verifiedphone');
    Route::get('/addresses/{user}/edit/{address}/{country}', 'AddressesController@edit')->name('user.addresses.edit')->middleware('auth')->middleware('verifiedphone');
    Route::get('/addresses/{user}/address/{address}/{country}', 'AddressesController@destroy')->name('user.addresses.destroy')->middleware('auth')->middleware('verifiedphone');

    Route::get('/addresses/create-address/{user}/{country}', 'AddressesController@create')->name('user.addresses.create')->middleware('auth')->middleware('verifiedphone');

    Route::post('/address/{user}/store/{country}/', 'AddressesController@store')->name('addresses.store.user')->middleware('auth')->middleware('verifiedphone');

    Route::post('/addresses/{user}/{address}/{country}', 'AddressesController@update')->name('user.addresses.update')->middleware('auth')->middleware('verifiedphone');

    Route::get('/my-orders/{user}/{country}', 'MyOrdersController@index')->name('my-orders')->middleware('auth')->middleware('verifiedphone');
    Route::get('/my-orders/order/{order}/{country}', 'MyOrdersController@products')->name('my-orders.products')->middleware('auth')->middleware('verifiedphone');

    Route::get('/profile/{user}/{country}', 'ProfileController@index')->name('profile')->middleware('auth')->middleware('verifiedphone');
    Route::post('/profile/{user}/{country}', 'ProfileController@saveCourses')->name('profile.courses')->middleware('auth')->middleware('verifiedphone');
    Route::get('/profile/activate/{user}/{country}', 'ProfileController@activate')->name('profile.activate')->middleware('auth')->middleware('verifiedphone');
    Route::get('/profile/deactivate/{user}/{country}', 'ProfileController@deactivate')->name('profile.deactivate')->middleware('auth')->middleware('verifiedphone');
    Route::post('/profile/info/{user}/{country}', 'ProfileController@saveInfo')->name('profile.info')->middleware('auth')->middleware('verifiedphone');
    Route::post('/profile/video/{user}/{country}', 'ProfileController@saveVideo')->name('profile.video')->middleware('auth')->middleware('verifiedphone');
    Route::get('/profile/{teacher}', 'ProfileController@show')->name('profile.show')->middleware('auth')->middleware('verifiedphone');
    Route::post('/profile/image/{user}/{country}', 'ProfileController@imageSave')->name('profile.image')->middleware('auth')->middleware('verifiedphone');
    Route::post('/profile/update/{user}/{country}', 'ProfileController@profileUpdate')->name('profile.update')->middleware('auth')->middleware('verifiedphone');





    Route::get('/teachers/{country}', 'TeachersController@index')->name('teachers');

    Route::get('/password-reset-request/{country}', 'PasswordResetController@index')->name('password.reset.request');
    Route::post('/password-reset-verify/{country}', 'PasswordResetController@verify')->name('password.reset.verify');
    Route::post('/password-reset-change/{country}', 'PasswordResetController@change')->name('password.reset.change');
    Route::get('/password-reset-confirm-show/{country}', 'PasswordResetController@show')->name('password.reset.confirm.show');
    Route::get('/password-reset-resend/{country}', 'PasswordResetController@resend')->name('resend.code.password');
    Route::post('/password-reset-confirm-password/{country}', 'PasswordResetController@confirm')->name('password.reset.confirm.password');




    Route::get('/teachers/{course}/{country}', 'TeachersController@courseTeachers')->name('teachers.course');
    Route::get('/teacher/{user}/{country}', 'TeachersController@teacherShow')->name('teachers.display')->middleware('auth')->middleware('verifiedphone');
    Route::post('/homework-order/{user}/{country}', 'TeachersController@addOrder')->name('homework-order')->middleware('auth')->middleware('verifiedphone');

    Route::get('/success-order/{user}/{country}', 'TeachersController@PaymentSuccess')->name('success-order')->middleware('auth')->middleware('verifiedphone');
    Route::get('/error-order/{user}/{country}', 'TeachersController@PaymentError')->name('error-order')->middleware('auth')->middleware('verifiedphone');


    Route::get('/course-order/{user}/{country}', 'CourseOrdersController@addOrder')->name('course-order')->middleware('auth')->middleware('verifiedphone');
    Route::get('/success-order-course/{user}/{country}', 'CourseOrdersController@PaymentSuccess')->name('success-order-course')->middleware('auth')->middleware('verifiedphone');
    Route::get('/error-order-course/{user}/{country}', 'CourseOrdersController@PaymentError')->name('error-order-course')->middleware('auth')->middleware('verifiedphone');

    Route::get('/homework/{user}/{country}', 'HomeWorkController@index')->name('homework')->middleware('auth')->middleware('verifiedphone');
    Route::get('/my-courses/{user}/{country}', 'MyCoursesController@index')->name('my-courses')->middleware('auth')->middleware('verifiedphone');

    Route::get('/homework-request/{user}/{country}', 'HomeWorkController@createRequest')->name('homework-request')->middleware('auth')->middleware('verifiedphone');
    Route::post('/homework-create/{user}/{country}', 'HomeWorkController@storeRequest')->name('homework-create')->middleware('auth')->middleware('verifiedphone');
    Route::post('/homework-update/{user}/{country}', 'HomeWorkController@updateRequest')->name('homework-update')->middleware('auth')->middleware('verifiedphone');
    Route::get('/homework-edit/{user}/{country}', 'HomeWorkController@editRequest')->name('homework-edit')->middleware('auth')->middleware('verifiedphone');
    Route::get('/homework/show-solution/{user}/{country}', 'HomeWorkController@showSolution')->name('homework-show')->middleware('auth')->middleware('verifiedphone');
    Route::post('/homework/send-comment/{user}/{country}', 'HomeWorkController@sendComment')->name('homework-comment-send')->middleware('auth')->middleware('verifiedphone');
    Route::post('/homework/rating/{user}/{country}', 'HomeWorkController@rating')->name('homework-rating')->middleware('auth')->middleware('verifiedphone');



    Route::get('/finances/{user}/{country}', 'FinancesController@index')->name('finances')->middleware('auth')->middleware('verifiedphone');
    Route::post('/finances/bankinformation/{user}/{country}', 'FinancesController@bankInformation')->name('finances.bankinformation')->middleware('auth')->middleware('verifiedphone');
    Route::post('/finances/withdraw/{user}/{country}', 'FinancesController@withdraw')->name('finances.withdraw')->middleware('auth')->middleware('verifiedphone');


    Route::get('/teacher/homework/{user}/{country}', 'TeacherHomeWorkController@index')->name('teacher.homework')->middleware('auth')->middleware('verifiedphone');
    Route::get('/teacher/interact-homework/{user}/{country}', 'TeacherHomeWorkController@interact')->name('teacher.interact')->middleware('auth')->middleware('verifiedphone');

    Route::post('/teacher/status-homework/{user}/{country}', 'TeacherHomeWorkController@status')->name('teacher.status')->middleware('auth')->middleware('verifiedphone');
    Route::get('/teacher/recieve-homework/{user}/{country}', 'TeacherHomeWorkController@recieve')->name('teacher.recieve')->middleware('auth')->middleware('verifiedphone');

    Route::post('/teacher/fav/{user}/{country}', 'TeacherHomeWorkController@toggle_favorite')->name('teacher.fav')->middleware('auth')->middleware('verifiedphone');
    Route::get('/user/fav/{user}/{country}', 'TeacherHomeWorkController@show_favorite')->name('teacher.favShow')->middleware('auth')->middleware('verifiedphone');

    Route::post('/teacher/update-homework/{user}/{country}', 'TeacherHomeWorkController@update')->name('teacher.update')->middleware('auth')->middleware('verifiedphone');

    Route::get('/report/{user}/{country}', 'ReportController@create')->name('report')->middleware('auth')->middleware('verifiedphone');
    Route::post('/report/store/{user}/{country}', 'ReportController@store')->name('report.store')->middleware('auth')->middleware('verifiedphone');
    Route::get('/report-done/{user}/{country}', 'ReportController@index')->name('report-done')->middleware('auth')->middleware('verifiedphone');

    Route::get('/notification-change/{user}/{country}', 'NotificationController@changeStatus')->name('notification-change')->middleware('auth')->middleware('verifiedphone');


    Route::get('/exam/questions/{user}/{country}', 'ExamController@index')->name('exam.questions')->middleware('auth')->middleware('verifiedphone');

    Route::post('/exam/result/save/{user}/{country}', 'ExamController@saveResult')->name('exam.save')->middleware('auth')->middleware('verifiedphone');
    Route::get('/exam/result/{user}/{country}', 'ExamController@showResult')->name('exam.show')->middleware('auth')->middleware('verifiedphone');


    Route::get('/resend-code/{user}/{country}', 'PhoneVerificationController@resend')->name('resend-code')->middleware('auth');

    Route::get('phone/verify/{country}', 'PhoneVerificationController@show')->name('phoneverification.notice');
    Route::post('phone/verify/{country}', 'PhoneVerificationController@verify')->name('phoneverification.verify');








    // ->middleware('verified')

    // Route::get('/', function () {
    //     return view('welcome');
    // })->name('/'); // naming the route for localization




    // middleware('auth')->

    // ->middleware('verifiedphone')


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
