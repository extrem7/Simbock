<template>
    <a :class="{'completed-account' : isCompleted}"
       :href="route('companies.show',id)"
       class="d-block card-work card-company link-inherit">
        <div class="card-company-profile">
            <img :alt="name"
                 :src="logo"
                 class="card-work-company-logo">
            <div>
                <div class="card-company-name">{{ name }}</div>
                <div class="mt-2">
                    <div class="card-company-short-info">{{ employment }}</div>
                    <div class="card-company-short-info mt-1">{{ location }}</div>
                </div>
            </div>
        </div>
    </a>
</template>

<script>
export default {
    props: {
        id: Number,
        name: String,
        logo: String,
        employment: String,
        location: String,
        isCompleted: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        link() {
            return this.route('')
        }
    }
}
</script>
