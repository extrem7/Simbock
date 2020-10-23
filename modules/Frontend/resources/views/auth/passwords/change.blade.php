@extends('frontend::layouts.master')

@section('content')
    <main class="container content-inner">
        <div class="form-box sign-box form-box-decorative_bg mx-auto">
            <div class="text-center mb-4">
                <img src="/dist/img/logo.svg" alt="logo" class="header-logo">
            </div>
            <div class="text-center">
                <div class="medium-size mt-3 mb-3">Change Password</div>
                <div class="extra-small-size mb-3 line-height-1">
                    You are currently updating preferences for {{$email}}
                </div>
            </div>
            <password-change-form></password-change-form>
        </div>
    </main>
@endsection
