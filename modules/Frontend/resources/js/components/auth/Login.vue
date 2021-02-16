<template>
    <div>
        <div class="medium-size text-center mt-4 mb-sm-4 mb-3">To continue, log in to Simboсk</div>
        <div class="login-social-wrapper">
            <a class="btn btn-login-social" href="">
                <img alt="facebook-login" src="dist/img/icons/facebook-login.svg">
            </a>
            <a class="btn btn-login-social" href="">
                <img alt="google-login" src="dist/img/icons/google-login.svg">
            </a>
        </div>

        <div class="mt-2 mt-sm-3 mb-3 text-center small-size">or</div>

        <form @submit.prevent="login">
            <div :class="[invalid('email')]" class="form-group">
                <InputMaterial
                    id="email"
                    v-model="form.email"
                    material-gray
                    placeholder="Email address"/>
                <Invalid name="email"></Invalid>
            </div>
            <div :class="[invalid('email')]" class="form-group">
                <InputMaterial
                    id="password"
                    v-model="form.password"
                    is-password-type
                    material-gray
                    placeholder="Password"
                    type="password"/>
                <Invalid name="password"></Invalid>
            </div>
            <div class="text-right">
                <a :href="route('password.request')" class="extra-small-size link">Forgot your password?</a>
            </div>
            <div class="custom-control custom-checkbox mt-2 mb-2">
                <input id="remember" v-model="form.remember" class="custom-control-input" type="checkbox">
                <label class="custom-control-label extra-small-size" for="remember">Remember me</label>
            </div>
            <button class="btn btn-violet w-100 btn-scale-active btn-shadow btn-lg mt-3">Log in</button>
            <div class="extra-small-size text-center mt-3">
                Don't have an account?
                <a :href="route('register')" class="link">Sign up for Simboсk</a></div>
        </form>
    </div>
</template>

<script>
import validation from "~/mixins/validation"

export default {
    mixins: [validation],
    data: () => ({
        form: {
            email: null,
            password: null,
            remember: false
        }
    }),
    methods: {
        async login() {
            try {
                const {status, data} = await this.send('', this.form)
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
