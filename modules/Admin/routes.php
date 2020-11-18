<?php

/**
 * @routeNamespace("Modules\Admin\Http\Controllers")
 * @routePrefix("admin.")
 */

use Modules\Admin\Http\Middleware\Admin;

Route::middleware('guest')->group(function () {
    Route::get('/login', 'LoginController@showLoginForm')->name('login');
    Route::post('/login', 'LoginController@login')->name('login.try');
});

Route::middleware(Admin::class)->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::resource('/pages', 'PageController', ['names' => 'pages'])->except(['show']);

    Route::prefix('/blog')
        ->namespace('Blog')
        ->as('blog.')
        ->group(function () {
            Route::resource('/categories', 'CategoryController');
            Route::post('/categories/sort', 'CategoryController@sort')->name('categories.sort');

            Route::resource('/articles', 'ArticleController')->except('show');
        });

    Route::resource('/users', 'UserController', ['names' => 'users'])->except(['show']);
    Route::group(['as' => 'users.', 'prefix' => 'users'], function () {
        Route::get('/search', 'UserController@search')->name('search');
    });

    Route::prefix('/jobs')->namespace('Jobs')->group(function () {
        Route::resource('/sectors', 'SectorController', ['names' => 'sectors'])->except(['show']);
        Route::get('/sectors/{sector}/roles', 'RoleController@index',)->name('sectors.roles');
        Route::post('/sectors/sort', 'SectorController@sort')->name('sectors.sort');

        Route::resource('/roles', 'RoleController', ['names' => 'roles'])->except(['show']);
        Route::post('/roles/sort', 'RoleController@sort')->name('roles.sort');
    });

    Route::post('/media', 'MediaController@upload')->name('media.upload');

    Route::post('logout', 'LoginController@logout')->name('logout');
});
