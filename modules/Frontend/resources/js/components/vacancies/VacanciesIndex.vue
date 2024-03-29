<template>
    <main class="container content-inner">
        <h1 v-if="title"
            class="title title-page title-line line-large">{{ title }}</h1>
        <Transition
            mode="out-in"
            name="fade">
            <VacanciesFilter
                v-if="enableFilter && isFilterOpen"
                key="filter"/>
            <div v-else
                 key="list"
                 :class="{'mt-0':!title}"
                 class="row card-list">
                <div v-if="vacancies.length"
                     class="col-xl-8">
                    <VacancyCard
                        v-for="(vacancy,i) in vacancies"
                        :key="vacancy.id"
                        v-bind="vacancyProps(vacancy)"
                        :in-bookmarks="vacancy.in_bookmarks"
                        :is-applied="vacancy.is_applied"
                        :has-actions="hasActions"
                        @update:applied="updateVacancyApplied(i)"
                        @update:bookmarked="updateVacancyBookmarked(i,$event)"/>

                    <div v-if="page!==lastPage"
                         class="text-center">
                        <button class="btn btn-outline-violet violet-color medium-weight btn-load-more btn-scale-active"
                                @click="loadMore">
                            Load More Vacancies
                            <svg-vue icon="arrow-down"></svg-vue>
                        </button>
                    </div>
                </div>
                <div v-else
                     class="col-xl-8">
                    <BAlert
                        class="text-center"
                        show
                        variant="warning">
                        No vacancies found
                    </BAlert>
                </div>
                <div class="col-xl-4 mt-4 mt-xl-0">
                    <div class="simbok-banner d-none">
                        <img alt="" class="i-amphtml-fill-content i-amphtml-replaced-content" decoding="async"
                             src="https://tpc.googlesyndication.com/simgad/173663363447728466?sqp=4sqPyQQ7QjkqNxABHQAAtEIgASgBMAk4A0DwkwlYAWBfcAKAAQGIAQGdAQAAgD-oAQGwAYCt4gS4AV_FAS2ynT4&amp;rs=AOga4qnCv7URJOJbJAOsv9i0WVj6iXmNQw">
                    </div>
                </div>
            </div>
        </Transition>
    </main>
</template>

<script>
import Vue from 'vue'
import {BAlert} from 'bootstrap-vue'
import VacancyCard from './VacancyCard'
import VacanciesFilter from "./VacanciesFilter"

export default {
    name: 'VacanciesIndex',
    components: {BAlert, VacanciesFilter, VacancyCard},
    props: {
        title: String,
        enableActions: {
            type: Boolean,
            default: true
        },
        enableFilter: {
            type: Boolean,
            default: true
        },
    },
    data() {
        const data = this.shared('vacancies')
        return {
            vacancies: data.data,
            page: data.current_page,
            lastPage: data.last_page || 1,

            isFilterOpen: false
        }
    },
    computed: {
        user() {
            return this.$store.state.user
        },
        hasActions() {
            return (this.user === null || this.user.is_volunteer) && this.enableActions
        }
    },
    created() {
        this.$bus.on('toggle-filter', () => {
            this.isFilterOpen = !this.isFilterOpen
        })
        if (this.enableFilter) this.$bus.emit('enable-filter')
    },
    methods: {
        async loadMore() {
            if (this.page < this.lastPage) {
                this.page += 1
                try {
                    const params = new URL(location.href).searchParams
                    params.set('page', this.page)
                    const {data} = await this.axios.get(`?${decodeURI(params)}`)
                    this.vacancies = this.vacancies.concat(data.data)
                } catch (e) {
                    console.log(e)
                }
            }
        },
        updateVacancyApplied(i) {
            Vue.set(this.vacancies[i], 'is_applied', true)
        },
        updateVacancyBookmarked(i, in_bookmarks) {
            Vue.set(this.vacancies[i], 'in_bookmarks', in_bookmarks)
        },
        vacancyProps(vacancy) {
            const props = {}
            const fields = [
                'id', 'title', 'location', 'employment', 'date', 'excerpt',
                'company', 'company_title'
            ]
            for (let field of fields) props[field] = vacancy[field]
            props.isCompleted = vacancy.is_completed
            return props
        }
    }
}
</script>
