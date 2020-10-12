<template>

    <div :class="{'is-search-fixed' : isMobileSearchFixed}" class="search-form search-form-header">
        <div class="container">
            <div class="search-form-wrapper">
                <div class="search-field-group search-form-item search-form-what">
                    <div class="search-group-box">What</div>
                    <input-search icon="search" placeholder="Job tittle or keyword"></input-search>
                </div>
                <div class="search-field-group search-form-item search-form-where">
                    <div class="search-group-box">What</div>
                    <input-search icon="map" placeholder="City, state or ZIP"></input-search>
                </div>
                <div class="search-form-item order-mobile-1">
                    <a v-b-tooltip.hover class="btn btn-filter btn-rotate-icon btn-scale-active" href=""
                       title="Tooltip directive content">
                        <svg-vue icon="filter"></svg-vue>
                    </a>
                </div>
                <div class="search-form-item flex-grow-1 flex-md-grow-0">
                    <button class="btn btn-violet btn-main-search btn-shadow">Search</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import InputSearch from "./InputSearch"

export default {
    data() {
        return {
            isMobileSearchFixed: false
        }
    },
    created() {
        this.$bus.on('search-toggle', () => {
            this.isMobileSearchFixed = !this.isMobileSearchFixed;
        })
    },
    components: {
        InputSearch,
    }
}
</script>
