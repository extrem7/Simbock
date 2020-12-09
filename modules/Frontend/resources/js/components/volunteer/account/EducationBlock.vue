<template>
    <div class="sector sector-middle sector-education">
        <div class="sector-label">Education</div>
        <div class="item-box">
            <div class="sector-header">
                <button @click="showModal"
                        class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add Education</span>
                </button>
            </div>
            <div v-if="educations.length" class="sector-body">
                <div v-for="education in educations" class="sector-body-inner sector-body-inner-divider">
                    <div class="sector-text-between">
                        <div v-if="education.field"
                             class="sector-name mb-1">{{ education.field }}
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
                        <div class="sector-text small-size">{{ education.school }} - {{ education.degree }}</div>
                        <div class="sector-text small-size flex-shrink-0">{{ education.start }} - {{ education.end }}
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
        <BModal ref="modal" hide-footer @hidden="clear">
            <template v-slot:modal-header="{ close }">
                <ModalHeader :close="close" title="Education"/>
            </template>
            <div :class="[invalid('school')]" class="form-group">
                <InputMaterial
                    v-model="form.school"
                    placeholder="School"/>
                <Invalid name="school"/>
            </div>
            <div :class="[invalid('degree')]" class="form-group">
                <InputMaterial
                    v-model="form.degree"
                    placeholder="Degree"/>
                <Invalid name="degree"/>
            </div>
            <div :class="[invalid('field')]" class="form-group">
                <InputMaterial
                    v-model="form.field"
                    placeholder="Major or field of study (optional)"/>
                <Invalid name="field"/>
            </div>
            <div class="row">
                <div :class="[invalid('start')]" class="col-sm-6 form-group">
                    <InputMaterial
                        v-model.number="form.start"
                        placeholder="Start Year"
                        type="number"/>
                    <Invalid name="start"/>
                </div>
                <div :class="[invalid('end')]" class="col-sm-6 form-group">
                    <InputMaterial
                        v-model.number="form.end"
                        placeholder="End Year"
                        type="number"/>
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
import volunteerBlock from "~/mixins/volunteerBlock"

export default {
    mixins: [volunteerBlock],
    data() {
        return {
            id: null,
            form: {
                school: '',
                degree: '',
                field: '',
                start: null,
                end: null,
                description: ''
            }
        }
    },
    computed: {
        educations() {
            return this.$store.state.volunteer.educations
        }
    },
    methods: {
        async update() {
            if (await this.$store.dispatch('volunteer/updateOrCreateEducation', {
                id: this.id, form: this.form
            })) {
                this.$refs.modal.hide()
                this.clear()
            }
        },
        edit(education) {
            this.id = education.id
            for (let field in this.form)
                if (education.hasOwnProperty(field))
                    this.form[field] = education[field]
            this.$refs.modal.show()
        },
        destroy(id) {
            this.$store.dispatch('volunteer/destroyEducation', id)
        },
        clear() {
            if (this.id) this.id = null
            for (let field in this.form) this.form[field] = null
        }
    }
}
</script>
