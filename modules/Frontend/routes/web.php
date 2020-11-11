<?php

use Modules\Frontend\Http\Middleware\Company;
use Modules\Frontend\Http\Middleware\VacancyNotClosed;
use Modules\Frontend\Http\Middleware\VacancyOwner;

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
    Route::prefix('account/change-password')
        ->namespace('Auth')
        ->as('auth.change_password.')
        ->group(function () {
            Route::get('', 'ChangePasswordController@form')->name('form');
            Route::post('', 'ChangePasswordController@update')->name('update');
        });

    Route::prefix('vacancies')->as('vacancies.')->group(function () {
        Route::prefix('{vacancy}')->group(function () {
            Route::get('', 'VacancyController@show')->name('show');
        });
    });
    Route::prefix('companies')->as('companies.')->group(function () {
        Route::get('self', 'CompanyController@self')->name('self');
        Route::prefix('{company}')->group(function () {
            Route::get('', 'CompanyController@show')->name('show');
        });
    });

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
                Route::get('{status?}', 'VacancyController@index')
                    ->name('index')
                    ->where('status', '(active|draft|closed)');
                Route::get('create', 'VacancyController@create')->name('create');
                Route::post('', 'VacancyController@store')->name('store');

                Route::prefix('{vacancy}')->middleware(VacancyOwner::class)->group(function () {
                    Route::middleware(VacancyNotClosed::class)->group(function () {
                        Route::get('edit', 'VacancyController@edit')->name('edit');
                        Route::post('', 'VacancyController@update')->name('update');
                    });

                    Route::post('post', 'VacancyController@post')->name('post');
                    Route::post('stop', 'VacancyController@stop')->name('stop');
                    Route::post('close', 'VacancyController@close')->name('close');

                    Route::get('duplicate', 'VacancyController@duplicate')->name('duplicate');

                    Route::delete('', 'VacancyController@destroy')->name('destroy');
                });
            });
        });

    Route::prefix('volunteer')
        //->middleware(Company::class)
        ->as('volunteer.')
        ->namespace('Volunteer')
        ->group(function () {
            Route::prefix('account')->as('account.')->group(function () {
                Route::get('', 'AccountController@page')->name('form');
                Route::post('', 'AccountController@update')->name('update');

                Route::prefix('avatar')->as('avatar.')->group(function () {
                    Route::post('', 'AccountController@uploadAvatar')->name('update');
                    Route::delete('', 'AccountController@destroyAvatar')->name('destroy');
                });
            });
        });
});

Route::get('/{pageModel:slug}', 'PageController@show')->name('pages.show');
