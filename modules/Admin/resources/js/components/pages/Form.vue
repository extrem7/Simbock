<template>
    <div class="col-md-10 col-lg-8">
        <form class="card" @submit.prevent="submit">
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input id="title" v-model="form.title" v-valid.title class="form-control" placeholder="Title">
                    <invalid name="title"></invalid>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input id="slug" v-model="form.slug" v-valid.slug class="form-control" placeholder="Slug">
                    <invalid name="slug"></invalid>
                </div>
                <div class="form-group">
                    <label for="body">Body</label>
                    <editor id="body" v-model="form.body" placeholder="Body"></editor>
                    <invalid name="body"></invalid>
                </div>

                <h4 class="mt-4">Seo settings</h4>
                <div class="form-group">
                    <label for="meta_title">Title</label>
                    <input id="meta_title" v-model="form.meta_title" v-valid.meta_title class="form-control"
                           placeholder="Title">
                    <invalid name="meta_title"></invalid>
                </div>
                <div class="form-group">
                    <label for="meta_description">Description</label>
                    <input id="meta_description" v-model="form.meta_description" v-valid.meta_description

                           class="form-control" placeholder="Description">
                    <invalid name="meta_description"></invalid>
                </div>
            </div>
            <card-footer></card-footer>
        </form>
    </div>
</template>

<script>
    import form from "@/mixins/form"

    export default {
        mixins: [form],
        data() {
            return {
                form: {
                    title: '',
                    slug: '',
                    body: '',
                    meta_title: '',
                    meta_description: '',
                },
                resource: 'pages',
                singular: 'page'
            }
        },
        created() {
            const page = this.shared('page')
            if (page) this.setupEdit(page)
        },
        methods: {
            submit() {
                this.easySubmit()
            }
        }
    }
</script>

