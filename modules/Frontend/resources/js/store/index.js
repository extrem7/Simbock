import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

import modules from './modules'

export default new Vuex.Store({
    state: {
        user: null,
        errors: {}
    },
    mutations: {
        setUser(state, user) {
            state.user = user
        },
        setErrors(state, errors) {
            state.errors = errors
        }
    },
    modules,
    strict: debug
});
