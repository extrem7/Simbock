<template>
    <div :class="[invalid('avatar')]" class="simbok-image-uploader form-group">
        <input ref="input" accept="image/*" name="image" type="file" @change="setImage">

        <div class="company-info-logo d-flex justify-content-center">
            <button class="btn btn-green min-width-140 btn-lg"
                    @click.prevent="showFileChooser">
                Select file
            </button>
        </div>
        <VueCropper
            v-show="image"
            ref="cropper"
            :src="image"
            class="vue-cropper w-100"/>
        <div v-if="image">
            <div class="modal-actions mt-3">
                <button class="btn btn-outline-silver min-width-100 btn-drop-shadow btn-scale-active"
                        @click="cancel">
                    Cancel
                </button>
                <button class="btn btn-green min-width-100 btn-shadow btn-scale-active"
                        @click="upload">
                    Upload
                    <BSpinner v-show="isLoading" small/>
                </button>
            </div>
        </div>
        <Invalid name="avatar"/>
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
    data() {
        return {
            imageName: null,
            image: null,
        }
    },
    mounted() {
        this.$refs.input.click()
    },
    methods: {
        async upload() {
            const form = new FormData
            const avatar = await this.getBlob()
            form.append('avatar', avatar, avatar.name)
            try {
                const {status, data} = await this.send(this.route('volunteer.account.avatar.update'), form)
                if (status === 200) {
                    this.resetImage()
                    this.$emit('update', data.avatar)
                    //this.notify(data.message)
                    this.$bvModal.hide('modal-avatar')
                }
            } catch (e) {
                console.log(e)
            }
        },
        cancel() {
            this.resetImage()
            this.$bvModal.hide('modal-avatar')
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
