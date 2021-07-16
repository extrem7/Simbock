@extends('frontend::layouts.master')

@section('content')
    <main class="container content-inner">
        <h1 class="title title-page title-line line-large mb-4">Vacancies</h1>
        <div class="row">
            <div class="offset-xl-1 col-xl-11">
                <ul class="tabs-wrapper horizontal-scroll">
                    <li class="tab-item btn-scale-active">
                        <a href="{{route('frontend.company.vacancies.index')}}" class="job-status job-status-all">
                            All ({{$counts['all']}}/{{$availableVacancies}})
                        </a>
                    </li>
                    <li class="tab-item btn-scale-active">
                        <a href="{{route('frontend.company.vacancies.index',$counts['active']?'active':null)}}"
                           class="job-status job-status-active">
                            Active ({{$counts['active']}})
                        </a>
                    </li>
                    <li class="tab-item btn-scale-active">
                        <a href="{{route('frontend.company.vacancies.index',$counts['draft']?'draft':null)}}"
                           class="job-status job-status-draft">
                            Draft ({{$counts['draft']}})
                        </a>
                    </li>
                    <li class="tab-item btn-scale-active">
                        <a href="{{route('frontend.company.vacancies.index',$counts['closed']?'closed':null)}}"
                           class="job-status job-status-closed">
                            Closed ({{$counts['closed']}})
                        </a>
                    </li>
                </ul>

                <company-vacancies-list></company-vacancies-list>

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
