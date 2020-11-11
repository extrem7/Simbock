import {mapState} from "vuex"
import {ReactiveProvideMixin} from 'vue-reactive-provide'
import Invalid from "~/components/includes/Invalid"

export default {
    components: {
        Invalid
    },
    mixins: [
        ReactiveProvideMixin({
            name: 'errorsInject',
            include: ['errors']
        }),
    ],
    data() {
        return {
            isLoading: false,
            formConfig: {
                header: {
                    'Content-Type': 'multipart/form-data'
                }
            }
        }
    },
    computed: {
        ...mapState(['errors'])
    },
    created() {
        this.fill()
    },
    methods: {
        async update() {
            if (await this.$store.dispatch('volunteer/updateAbout', this.form)) this.$refs.modal.hide()
        },
        invalid(field) {
            if (field in this.errors) return 'has-error'
        },
        fill() {
            for (let field in this.form) {
                if (this.form.hasOwnProperty(field) && this.$store.state.volunteer.form.hasOwnProperty(field))
                    this.form[field] = this.$store.state.volunteer.form[field]
            }
        },
        showModal() {
            this.$refs.modal.show()
        },
        cancel() {
            this.$refs.modal.hide()
            this.fill()
        }
    }
}
