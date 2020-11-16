<?php

use Illuminate\Support\Facades\Route;






Route::redirect('/dashboard','/dashboard/ar');

Route::group(['prefix'=> '{lang}' , 'middleware' => ['role:superadministrator|administrator']], function(){



    Route::get('/dashboard','WelcomeController@index')->name('dashboard');

    Route::resource('/dashboard/users' , 'AdminUsersController');
    Route::get('/trashed-users' , 'AdminUsersController@trashed' )->name('users.trashed');
    Route::get('/trashed-users/{user}' , 'AdminUsersController@restore' )->name('users.restore');


    Route::get('/trashed-roles' , 'RoleController@trashed' )->name('roles.trashed');
    Route::get('/trashed-roles/{role}' , 'RoleController@restore' )->name('roles.restore');
    Route::resource('/dashboard/roles' , 'RoleController');

    Route::resource('/dashboard/learning_systems' , 'LearningSystemsController');
    Route::get('/trashed-learning_systems' , 'LearningSystemsController@trashed' )->name('learning_systems.trashed');
    Route::get('/trashed-learning_systems/{learning_system}' , 'LearningSystemsController@restore' )->name('learning_systems.restore');



    Route::resource('/dashboard/countries' , 'CountriesController');
    Route::get('/trashed-countries' , 'CountriesController@trashed' )->name('countries.trashed');
    Route::get('/trashed-countries/{country}' , 'CountriesController@restore' )->name('countries.restore');


    Route::get('/dashboard/settings/social_links' , 'SettingController@social_links')->name('settings.social_links');
    Route::post('/dashboard/settings', 'SettingController@store')->name('settings.store');


    Route::resource('/dashboard/stages' , 'StagesController');
    Route::get('/trashed-stages' , 'StagesController@trashed' )->name('stages.trashed');
    Route::get('/trashed-stages/{stage}' , 'StagesController@restore' )->name('stages.restore');


    Route::resource('/dashboard/ed_classes' , 'EdClassesController');
    Route::get('/trashed-ed_classes' , 'EdClassesController@trashed' )->name('ed_classes.trashed');
    Route::get('/trashed-ed_classes/{ed_class}' , 'EdClassesController@restore' )->name('ed_classes.restore');


    Route::resource('/dashboard/courses' , 'CoursesController');
    Route::get('/trashed-courses' , 'CoursesController@trashed' )->name('courses.trashed');
    Route::get('/trashed-courses/{course}' , 'CoursesController@restore' )->name('courses.restore');


    Route::resource('/dashboard/chapters' , 'ChaptersController');
    Route::get('/trashed-chapters' , 'ChaptersController@trashed' )->name('chapters.trashed');
    Route::get('/trashed-chapters/{chapter}' , 'ChaptersController@restore' )->name('chapters.restore');


    Route::resource('/dashboard/lessons' , 'LessonsController');
    Route::get('/trashed-lessons' , 'LessonsController@trashed' )->name('lessons.trashed');
    Route::get('/dashboard/lessons/display/{lesson}' , 'LessonsController@display' )->name('lessons.display');
    Route::get('/trashed-lessons/{lesson}' , 'LessonsController@restore' )->name('lessons.restore');



    Route::resource('/dashboard/live_stream' , 'LiveStreamController');
    Route::get('/trashed-live_stream' , 'LiveStreamController@trashed' )->name('live_stream.trashed');


    Route::resource('/dashboard/categories' , 'CategoriesController');
    Route::get('/trashed-categories' , 'CategoriesController@trashed' )->name('categories.trashed');
    Route::get('/trashed-categories/{category}' , 'CategoriesController@restore' )->name('categories.restore');


    Route::resource('/dashboard/products' , 'ProductsController');
    Route::get('/trashed-products' , 'ProductsController@trashed' )->name('products.trashed');
    Route::get('/trashed-products/{product}' , 'ProductsController@restore' )->name('products.restore');


    Route::resource('/dashboard/orders' , 'OrdersController');
    Route::get('/trashed-orders' , 'OrdersController@trashed' )->name('orders.trashed');
    Route::get('/trashed-orders/{order}' , 'OrdersController@restore' )->name('orders.restore');

    Route::resource('/dashboard/all_orders' , 'AllOrdersController');
    Route::get('/dashboard/all_orders/{order}/products' , 'AllOrdersController@products' )->name('all_orders.products');
    Route::get('/trashed-all_orders' , 'AllOrdersController@trashed' )->name('all_orders.trashed');
    Route::get('/trashed-all_orders/{all_order}' , 'AllOrdersController@restore' )->name('all_orders.restore');


    Route::resource('/dashboard/addresses' , 'AddressesController');
    Route::get('/trashed-addresses' , 'AddressesController@trashed' )->name('addresses.trashed');
    Route::get('/trashed-addresses/{address}' , 'AddressesController@restore' )->name('addresses.restore');



    Route::resource('/dashboard/posts' , 'PostsController');
    Route::get('/trashed-posts' , 'PostsController@trashed' )->name('posts.trashed');
    Route::get('/trashed-posts/{post}' , 'PostsController@restore' )->name('posts.restore');

    Route::resource('/dashboard/ads' , 'AdsController');
    Route::get('/trashed-ads' , 'AdsController@trashed' )->name('ads.trashed');
    Route::get('/trashed-ads/{ad}' , 'AdsController@restore' )->name('ads.restore');


    Route::resource('/dashboard/sponsers' , 'SponsersController');
    Route::get('/trashed-sponsers' , 'SponsersController@trashed' )->name('sponsers.trashed');
    Route::get('/trashed-sponsers/{sponser}' , 'SponsersController@restore' )->name('sponsers.restore');


    Route::resource('/dashboard/links' , 'LinksController');
    Route::get('/trashed-links' , 'LinksController@trashed' )->name('links.trashed');
    Route::get('/trashed-links/{link}' , 'LinksController@restore' )->name('links.restore');
});










