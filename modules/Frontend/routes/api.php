<?php

Route::get('cities/{query}', 'LocationController@cities')->name('api.search');

Route::get('vacancies/{query}', 'VacancyController@search')->name('api.search');
