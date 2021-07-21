<template>
    <main class="container content-inner">
        <h1 class="title title-page title-line line-large">{{ title }}</h1>
        <div class="row mt-4">
            <div class="col-md-3 col-6">
                <div class="footer-title semi-bold-weight small-size">Menu</div>
                <nav class="footer-nav">
                    <a class="footer-nav-link" href="/for-seekers">For Seekers</a>
                    <a class="footer-nav-link" href="/small-medium-businesses">Small & Medium Businesses</a>
                    <a class="footer-nav-link" href="/enterprise-businesses">Enterprise Businesses</a>
                    <a class="footer-nav-link" href="/sports-events">Sports & events</a>
                </nav>
            </div>
            <div class="col-md-3 col-6">
                <div class="footer-title semi-bold-weight small-size">For volunteers</div>
                <nav class="footer-nav">
                    <a :href="route('vacancies.search')"
                       class="footer-nav-link">Browse Jobs</a>
                    <a class="footer-nav-link" href="/job-search">Job search</a>
                    <a class="footer-nav-link" href="/from-home">From home</a>
                    <a class="footer-nav-link" href="/volunteering-job-categories">Volunteering job categories</a>
                    <a class="footer-nav-link" href="/mobile-apps">Mobile Apps</a>
                </nav>
            </div>
            <div class="col-md-3 col-6">
                <div class="footer-title semi-bold-weight small-size">Small & Medium Businesses</div>
                <nav class="footer-nav">
                    <a class="footer-nav-link" href="/post-a-need">Post vacancy</a>
                    <a class="footer-nav-link" href="/find-candidates">Find candidates</a>
                    <a class="footer-nav-link" href="/plans">Plans</a>
                    <a class="footer-nav-link" href="/how-it-works">How it works</a>
                    <a class="footer-nav-link" href="/mobile-apps">Mobile Apps</a>
                </nav>
            </div>
            <div class="col-md-3 col-6">
                <div class="footer-title semi-bold-weight small-size">For Employers</div>
                <nav class="footer-nav">
                    <a class="footer-nav-link" href="/for-employers">Post vacancy</a>
                    <a class="footer-nav-link" href="/find-candidates">Find candidates</a>
                    <a class="footer-nav-link" href="/plans-for-employers">Plans</a>
                    <a class="footer-nav-link" href="/how-it-works-for-employers">How it works</a>
                    <a class="footer-nav-link" href="/mobile-apps">Mobile Apps</a>
                </nav>
            </div>
            <div class="col-md-3 col-6">
                <div class="footer-title semi-bold-weight small-size">Company</div>
                <nav class="footer-nav">
                    <a class="footer-nav-link" href="/about-us">About us</a>
                    <a class="footer-nav-link" href="/careers">Careers</a>
                    <a :href="route('articles.index')"
                       class="footer-nav-link">Newsroom</a>
                    <a class="footer-nav-link" href="/help">Help</a>
                    <a class="footer-nav-link" href="/partners">Partners</a>
                    <a class="footer-nav-link" href="/donate">Donate</a>
                    <a class="footer-nav-link" href="/for-investors">For investors</a>
                    <a class="footer-nav-link" href="/advertising">Advertising</a>
                    <a class="footer-nav-link" href="/simbock-international">Simbock international</a>
                </nav>
            </div>
            <div class="col-12 text-center mt-5">
                <SocialMedia/>
            </div>
        </div>
    </main>
</template>

<script>
import SocialMedia from '~/components/layout/SocialMedia'

export default {
    components: {SocialMedia},
    data() {
        return {
            title: this.shared('title')
        }
    }
}
</script>
