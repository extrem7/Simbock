<?php

use Modules\Admin\Http\Middleware\Admin;

Route::middleware('guest')->group(function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login')->name('login.try');
});

Route::middleware(Admin::class)->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::resource('/pages', 'PageController', ['names' => 'pages'])->except(['show']);

    Route::resource('/articles', 'ArticleController')->except('show');

    Route::resource('/users', 'UserController', ['names' => 'users'])->except(['show']);
    Route::group(['as' => 'users.', 'prefix' => 'users'], function () {
        Route::get('/search', 'UserController@search')->name('search');
    });

    Route::post('/media', 'MediaController@upload')->name('media.upload');

    Route::post('logout', 'LoginController@logout')->name('logout');
});
