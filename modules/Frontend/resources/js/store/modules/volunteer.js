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

            years_of_experience_id: null,
            level_of_education_id: null,
            veteran_status_id: null,

            cover_letter: '',
            personal_statement: '',

            has_driver_license: false,
            has_car: false
        },
        avatar: null,
        work_experiences: [],
        educations: [],
        resumes: [],
        certificates: [],
        skills: [],
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
        },
        update(state, form) {
            for (let field in form) {
                if (form.hasOwnProperty(field) && state.form.hasOwnProperty(field)) state.form[field] = form[field]
            }
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
        }
    }
}
