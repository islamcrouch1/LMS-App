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

Route::group(['prefix'=> '{lang}'], function(){

    Auth::routes();



    Route::get('/home/{country}', 'HomeController@index')->name('home');
    Route::get('/learning_systems/{learning_system}/{country}', 'LearningSystemsController@index')->name('learning_systems');
    Route::get('/ed_classes/{ed_class}/{country}', 'EdClassesController@index')->name('ed_classes');
    Route::get('/courses/{course}/{country}', 'CoursesController@index')->name('courses');
    Route::get('/lessons/{lesson}/{country}', 'LessonsController@index')->name('lessons');


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