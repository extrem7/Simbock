import Editor from "@/components/includes/forms/Editor"
import Invalid from "@/components/includes/forms/Invalid"
import CardFooter from "@/components/includes/forms/CardFooter"

import vSelect from 'vue-select'
import RedCropper from "@/components/includes/forms/RedCropper"

import {errors} from "@/helpers/helpers"

import {ReactiveProvideMixin} from 'vue-reactive-provide'

import jsonToForm from 'json-form-data'

export default {
    data() {
        return {
            id: null,
            isEdit: false,
            files: [],
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
        setupEdit(model) {
            if (model) {
                if (!this.isEdit) this.isEdit = true

                this.id = model.id
                for (let field in this.form) {
                    if (model[field] !== undefined && model[field] !== null) this.form[field] = model[field]
                }
            }
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
        }
    },
    provide() {
        return {
            resource: this.resource,
            isEdit: this.isEdit,
        }
    },
    directives: {
        valid(el, {modifiers}, {context}) {
            if (Object.keys(modifiers)[0] in context.errors) {
                el.classList.remove('is-valid')
                el.classList.add('is-invalid')
            } else {
                el.classList.remove('is-invalid')
                if (context.wasValidated) {
                    el.classList.add('is-valid')
                } else if (el.classList.contains('is-valid')) {
                    el.classList.remove('is-valid')
                }
            }
        }
    },
    mixins: [
        ReactiveProvideMixin({
            name: 'errorsInject',
            include: ['errors']
        }),
        ReactiveProvideMixin({
            name: 'footerInject',
            include: ['resource', 'isEdit', 'isLoading']
        })
    ],
    components: {
        Editor,
        Invalid,
        CardFooter,

        vSelect,
        RedCropper,
    }
}
