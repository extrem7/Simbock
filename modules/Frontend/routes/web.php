<?php

/**
 * @routeNamespace("Modules\Frontend\Http\Controllers")
 * @routePrefix("frontend.")
 */

use Modules\Frontend\Http\Middleware\Company;
use Modules\Frontend\Http\Middleware\VacancyNotClosed;
use Modules\Frontend\Http\Middleware\VacancyOwner;
use Modules\Frontend\Http\Middleware\Volunteer;

Auth::routes();

Route::middleware('guest')->as('auth.')->group(function () {
    Route::get('social/company/{provider}', 'Auth\SocialController@companyRedirect')->name('provider_company');
    Route::get('social/company/{provider}/callback', 'Auth\SocialController@companyCallback');

    Route::get('social/{provider}', 'Auth\SocialController@redirect')->name('provider');
    Route::get('social/{provider}/callback', 'Auth\SocialController@callback');
});

Route::get('', 'PageController@home')->name('home');

Route::prefix('newsroom')->as('articles.')->group(function () {
    Route::get('', 'ArticleController@index')->name('index');

    Route::prefix('{category:slug}')->group(function () {
        Route::get('', 'ArticleController@index')->name('category');
        Route::get('{article:slug}', 'ArticleController@show')->name('show');
    });
});

Route::as('vacancies.')->group(function () {
    Route::prefix('vacancies/{query?}')
        ->as('search')
        ->group(function () {
            Route::get('', 'VacancyController@index');
            Route::get('{location?}', 'VacancyController@index')->name('.location');
        });

    Route::prefix('vacancy/{vacancy}')->group(function () {
        Route::get('', 'VacancyController@show')
            ->name('show')
            ->where('vacancy', '[0-9]+');
        Route::prefix('')
            ->middleware(['auth', Volunteer::class])
            ->as('actions.')
            ->group(function () {
                Route::post('apply', 'VacancyController@apply')->name('apply');
                Route::post('bookmark', 'VacancyController@bookmark')->name('bookmark');
            });
    });
});

Route::middleware('auth')
    ->as('volunteers.')
    ->group(function () {
        Route::prefix('volunteers/{query?}')
            ->as('search')
            ->group(function () {
                Route::get('', 'VolunteerController@index');
                Route::get('{location?}', 'VolunteerController@index')->name('.location');
            });

        Route::prefix('volunteer/{volunteer}')->group(function () {
            Route::get('', 'VolunteerController@show')
                ->name('show')
                ->where('volunteer', '[0-9]+');
            Route::middleware(Company::class)
                ->as('actions.')
                ->group(function () {
                    Route::post('bookmark', 'VolunteerController@bookmark')->name('bookmark');
                });
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

    /*Route::prefix('vacancies')->as('vacancies.')->group(function () {
        Route::prefix('{vacancy}')->group(function () {
            Route::get('', 'VacancyController@show')->name('show');
        });
    });*/
    Route::as('companies.')->group(function () {
        Route::get('company/self', 'CompanyController@self')
            ->middleware(Company::class)
            ->name('self');
        Route::prefix('companies/{company}')->group(function () {
            Route::get('', 'CompanyController@show')->name('show');
        });
    });

    Route::prefix('company')
        ->middleware(Company::class)
        ->as('company.')
        ->group(function () {
            Route::as('volunteers.')->group(function () {
                Route::get('saved', 'VolunteerController@saved')->name('saved');
                Route::get('candidates', 'VolunteerController@candidates')->name('candidates');
            });

            Route::namespace('Company')->group(function () {
                Route::get('board', 'BoardController')->name('board');
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
                Route::prefix('upgrade')->as('upgrade.')->group(function () {
                    Route::get('', 'UpgradeController@page')->name('page');
                    Route::get('checkout/{plan}', 'UpgradeController@checkout')->name('checkout');
                    Route::post('cancel', 'UpgradeController@cancel')->name('cancel');
                    /*Route::get('setup-intent', 'UpgradeController@intent')->name('intent');
                    Route::put('subscription', 'UpgradeController@updatePlan')->name('update');
                    Route::prefix('payments')->as('payments.')->group(function () {
                        Route::get('', 'UpgradeController@getPaymentMethods')->name('index');
                        Route::post('', 'UpgradeController@createPaymentMethod')->name('create');
                        Route::delete('', 'UpgradeController@removePaymentMethod')->name('destroy');
                    });*/

                });
            });
        });

    Route::prefix('volunteer')->as('volunteers.')->group(function () {
        Route::get('self', 'VolunteerController@self')
            ->middleware(Volunteer::class)
            ->name('self');
    });

    Route::prefix('account')
        ->middleware(Volunteer::class)
        ->as('volunteer.')
        ->namespace('Volunteer')
        ->group(function () {
            Route::get('companies', 'CompanyController')->name('vacancies.companies');
            Route::get('saved', 'VacancyController@saved')->name('vacancies.saved');
            Route::get('history', 'VacancyController@history')->name('vacancies.history');

            Route::prefix('info')->as('account.')->namespace('Account')->group(function () {
                Route::get('', 'AccountController@page')->name('form');
                Route::post('', 'AccountController@update')->name('update');

                Route::prefix('avatar')->as('avatar.')->group(function () {
                    Route::post('', 'AvatarController@update')->name('update');
                    Route::delete('', 'AvatarController@destroy')->name('destroy');
                });
                Route::prefix('job')->as('job.')->group(function () {
                    Route::post('', 'JobController@update')->name('update');
                    Route::delete('', 'JobController@destroy')->name('destroy');
                });
                Route::prefix('work_experience')->as('work_experiences.')->group(function () {
                    Route::post('', 'WorkExperienceController@store')->name('store');
                    Route::prefix('{workExperience}')->group(function () {
                        Route::patch('', 'WorkExperienceController@update')->name('update');
                        Route::delete('', 'WorkExperienceController@destroy')->name('destroy');
                    });
                });
                Route::prefix('education')->as('educations.')->group(function () {
                    Route::post('', 'EducationController@store')->name('store');
                    Route::prefix('{education}')->group(function () {
                        Route::patch('', 'EducationController@update')->name('update');
                        Route::delete('', 'EducationController@destroy')->name('destroy');
                    });
                });
                Route::prefix('resume')->as('resume.')->group(function () {
                    Route::post('', 'ResumeController@store')->name('store');
                    Route::delete('', 'ResumeController@destroy')->name('destroy');
                });
                Route::prefix('certificate')->as('certificates.')->group(function () {
                    Route::post('', 'CertificateController@store')->name('store');
                    Route::prefix('{certificate}')->group(function () {
                        Route::patch('', 'CertificateController@update')->name('update');
                        Route::delete('', 'CertificateController@destroy')->name('destroy');
                    });
                });
                Route::prefix('language')->as('languages.')->group(function () {
                    Route::post('', 'LanguageController@store')->name('store');
                    Route::prefix('{language}')->group(function () {
                        Route::patch('', 'LanguageController@update')->name('update');
                        Route::delete('', 'LanguageController@destroy')->name('destroy');
                    });
                });
            });
        });
});

Route::post('/contact-form', 'PageController@contactForm')->name('contact-form');

Route::get('/{pageModel:slug}', 'PageController@show')->name('pages.show');
