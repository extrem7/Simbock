@extends('frontend::layouts.master')

@section('content')
    <main class="container content-inner">
        <h1 class="title title-page title-line line-large mb-4">Volunteering Vacancies</h1>
        <div class="row">
            <div class="offset-xl-1 col-xl-11">
                <ul class="tabs-wrapper horizontal-scroll">
                    <li class="tab-item btn-scale-active"><a href="" class="job-status job-status-all">All</a></li>
                    <li class="tab-item btn-scale-active"><a href="" class="job-status job-status-active">Active (0)</a>
                    </li>
                    <li class="tab-item btn-scale-active"><a href="" class="job-status job-status-draft">Draft (0)</a>
                    </li>
                    <li class="tab-item btn-scale-active"><a href="" class="job-status job-status-closed">Closed (0)</a>
                    </li>
                </ul>
                <div class="card-list">
                    <div class="job-settings-wrapper">
                        <vacancy-card :is-actions="false" is-completed></vacancy-card>
                        <vacancy-settings></vacancy-settings>
                    </div>
                    <div class="job-settings-wrapper">
                        <vacancy-card :is-actions="false"></vacancy-card>
                        <vacancy-settings></vacancy-settings>
                    </div>
                </div>
                <div class="text-center text-xl-left">
                    <a href="{{route('frontend.company.vacancies.create')}}"
                       class="btn btn-violet btn-flex btn-add-vacancy btn-sm">
                        <svg-vue icon="add-opacity"></svg-vue>
                        Post vacancy</a>
                </div>
            </div>
        </div>
    </main>
@endsection
