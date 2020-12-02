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
    <app>
        @yield('content')
    </app>
</div>
@shared
@routes('frontend')
@stack('scripts')
<script src="{{mix('dist/js/app.js')}}"></script>
@php /* @schema */ @endphp
</body>
</html>
