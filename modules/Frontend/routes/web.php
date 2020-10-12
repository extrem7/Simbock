<?php

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

Route::get('/{pageModel:slug}', 'PageController@show')->name('pages.show');
