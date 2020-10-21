<template>
    <header class="header header-account">
        <div class="header-wrapper container">
            <a :href="route('home')" class="d-block">
                <img alt="logo" class="header-logo" src="/dist/img/logo.svg">
            </a>
            <nav class="header-account-navigation">
                <button class="btn btn-show-search" @click="$bus.emit('search-toggle')">
                    <svg-vue icon="search-thin"></svg-vue>
                </button>
                <slot></slot>
            </nav>
        </div>
    </header>
</template>

<script>
export default {
    methods: {
        async logout() {
            await this.axios.post(this.route('logout'))
            location.href = this.route('home')
        }
    }
}
</script>
