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
        <TheFooter/>
        <button :class="{'active' : scrolled}"
                class="btn btn-up btn-scale-active"
                @click="scrollToHeader">
            <SvgVue icon="arrow-solid"/>
        </button>
        <AlertNotification/>
    </div>
</template>

<script>
import HeaderGuest from "./layout/header/HeaderGuest"
import HeaderVolunteer from "./layout/header/HeaderVolunteer"
import HeaderCompany from "./layout/header/HeaderCompany"
import TheMainSearch from "./layout/TheMainSearch"
import VolunteerMenu from './layout/header/VolunteerMenu'
import CompanyMenu from "./layout/header/CompanyMenu"
import TheFooter from "./layout/TheFooter"
import AlertNotification from "./includes/AlertNotification"

export default {
    name: "App",
    components: {
        HeaderGuest,
        HeaderVolunteer,
        HeaderCompany,
        TheMainSearch,
        VolunteerMenu,
        CompanyMenu,
        TheFooter,
        AlertNotification,
    },
    data() {
        return {
            isScrolledSearch: false,
            scrolled: false,
            enableFilter: false,
            isFilterOpen: false,
            isSearch: this.routeIncludes(['vacancies.index', 'vacancies.saved', 'vacancies.history'])
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
        window.addEventListener("scroll", this.handleScroll)

        this.$bus.on('toggle-filter', () => {
            this.isFilterOpen = !this.isFilterOpen
        })

        this.$bus.on('enable-filter', () => {
            this.isFilterOpen = true
        })
        this.$bus.on('disable-filter', () => {
            this.isFilterOpen = false
        })
    },
    destroyed() {
        window.removeEventListener("scroll", this.handleScroll);
    },
    methods: {
        handleScroll() {
            let top = window.pageYOffset;

            if (window.innerWidth > 991) {
                this.isScrolledSearch = top > 70
            }

            if (this.scroll > top) {
                this.scrolled = false
            } else if (top > 400) {
                this.scrolled = true
            }

            this.scroll = top;
        },
        scrollToHeader() {
            window.scrollTo({top: 0, behavior: 'smooth'});
        }
    }
}
</script>
