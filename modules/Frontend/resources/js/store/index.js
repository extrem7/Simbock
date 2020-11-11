import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

import modules from './modules'

export default new Vuex.Store({
    state: {
        errors: {}
    },
    mutations: {
        setErrors(state, errors) {
            state.errors = errors
        }
    },
    modules,
    strict: debug
});
