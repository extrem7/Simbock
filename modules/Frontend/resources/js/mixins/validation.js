import {ReactiveProvideMixin} from 'vue-reactive-provide'
import jsonToForm from "json-form-data"

import Invalid from "~/components/includes/Invalid"

import {errors} from "~/helpers/helpers"

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
            errors: {},
            isLoading: false,
            wasValidated: false,

            formConfig: {
                header: {
                    'Content-Type': 'multipart/form-data'
                }
            }
        }
    },
    methods: {
        invalid(field) {
            if (field in this.errors) return 'has-error'
        },
        async send(url, form) {
            this.isLoading = true
            try {
                const {status, data} = await this.axios.post(
                    url, form, form instanceof FormData ? this.formConfig : null
                )
                this.wasValidated = false
                this.errors = {}
                return {status, data}
            } catch ({response}) {
                this.wasValidated = true
                this.$bus.emit('alert', {variant: 'warning', text: response.data.message})
                this.errors = errors(response)
            } finally {
                this.isLoading = false
            }
        },
        jtf(json, options = null) {
            const form = jsonToForm(json, options)
            if (this.isEdit) form.append('_method', 'PATCH')
            return form
        },
    }
}
