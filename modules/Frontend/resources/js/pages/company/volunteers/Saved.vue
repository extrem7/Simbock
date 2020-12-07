<template>
    <VolunteersIndex
        :enable-filter="false"
        title="Saved Candidates"/>
</template>

<script>
import VolunteersIndex from "./Index"

export default {
    name: "SavedVacancies",
    components: {VolunteersIndex}
}
</script>
