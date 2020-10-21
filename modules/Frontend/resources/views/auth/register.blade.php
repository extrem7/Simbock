@extends('frontend::layouts.master')

@section('content')
    <main class="container content-inner">
        <div class="form-box sign-box form-box-decorative_bg mx-auto">
            <div class="text-center mb-4">
                <img src="/dist/img/logo.svg" alt="logo" class="header-logo">
            </div>
            <b-tabs>
                <register-form title="I'm a Job Seeker" is-active></register-form>
                <register-form title="I'm an Employer" is-company></register-form>
            </b-tabs>
        </div>
    </main>
@endsection
