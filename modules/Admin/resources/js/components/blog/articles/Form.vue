<template>
    <div class="col-md-10 col-lg-8">
        <form class="card" @submit.prevent="submit">
            <div class="card-body">
                <div class="form-group">
                    <label for="category">Category</label>
                    <b-form-select id="category" v-model="form.category_id" v-valid="form.category_id"
                                   :options="categories"></b-form-select>
                    <invalid name="category_id"></invalid>
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input id="title" v-model="form.title" v-valid.title class="form-control meta_description mb-2"
                           placeholder="Title" type="text">
                    <invalid name="title"></invalid>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input id="slug" v-model="form.slug" v-valid.slug class="form-control meta_description mb-2"
                           placeholder="Slug" type="text">
                    <invalid name="slug"></invalid>
                </div>
                <div class="form-group">
                    <label for="body">Body</label>
                    <editor id="body" v-model="form.body" placeholder="Body"></editor>
                    <invalid name="body"></invalid>
                </div>
                <div class="form-group">
                    <label for="excerpt">Excerpt</label>
                    <b-form-textarea
                        id="excerpt"
                        v-model="form.excerpt"
                        max-rows="3"
                        placeholder="Excerpt"
                        rows="3"
                    ></b-form-textarea>
                    <invalid name="excerpt"></invalid>
                </div>

                <red-cropper ref="cropper" :old="oldImage" validate="image"></red-cropper>

                <h4 class="mt-4">Seo settings</h4>
                <div class="form-group">
                    <label for="meta_title">Title</label>
                    <input id="meta_title" v-model="form.meta_title" v-valid.meta_title
                           class="form-control meta_description mb-2"
                           placeholder="Title" type="text">
                    <invalid name="meta_title"></invalid>
                </div>
                <div class="form-group">
                    <label for="meta_description">Description</label>
                    <input id="meta_description" v-model="form.meta_description" v-valid.meta_description
                           class="form-control meta_description mb-2"
                           placeholder="Description" type="text">
                    <invalid name="meta_description"></invalid>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <b-form-select id="category" v-model="form.status" v-valid="form.status"
                                   :options="statuses"></b-form-select>
                    <invalid name="status"></invalid>
                </div>
            </div>
            <card-footer></card-footer>
        </form>
    </div>
</template>

<script>
    import form from '@/mixins/form'

    export default {
        mixins: [form],
        created() {
            const article = this.shared('article')
            if (article) {
                this.setupEdit(article)
            } else {
                this.form.status = this.statuses[0].value
            }
        },
        data() {
            return {
                form: {
                    category_id: null,
                    title: '',
                    slug: '',
                    body: '',
                    excerpt: '',

                    meta_title: '',
                    meta_description: '',

                    status: null,
                },
                resource: 'blog.articles',
                categories: [{text: 'Choose category', value: null}, ...this.shared('categories')],
                statuses: this.shared('statuses'),
                oldImage: null
            }
        },
        methods: {
            async submit() {
                const form = this.jtf(this.form, {
                    includeNullValues: true,
                    mapping: (value) => value === null ? '' : value
                })

                const image = await this.$refs.cropper.getBlob()
                if (image) form.append('image', image, image.name)

                try {
                    if (this.isEdit) {
                        const {status, data} = await this.send(
                            this.route(`admin.${this.resource}.update`, this.id), form
                        )
                        if (status === 200) {
                            this.setupEdit(data.article)
                            if (image) this.$refs.cropper.resetImage()
                            this.$bus.emit('alert', {text: data.status})
                        }
                    } else {
                        const {status, data} = await this.send(this.route(`admin.${this.resource}.store`), form)
                        if (status === 201) {
                            const article = data.article
                            this.setupEdit(article)
                            if (image) this.$refs.cropper.resetImage()
                            document.title = data.title
                            history.pushState(
                                null, data.title, this.route(`admin.${this.resource}.edit`, article.id)
                            )
                            this.$bus.emit('alert', {text: data.status})
                        }
                    }
                } catch (e) {
                    console.log(e)
                }
            },
            setupEdit(article) {
                this.$super(form).setupEdit(article)
                if (this.isEdit && article.image) this.oldImage = article.image
            }
        }
    }
</script>

