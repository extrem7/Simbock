<template>
    <form @submit.prevent="login">
        <div v-if="!done">
            <div :class="[invalid('email')]" class="form-group">
                <InputMaterial
                    id="email"
                    v-model="form.email"
                    material-gray
                    placeholder="Email address"/>
                <Invalid name="email"></Invalid>
            </div>
            <button class="btn btn-violet w-100 btn-scale-active btn-shadow btn-lg mt-3">
                Send
                <b-spinner v-show="isLoading" small></b-spinner>
            </button>
        </div>
        <p v-else class="medium-size text-center">{{ doneMessage }}</p>
        <div class="extra-small-size text-center mt-3">
            If you still need help, please contact
            <a class="link d-block mx-auto" href="">Simbock Support.</a>
        </div>
    </form>
</template>

<script>
import {BSpinner} from 'bootstrap-vue'
import validation from '~/mixins/validation'

export default {
    components: {BSpinner},
    mixins: [validation],
    data: () => ({
        done: false,
        doneMessage: '',
        form: {
            email: null
        }
    }),
    methods: {
        async login() {
            try {
                const {status, data} = await this.send(this.route('password.email'), this.form)
                if (status === 200) {
                    this.done = true
                    this.doneMessage = data.message
                }
            } catch (e) {
                console.log(e)
            }
        }
    }
}
</script>
