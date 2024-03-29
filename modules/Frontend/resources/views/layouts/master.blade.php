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
    @stack('styles')
    @php /*@include('frontend::includes.google')*/ @endphp
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#7b68ee">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#7B68EE">
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || []
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            })
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''
            j.async = true
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl
            f.parentNode.insertBefore(j, f)
        })(window, document, 'script', 'dataLayer', 'GTM-5SPK2PM')</script>
    <!-- End Google Tag Manager -->
</head>
<body class="{{ $bodyClass }}">
<noscript>
    <iframe src="googletagmanager.com/ns.html?id=GTM-5SPK2PM"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<div id="app">
    <app>
        @yield('content')
    </app>
</div>
@shared
@routes('frontend')
@stack('scripts')
<script src="{{ mix('dist/js/manifest.js') }}" defer></script>
<script src="{{ mix('dist/js/vendor.js') }}" defer></script>
<script src="{{mix('dist/js/app.js')}}" defer></script>
@schema
</body>
</html>
