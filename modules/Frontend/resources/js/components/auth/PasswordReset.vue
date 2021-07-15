<template>
    <form @submit.prevent="reset">
        <div class="extra-small-size mb-3 line-height-1">To continue, provide new password.</div>
        <div :class="[invalid('email')]" class="form-group">
            <InputMaterial
                id="email"
                v-model="form.email"
                material-gray
                placeholder="Email address"/>
            <Invalid name="email"></Invalid>
        </div>
        <div :class="[invalid('password')]" class="form-group">
            <InputMaterial
                id="password"
                v-model="form.password"
                is-password-type
                material-gray
                placeholder="Password"
                type="password"/>
            <Invalid name="password"></Invalid>
        </div>
        <div class="form-group">
            <InputMaterial
                id="password_confirmation"
                v-model="form.password_confirmation"
                is-password-type
                material-gray
                placeholder="Confirm password"
                type="password"/>
        </div>
        <button
            class="btn btn-violet w-100 btn-scale-active btn-shadow btn-lg mt-3">
            Reset Password
            <b-spinner v-show="isLoading" small></b-spinner>
        </button>
    </form>
</template>

<script>
import {BSpinner} from 'bootstrap-vue'
import validation from '~/mixins/validation'

export default {
    components: {BSpinner},
    mixins: [validation],
    data() {
        return {
            form: {
                email: this.shared('email'),
                password: null,
                password_confirmation: null
            }
        }
    },
    methods: {
        async reset() {
            try {
                const {status, data} = await this.send(this.route('password.update'), {
                    ...this.form,
                    token: this.shared('token')
                })
                if (status === 200) {
                    location.href = data.redirect
                }
            } catch (e) {
                console.log(e)
            }
        }
    }
}
</script>

