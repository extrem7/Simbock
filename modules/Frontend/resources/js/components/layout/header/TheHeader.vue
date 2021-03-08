<template>
    <header class="header header-account">
        <div class="header-wrapper container">
            <a :href="link"
               class="d-block">
                <img alt="logo" class="header-logo" src="/dist/img/logo.svg">
            </a>
            <nav class="header-account-navigation">
                <button class="btn btn-show-search"
                        @click="$bus.emit('search-toggle')">
                    <SvgVue icon="search-thin"/>
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
    },
    computed: {
        user() {
            return this.$store.state.user
        },
        link() {
            if (this.user) {
                return this.route(this.user.is_volunteer ? 'vacancies.search' : 'company.board')
            }
            return this.route('home')
        }
    }
}
</script>
