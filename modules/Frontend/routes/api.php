<?php

Route::get('cities/{query}', 'LocationController@cities')->name('api.cities.search');

Route::get('vacancies/{query}', 'VacancyController@search')->name('api.vacancies.search');
