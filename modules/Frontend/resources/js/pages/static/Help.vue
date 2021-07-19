<template>
    <main class="container content-inner">
        <h1 class="title title-page title-line line-medium mb-4">{{ title }}</h1>
        <div class="row">
            <div class="offset-xl-2 col-xl-5 col-lg-8 col-md-7" v-html="content"></div>
            <div class="col-xl-3 col-lg-4 col-md-5 mt-3 mt-md-0">
                <div class="medium-size semi-bold-weight mb-3">Give us your feedback</div>
                <form @submit.prevent="submit">
                    <div :class="[invalid('name')]" class="form-group">
                        <InputMaterial
                            v-model="form.name"
                            material
                            placeholder="Name"/>
                        <Invalid name="name"/>
                    </div>
                    <div :class="[invalid('email')]" class="form-group">
                        <InputMaterial
                            v-model="form.email"
                            material
                            placeholder="E-mail address"
                            required
                            type="email"/>
                        <Invalid name="email"/>
                    </div>
                    <div :class="[invalid('comment')]" class="form-group control-material_mod">
                        <textarea
                            v-model="form.comment"
                            class="form-control form-control-material"
                            placeholder="Enter your comments (0/1200 characters)"
                            rows="4"></textarea>
                        <Invalid name="comment"/>
                    </div>
                    <button class="btn btn-silver btn-send-message min-width-100 btn-scale-active">
                        <SvgVue icon="telegramm"/>
                    </button>
                </form>
            </div>
        </div>
    </main>
</template>

<script>
import validation from "~/mixins/validation";

export default {
    name: "HelpPage",
    mixins: [validation],
    data() {
        return {
            title: this.shared('title'),
            content: this.shared('content'),

            form: {
                name: '',
                email: '',
                comment: ''
            }
        }
    },
    methods: {
        async submit() {
            try {
                const {status, data} = await this.send(this.route('contact-form'), this.form)
                if (status === 200) {
                    for (let f in this.form) this.form[f] = ''
                    this.notify(data.message)
                }
            } catch (e) {
                console.log(e)
            }
        }
    }
}
</script>
