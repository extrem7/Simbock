<template>
    <div :class="{'completed-account' : isCompleted}" class="card-work card-work-vacancy">
        <div v-if="hasLogoAndName" class="card-work-company">
            <div class="card-work-company-name">{{ company_title }}</div>
            <img :alt="company_title" :src="company.logo" class="card-work-company-logo">
        </div>
        <div class="card-work-title">{{ title }}</div>
        <div class="card-work-info">
            <div class="card-work-place">{{ location }}</div>
            <span class="vertical-divider"></span>
            <div class="card-work-posted flex-shrink-0">{{ date }}</div>
        </div>
        <div class="card-work-time">{{ employment }}</div>
        <div v-if="hasDescription" class="card-work-text">
            {{ excerpt }}
            <a :href="route('vacancies.show',this.id)" class="link link-border semi-bold-weight">See more</a>
        </div>
        <div v-if="hasActions" class="card-work-actions justify-content-end">
            <a :class="{'was-apply disabled' : isApplied}"
               class="btn btn-outline-violet min-width-100"
               href="" @click.prevent="apply">Apply</a>
            <button :class="{active : inBookmarks}"
                    class="btn btn-bookmark btn-scale-active"
                    @click.prevent="bookmark">
                <svg-vue icon="bookmark"></svg-vue>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        id: Number,
        title: String,
        location: String,
        employment: String,
        date: String,
        excerpt: String,
        company: Object,
        company_title: String,

        isCompleted: {
            type: Boolean,
            default: false
        },
        inBookmarks: {
            type: Boolean,
            default: false
        },
        hasDescription: {
            type: Boolean,
            default: true
        },
        hasActions: {
            type: Boolean,
            default: true
        },
        hasLogoAndName: {
            type: Boolean,
            default: true
        },
        isApplied: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        async apply() {
            const {status, data} = await this.axios.post(this.route('vacancies.actions.apply', this.id))
            if (status === 200) {
                this.$emit('update:applied')
                this.notify(data.message)
            }
        },
        async bookmark() {
            const {status, data} = await this.axios.post(this.route('vacancies.actions.bookmark', this.id))
            if (status === 200) {
                this.$emit('update:bookmarked', data.inBookmarks)
                this.notify(data.message)
            }
        },
    }
}
</script>
