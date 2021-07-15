<template>
    <div class="sector sector-middle sector-skills">
        <div v-if="!skills.length" class="sector-label">Skills</div>
        <div class="item-box">
            <div v-if="!skills.length" class="sector-header">
                <button @click="showModal"
                        class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add Skills</span>
                </button>
            </div>
            <div v-else class="sector-body-inner">
                <div class="sector-text-between">
                    <div class="sector-name">Skills</div>
                    <div class="sector-actions">
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
                <div class="tag-list">
                    <div v-for="({text},i) in skills" class="tag-item">
                        {{ text }}
                        <button class="btn btn-clear-input btn-clear-input-sm"
                                @click="deleteSkill(i)">
                            <svg-vue icon="close"></svg-vue>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <BModal id="skills-modal" ref="modal" hide-footer>
            <template v-slot:modal-header="{ close }">
                <button aria-label="Close" class="close" type="button" @click="close()">
                    <svg-vue icon="close"></svg-vue>
                </button>
                <h5 class="title medium-size semi-bold-weight">Skills</h5>
            </template>
            <div class="form-group">
                <InputTag v-model="form.newSkills"
                          :options="options"
                          placeholder="Enter Skill"/>
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
import InputTag from '~/components/layout/InputTag'
import volunteerBlock from '~/mixins/volunteerBlock'

export default {
    components: {InputTag},
    mixins: [volunteerBlock],
    data() {
        return {
            options: this.shared('skills'),
            form: {
                newSkills: []
            }
        }
    },
    computed: {
        skills() {
            return this.$store.state.volunteer.form.skills.map(skill => ({text: skill}))
        }
    },
    methods: {
        async update() {
            if (await this.$store.dispatch('volunteer/updateAbout', {
                skills: this.form.newSkills.map(({text}) => text)
            })) this.$refs.modal.hide()
        },
        deleteSkill(i) {
            const skills = this.form.newSkills
            skills.splice(i, 1)
            this.form.newSkills = skills
            this.update()
        },
        fill() {
            this.form.newSkills = this.skills
        },
        clear() {
            this.form.newSkills = []
            this.update()
        }
    }
}
</script>
