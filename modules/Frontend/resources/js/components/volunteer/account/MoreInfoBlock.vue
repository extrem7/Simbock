<template>
    <div class="sector sector-middle sector-more-information">
        <div class="sector-label">More Information</div>
        <div class="item-box">
            <div class="sector-body">
                <div v-if="veteran_status_id || level_of_education_id || veteran_status_id"
                     class="sector-actions sector-actions-absolute">
                    <button class="btn btn-sector-action btn-sector-edit"
                            @click="showModal">
                        <svg-vue icon="settings"></svg-vue>
                    </button>
                    <button class="btn btn-sector-action btn-sector-delete"
                            @click="clear">
                        <svg-vue icon="close"></svg-vue>
                    </button>
                </div>
                <div class="sector-body-inner">
                    <button v-if="!years_of_experience_id"
                            class="btn btn-sector-link base-size d-block"
                            @click="showModal">
                        Add Years of Experience
                    </button>
                    <button v-if="!level_of_education_id"
                            class="btn btn-sector-link base-size d-block"
                            @click="showModal">
                        Add Highest level of Education
                    </button>
                    <button v-if="!veteran_status_id"
                            class="btn btn-sector-link base-size d-block"
                            @click="showModal">
                        Add Veteran Status
                    </button>
                    <div v-if="years_of_experience_id || level_of_education_id || veteran_status_id"
                         class="mt-2">
                        <div v-if="years_of_experience_id" class="more-information-item">
                            <div class="sector-name small-size">Years of Experience</div>
                            <div class="sector-text extra-small-size mt-1">
                                {{ yearsOfExperience.find(({value}) => value === years_of_experience_id).text }}
                            </div>
                        </div>
                        <div v-if="level_of_education_id" class="more-information-item">
                            <div class="sector-name small-size">Highest Degree Earned</div>
                            <div class="sector-text extra-small-size mt-1">
                                {{ degrees.find(({value}) => value === level_of_education_id).text }}
                            </div>
                        </div>
                        <div v-if="veteran_status_id" class="more-information-item">
                            <div class="sector-name small-size">Veteran Status</div>
                            <div class="sector-text extra-small-size mt-1">
                                {{ veteranStatuses.find(({value}) => value === veteran_status_id).text }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <BModal ref="modal" hide-footer>
            <template v-slot:modal-header="{ close }">
                <button aria-label="Close" class="close" type="button" @click="close()">
                    <svg-vue icon="close"></svg-vue>
                </button>
                <h5 class="title medium-size semi-bold-weight">More Information</h5>
            </template>
            <div class="form-group">
                <SelectMaterial
                    v-model="form.years_of_experience_id"
                    :options="yearsOfExperience"
                    placeholder="Years of Experience"/>
            </div>
            <div class="form-group">
                <SelectMaterial
                    v-model="form.level_of_education_id"
                    :options="degrees"
                    placeholder="Highest Degree Earned"/>
            </div>
            <div class="form-group">
                <SelectMaterial
                    v-model="form.veteran_status_id"
                    :options="veteranStatuses"
                    placeholder="Veteran Status"/>
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
import {mapState} from "vuex"

export default {
    mixins: [volunteerBlock],
    data() {
        return {
            form: {
                years_of_experience_id: null,
                level_of_education_id: null,
                veteran_status_id: null,
            },
            yearsOfExperience: this.shared('yearsOfExperience'),
            degrees: this.shared('degrees'),
            veteranStatuses: this.shared('veteranStatuses')
        }
    },
    computed: {
        ...mapState('volunteer', {
            years_of_experience_id: state => state.form.years_of_experience_id,
            level_of_education_id: state => state.form.level_of_education_id,
            veteran_status_id: state => state.form.veteran_status_id
        })
    },
    methods: {
        clear() {
            this.form.years_of_experience_id = null
            this.form.level_of_education_id = null
            this.form.veteran_status_id = null
            this.update()
        }
    }
}
</script>
