<template>
    <div class="sector sector-middle sector-summary">
        <div v-if="!achievements" class="sector-label">Achievements</div>
        <div class="item-box">
            <div v-if="!achievements" class="sector-header">
                <button class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg"
                        @click="showModal">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add Achievements</span>
                </button>
            </div>
            <div v-else class="sector-body-inner">
                <div class="sector-text-between">
                    <div class="sector-name">Achievements</div>
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
                    <div class="sector-text small-size">{{ achievements }}</div>
                </div>
            </div>
        </div>
        <BModal ref="modal" hide-footer>
            <template v-slot:modal-header="{ close }">
                <button aria-label="Close" class="close" type="button" @click="close()">
                    <svg-vue icon="close"></svg-vue>
                </button>
                <h5 class="title medium-size semi-bold-weight">Achievements</h5>
            </template>
            <div :class="[invalid('achievements')]" class="form-group">
                        <textarea v-model="form.achievements"
                                  class="form-control form-control-material"
                                  cols="30"
                                  placeholder="Please enter an Executive Summary"
                                  rows="5">
                        </textarea>
                <Invalid name="achievements"/>
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
                achievements: ''
            }
        }
    },
    computed: {
        achievements() {
            return this.$store.state.volunteer.form.achievements
        }
    },
    methods: {
        clear() {
            this.form.achievements = ''
            this.update()
        }
    }
}
</script>

