import Vue from 'vue'
import VueEcho from 'vue-echo'

window.Pusher = require('pusher-js')

Vue.use(VueEcho, {
    broadcaster: 'pusher',
    key: 'Simbock',
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    forceTLS: process.env.MIX_APP_ENV !== 'local'
})
