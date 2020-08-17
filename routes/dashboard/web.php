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

});










