@php /* @var $article \App\Models\Blog\Article */  @endphp

@extends('frontend::layouts.master')

@section('content')
    <nav>
        <div class="container nav-article-content">
            @include('frontend::articles.includes.categories')
        </div>
    </nav>
    <main class="container content-inner">
        <article class="article">
            <div class="text-center">
                <h1 class="title large-size semi-bold-weight">{{ $article->title }}</h1>
                <div class="date violet-color mt-2">{{ $article->date }}</div>
            </div>
            <div class="article-img-wrapper">
                <img src="{{ $article->image }}" alt="{{ $article->title }}" class="article-img img-fluid">
            </div>
            <div class="article-share">
                <div class="medium-size silver-color semi-bold-weight line-height-1">Share</div>
                <div>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{$article->link}}"
                       class="article-share-item">
                        <svg-vue icon="media-facebook" class="article-share-icon"></svg-vue>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{$article->link}}" class="article-share-item">
                        <svg-vue icon="media-twitter" class="article-share-icon"></svg-vue>
                    </a>
                    <a href="https://www.linkedin.com/cws/share?url={{$article->link}}" class="article-share-item">
                        <svg-vue icon="media-linkedin" class="article-share-icon"></svg-vue>
                    </a>
                </div>
            </div>
            <div class="article-text dynamic-content">{!! $article->body !!}</div>
        </article>
    </main>
@endsection

@push('scripts')
    {!!$articleSchema!!}
@endpush
