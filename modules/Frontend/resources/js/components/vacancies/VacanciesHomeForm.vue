<template>
    <form class="search-form-wrapper" @submit.prevent="submit()">
        <div class="search-field-group search-form-item search-form-what">
            <InputSearch
                ref="query"
                :options="jobs"
                :value="query"
                icon="search"
                placeholder="Vacancy title or keyword"
                @change="query = $event.trim()"/>
        </div>
        <div class="search-field-group search-form-item search-form-where">
            <InputSearch
                :options="cities"
                :value="cityQuery"
                icon="map"
                placeholder="City, state or ZIP"
                @change="cityQuery = $event.trim()"/>
        </div>
        <div class="search-form-item flex-grow-1 flex-md-grow-0">
            <button class="btn btn-violet btn-main-search btn-shadow">
                Search
            </button>
        </div>
    </form>
</template>

<script>
import InputSearch from '~/components/layout/InputSearch'
import vacanciesSearch from '~/mixins/vacancies-search'

export default {
    name: 'VacanciesHomeForm',
    components: {InputSearch},
    mixins: [vacanciesSearch]
}
</script>
