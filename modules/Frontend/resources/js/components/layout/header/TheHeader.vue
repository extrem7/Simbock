<template>
    <header class="header header-account">
        <div class="header-wrapper container">
            <a :href="route('frontend.home')" class="d-block">
                <img alt="logo" class="header-logo" src="dist/img/logo.svg">
            </a>
            <nav class="header-account-navigation">
                <slot></slot>
            </nav>
        </div>
    </header>
</template>

<script>
export default {
    methods: {
        async logout() {
            await this.axios.post(this.route('frontend.logout'))
            location.href = this.route('frontend.home')
        }
    }
}
</script>
