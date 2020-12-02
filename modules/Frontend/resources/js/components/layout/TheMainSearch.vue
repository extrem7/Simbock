<template>
    <div :class="{'is-search-fixed' : isMobileSearchFixed}"
         class="search-form search-form-header">
        <div class="container">
            <form class="search-form-wrapper"
                  @submit.prevent="submit()">
                <div class="search-field-group search-form-item search-form-what">
                    <div class="search-group-box">What</div>
                    <InputSearch
                        :options="jobs"
                        :value="query"
                        icon="search"
                        placeholder="Job tittle or keyword"
                        @change="query = $event.trim()"/>
                </div>
                <div class="search-field-group search-form-item search-form-where">
                    <div class="search-group-box">Where</div>
                    <InputSearch
                        :options="cities"
                        :value="cityQuery"
                        icon="map"
                        placeholder="City, state or ZIP"
                        @change="cityQuery = $event.trim()"/>
                </div>
                <div class="search-form-item order-mobile-1">
                    <a v-if="enableFilter"
                       v-b-tooltip.hover
                       class="btn btn-filter btn-rotate-icon btn-scale-active"
                       href="#"
                       title="Filter results"
                       @click.prevent="filter">
                        <svg-vue icon="filter"></svg-vue>
                    </a>
                </div>
                <div class="search-form-item flex-grow-1 flex-md-grow-0">
                    <button class="btn btn-violet btn-main-search btn-shadow">
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import vacanciesSearch from "~/mixins/vacancies-search";

export default {
    mixins: [vacanciesSearch],
    props: {
        enableFilter: {
            type: Boolean,
            default: true
        }
    },
    data() {
        const query = this.shared('query')
        if (!query) this.$bus.emit('disable-filter')

        let location = this.shared('location')
        if (location) location = location.split('--').join(',').split('-').join(' ')
        return {
            query: query || '',
            cityQuery: location || '',

            isMobileSearchFixed: false
        }
    },
    created() {
        this.$bus.on('filter', filters => {
            this.submit(filters)
        })
        this.$bus.on('search-toggle', () => {
            this.isMobileSearchFixed = !this.isMobileSearchFixed;
        })
    },
    methods: {
        filter() {
            this.$bus.emit('toggle-filter')
        }
    }
}
</script>
