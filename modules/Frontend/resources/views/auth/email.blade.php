@extends('frontend::layouts.master')

@section('content')
    <main class="container content-inner">
        <div class="form-box sign-box form-box-decorative_bg mx-auto">
            <div class="text-center mb-4">
                <img src="/dist/img/logo.svg" alt="logo" class="header-logo">
            </div>
            <div class="medium-size text-center mt-3 mb-3">Password Reset</div>
            <div class="extra-small-size text-center mb-3 line-height-1">
                Enter your Simbock email address that you used to register.
                We'll send you an email with a link to reset your password.
            </div>
            <email-reset-form></email-reset-form>
        </div>
    </main>
@endsection
