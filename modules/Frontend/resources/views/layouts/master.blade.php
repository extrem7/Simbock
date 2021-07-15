<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="it-rating" content="it-rat-96ce2df79b44e83b1c096943ce4efc94"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEO::generate() !!}
    <link rel="preload" as="font" href="{{asset('dist/fonts/GolosText-Regular.woff2')}}">
    <link rel="preload" as="font" href="{{asset('dist/fonts/GolosText-DemiBold.woff2')}}">
    <link rel="preload" as="font" href="{{asset('dist/fonts/GolosText-Bold.woff2')}}">
    <link href="{{mix('dist/css/app.css')}}" rel="stylesheet">
    <script data-ad-client="ca-pub-2150066652665124"
            async
            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    @stack('styles')
    @php /*@include('frontend::includes.google')*/ @endphp
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#7b68ee">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#7B68EE">
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
<script src="{{mix('dist/js/app.js')}}" async></script>
@php /* @schema */ @endphp
</body>
</html>
