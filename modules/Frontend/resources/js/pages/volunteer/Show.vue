<template>
    <main class="container content-inner">
        <AccessBox/>
        <div class="row">
            <HistoryBack/>
            <div class="col-xl-3 col-lg-4 col-md-5">
                <div class="sector sector-sidebar sector-profile">
                    <div class="sector-label invisible d-none d-md-block">About volunteer</div>
                    <div class="item-box">
                        <div class="sector-body">
                            <div class="sector-body-inner">
                                <div class="position-relative mb-2">
                                    <div class="profile-avatar">
                                        <img :src="avatar||'/dist/img/avatar.svg'"
                                             alt="profile"
                                             class="profile-avatar-img">
                                    </div>
                                </div>
                                <div v-if="name" class="sector-name text-center profile-name mb-2">{{ name }}</div>
                                <div v-if="headline" class="sector-text text-center extra-small-size mt-1">{{
                                        headline
                                    }}
                                </div>
                                <div v-if="city_id"
                                     class="sector-text text-center extra-small-size mt-1">{{ city.text }}
                                </div>
                                <div v-if="is_relocating||is_working_remotely"
                                     class="mt-3">
                                    <div v-if="is_relocating"
                                         class="sector-text text-center extra-small-size mt-1">
                                        I am willing to relocate
                                    </div>
                                    <div v-if="is_working_remotely"
                                         class="sector-text text-center extra-small-size mt-1">
                                        I am willing to work remotely
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sector sector-sidebar">
                    <div class="sector-label">Contact Information</div>
                    <div class="item-box">
                        <div class="sector-body">
                            <div class="sector-body-inner">
                                <div class="sector-contact-info">
                                    <div class="sector-contact-icon">
                                        <img alt="" src="/dist/img/icons/mail.svg">
                                    </div>
                                    <div class="sector-contact-text">
                                        <a v-if="email"
                                           :href="`mailto:${email}`"
                                           class="line-nowrap link-inherit d-block">
                                            {{ email }}
                                        </a>
                                    </div>
                                </div>
                                <div class="sector-contact-info">
                                    <div class="sector-contact-icon">
                                        <img alt="" src="/dist/img/icons/phone.svg">
                                    </div>
                                    <div class="sector-contact-text">
                                        <a v-if="phone"
                                           :href="`tel:${phone}`"
                                           class="line-nowrap link-inherit d-block">
                                            {{ phone }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="Object.values(social).length" class="sector sector-sidebar">
                    <div class="sector-label">Websites</div>
                    <div class="item-box">
                        <div class="sector-body">
                            <div class="sector-body-inner">
                                <div v-for="(link,name) in social"
                                     v-if="link"
                                     class="sector-contact-info">
                                    <div class="sector-contact-icon">
                                        <img :src="`/dist/img/icons/${name}.svg`" alt="">
                                    </div>
                                    <div class="sector-contact-text">
                                        <a v-if="link"
                                           :href="link"
                                           target="_blank"
                                           class="line-nowrap link d-block">{{ link }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="skills.length" class="sector sector-sidebar">
                    <div class="sector-label">Skills</div>
                    <div class="item-box">
                        <div class="sector-body">
                            <div class="sector-body-inner">
                                <div class="tag-list">
                                    <div v-for="skill in skills" class="tag-item tag-item-info">{{ skill }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="languages.length" class="sector sector-sidebar">
                    <div class="sector-label">Languages</div>
                    <div class="item-box">
                        <div class="sector-body">
                            <div class="sector-body-inner">
                                <div v-for="({name,fluency},i) in languages"
                                     :class="{'mt-3':i>0}">
                                    <div class="sector-name">{{ name }}</div>
                                    <div class="sector-text small-size mt-1">({{ fluency }})</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sector sector-sidebar">
                    <div class="sector-label">Car & driving license</div>
                    <div class="item-box">
                        <div class="sector-body">
                            <div class="sector-body-inner">
                                <div>
                                    <div class="sector-name">Licence</div>
                                    <div class="sector-text small-size mt-1">
                                        I have{{ !has_driver_license ? 'n\'t' : '' }} a full licence
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="sector-name">Car</div>
                                    <div class="sector-text small-size mt-1">
                                        I have{{ !has_car ? 'n\'t' : '' }} a car
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="veteran_status_id || level_of_education_id || veteran_status_id"
                     class="sector sector-sidebar sector-more-information">
                    <div class="sector-label">More Information</div>
                    <div class="item-box">
                        <div class="sector-body">
                            <div class="sector-body-inner">
                                <div v-if="years_of_experience_id" class="more-information-item">
                                    <div class="sector-name base-size">Years of Experience</div>
                                    <div class="sector-text small-size mt-1">
                                        {{ yearsOfExperience.find(({value}) => value === years_of_experience_id).text }}
                                    </div>
                                </div>
                                <div v-if="level_of_education_id" class="more-information-item">
                                    <div class="sector-name base-size">Highest Degree Earned</div>
                                    <div class="sector-text small-size mt-1">
                                        {{ degrees.find(({value}) => value === level_of_education_id).text }}
                                    </div>
                                </div>
                                <div v-if="veteran_status_id" class="more-information-item">
                                    <div class="sector-name base-size">Veteran Status</div>
                                    <div class="sector-text small-size mt-1">
                                        {{ veteranStatuses.find(({value}) => value === veteran_status_id).text }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-7 col-md-7">
                <div v-if="Object.values(sectors).length" class="sector sector-middle sector-looking">
                    <div class="sector-label">Looking to volunteer</div>
                    <div class="item-box">
                        <div class="sector-body">
                            <div class="sector-body-inner">
                                <div class="sector-name mb-1">{{ job_title }}</div>
                                <div class="sector-text small-size">{{ locationsFormatted }}</div>
                                <div class="mt-3">
                                    <div class="sector-text extra-small-size mt-1">{{ employmentFormatted }}</div>
                                    <div class="sector-text extra-small-size mt-1">{{ sectorsFormatted }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="work_experiences.length" class="sector sector-middle sector-work-experience">
                    <div class="sector-label">Work Experience</div>
                    <div class="item-box">
                        <div v-for="experience in work_experiences" class="sector-body sector-body-divider">
                            <div class="sector-body-inner">
                                <div class="sector-name mb-1">{{ experience.title }}</div>
                                <div class="sector-text-between">
                                    <div class="sector-text small-size">{{ experience.company }}</div>
                                    <div class="sector-text small-size flex-shrink-0">
                                        {{ dayjs(experience.start).format('MMM YYYY') }}
                                        -
                                        {{ experience.end ? experience.end : 'Current' }}
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div v-if="experience.description"
                                         class="sector-text extra-small-size">
                                        {{ experience.description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="educations.length" class="sector sector-middle sector-education">
                    <div class="sector-label">Education</div>
                    <div class="item-box">
                        <div v-for="education in educations" class="sector-body sector-body-divider">
                            <div class="sector-body-inner">
                                <div v-if="education.field"
                                     class="sector-name mb-1">{{ education.field }}
                                </div>
                                <div class="sector-text-between">
                                    <div class="sector-text small-size">{{ education.school }} - {{
                                            education.degree
                                        }}
                                    </div>
                                    <div class="sector-text small-size flex-shrink-0">{{ education.start }} -
                                        {{ education.end }}
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
                </div>
                <div v-if="resume" class="sector sector-middle sector-resume">
                    <div class="sector-label">Resume</div>
                    <div class="item-box">
                        <div class="sector-body sector-body-divider">
                            <div class="sector-body-inner">
                                <a :href="resume.url"
                                   class="sector-name d-block"
                                   target="_blank">{{ resume.title }}</a>
                                <a :href="resume.url"
                                   class="sector-text extra-small-size mt-1"
                                   target="_blank">
                                    Added {{ dayjs(resume.created_at).format('d.m.YYYY, hh:ss') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="certificates.length" class="sector sector-middle sector-cert">
                    <div class="sector-label">Certificates and Licenses</div>
                    <div class="item-box">
                        <div v-for="certificate in certificates"
                             class="sector-body sector-body-divider">
                            <div class="sector-body-inner">
                                <div v-if="certificate.title"
                                     class="sector-name mb-1">
                                    {{ certificate.title }}
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
                </div>
                <div v-if="executive_summary" class="sector sector-middle sector-summary">
                    <div class="sector-label">Executive Summary</div>
                    <div class="item-box">
                        <div class="sector-body">
                            <div class="sector-body-inner">
                                <div class="sector-text small-size">{{ executive_summary }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="objective" class="sector sector-middle sector-objective">
                    <div class="sector-label">Objective</div>
                    <div class="item-box">
                        <div class="sector-body">
                            <div class="sector-body-inner">
                                <div class="sector-text small-size">{{ objective }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="achievements" class="sector sector-middle sector-achievements">
                    <div class="sector-label">Achievements</div>
                    <div class="item-box">
                        <div class="sector-body">
                            <div class="sector-body-inner">
                                <div class="sector-text small-size">{{ achievements }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="associations" class="sector sector-middle sector-associations">
                    <div class="sector-label">Associations</div>
                    <div class="item-box">
                        <div class="sector-body">
                            <div class="sector-body-inner">
                                <div class="sector-text small-size">{{ associations }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="cover_letter" class="sector sector-middle sector-cover-letter">
                    <div class="sector-label">Cover letter</div>
                    <div class="item-box">
                        <div class="sector-body sector-body-divider">
                            <div class="sector-body-inner">
                                <div :class="{'show-hidden-text' : isOpenText}"
                                     class="sector-text hidden-text small-size">{{ cover_letter }}
                                </div>
                                <button class="btn btn-sector-link toggle-text mt-3" @click="isOpenText = !isOpenText">
                                    See more
                                    <SvgVue class="ml-2" icon="arrow-down"/>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="personal_statement" class="sector sector-middle sector-statement">
                    <div class="sector-label">Personal statement</div>
                    <div class="item-box">
                        <div class="sector-body sector-body-divider">
                            <div class="sector-body-inner">
                                <div class="sector-text small-size">{{ personal_statement }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import Vue from 'vue'
import {mapState} from 'vuex'

import AccessBox from '~/components/layout/AccessBox'
import HistoryBack from '~/components/layout/HistoryBack'

const languages = Vue.options.methods.shared('languages')

export default {
    name: 'VolunteerShow',
    components: {
        AccessBox,
        HistoryBack
    },
    data() {
        const volunteer = this.shared('volunteer'),
            sectors = this.shared('sectors')

        return {
            avatar: volunteer.avatar,
            cities: volunteer.city ? [volunteer.city] : [],
            jobCities: volunteer.cities.length ? volunteer.cities : [[]],

            fluencies: this.shared('fluencies'),

            yearsOfExperience: this.shared('yearsOfExperience'),
            degrees: this.shared('degrees'),
            veteranStatuses: this.shared('veteranStatuses'),

            typesOptions: this.shared('types'),
            hoursOptions: this.shared('hours'),
            sectorsOptions: sectors,

            isOpenText: false
        }
    },
    computed: {
        ...mapState('volunteer', {
            name: state => state.form.name,
            headline: state => state.form.headline,
            city_id: state => state.form.city_id,
            is_relocating: state => state.form.is_relocating,
            is_working_remotely: state => state.form.is_working_remotely,

            phone: state => state.form.phone,
            email: state => state.form.email,

            social: state => state.form.social,

            has_driver_license: state => state.form.has_driver_license,
            has_car: state => state.form.has_car,

            years_of_experience_id: state => state.form.years_of_experience_id,
            level_of_education_id: state => state.form.level_of_education_id,
            veteran_status_id: state => state.form.veteran_status_id,

            job_title: state => state.form.job_title,
            locations: state => state.locations,
            types: state => state.types,
            hours: state => state.hours,
            sectors: state => state.sectors,


            executive_summary: state => state.form.executive_summary,
            objective: state => state.form.objective,
            achievements: state => state.form.achievements,
            associations: state => state.form.associations,
            cover_letter: state => state.form.cover_letter,
            personal_statement: state => state.form.personal_statement,
        }),
        city() {
            return this.cities.find(({value}) => value === this.city_id)
        },

        skills() {
            return this.$store.state.volunteer.form.skills
        },
        languages() {
            return this.$store.state.volunteer.languages.map(a => ({...a})).map(l => {
                l.name = languages.find(({value}) => value === l.id).text
                l.fluency = this.fluencies.find(({value}) => value === l.fluency).text
                return l
            })
        },

        locationsFormatted() {
            return this.locations ? [...this.locations]
                .map((id, i) => this.jobCities[i].find(({value}) => value === id).text)
                .join(' | ') : ''
        },
        employmentFormatted() {
            let string = ''
            if (this.types.length) string += [...this.types]
                .map(id => this.typesOptions.find(({value}) => value === id).text)
                .join(' & ')
            if (this.hours.length) string += ' & ' + [...this.hours]
                .map(id => this.hoursOptions.find(({value}) => value === id).text)
                .join(' & ')
            return string
        },
        sectorsFormatted() {
            return this.sectors ? [...Object.keys(this.sectors)]
                .map((id) => this.sectorsOptions.find(({value}) => value === parseInt(id)).text)
                .join(' | ') : ''
        },

        work_experiences() {
            return this.$store.state.volunteer.work_experiences
        },
        educations() {
            return this.$store.state.volunteer.educations
        },
        resume() {
            return this.$store.state.volunteer.resume
        },
        certificates() {
            return this.$store.state.volunteer.certificates
        }
    },
    created() {
        this.$store.commit('volunteer/setup', this.shared('volunteer'))
    }
}
</script>
