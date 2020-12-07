<template>
    <div class="card-work card-company card-company-actions border-left-0 border-r-10">
        <div class="card-company-profile">
            <div v-if="canEdit"
                 class="sector-actions sector-actions-absolute">
                <a
                    :href="route('company.info.form')" class="btn btn-sector-action btn-sector-edit">
                    <SvgVue icon="settings"/>
                </a>
            </div>
            <img :alt="name" :src="logo" class="card-work-company-logo">
            <div>
                <div class="card-company-name">{{ name }}</div>
                <div class="mt-2">
                    <div class="card-company-short-info">{{ employment }}</div>
                    <div class="card-company-short-info mt-1">{{ location }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        name: String,
        logo: String,
        employment: String,
        location: String,
        isCompleted: {
            type: Boolean,
            default: false
        },
        canEdit: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {}
    }
}
</script>
