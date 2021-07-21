<template>
    <VolunteersIndex
        :enable-filter="false"
        title="Saved candidates"/>
</template>

<script>
import VolunteersIndex from "./Index"

export default {
    name: "SavedVacancies",
    components: {VolunteersIndex}
}
</script>
