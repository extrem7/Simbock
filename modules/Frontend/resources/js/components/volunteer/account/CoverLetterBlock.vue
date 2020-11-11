<template>
    <div class="sector sector-middle sector-summary">
        <div v-if="!cover_letter" class="sector-label">Cover letter</div>
        <div class="item-box">
            <div v-if="!cover_letter" class="sector-header">
                <button class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg"
                        @click="showModal">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add Cover letter</span>
                </button>
            </div>
            <div v-else class="sector-body-inner">
                <div class="sector-text-between">
                    <div class="sector-name">Cover letter</div>
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
                    <div class="sector-text small-size">{{ cover_letter }}</div>
                </div>
            </div>
        </div>
        <BModal ref="modal" hide-footer>
            <template v-slot:modal-header="{ close }">
                <button aria-label="Close" class="close" type="button" @click="close()">
                    <svg-vue icon="close"></svg-vue>
                </button>
                <h5 class="title medium-size semi-bold-weight">Cover letter</h5>
            </template>
            <div class="extra-small-size control-label">
                A good cover letter can greatly increase your chances of standing out to recruiters.
            </div>
            <div :class="[invalid('cover_letter')]" class="form-group">
                        <textarea v-model="form.cover_letter"
                                  class="form-control form-control-material"
                                  cols="30"
                                  placeholder="Please enter an Cover letter"
                                  rows="5">
                        </textarea>
                <Invalid name="cover_letter"/>
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
                cover_letter: ''
            }
        }
    },
    computed: {
        cover_letter() {
            return this.$store.state.volunteer.form.cover_letter
        }
    },
    methods: {
        clear() {
            this.form.cover_letter = ''
            this.update()
        }
    }
}
</script>
