@extends('frontend::layouts.master')

@section('content')
    <div class="article-banner">
        <img src="/dist/img/news.jpg" class="fit-cover" alt="banner">
    </div>
    <nav class="nav-article">
        <div class="container nav-article-content">
            <h1 class="title title-page title-line line-medium flex-shrink-0">Newsroom</h1>
            @include('frontend::articles.includes.categories')
        </div>
    </nav>
    <articles-list></articles-list>
@endsection
