<template>
    <main class="container content-inner">
        <div v-html="content"></div>
        <div class="job-table mt-4">
            <div class="job-table-row">
                <div class="job-table-item job-table-item-job">
                    <div class="medium-size semi-bold-weight">Job Title</div>
                </div>
                <div class="job-table-item job-table-item-location">
                    <div class="medium-size semi-bold-weight">Location</div>
                </div>
                <div class="job-table-item job-table-item-posted">
                    <div class="medium-size semi-bold-weight">Posted</div>
                </div>
            </div>
            <div v-for="{id,title,location,date} in vacancies"
                 class="job-table-row">
                <div class="job-table-item job-table-item-job">
                    <a :href="route('vacancies.show',id)" class="link">{{ title }}</a>
                </div>
                <div class="job-table-item job-table-item-location">{{ location }}</div>
                <div class="job-table-item job-table-item-posted">{{ date }}</div>
            </div>
        </div>
    </main>
</template>

<script>
export default {
    name: "WorkPage",
    data() {
        return {
            content: this.shared('content'),
            vacancies: this.shared('vacancies')
        }
    }
}
</script>
