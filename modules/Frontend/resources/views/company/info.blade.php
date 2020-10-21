@extends('frontend::layouts.master')

@section('content')
    <main class="container content-inner">
        <div class="company-info">
            <h1 class="title title-page title-line line-large">Company Info</h1>
            <div class="silver-color text-center mt-3">
                Edit the company information for your Simbok account.<br>
                * Indicates required fields.
            </div>
            <company-info-form></company-info-form>
        </div>
    </main>
@endsection
