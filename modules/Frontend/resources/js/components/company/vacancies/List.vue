<template>
    <div class="card-list">
        <div v-for="(vacancy,i) in vacancies" class="job-settings-wrapper">
            <VacancyCard
                v-bind="vacancyProps(vacancy)"
                :has-actions="false"
                is-completed/>
            <VacancySettings
                :id="vacancy.id"
                :days="vacancy.days"
                :status="vacancy.status"
                @destroy="destroyVacancy(i)"
                @update:status="updateVacancyStatus(i,$event)"
            />
        </div>
    </div>
</template>

<script>
import Vue from 'vue'

import VacancyCard from "~/components/vacancies/VacancyCard"
import VacancySettings from "~/components/vacancies/VacancySettings"

export default {
    components: {
        VacancyCard,
        VacancySettings
    },
    data() {
        return {
            vacancies: this.shared('vacancies')
        }
    },
    methods: {
        updateVacancyStatus(i, status) {
            this.vacancies[i]['status'] = status
        },
        destroyVacancy(i) {
            Vue.delete(this.vacancies, i)
        },
        vacancyProps(vacancy) {
            const props = {}
            const fields = ['id', 'title', 'location', 'employment', 'date', 'excerpt', 'company', 'company_title']
            for (let field of fields) props[field] = vacancy[field]
            return props
        }
    }
}
</script>

