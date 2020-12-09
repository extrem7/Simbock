<template>
    <div class="sector sector-middle sector-work-experience">
        <div class="sector-label">Work Experience</div>
        <div class="item-box">
            <div class="sector-header">
                <button @click="showModal"
                        class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add Work Experience</span>
                </button>
            </div>
            <div v-if="work_experiences.length" class="sector-body">
                <div v-for="education in work_experiences" class="sector-body-inner sector-body-inner-divider">
                    <div class="sector-text-between">
                        <div class="sector-name mb-1">{{ education.title }}
                        </div>
                        <div class="sector-actions">
                            <button class="btn btn-sector-action btn-sector-edit" @click="edit(education)">
                                <svg-vue icon="settings"></svg-vue>
                            </button>
                            <button class="btn btn-sector-action btn-sector-delete" @click="destroy(education.id)">
                                <svg-vue icon="close"></svg-vue>
                            </button>
                        </div>
                    </div>
                    <div class="sector-text-between">
                        <div class="sector-text small-size">{{ education.company }}</div>
                        <div class="sector-text small-size flex-shrink-0">
                            {{ education.start | moment('MMM YYYY') }}
                            -
                            <span v-if="education.end">{{ education.end | moment('MMM YYYY') }}</span>
                            <span v-else>Current</span>
                        </div>
                    </div>
                    <div v-if="education.description"
                         class="mt-3">
                        <div class="sector-text extra-small-size">
                            {{ education.description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <BModal
            id="work-experience-modal"
            ref="modal"
            hide-footer
            @hidden="clear">
            <template v-slot:modal-header="{ close }">
                <ModalHeader :close="close" title="Work Experience"/>
            </template>
            <div :class="[invalid('title')]" class="form-group">
                <InputMaterial
                    v-model="form.title"
                    placeholder="Title"/>
                <Invalid name="title"/>
            </div>
            <div :class="[invalid('company')]" class="form-group">
                <InputMaterial
                    v-model="form.company"
                    placeholder="Company"/>
                <Invalid name="company"/>
            </div>
            <div class="row">
                <div :class="[invalid('start')]" class="col-sm-6 form-group">
                    <Datepicker
                        v-model="form.start"
                        format="MMM yyyy"
                        initial-view="year"
                        input-class="form-control form-control-material form-control-material--without-label"
                        minimum-view="month"
                        placeholder="Start month"
                        wrapper-class="form-group-material"/>
                    <Invalid name="start"/>
                </div>
                <div :class="[invalid('end')]" class="col-sm-6 form-group">
                    <Datepicker
                        v-model="form.end"
                        :clear-button="true"
                        format="MMM yyyy"
                        initial-view="year"
                        input-class="form-control form-control-material form-control-material--without-label"
                        minimum-view="month"
                        placeholder="End month"
                        wrapper-class="form-group-material"/>
                    <Invalid name="end"/>
                </div>
            </div>
            <div :class="[invalid('description')]" class="form-group">
                        <textarea v-model="form.description"
                                  placeholder="Description (optional)"
                                  class="form-control form-control-material"
                                  rows="5"></textarea>
                <Invalid name="description"/>
            </div>
            <ModalActions @cancel="hideModal" @save="update"/>
        </BModal>
    </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker'
import volunteerBlock from "~/mixins/volunteerBlock"

export default {
    components: {
        Datepicker
    },
    mixins: [volunteerBlock],
    data() {
        return {
            id: null,
            form: {
                title: '',
                company: '',
                start: null,
                end: null,
                description: ''
            }
        }
    },
    computed: {
        work_experiences() {
            return this.$store.state.volunteer.work_experiences
        }
    },
    methods: {
        async update() {
            if (await this.$store.dispatch('volunteer/updateOrCreateWorkExperience', {
                id: this.id, form: this.form
            })) {
                this.$refs.modal.hide()
                this.clear()
            }
        },
        edit(experience) {
            this.id = experience.id
            for (let field in this.form)
                if (experience.hasOwnProperty(field))
                    this.form[field] = experience[field]
            this.$refs.modal.show()
        },
        destroy(id) {
            this.$store.dispatch('volunteer/destroyWorkExperience', id)
        },
        clear() {
            if (this.id) this.id = null
            for (let field in this.form) this.form[field] = null
        }
    }
}
</script>
