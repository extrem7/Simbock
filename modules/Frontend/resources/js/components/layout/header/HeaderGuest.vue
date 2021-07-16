<template>
    <header class="header header-front">
        <div class="header-wrapper container">
            <a :href="route('home')" class="d-block">
                <img alt="logo" class="header-logo" src="/dist/img/logo.svg">
            </a>
            <nav class="header-front-navigation">
                <button class="btn btn-show-search" @click="$bus.emit('search-toggle')">
                    <svg-vue icon="search-thin"></svg-vue>
                </button>
                <div :class="{'is-open-menu' : isOpenMenuMobile}" class="header-menu-wrapper">
                    <ul class="menu">
                        <li class="menu-item">
                            <a class="menu-link" href="/for-seekers">For Seekers</a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="/small-medium-businesses">Small & Medium Businesses</a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="/enterprise-businesses">Enterprise Businesses</a>
                        </li>
                        <li class="menu-item">
                            <a class="menu-link" href="/sports-events">Sport & Events</a>
                        </li>
                    </ul>
                    <a :href="route('login')+'?employer'"
                       class="btn btn-outline-violet violet-color medium-weight btn-sm min-width-140">
                        Post a need
                    </a>
                </div>
                <a :href="route('register')+'?employer'"
                   class="btn btn-outline-violet violet-color medium-weight btn-sm min-width-140 hidden-md">
                    Post a need
                </a>
                <a :href="route('login')" class="header-link-sign header-link link-inherit small-size">
                    <svg-vue class="mr-1" icon="login"></svg-vue>
                    Sign in</a>
                <button :class="{'open' : isOpenMenuMobile}" class="mobile-btn"
                        @click="isOpenMenuMobile = !isOpenMenuMobile"><span></span><span></span><span></span></button>
            </nav>
        </div>
    </header>
</template>

<script>
export default {
    data() {
        return {
            isOpenMenuMobile: false
        }
    }
}
</script>
