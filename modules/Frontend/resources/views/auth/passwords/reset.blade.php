@extends('frontend::layouts.master')

@section('content')
    <main class="container content-inner">
        <div class="form-box sign-box form-box-decorative_bg mx-auto">
            <div class="text-center mb-4">
                <img src="/dist/img/logo.svg" alt="logo" class="header-logo">
            </div>
            <div class="medium-size text-center mt-3 mb-3">Password Reset</div>
            <password-reset-form></password-reset-form>
        </div>
    </main>
@endsection
