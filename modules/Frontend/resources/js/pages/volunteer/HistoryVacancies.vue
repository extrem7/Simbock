<template>
    <VacanciesIndex
        :enable-actions="false"
        :enable-filter="false"
        title="History Vacancies"/>
</template>

<script>
import VacanciesIndex from "~/components/vacancies/VacanciesIndex"

export default {
    name: "HistoryVacancies",
    components: {VacanciesIndex}
}
</script>
