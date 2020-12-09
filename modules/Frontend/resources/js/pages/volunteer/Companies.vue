<template>
    <main class="container content-inner">
        <h1 class="title title-page title-line line-large">Company recommend for you</h1>
        <div class="row card-list">
            <div class="col-xl-8">
                <CompanyCard
                    v-for="company in companies"
                    :key="company.id"
                    v-bind="companyProps(company)"
                />
                <div
                    v-if="page!==lastPage"
                    class="text-center">
                    <button
                        class="btn btn-outline-violet violet-color medium-weight btn-load-more btn-scale-active"
                        @click="loadMore">
                        Load More Companies
                        <SvgVue icon="arrow-down"/>
                    </button>
                </div>
            </div>
            <div class="col-xl-4 mt-4 mt-xl-0">
                <div class="simbok-banner">
                    <img alt="" class="i-amphtml-fill-content i-amphtml-replaced-content" decoding="async"
                         src="https://tpc.googlesyndication.com/simgad/173663363447728466?sqp=4sqPyQQ7QjkqNxABHQAAtEIgASgBMAk4A0DwkwlYAWBfcAKAAQGIAQGdAQAAgD-oAQGwAYCt4gS4AV_FAS2ynT4&amp;rs=AOga4qnCv7URJOJbJAOsv9i0WVj6iXmNQw">
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import CompanyCard from "~/components/layout/CompanyCard"

export default {
    components: {
        CompanyCard
    },
    data() {
        const data = this.shared('companies')
        return {
            companies: data.data,
            page: data.current_page,
            lastPage: data.last_page || 1,
        }
    },
    methods: {
        async loadMore() {
            if (this.page < this.lastPage) {
                this.page += 1
                try {
                    const {data} = await this.axios.get(`?page=${this.page}`)
                    this.companies = this.companies.concat(data.data)
                } catch (e) {
                    console.log(e)
                }
            }
        },
        companyProps(company) {
            const props = {}
            const fields = ['id', 'name', 'logo', 'employment', 'location']
            for (let field of fields) props[field] = company[field]
            return props
        }
    }
}
</script>
