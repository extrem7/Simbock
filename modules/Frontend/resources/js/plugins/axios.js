import Vue from 'vue'

import axios from 'axios'
import VueAxios from 'vue-axios'

axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
}

axios.interceptors.response.use(function (response) {
    return response
}, function (error) {
    console.log(error)
    const {status, data} = error.response

    if (status === 401) {
        const login = Vue.options.methods.route('login')
        Vue.bus.emit('alert', {
            text: `Your are not unauthenticated. Please <a href="${login}">Sing In.</a>`,
            variant: 'warning'
        })
    } else if (status === 403) {
        Vue.bus.emit('alert', {text: 'Your haven\'t permission to do it.', variant: 'danger'})
    } else if (status === 419) {
        Vue.bus.emit('alert', {text: status, variant: 'danger'})
        location.reload()
    } else if (status === 422) {
        //Vue.bus.emit('alert', {text: 'Validation error. Please check your input data.', variant: 'warning'})
    } else if ((status % 500) < 100) {
        Vue.bus.emit('alert', {
            text: 'Internal Server Error. The server encountered an internal error or misconfiguration and was unable to complete your request.',
            variant: 'danger',
            position: 'top',
            delay: 12
        })
    } else {
        Vue.options.methods.notify(data.message, 'warning')
    }
    throw error
})

Vue.use(VueAxios, axios)
