<?php

Route::get('/', 'PageController@home')->name('home');

Route::prefix('/newsroom')->as('articles.')->group(function () {
    Route::get('/', 'ArticleController@index')->name('index');

    Route::prefix('/{category:slug}')->group(function () {
        Route::get('/', 'ArticleController@index')->name('category');
        Route::get('/{article:slug}', 'ArticleController@show')->name('show');
    });
});

Route::get('/{pageModel:slug}', 'PageController@show')->name('pages.show');
