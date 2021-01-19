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

    Route::namespace('Users')->group(function () {
        Route::resource('/users', 'UserController', ['names' => 'users'])->except(['show']);
        Route::get('/companies', 'CompanyController@index')->name('companies.index');
        Route::get('/volunteers', 'VolunteerController@index')->name('volunteers.index');
    });


    Route::prefix('/jobs')->namespace('Jobs')->group(function () {
        Route::resource('/sectors', 'SectorController', ['names' => 'sectors'])->except(['show']);
        Route::get('/sectors/{sector}/roles', 'RoleController@index',)->name('sectors.roles');
        Route::post('/sectors/sort', 'SectorController@sort')->name('sectors.sort');

        Route::resource('/roles', 'RoleController', ['names' => 'roles'])->except(['show']);
        Route::post('/roles/sort', 'RoleController@sort')->name('roles.sort');
    });

    Route::get('/surveys', 'SurveyController@index')->name('surveys.index');

    Route::get('/search-queries', 'SearchQueryController@index')->name('search-queries.index');

    Route::post('/media', 'MediaController@upload')->name('media.upload');

    Route::post('logout', 'LoginController@logout')->name('logout');
});
