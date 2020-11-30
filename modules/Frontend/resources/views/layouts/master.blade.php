<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="it-rating" content="it-rat-96ce2df79b44e83b1c096943ce4efc94"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate() !!}
    @php /* @include('includes.favicon') */ @endphp
    <link href="{{mix('dist/css/app.css')}}" rel="stylesheet">
    @stack('styles')
    @php /*@include('frontend::includes.google')*/ @endphp
</head>
<body class="{{ $bodyClass }}">
<div id="app">
    @auth
        @if(Auth::getUser()->is_volunteer)
            <header-volunteer></header-volunteer>
        @else
            <header-company></header-company>
        @endif
            <the-main-search></the-main-search>
    @else
        <header-guest></header-guest>
    @endauth
    @yield('content')
    @auth
        @if(Auth::getUser()->is_volunteer)
            <volunteer-menu class="menu-account-fixed"></volunteer-menu>
        @else
            <company-menu class="menu-account-fixed"></company-menu>
        @endif
    @endauth
    <the-footer></the-footer>
    <button class="btn btn-up btn-scale-active" :class="{'active' : scrolled}" @click="scrollToHeader">
        <svg-vue icon="arrow-solid"></svg-vue>
    </button>
    <alert-notification></alert-notification>
</div>
@shared
@routes('frontend')
@stack('scripts')
<script src="{{mix('dist/js/app.js')}}"></script>
@php /* @schema */ @endphp
</body>
</html>
