<template>
    <div class="sector sector-middle sector-summary">
        <div v-if="!personal_statement" class="sector-label">Personal Statement</div>
        <div class="item-box">
            <div v-if="!personal_statement" class="sector-header">
                <button class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg"
                        @click="showModal">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add Personal Statement</span>
                </button>
            </div>
            <div v-else class="sector-body-inner">
                <div class="sector-text-between">
                    <div class="sector-name">Personal Statement</div>
                    <div class="sector-action">
                        <button class="btn btn-sector-action btn-sector-edit"
                                @click="showModal">
                            <svg-vue icon="settings"></svg-vue>
                        </button>
                        <button class="btn btn-sector-action btn-sector-delete"
                                @click="clear">
                            <svg-vue icon="close"></svg-vue>
                        </button>
                    </div>
                </div>
                <div class="mt-2">
                    <div class="sector-text small-size">{{ personal_statement }}</div>
                </div>
            </div>
        </div>
        <BModal ref="modal" hide-footer>
            <template v-slot:modal-header="{ close }">
                <button aria-label="Close" class="close" type="button" @click="close()">
                    <svg-vue icon="close"></svg-vue>
                </button>
                <h5 class="title medium-size semi-bold-weight">Personal Statement</h5>
            </template>
            <div class="extra-small-size control-label">
                Summarise the key things a recruiter should know about you in a few lines.
                Highlight any particularly impressive achievements, skills or qualifications.
            </div>
            <div :class="[invalid('personal_statement')]" class="form-group">
                        <textarea v-model="form.personal_statement"
                                  class="form-control form-control-material"
                                  cols="30"
                                  placeholder="Please enter an Personal Statement"
                                  rows="5">
                        </textarea>
                <Invalid name="personal_statement"/>
            </div>
            <div class="modal-actions">
                <button class="btn btn-outline-silver min-width-100 btn-drop-shadow btn-scale-active"
                        @click="cancel">
                    Cancel
                </button>
                <button class="btn btn-green min-width-100 btn-shadow btn-scale-active"
                        @click="update">
                    Save
                </button>
            </div>
        </BModal>
    </div>
</template>

<script>
import volunteerBlock from "~/mixins/volunteerBlock"

export default {
    mixins: [volunteerBlock],
    data() {
        return {
            form: {
                personal_statement: ''
            }
        }
    },
    computed: {
        personal_statement() {
            return this.$store.state.volunteer.form.personal_statement
        }
    },
    methods: {
        clear() {
            this.form.personal_statement = ''
            this.update()
        }
    }
}
</script>
