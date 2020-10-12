@extends('frontend::layouts.master')

@section('content')
    <main class="container content-inner">
        <div class="form-box sign-box form-box-decorative_bg mx-auto">
            <div class="text-center mb-4">
                <img src="/dist/img/logo.svg" alt="logo" class="header-logo">
            </div>
            <login-form></login-form>
        </div>
    </main>
@endsection
