<template>
    <b-tab :active="isActive" :title="title">
        <div class="medium-size text-center mt-4 mb-sm-4 mb-3">Sign up with</div>
        <div class="login-social-wrapper">
            <a class="btn btn-login-social" href="">
                <img alt="facebook-login" src="dist/img/icons/facebook-login.svg">
            </a>
            <a :href="google" class="btn btn-login-social">
                <img alt="google-login" src="dist/img/icons/google-login.svg">
            </a>
        </div>

        <div class="mt-2 mt-sm-3 mb-2 text-center small-size">or</div>

        <div class="medium-size text-center mb-3">Sign up with your email address</div>
        <form @submit.prevent="register">
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
            <button class="btn btn-violet w-100 btn-scale-active btn-shadow btn-lg mt-3">Sign up</button>
            <div class="extra-small-size text-center mt-3">Already have an account?
                <a :href="route('login')" class="link">Log in</a>
            </div>
        </form>
    </b-tab>
</template>

<script>
import validation from "~/mixins/validation"

export default {
    mixins: [validation],
    props: {
        title: String,
        isCompany: {
            type: Boolean,
            default: false
        },
        isActive: Boolean
    },
    data: () => ({
        form: {
            email: null,
            password: null,
            password_confirmation: null
        }
    }),
    computed: {
        google() {
            return this.route('auth.' + (this.isVolunteer ? 'provider' : 'provider_company'), 'google')
        }
    },
    methods: {
        async register() {
            try {
                const {status, data} = await this.send('', {
                    ...this.form,
                    is_company: this.isCompany
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
