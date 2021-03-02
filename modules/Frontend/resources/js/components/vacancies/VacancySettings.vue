<template>
    <div class="w-100">
        <div class="job-settings">
            <div class="job-settings-statistics">
                <div class="job-settings-statistics-item">{{ days }}
                    <span class="d-block extra-small-size line-height-1">Day posted</span>
                </div>
                <img alt="divider" src="/dist/img/icons/divider.svg">
                <div class="job-settings-statistics-item">0
                    <span class="d-block extra-small-size line-height-1">Visitors</span>
                </div>
                <img alt="divider" src="/dist/img/icons/divider.svg">
                <a class="job-settings-statistics-item link-inherit" href="">View
                    <span class="d-block extra-small-size line-height-1">Candidates</span>
                </a>
            </div>
            <div :class="[`job-status-${status.toLocaleLowerCase()}`]" class="job-status">{{ statuses[status] }}</div>
            <button v-if="['DRAFT','STOPPED'].includes(status)"
                    class="btn btn-outline-violet btn-flex btn-sm btn-job-post btn-scale-active"
                    @click.prevent="post">
                <svg-vue class="mr-1" icon="arrow-up"></svg-vue>
                Post a need
            </button>
            <div class="job-settings-actions mt-1">
                <button :disabled="status!=='ACTIVE'"
                        class="btn btn-flex btn-job-action"
                        @click.prevent="stop">
                    <svg-vue class="mr-2" icon="stop"></svg-vue>
                    Stop post
                </button>
                <button :disabled="!['ACTIVE','DRAFT'].includes(status)" class="btn btn-flex btn-job-action"
                        @click.prevent="close">
                    <svg-vue class="mr-2" icon="cancel"></svg-vue>
                    Close post
                </button>
                <a v-if="status!=='CLOSED'" :href="route('company.vacancies.edit',this.id)"
                   class="btn btn-flex btn-job-action">
                    <svg-vue class="mr-2" icon="pen"></svg-vue>
                    Edit
                </a>
                <a :href="route('vacancies.show',this.id)" class="btn btn-flex btn-job-action">
                    <svg-vue class="mr-2" icon="binocl"></svg-vue>
                    Preview
                </a>
                <a :href="route('company.vacancies.duplicate',this.id)" class="btn btn-flex btn-job-action">
                    <svg-vue class="mr-2" icon="copy"></svg-vue>
                    Duplicate
                </a>
                <button class="btn btn-flex btn-job-action" @click.prevent="destroy">
                    <svg-vue class="mr-2" icon="delete"></svg-vue>
                    Delete
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import statuses from "./statuses.json"

export default {
    props: {
        id: Number,
        days: Number,
        status: String,
    },
    data() {
        return {
            isShowInfo: true,
            statuses
        }
    },
    methods: {
        async post() {
            const {status, data} = await this.axios.post(this.route('company.vacancies.post', this.id))
            if (status === 200) {
                this.$emit('update:status', 'ACTIVE')
                this.notify(data.message)
            }
        },
        async stop() {
            this.$confirm("Are you sure?").then(async () => {
                const {status, data} = await this.axios.post(this.route('company.vacancies.stop', this.id))
                if (status === 200) {
                    this.$emit('update:status', 'DRAFT')
                    this.notify(data.message)
                }
            })
        },
        async close() {
            this.$confirm("Are you sure?").then(async () => {
                const {status, data} = await this.axios.post(this.route('company.vacancies.close', this.id))
                if (status === 200) {
                    this.$emit('update:status', 'CLOSED')
                    this.notify(data.message)
                }
            })
        },
        async destroy() {
            this.$confirm("Are you sure?").then(async () => {
                const {status, data} = await this.axios.delete(this.route('company.vacancies.destroy', this.id))
                if (status === 200) {
                    this.$emit('destroy')
                    this.notify(data.message)
                }
            })
        },
    }
}
</script>
