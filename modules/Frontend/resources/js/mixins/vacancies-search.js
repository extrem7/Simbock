import locationService from "~/services/location"

export default {
    data() {
        return {
            query: '',
            cityQuery: '',
            jobs: [],
            cities: [],
        }
    },
    watch: {
        async query(val) {
            if (this.query.length > 1 && !this.jobs.includes(val)) {
                const {data: jobs} = await this.axios.get(`/api/vacancies/${this.query}`)
                if (jobs) this.jobs = jobs
            }
        },
        async cityQuery(query) {
            if (query.length && !this.cities.includes(query)) {
                this.cities = (await locationService.searchCity(query)).map(({text}) => text)
            }
        }
    },
    methods: {
        submit(filters = null) {
            this.$refs.query.update.flush()
            location.href = this.action(filters)
        },
        action(filters = null) {
            const resource = this.routeIncludes(['volunteers']) ? 'volunteers' : 'vacancies',
                params = {
                    query: this.query.split(' ').join('-'),
                }
            if (this.query && this.cityQuery) {
                params.location = this.cityQuery.replace(',', '-').split(' ').join('-')
            }
            return this.route(`${resource}.search${this.cityQuery ? '.location' : ''}`, params)
                +
                (filters !== null ? (!this._.isEmpty(filters) ? `?${filters}` : '') : location.search)
        }
    }
}
