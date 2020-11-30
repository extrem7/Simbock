import locationService from "~/services/location";

export default {
    data() {
        return {
            query: '',
            cityQuery: '',
            jobs: [],
            cities: [],
        }
    },
    computed: {
        action() {
            const params = {
                query: this.query.split(' ').join('-'),
            }
            if (this.cityQuery) {
                params.location = this.cityQuery.replace(',', '-').split(' ').join('-')
            }
            return this.route('vacancies.index', params)
        }
    },
    watch: {
        async query(val) {
            if (this.query.length > 1 && !this.jobs.includes(val)) {
                const {data} = await this.axios.get(`/api/vacancies/${this.query}`)
                if (data) this.jobs = data
            }
        },
        async cityQuery(query) {
            if (query.length && !this.cities.includes(query)) {
                this.cities = (await locationService.searchCity(query)).map(({text}) => text)
            }
        }
    },
    methods: {
        submit() {
            if (this.query) location.href = this.action
        }
    }
}
