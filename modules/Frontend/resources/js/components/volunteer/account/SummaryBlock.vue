<template>
    <div class="sector sector-middle sector-summary">
        <div v-if="!executive_summary" class="sector-label">Executive Summary</div>
        <div class="item-box">
            <div v-if="!executive_summary" class="sector-header">
                <button class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg"
                        @click="showModal">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add Executive Summary</span>
                </button>
            </div>
            <div v-else class="sector-body-inner">
                <div class="sector-text-between">
                    <div class="sector-name">Executive Summary</div>
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
                    <div class="sector-text small-size">{{ executive_summary }}</div>
                </div>
            </div>
        </div>
        <BModal ref="modal" hide-footer>
            <template v-slot:modal-header="{ close }">
                <button aria-label="Close" class="close" type="button" @click="close()">
                    <svg-vue icon="close"></svg-vue>
                </button>
                <h5 class="title medium-size semi-bold-weight">Executive Summary</h5>
            </template>
            <div :class="[invalid('executive_summary')]" class="form-group">
                        <textarea v-model="form.executive_summary"
                                  class="form-control form-control-material"
                                  cols="30"
                                  placeholder="Please enter an Executive Summary"
                                  rows="5">
                        </textarea>
                <Invalid name="executive_summary"/>
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
                executive_summary: ''
            }
        }
    },
    computed: {
        executive_summary() {
            return this.$store.state.volunteer.form.executive_summary
        }
    },
    methods: {
        clear() {
            this.form.executive_summary = ''
            this.update()
        }
    }
}
</script>

