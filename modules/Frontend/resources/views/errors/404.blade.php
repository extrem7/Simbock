@extends('frontend::layouts.master')

@section('content')
    <main class="container content-inner">
        <div class="text-center">
            <img src="/dist/img/404.svg" alt="404" class="img-fluid">
            <h1 class="extra-large-size bold-weight text-center color-white mt-4 mb-4">{{$title}}</h1>
            @if($message)
                <div class="medium-size mb-4">{{$message}}</div>
            @endif
            <a href="{{route('frontend.home')}}" class="btn btn-green btn-shadow btn-scale-active min-width-170 btn-lg">Back
                to Home</a>
        </div>
    </main>
@endsection
