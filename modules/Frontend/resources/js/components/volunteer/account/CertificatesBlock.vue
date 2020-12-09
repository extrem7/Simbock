<template>
    <div class="sector sector-middle sector-cert">
        <div class="sector-label">Certificates and Licenses</div>
        <div class="item-box">
            <div class="sector-header">
                <button @click="showModal"
                        class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add Certificates and Licenses</span>
                </button>
            </div>
            <div v-if="certificates.length" class="sector-body">
                <div v-for="certificate in certificates" class="sector-body-inner sector-body-inner-divider">
                    <div class="sector-text-between">
                        <div v-if="certificate.title"
                             class="sector-name mb-1">
                            {{ certificate.title }}
                        </div>
                        <div class="sector-actions">
                            <button class="btn btn-sector-action btn-sector-edit" @click="edit(certificate)">
                                <svg-vue icon="settings"></svg-vue>
                            </button>
                            <button class="btn btn-sector-action btn-sector-delete" @click="destroy(certificate.id)">
                                <svg-vue icon="close"></svg-vue>
                            </button>
                        </div>
                    </div>
                    <div class="sector-text-between">
                        <div class="sector-text small-size">{{ certificate.issuing_authority }}</div>
                        <div class="sector-text small-size flex-shrink-0">{{ certificate.year }}</div>
                    </div>
                    <div v-if="certificate.description"
                         class="mt-3">
                        <div class="sector-text extra-small-size">
                            {{ certificate.description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <BModal ref="modal" hide-footer @hidden="clear">
            <template v-slot:modal-header="{ close }">
                <ModalHeader :close="close" title="Certificates and Licenses"/>
            </template>
            <div :class="[invalid('title')]" class="form-group">
                <InputMaterial
                    v-model="form.title"
                    placeholder="Title"/>
                <Invalid name="title"/>
            </div>
            <div :class="[invalid('issuing_authority')]" class="form-group">
                <InputMaterial
                    v-model="form.issuing_authority"
                    placeholder="Issuing Authority (optional)"/>
                <Invalid name="issuing_authority"/>
            </div>
            <div :class="[invalid('year')]" class="form-group">
                <InputMaterial
                    v-model.number="form.year"
                    placeholder="Year Received (optional)"
                    type="number"/>
                <Invalid name="year"/>
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
                title: '',
                issuing_authority: '',
                year: null,
                description: ''
            }
        }
    },
    computed: {
        certificates() {
            return this.$store.state.volunteer.certificates
        }
    },
    methods: {
        async update() {
            if (await this.$store.dispatch('volunteer/updateOrCreateCertificate', {
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
            this.$store.dispatch('volunteer/destroyCertificate', id)
        },
        clear() {
            if (this.id) this.id = null
            for (let field in this.form) this.form[field] = null
        }
    }
}
</script>
