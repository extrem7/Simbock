@extends('frontend::layouts.master')

@section('content')
    <main class="container content-inner">
        <div class="home-center-wrapper">
            <h1 class="title extra-large-size bold-weight text-center">
                <span class="violet-color">Let's find you a place</span>
            </h1>
            <div class="medium-size text-center mt-2">any industry, any location, any experience level.</div>
            <div class="search-form search-form-main mt-0">
                <vacancies-home-form></vacancies-home-form>
            </div>
        </div>
    </main>
    <section class="section-home-about">
        <div class="container">
            <div class="row">
                <div class="offset-xl-2 col-xl-8">
                    <div class="text-center">
                        <div class="large-size semi-bold-weight">Let's work together in giving back to this
                            communities.
                        </div>
                        <div class="mt-4">Simboсk is here to encourage people to give back to the society by
                            volunteering
                            and acting as goodwill ambassadors. We are here to make the world a better place by helping
                            using the least skills we have to help and give back those those in need. We ask everyone to
                            be part of the change we all want to see in the world.
                        </div>
                    </div>
                    <div class="about-wrapper">
                        <div class="about-item">
                            <img src="dist/img/icons/group.svg" alt="group" class="about-item-icon">
                            <div class="about-item-text">
                                <div class="about-item-title">1 952</div>
                                <div class="mt-1">Subscribers</div>
                            </div>
                        </div>
                        <div class="about-item">
                            <img src="dist/img/icons/personal-info.svg" alt="personal" class="about-item-icon">
                            <div class="about-item-text">
                                <div class="about-item-title">{{$vacancies}}</div>
                                <div class="mt-1">Vacancies</div>
                            </div>
                        </div>
                        <div class="about-item">
                            <img src="dist/img/icons/resume.svg" alt="resume" class="about-item-icon">
                            <div class="about-item-text">
                                <div class="about-item-title">{{$resumes}}</div>
                                <div class="mt-1">Resume</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <seo-text></seo-text>
@endsection
