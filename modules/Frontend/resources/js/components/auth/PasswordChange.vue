<template>
    <form @submit.prevent="reset">
        <div :class="[invalid('current_password')]" class="form-group">
            <InputMaterial
                id="password"
                v-model="form.current_password"
                is-password-type
                material-gray
                placeholder="Enter your current password"
                type="password"/>
            <Invalid name="current_password"></Invalid>
            <div class="extra-small-size mb-3 line-height-1 mt-2">Forgot password?
                <a :href="route('password.request')" class="link">Click here</a> and we'll email you a link to
                reset your password.
            </div>
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
import validation from "~/mixins/validation"

export default {
    mixins: [validation],
    data() {
        return {
            form: {
                current_password: null,
                password: null,
                password_confirmation: null
            }
        }
    },
    methods: {
        async reset() {
            try {
                const {status, data} = await this.send(this.route('auth.change_password.update'), {
                    ...this.form,
                    token: this.shared('token')
                })
                if (status === 200) {
                    for (let field in this.form) this.form[field] = null

                    this.notify(data.message)
                }
            } catch (e) {
                console.log(e)
            }
        }
    }
}
</script>

