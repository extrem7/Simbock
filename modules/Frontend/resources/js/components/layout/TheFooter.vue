<template>
    <footer :class="[isAccount?'footer-inner':'footer-front',{'footer-front-light':isHome}]" class="footer">
        <div class="container">
            <div v-if="!isAccount" class="text-center">
                <img alt="logo-footer" class="footer-logo" src="/dist/img/logo.svg">
            </div>
            <div v-if="!isAccount" class="row mt-4">
                <div class="col-md-3 col-6">
                    <div class="footer-title semi-bold-weight small-size">For volunteers</div>
                    <nav class="footer-nav">
                        <a :href="route('vacancies.search')"
                           class="footer-nav-link">Browse Jobs</a>
                        <a :href="route('vacancies.search')"
                           class="footer-nav-link">Job search</a>
                        <a class="footer-nav-link" href="">From home</a>
                        <a class="footer-nav-link" href="">Volunteering job categories</a>
                        <a class="footer-nav-link" href="">Mobile Apps</a>
                    </nav>
                </div>
                <div class="col-md-3 col-6">
                    <div class="footer-title semi-bold-weight small-size">Small & Medium Businesses</div>
                    <nav class="footer-nav">
                        <a :href="route('login')+'?employer'" class="footer-nav-link">Post a need</a>
                        <a class="footer-nav-link" href="">Find candidates</a>
                        <a class="footer-nav-link" href="">Plans</a>
                        <a class="footer-nav-link" href="">How it works</a>
                        <a class="footer-nav-link" href="">Mobile Apps</a>
                    </nav>
                    <div class="footer-title semi-bold-weight small-size">For Employers</div>
                    <nav class="footer-nav">
                        <a :href="route('login')+'?employer'" class="footer-nav-link">Post a need</a>
                        <a class="footer-nav-link" href="">Find candidates</a>
                        <a class="footer-nav-link" href="">Plans</a>
                        <a class="footer-nav-link" href="">How it works</a>
                        <a class="footer-nav-link" href="">Mobile Apps</a>
                    </nav>
                </div>
                <div class="col-md-3 col-6">
                    <div class="footer-title semi-bold-weight small-size">Company</div>
                    <nav class="footer-nav">
                        <a class="footer-nav-link" href="/about">About us</a>
                        <a class="footer-nav-link" href="/our-vacancies">Careers</a>
                        <a :href="route('articles.index')"
                           class="footer-nav-link">Newsroom</a>
                        <a class="footer-nav-link" href="/help">Help</a>
                        <a class="footer-nav-link" href="">Site Map</a>
                        <a class="footer-nav-link" href="">Partners</a>
                        <a class="footer-nav-link" href="">Donate</a>
                        <a class="footer-nav-link" href="">For investors</a>
                        <a class="footer-nav-link" href="">Advertising</a>
                        <a class="footer-nav-link" href="">Simbock international</a>
                    </nav>
                </div>
                <div class="col-md-3 col-6">
                    <div class="footer-title semi-bold-weight small-size">Helpful Resources</div>
                    <nav class="footer-nav">
                        <a class="footer-nav-link" href="/help">Contact Us</a>
                        <a class="footer-nav-link" href="/policies">Terms of Use</a>
                    </nav>
                </div>
                <div class="col-12 text-center mt-3">
                    <SocialMedia/>
                </div>
            </div>
            <div v-else class="row">
                <div class="col-md-3 text-center text-md-left">
                    <img alt="logo-footer" class="footer-logo" src="/dist/img/logo.svg">
                </div>
                <div class="col-md-9 text-md-right text-center">
                    <SocialMedia/>
                </div>
            </div>
            <div class="row extra-small-size mt-4 footer-bottom-link">
                <nav class="col-md-6 text-uppercase text-center text-md-left">
                    <a class="text-uppercase" href="/policies#security">SECURITY</a>,
                    <a class="text-uppercase" href="/policies#privacy">PRIVACY</a>,
                    <a class="text-uppercase" href="/policies#cookies">COOKIES</a>,
                    <a class="text-uppercase" href="/policies#terms">TERMS & CONDITIONS</a>
                </nav>
                <div class="col-md-6 text-center text-md-right mt-2 mt-md-0">COPYRIGHT © Simboсk {{ year }}</div>
            </div>
        </div>
    </footer>
</template>

<script>
import SocialMedia from './SocialMedia'

export default {
    components: {
        SocialMedia
    },
    data() {
        return {
            year: new Date().getFullYear()
        }
    },
    computed: {
        isHome() {
            return this.isRoute('home')
        },
        isAccount() {
            return !!this.routeIncludes(['company', 'volunteer'])
                ||
                (this.routeIncludes(['vacancies']) && this.$store.state.user)
        }
    }
}
</script>
