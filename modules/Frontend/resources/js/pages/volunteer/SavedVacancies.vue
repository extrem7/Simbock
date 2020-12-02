<template>
    <VacanciesIndex
        :enable-filter="false"
        title="Saved Vacancies"/>
</template>

<script>
import VacanciesIndex from "~/components/vacancies/VacanciesIndex"

export default {
    name: "SavedVacancies",
    components: {VacanciesIndex}
}
</script>
