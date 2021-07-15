<template>
    <div class="sector sector-middle sector-resume">
        <div class="sector-label">Resume</div>
        <div class="item-box">
            <div v-if="!resume" class="sector-header">
                <button class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg"
                        @click="showModal">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add Resume</span>
                </button>
            </div>
            <div v-else class="sector-body sector-body-divider">
                <div class="sector-body-inner">
                    <div class="sector-text-between">
                        <a :href="resume.url"
                           class="sector-name"
                           target="_blank">{{ resume.title }}</a>
                        <div class="sector-actions">
                            <button v-b-modal.resume-delete class="btn btn-link">
                                Delete
                            </button>
                            <div class="divider"></div>
                            <button v-b-modal.resume-replace class="btn btn-link">
                                Replace
                            </button>
                        </div>
                    </div>
                    <a :href="resume.url"
                       class="sector-text extra-small-size mt-1"
                       target="_blank">
                        Added {{ dayjs(resume.created_at).format('d.m.YYYY, hh:ss') }}
                    </a>
                </div>
            </div>
        </div>
        <BModal id="resume-modal" ref="modal" hide-footer @hidden="clear">
            <template v-slot:modal-header="{ close }">
                <ModalHeader :close="close" title="Resume"/>
            </template>
            <div :class="[invalid('title')]" class="form-group">
                <InputMaterial
                    v-model="form.title"
                    placeholder="Title"/>
                <Invalid name="title"/>
            </div>
            <div :class="[invalid('file')]" class="form-group">
                <p class="mb-2">Less than 1 MB.</p>
                <BFormFile
                    v-model="form.file"
                    accept="application/pdf"
                    drop-placeholder="Drop file here..."
                    placeholder="Choose a file..."/>
                <Invalid name="file"/>
            </div>
            <ModalActions @cancel="hideModal" @save="update"/>
        </BModal>
        <BModal id="resume-delete" hide-footer>
            <template v-slot:modal-header="{ close }">
                <ModalHeader :close="close"/>
            </template>
            <div class="d-flex flex-column align-items-center">
                <img alt="danger" class="modal-title-icon" src="/dist/img/icons/danger.svg">
                <div class="mt-3 mb-3 text-center">Are you sure you want to delete?</div>
                <button class="btn btn-red min-width-140 btn-shadow"
                        @click="destroy">Yes, delete
                </button>
                <button class="btn small-size silver-color normal-weight mt-1" @click="$bvModal.hide('resume-delete')">
                    No, do not delete
                </button>
            </div>
        </BModal>
        <BModal id="resume-replace" hide-footer>
            <template v-slot:modal-header="{ close }">
                <ModalHeader :close="close"/>
            </template>
            <div class="d-flex flex-column align-items-center">
                <img alt="danger" class="modal-title-icon" src="/dist/img/icons/danger.svg">
                <div class="mt-3 mb-3 text-center">Uploading a new resume will replace your existing profile. Are you
                    sure you
                    want to continue?
                </div>
                <button class="btn btn-green min-width-140 btn-shadow" @click="replace">Yes, delete</button>
                <button class="btn small-size silver-color normal-weight mt-1"
                        @click="$bvModal.hide('resume-replace')">No, do not delete
                </button>
            </div>
        </BModal>
    </div>
</template>

<script>
import {BFormFile} from 'bootstrap-vue'
import volunteerBlock from '~/mixins/volunteerBlock'

export default {
    components: {BFormFile},
    mixins: [volunteerBlock],
    data() {
        return {
            form: {
                title: '',
                file: null
            }
        }
    },
    computed: {
        resume() {
            return this.$store.state.volunteer.resume
        }
    },
    methods: {
        async update() {
            if (await this.$store.dispatch('volunteer/createResume', this.form)) {
                this.$refs.modal.hide()
                this.clear()
            }
        },
        destroy() {
            this.$store.dispatch('volunteer/destroyResume')
            this.$root.$emit('bv::hide::modal', 'resume-delete')
        },
        async replace() {
            await this.$store.dispatch('volunteer/destroyResume')
            this.$root.$emit('bv::hide::modal', 'resume-replace')

            setTimeout(() => {
                this.showModal()
            }, 500)
        }
    }
}
</script>
