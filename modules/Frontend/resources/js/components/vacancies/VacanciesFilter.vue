<template>
    <div class="filter-wrapper">
        <div class="text-left d-none d-lg-block">
            <a
                class="btn back-to-page btn-scale-active d-flex"
                href="#"
                @click.prevent="back">
                <svg-vue icon="arrow-solid-right"></svg-vue>
            </a>
        </div>
        <h1 class="title title-page title-line line-large mb-3">Additional Settings</h1>
        <div class="filter">
            <div class="title medium-size filter-title">Relocation:</div>
            <div class="row">
                <div class="col-lg-3 col-sm-6 filter-item">
                    <div class="custom-control custom-checkbox">
                        <input id="is-relocation"
                               v-model="filters.is_relocation"
                               class="custom-control-input"
                               type="checkbox">
                        <label class="custom-control-label label-violet"
                               for="is-relocation">
                            Willing to relocate
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="filter">
            <div class="title medium-size filter-title">Volunteer from home or office:</div>
            <div class="row">
                <div class="col-lg-3 col-sm-6 filter-item">
                    <div class="custom-control custom-checkbox">
                        <input id="is-remote-work"
                               v-model="filters.is_remote_work"
                               class="custom-control-input"
                               type="checkbox">
                        <label class="custom-control-label label-violet"
                               for="is-remote-work">
                            Willing to work remotely
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="filter">
            <div class="title medium-size filter-title">Choose hours:</div>
            <div class="row">
                <div v-for="{value,text} in hours"
                     class="col-lg-3 col-sm-6 filter-item">
                    <div class="custom-control custom-checkbox">
                        <input :id="`hour-${value}`"
                               v-model="filters.hours"
                               :value="value"
                               class="custom-control-input"
                               type="checkbox">
                        <label :for="`hour-${value}`" class="custom-control-label label-violet">
                            {{ text }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="filter">
            <div class="title medium-size filter-title">Choose volunteering type:</div>
            <div class="row">
                <div v-for="{value,text} in types"
                     class="col-lg-3 col-sm-6 filter-item">
                    <div class="custom-control custom-checkbox">
                        <input :id="`type-${value}`"
                               v-model="filters.types"
                               :value="value"
                               class="custom-control-input"
                               type="checkbox">
                        <label :for="`type-${value}`" class="custom-control-label label-violet">
                            {{ text }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="filter">
            <div class="title medium-size filter-title">Choose time posted:</div>
            <div class="row">
                <div class="col-lg-3 col-sm-6 filter-item">
                    <div class="custom-control custom-radio">
                        <input
                            id="time-all"
                            v-model="filters.time"
                            :value="null"
                            class="custom-control-input"
                            type="radio">
                        <label class="custom-control-label label-violet"
                               for="time-all">
                            All postings
                        </label>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 filter-item">
                    <div class="custom-control custom-radio">
                        <input
                            id="time-3-days"
                            v-model="filters.time"
                            class="custom-control-input"
                            type="radio"
                            value="3">
                        <label class="custom-control-label label-violet"
                               for="time-3-days">
                            Last 3 Days
                        </label>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 filter-item">
                    <div class="custom-control custom-radio">
                        <input
                            id="time-last-week"
                            v-model="filters.time"
                            class="custom-control-input"
                            type="radio"
                            value="7">
                        <label class="custom-control-label label-violet"
                               for="time-last-week">
                            Last Week
                        </label>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 filter-item">
                    <div class="custom-control custom-radio">
                        <input
                            id="time-last-2-weeks"
                            v-model="filters.time"
                            class="custom-control-input"
                            type="radio"
                            value="14">
                        <label class="custom-control-label label-violet"
                               for="time-last-2-weeks">
                            Last 2 Weeks
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!routeIncludes(['volunteers'])" class="filter">
            <div class="title medium-size filter-title">Choose more Company Sizes:</div>
            <div class="row">
                <div v-for="{value,text} in sizes"
                     class="col-lg-3 col-sm-6 filter-item">
                    <div class="custom-control custom-checkbox">
                        <input :id="`size-${value}`"
                               v-model="filters.sizes"
                               :value="value"
                               class="custom-control-input"
                               type="checkbox">
                        <label :for="`size-${value}`" class="custom-control-label label-violet">
                            {{ text }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="filter">
            <div class="title medium-size filter-title"> Choose an industry or sector below to browse jobs:</div>
            <div class="row">
                <div v-for="chunk in makeChunks(sectors,Math.ceil(sectors.length/4))" class="col-lg-3 col-sm-6">
                    <div v-for="{value,text} in chunk"
                         class="filter-item">
                        <div class="custom-control custom-checkbox">
                            <input :id="`sector-${value}`"
                                   v-model="filters.sectors"
                                   :value="value"
                                   class="custom-control-input"
                                   type="checkbox">
                            <label :for="`sector-${value}`" class="custom-control-label label-violet">
                                {{ text }}
                            </label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="text-center mt-4">
            <button class="btn btn-green btn-shadow btn-scale-active min-width-100 btn-submit-filtered"
                    @click="filter">
                Search
            </button>
        </div>
    </div>
</template>

<script>
import {isString, isArray, isBoolean, chunk} from 'lodash'

export default {
    name: 'VacanciesFilter',
    data() {
        return {
            filters: {
                is_relocation: false,
                is_remote_work: false,
                hours: [],
                types: [],
                time: null,
                sizes: [],
                sectors: []
            },
            sectors: this.shared('sectors'),
            types: this.shared('types'),
            hours: this.shared('hours'),
            sizes: this.shared('sizes')
        }
    },
    created() {
        const filters = new URL(location.href).searchParams
        for (let key in this.filters) {
            const val = this.filters[key],
                param = filters.get(key)
            if (param) {
                if (isString(val)) {
                    this.filters[key] = param
                } else if (isArray(val)) {
                    this.filters[key] = param.split('|')
                } else if (isBoolean(val)) {
                    this.filters[key] = !!param
                } else {
                    this.filters[key] = param
                }
            }
        }
    },
    methods: {
        filter() {
            const filters = {}
            for (let key in this.filters) {
                const val = this.filters[key]
                if (Array.isArray(val)) {
                    if (val.length) filters[key] = val.join('|')
                } else if (val) {
                    filters[key] = val
                }
            }

            const params = decodeURI(new URLSearchParams(filters))
            this.$bus.emit('filter', params)
        },
        back() {
            this.$bus.emit('toggle-filter')
        },
        makeChunks: chunk
    }
}
</script>
