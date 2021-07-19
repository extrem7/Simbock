<template>
    <div :class="{'page-filtered':isFilterOpen}"
         class="simbok-app">
        <div :class="headerClasses">
            <div v-if="user">
                <HeaderVolunteer v-if="user.type==='VOLUNTEER'"/>
                <HeaderCompany v-else/>
            </div>
            <HeaderGuest v-else/>
            <TheMainSearch v-if="isSearch" :enable-filter="enableFilter"/>
        </div>
        <slot/>
        <div v-if="user">
            <VolunteerMenu
                v-if="user.type==='VOLUNTEER'"
                class="menu-account-fixed"/>
            <CompanyMenu
                v-else
                class="menu-account-fixed"/>
        </div>
        <TheFooter v-if="showFooter"/>
        <button :class="{'active' : scrolled}"
                class="btn btn-up btn-scale-active"
                @click="scrollToHeader">
            <SvgVue icon="arrow-solid"/>
        </button>
        <AlertNotification/>
        <ChatNotifications v-if="user && user.client"/>
    </div>
</template>

<script>
import HeaderGuest from './layout/header/HeaderGuest'
import TheFooter from './layout/TheFooter'
import AlertNotification from './includes/AlertNotification'
import ChatNotifications from './ChatNotifications'

export default {
    components: {
        HeaderGuest,
        HeaderVolunteer: () => import('./layout/header/HeaderVolunteer'),
        HeaderCompany: () => import('./layout/header/HeaderCompany'),
        TheMainSearch: () => import('./layout/TheMainSearch'),
        VolunteerMenu: () => import('./layout/header/VolunteerMenu'),
        CompanyMenu: () => import('./layout/header/CompanyMenu'),
        TheFooter,
        AlertNotification,
        ChatNotifications
    },
    data() {
        return {
            isScrolledSearch: false,
            scrolled: false,
            enableFilter: false,
            isFilterOpen: false,
            isSearch: this.routeIncludes([
                'vacancies.search', 'vacancies.saved', 'vacancies.history', 'vacancies.companies',
                'volunteers.search', 'volunteers.saved', 'volunteers.candidates'
            ]),
            showFooter: !location.href.includes('sitemap')
        }
    },
    computed: {
        user() {
            return this.$store.state.user
        },
        headerClasses() {
            return this.isSearch ? [
                'header-wrapper-search',
                {'is-scrolled-search': this.isScrolledSearch}
            ] : null
        }
    },
    created() {
        window.addEventListener('scroll', this.handleScroll)

        this.$bus.on('toggle-filter', () => {
            this.isFilterOpen = !this.isFilterOpen
        })

        this.$bus.on('enable-filter', () => {
            this.enableFilter = true
        })
        this.$bus.on('disable-filter', () => {
            this.enableFilter = false
        })
    },
    destroyed() {
        window.removeEventListener('scroll', this.handleScroll)
    },
    methods: {
        handleScroll() {
            let top = window.pageYOffset

            if (window.innerWidth > 991) {
                this.isScrolledSearch = top > 70
            }

            if (this.scroll > top) {
                this.scrolled = false
            } else if (top > 400) {
                this.scrolled = true
            }

            this.scroll = top
        },
        scrollToHeader() {
            window.scrollTo({top: 0, behavior: 'smooth'})
        }
    }
}
</script>
