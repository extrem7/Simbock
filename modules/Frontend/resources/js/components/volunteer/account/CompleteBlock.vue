<template>
    <div class="sector sector-sidebar sector-progress-info">
        <div class="sector-label invisible">Progress</div>
        <div class="item-box">
            <div class="sector-body">
                <div class="sector-body-inner">
                    <div class="radial-progress-bar-wrapper">
                        <RadialProgressBar
                            :completed-steps="completedSteps"
                            :diameter="72"
                            :inner-stroke-width="4"
                            :stroke-width="4"
                            :total-steps="Object.keys(steps).length"
                            inner-stroke-color="#DFDFDF"
                            start-color="#5CEDAA"
                            stop-color="#5CEDAA"
                            stroke-linecap="butt"/>
                        <span class="semi-bold-weight radial-progress-bar-value">
                            {{ (completedSteps / steps.length) * 100 }}%
                        </span>
                    </div>
                    <div class="sector-name semi-bold-weight">
                        Your Profile is {{ isCompleted ? 'Completed' : 'Incomplete' }}
                    </div>
                    <div v-if="!isCompleted" class="extra-small-size mt-2">
                        Finish your profile to unlock better job matching and stand out to hiring managers!
                    </div>
                    <div class="sector-progress-step">
                        <div v-for="{text,modal,value} in steps" :class="{'fill-step':value}"
                             class="progress-step-item">
                            <div class="progress-step-circle"></div>
                            <button v-b-modal="modal"
                                    class="btn btn-sector-link btn-rotate-icon btn-flex">
                                {{ text }}
                                <svg-vue icon="plus"></svg-vue>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sector-footer text-center">
                <a :href="route('volunteer.survey.page')"
                   class="link-inherit small-size">
                    I got hired!
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import RadialProgressBar from 'vue-radial-progress'
import {mapState} from 'vuex'

export default {
    components: {
        RadialProgressBar
    },
    computed: {
        ...mapState('volunteer', {
            name: state => state.form.name,
            headline: state => state.form.headline,
            city_id: state => state.form.city_id,

            sectors: state => state.sectors,
            work_experiences: state => state.work_experiences,

            email: state => state.form.email,
            phone: state => state.form.phone,
            social: state => state.form.social,

            skills: state => state.form.skills,
        }),
        steps() {
            return [
                {
                    text: 'Add About Me Info',
                    modal: 'about-modal',
                    value: this.name && this.headline && this.city_id
                },
                {
                    text: 'Add Looking To Volunteer',
                    modal: 'job-modal',
                    value: Object.values(this.sectors).length
                },
                {
                    text: 'Add Work Experience',
                    modal: 'work-experience-modal',
                    value: this.work_experiences.length
                },
                {
                    text: 'Add Contact and Website Info',
                    modal: this.email && this.phone ? 'social-modal' : 'contact-modal',
                    value: this.email && this.phone && Object.values(this.social).filter(i => i !== null).length
                },
                {
                    text: 'Add Skills',
                    modal: 'skills-modal',
                    value: this.skills.length
                }
            ]
        },
        completedSteps() {
            return this.steps.reduce((acc, {value}) => acc + (value ? 1 : 0), 0)
        },
        isCompleted() {
            return this.completedSteps === this.steps.length
        }
    }
}
</script>
