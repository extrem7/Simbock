@extends('frontend::layouts.master')

@section('content')
    <main class="container content-inner">
        <div class="post-vacancy">
            <h1 class="title title-page title-line line-large">{{$title}}</h1>
            <vacancy-form></vacancy-form>
        </div>
    </main>
    <the-bottom-menu-company></the-bottom-menu-company>
@endsection
