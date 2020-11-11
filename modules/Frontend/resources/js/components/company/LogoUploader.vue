<template>
    <div :class="[invalid('logo')]" class="simbok-image-uploader form-group">
        <input ref="input" accept="image/*" name="image" type="file" @change="setImage">

        <div class="company-info-logo">
            <div class="flex-shrink-0 mr-4 company-info-logo-label">Company logo</div>
            <button class="btn btn-action-img btn-upload-img" @click.prevent="showFileChooser">
                <img alt="add-photo" src="/dist/img/icons/plus-light.svg">
            </button>
            <button class="btn btn-action-img btn-delete ml-2" @click.prevent="destroy">
                <img alt="delete-photo" src="/dist/img/icons/delete-white.svg">
            </button>
        </div>
        <div v-if="value && !image" class="company-info-logo-box mt-3">
            <img :src="value" alt="logo" class="card-work-company-logo">
        </div>
        <VueCropper v-show="image"
                    ref="cropper"
                    :src="image"
                    class="vue-cropper"/>
        <div v-if="image">
            <a class="btn btn-success mt-2" href="#" @click.prevent="upload">
                Upload
                <b-spinner v-show="isLoading" small></b-spinner>
            </a>
            <a class="btn btn-danger mt-2" href="#" @click.prevent="resetImage">Reset</a>
        </div>
        <Invalid name="logo"/>
    </div>
</template>

<script>
import VueCropper from 'vue-cropperjs'
import validation from "~/mixins/validation"

export default {
    components: {
        VueCropper
    },
    mixins: [validation],
    props: {
        value: String
    },
    data() {
        return {
            imageName: null,
            image: null,
        }
    },
    methods: {
        async upload() {
            const form = new FormData
            const logo = await this.getBlob()
            form.append('logo', logo, logo.name)
            try {
                const {status, data} = await this.send(this.route('company.info.logo.update'), form)
                if (status === 200) {
                    this.resetImage()
                    this.$emit('input', data.logo)
                    this.notify(data.message)
                }
            } catch (e) {
                console.log(e)
            }
        },
        async destroy() {
            try {
                const {status, data} = await this.axios.delete(this.route('company.info.logo.destroy'))
                if (status === 200) {
                    this.resetImage()
                    this.$emit('input', null)
                    this.notify(data.message)
                }
            } catch (e) {
                console.log(e)
            }
        },
        async getBlob() {
            return new Promise((resolve) => {
                if (!this.image) resolve(null)
                const canvas = this.$refs.cropper.getCroppedCanvas()
                if (canvas)
                    canvas.toBlob((blob) => {
                        blob.name = this.imageName
                        resolve(blob)
                    })

            })
        },
        resetImage() {
            this.image = null
            this.$refs.cropper.reset()
            this.errors = {}
        },
        setImage(e) {
            const file = e.target.files[0]
            if (file.type.indexOf('image/') === -1) {
                alert('Please select an image file')
                return
            }
            this.imageName = file.name
            const reader = new FileReader()
            reader.onload = (event) => {
                this.image = event.target.result
                this.$refs.cropper.replace(event.target.result)
            }
            reader.readAsDataURL(file)
        },
        showFileChooser() {
            this.$refs.input.click()
        },
    }
}
</script>
