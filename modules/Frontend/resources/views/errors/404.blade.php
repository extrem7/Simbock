@extends('frontend::layouts.master')

@section('content')
    <main class="container content-inner">
        <div class="text-center">
            <img src="/dist/img/404.svg" alt="404" class="img-fluid">
            <h1 class="extra-large-size bold-weight text-center color-white mt-4 mb-4">Oops! Page not found</h1>
            <div class="medium-size mb-4">We couldn't find the page you were looking for. Maybe our FAQ or Community can
                help?
            </div>
            <a href="{{route('frontend.home')}}" class="btn btn-green btn-shadow btn-scale-active min-width-170 btn-lg">Back
                to Home</a>
        </div>
    </main>
@endsection
