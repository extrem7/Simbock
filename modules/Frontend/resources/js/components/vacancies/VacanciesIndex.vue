<template>
    <main class="container content-inner">
        <Transition
            mode="out-in"
            name="fade">
            <VacanciesFilter v-if="isFilterOpen" key="filter"/>
            <div v-else key="list" class="row card-list mt-0">
                <div v-if="vacancies.length" class="col-xl-8">
                    <VacancyCard
                        v-for="(vacancy,i) in vacancies"
                        :key="vacancy.id"
                        v-bind="vacancyProps(vacancy)"
                        :in-bookmarks="vacancy.in_bookmarks"
                        :is-applied="vacancy.is_applied"
                        is-bookmarked
                        is-completed
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
                    <div class="simbok-banner">
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
import VacancyCard from "./VacancyCard"
import VacanciesFilter from "./VacanciesFilter";

export default {
    name: 'VacanciesIndex',
    components: {
        VacanciesFilter,
        VacancyCard
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
    created() {
        this.$bus.on('toggle-filter', () => {
            this.isFilterOpen = !this.isFilterOpen
        })
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
            return props
        }
    }
}
</script>

<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity .3s;
}

.fade-enter, .fade-leave-to {
    opacity: 0;
}
</style>
