import Vue from 'vue'
import jsonToForm from 'json-form-data'
import {errors} from "~/helpers/helpers"

export default {
    namespaced: true,
    state: {
        form: {
            is_private: false,

            phone: '',
            email: '',
            social: {
                website: '',
                linkedin: '',
                twitter: '',
                facebook: '',
                instagram: '',
                youtube: '',
                reddit: '',
                pinterest: '',
                quora: '',
            },

            name: '',
            headline: '',
            city_id: null,
            zip: '',
            is_relocating: false,
            is_working_remotely: false,

            job_title: '',

            executive_summary: '',
            objective: '',
            achievements: '',
            associations: '',

            skills: [],

            years_of_experience_id: null,
            level_of_education_id: null,
            veteran_status_id: null,

            cover_letter: '',
            personal_statement: '',

            has_driver_license: false,
            has_car: false
        },
        avatar: null,
        locations: [null],
        types: [],
        hours: [],
        sectors: {},
        work_experiences: [],
        educations: [],
        resume: null,
        certificates: [],
        languages: []
    },
    mutations: {
        setup(state, volunteer) {
            for (let field in state.form) {
                if (volunteer.hasOwnProperty(field)) {
                    if (field === 'social') {
                        for (let field in state.form.social) {
                            state.form.social[field] = volunteer.social[field]
                        }
                    } else {
                        state.form[field] = volunteer[field]
                    }
                }
            }
            state.resume = volunteer.resume || null
            const relations = [
                'locations', 'types', 'hours', 'sectors', 'work_experiences', 'educations', 'certificates', 'languages'
            ]
            for (let relation of relations)
                if (volunteer[relation].length || Object.values(volunteer[relation]).length)
                    state[relation] = volunteer[relation]
        },
        update(state, form) {
            for (let field in form) {
                if (form.hasOwnProperty(field) && state.form.hasOwnProperty(field)) state.form[field] = form[field]
            }
        },

        updateJob(state, form) {
            state.form.job_title = form.job_title
            state.locations = form.locations
            state.types = form.types
            state.hours = form.hours
            state.sectors = {}
            for (let sector of form.sectors) {
                state.sectors[sector.id] = sector.roles
            }
        },
        destroyJob(state) {
            state.form.job_title = ''
            state.location = []
            state.types = []
            state.hours = []
            state.sectors = {}
        },

        addWorkExperience(state, experience) {
            state.work_experiences.push(experience)
        },
        updateWorkExperience(state, experience) {
            Vue.set(state.work_experiences, state.work_experiences.findIndex(({id}) => id === experience.id), experience)
        },
        destroyWorkExperience(state, id) {
            state.work_experiences = state.work_experiences.filter(item => item.id !== id)
        },

        addEducation(state, education) {
            state.educations.push(education)
        },
        updateEducation(state, education) {
            Vue.set(state.educations, state.educations.findIndex(({id}) => id === education.id), education)
        },
        destroyEducation(state, id) {
            state.educations = state.educations.filter(item => item.id !== id)
        },

        addResume(state, resume) {
            state.resume = resume
        },
        destroyResume(state) {
            state.resume = null
        },

        addCertificate(state, certificate) {
            state.certificates.push(certificate)
        },
        updateCertificate(state, certificate) {
            Vue.set(state.certificates, state.certificates.findIndex(({id}) => id === certificate.id), certificate)
        },
        destroyCertificate(state, id) {
            state.certificates = state.certificates.filter(item => item.id !== id)
        },

        addLanguage(state, language) {
            state.languages.push(language)
        },
        updateLanguage(state, language) {
            Vue.set(state.languages, state.languages.findIndex(({id}) => id === language.id), language)
        },
        destroyLanguage(state, id) {
            state.languages = state.languages.filter(item => item.id !== id)
        }
    },
    actions: {
        async updateAbout({commit}, form) {
            try {
                const {status, data} = await this.app.axios.post(this.app.route('volunteer.account.update'), form)
                if (status === 200) {
                    commit('update', form)
                    commit('setErrors', {}, {root: true})
                    //this.app.notify(data.message)
                    return true
                }
            } catch ({response}) {
                //this.wasValidated = true
                //this.app.notify(response.data.message, 'warning')
                commit('setErrors', errors(response), {root: true})
                return false
            }
        },
        async togglePrivacy({state, commit}) {
            try {
                const form = {is_private: !state.form.is_private}
                const {status} = await this.app.axios.post(this.app.route('volunteer.account.update'), form)
                if (status === 200) {
                    commit('update', form)
                    return true
                }
            } catch (e) {
                console.log(e)
                return false
            }
        },

        async updateJob({commit}, form) {
            try {
                const {status, data} = await this.app.axios.post(this.app.route('volunteer.account.job.update'), form)
                if (status === 200) {
                    commit('updateJob', form)
                    commit('setErrors', {}, {root: true})
                    this.app.notify(data.message)
                    return true
                }
            } catch ({response}) {
                //this.wasValidated = true
                //this.app.notify(response.data.message, 'warning')
                commit('setErrors', errors(response), {root: true})
                return false
            }
        },
        async destroyJob({commit}) {
            try {
                const {
                    status,
                    data
                } = await this.app.axios.delete(this.app.route('volunteer.account.job.destroy'))
                if (status === 200) {
                    commit('destroyJob')
                    this.app.notify(data.message)
                    return true
                }
            } catch (e) {
                console.log(e)
                return false
            }
        },

        async updateOrCreateWorkExperience({commit}, {id, form}) {
            try {
                const {status, data} = id
                    ? await this.app.axios.patch(this.app.route('volunteer.account.work_experiences.update', id), {
                        ...form,
                        _method: 'PATCH'
                    })
                    : await this.app.axios.post(this.app.route('volunteer.account.work_experiences.store'), form)

                if (status === 200) {
                    if (id) {
                        commit('updateWorkExperience', {id, ...form})
                    } else {
                        commit('addWorkExperience', {id: data.id, ...form})
                    }
                    this.app.notify(data.message)
                    commit('setErrors', {}, {root: true})
                    return true
                }
            } catch ({response}) {
                commit('setErrors', errors(response), {root: true})
                return false
            }
        },
        async destroyWorkExperience({commit}, id) {
            try {
                const {
                    status,
                    data
                } = await this.app.axios.delete(this.app.route('volunteer.account.work_experiences.destroy', id))
                if (status === 200) {
                    commit('destroyWorkExperience', id)
                    this.app.notify(data.message)
                    return true
                }
            } catch (e) {
                console.log(e)
                return false
            }
        },

        async updateOrCreateEducation({commit}, {id, form}) {
            try {
                const {status, data} = id
                    ? await this.app.axios.patch(this.app.route('volunteer.account.educations.update', id), {
                        ...form,
                        _method: 'PATCH'
                    })
                    : await this.app.axios.post(this.app.route('volunteer.account.educations.store'), form)

                if (status === 200) {
                    if (id) {
                        commit('updateEducation', {id, ...form})
                    } else {
                        commit('addEducation', {id: data.id, ...form})
                    }
                    this.app.notify(data.message)
                    commit('setErrors', {}, {root: true})
                    return true
                }
            } catch ({response}) {
                commit('setErrors', errors(response), {root: true})
                return false
            }
        },
        async destroyEducation({commit}, id) {
            try {
                const {
                    status,
                    data
                } = await this.app.axios.delete(this.app.route('volunteer.account.educations.destroy', id))
                if (status === 200) {
                    commit('destroyEducation', id)
                    this.app.notify(data.message)
                    return true
                }
            } catch (e) {
                console.log(e)
                return false
            }
        },

        async createResume({commit}, form) {
            try {
                const {
                    status,
                    data
                } = await this.app.axios.post(this.app.route('volunteer.account.resume.store'), jsonToForm(form), {
                    header: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                if (status === 200) {
                    commit('addResume', {
                        title: form.title,
                        url: data.url,
                        created_at: data.created_at
                    })
                    this.app.notify(data.message)
                    commit('setErrors', {}, {root: true})
                    return true
                }
            } catch ({response}) {
                commit('setErrors', errors(response), {root: true})
                return false
            }
        },
        async destroyResume({commit}) {
            try {
                const {
                    status,
                    data
                } = await this.app.axios.delete(this.app.route('volunteer.account.resume.destroy'))
                if (status === 200) {
                    commit('destroyResume')
                    this.app.notify(data.message)
                    return true
                }
            } catch (e) {
                console.log(e)
                return false
            }
        },

        async updateOrCreateCertificate({commit}, {id, form}) {
            try {
                const {status, data} = id
                    ? await this.app.axios.patch(this.app.route('volunteer.account.certificates.update', id), {
                        ...form,
                        _method: 'PATCH'
                    })
                    : await this.app.axios.post(this.app.route('volunteer.account.certificates.store'), form)

                if (status === 200) {
                    if (id) {
                        commit('updateCertificate', {id, ...form})
                    } else {
                        commit('addCertificate', {id: data.id, ...form})
                    }
                    this.app.notify(data.message)
                    commit('setErrors', {}, {root: true})
                    return true
                }
            } catch ({response}) {
                commit('setErrors', errors(response), {root: true})
                return false
            }
        },
        async destroyCertificate({commit}, id) {
            try {
                const {
                    status,
                    data
                } = await this.app.axios.delete(this.app.route('volunteer.account.certificates.destroy', id))
                if (status === 200) {
                    commit('destroyCertificate', id)
                    this.app.notify(data.message)
                    return true
                }
            } catch (e) {
                console.log(e)
                return false
            }
        },

        async updateOrCreateLanguage({commit}, {id, form}) {
            try {
                const {status, data} = id
                    ? await this.app.axios.patch(this.app.route('volunteer.account.languages.update', id), {
                        ...form,
                        _method: 'PATCH'
                    })
                    : await this.app.axios.post(this.app.route('volunteer.account.languages.store'), form)

                if (status === 200) {
                    if (id) {
                        commit('updateLanguage', {id, ...form})
                    } else {
                        commit('addLanguage', {id: form.language_id, fluency: form.fluency})
                    }
                    this.app.notify(data.message)
                    commit('setErrors', {}, {root: true})
                    return true
                }
            } catch ({response}) {
                commit('setErrors', errors(response), {root: true})
                return false
            }
        },
        async destroyLanguage({commit}, id) {
            try {
                const {
                    status,
                    data
                } = await this.app.axios.delete(this.app.route('volunteer.account.languages.destroy', id))
                if (status === 200) {
                    commit('destroyLanguage', id)
                    this.app.notify(data.message)
                    return true
                }
            } catch (e) {
                console.log(e)
                return false
            }
        },
    }
}
