<template>
    <footer :class="[isAccount?'footer-inner':'footer-front',{'footer-front-light':isHome}]" class="footer">
        <div class="container">
            <div v-if="!isAccount" class="text-center">
                <img alt="logo-footer" class="footer-logo" src="/dist/img/logo.svg">
            </div>
            <div v-if="!isAccount" class="row mt-4">
                <div class="col-md-3 col-6">
                    <div class="footer-title semi-bold-weight small-size">For Job Seekers</div>
                    <nav class="footer-nav">
                        <a class="footer-nav-link" href="">Browse Jobs</a>
                        <a class="footer-nav-link" href="">Upload resume</a>
                        <a class="footer-nav-link" href="">Salary Tools</a>
                        <a class="footer-nav-link" href="">Resume Help</a>
                        <a class="footer-nav-link" href="">Career Advice</a>
                        <a class="footer-nav-link" href="">Company Profile</a>
                        <a class="footer-nav-link" href="">International Jobs</a>
                        <a class="footer-nav-link" href="">Help</a>
                    </nav>
                </div>
                <div class="col-md-3 col-6">
                    <div class="footer-title semi-bold-weight small-size">For Employers</div>
                    <nav class="footer-nav">
                        <a class="footer-nav-link" href="">Product</a>
                        <a class="footer-nav-link" href="">Solutions</a>
                        <a class="footer-nav-link" href="">Pricing</a>
                        <a class="footer-nav-link" href="">Resources</a>
                        <a class="footer-nav-link" href="">Help</a>
                    </nav>
                </div>
                <div class="col-md-3 col-6">
                    <div class="footer-title semi-bold-weight small-size">About us</div>
                    <nav class="footer-nav">
                        <a class="footer-nav-link" href="/about">About Simboсk</a>
                        <a :href="route('articles.index')"
                           class="footer-nav-link">Newsroom</a>
                        <a class="footer-nav-link" href="/our-vacancies">Work for Simboсk</a>
                        <a class="footer-nav-link" href="">Partner with us</a>
                        <a class="footer-nav-link" href="">Simboсk International</a>
                    </nav>
                </div>
                <div class="col-md-3 col-6">
                    <div class="footer-title semi-bold-weight small-size">Helpful Resources</div>
                    <nav class="footer-nav">
                        <a class="footer-nav-link" href="">Contact Us</a>
                        <a class="footer-nav-link" href="">Site Map</a>
                        <a class="footer-nav-link" href="">Terms of Use</a>
                        <a class="footer-nav-link" href="">Security Center</a>
                        <a class="footer-nav-link" href="">Accessibility Center</a>
                        <a class="footer-nav-link" href="">AdChoices</a>
                    </nav>
                </div>
                <div class="col-12 text-center mt-3">
                    <div class="media-wrapper">
                        <a class="media-link" href="">
                            <svg-vue class="media-icon" icon="media-news"></svg-vue>
                        </a>
                        <a class="media-link" href="">
                            <svg-vue class="media-icon" icon="media-youtube"></svg-vue>
                        </a>
                        <a class="media-link" href="">
                            <svg-vue class="media-icon" icon="media-facebook"></svg-vue>
                        </a>
                        <a class="media-link" href="">
                            <svg-vue class="media-icon" icon="media-twitter"></svg-vue>
                        </a>
                        <a class="media-link" href="">
                            <svg-vue class="media-icon" icon="media-instagramm"></svg-vue>
                        </a>
                        <a class="media-link" href="">
                            <svg-vue class="media-icon" icon="media-linkedin"></svg-vue>
                        </a>
                    </div>
                </div>
            </div>
            <div v-else class="row">
                <div class="col-md-3 text-center text-md-left">
                    <img alt="logo-footer" class="footer-logo" src="/dist/img/logo.svg">
                </div>
                <div class="col-md-9 text-md-right text-center">
                    <div class="media-wrapper">
                        <a class="media-link" href="">
                            <svg-vue class="media-icon" icon="media-news"></svg-vue>
                        </a>
                        <a class="media-link" href="">
                            <svg-vue class="media-icon" icon="media-youtube"></svg-vue>
                        </a>
                        <a class="media-link" href="">
                            <svg-vue class="media-icon" icon="media-facebook"></svg-vue>
                        </a>
                        <a class="media-link" href="">
                            <svg-vue class="media-icon" icon="media-twitter"></svg-vue>
                        </a>
                        <a class="media-link" href="">
                            <svg-vue class="media-icon" icon="media-instagramm"></svg-vue>
                        </a>
                        <a class="media-link" href="">
                            <svg-vue class="media-icon" icon="media-linkedin"></svg-vue>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row extra-small-size mt-4 footer-bottom-link">
                <nav class="col-md-6 text-uppercase text-center text-md-left">
                    <a class="text-uppercase" href="/policies#security">SECURITY</a>,
                    <a class="text-uppercase" href="/policies#privacy">PRIVACY</a>,
                    <a class="text-uppercase" href="/policies#cookies">COOKIES</a>,
                    <a class="text-uppercase" href="/policies#terms">TERMS & CONDITIONS</a>
                </nav>
                <div class="col-md-6 text-center text-md-right mt-2 mt-md-0">COPYRIGHT © Simboсk.com {{ year }}</div>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
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
