<?php

use Modules\Frontend\Http\Middleware\Company;

Auth::routes();

Route::middleware('guest')->as('auth.')->group(function () {
    Route::get('social/company/{provider}', 'Auth\SocialController@companyRedirect')->name('provider_company');
    Route::get('social/company/{provider}/callback', 'Auth\SocialController@companyCallback');

    Route::get('social/{provider}', 'Auth\SocialController@redirect')->name('provider');
    Route::get('social/{provider}/callback', 'Auth\SocialController@callback');
});

Route::get('/', 'PageController@home')->name('home');

Route::prefix('/newsroom')->as('articles.')->group(function () {
    Route::get('/', 'ArticleController@index')->name('index');

    Route::prefix('/{category:slug}')->group(function () {
        Route::get('/', 'ArticleController@index')->name('category');
        Route::get('/{article:slug}', 'ArticleController@show')->name('show');
    });
});

Route::middleware('auth')->group(function () {
    Route::prefix('company')
        ->middleware(Company::class)
        ->as('company.')
        ->namespace('Company')
        ->group(function () {
            Route::prefix('info')->as('info.')->group(function () {
                Route::get('', 'InfoController@showForm')->name('form');
                Route::post('', 'InfoController@update')->name('update');

                Route::prefix('logo')->as('logo.')->group(function () {
                    Route::post('', 'InfoController@uploadLogo')->name('update');
                    Route::delete('', 'InfoController@destroyLogo')->name('destroy');
                });
            });
            Route::prefix('vacancies')->as('vacancies.')->group(function () {
                Route::get('', 'VacancyController@index')->name('index');
                Route::get('create', 'VacancyController@create')->name('create');
                Route::post('', 'VacancyController@store')->name('store');
            });

        });
});

Route::get('/{pageModel:slug}', 'PageController@show')->name('pages.show');
