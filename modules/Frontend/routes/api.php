<?php

Route::get('cities/{query}', 'LocationController@cities')->name('search');

Route::get('vacancies/{query}', 'VacancyController@search')->name('search');
