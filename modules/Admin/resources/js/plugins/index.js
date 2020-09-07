import Vue from 'vue'

import './axios'
import './bootstrap'
import './ls'

import VueBus from 'vue-bus'
import SvgVue from 'svg-vue'
import VueMoment from 'vue-moment'
import VueCookies from 'vue-cookies'
import VueSuperMethod from 'vue-super-call'
import VueSimpleAlert from "vue-simple-alert";
import route, {Ziggy} from 'ziggy'

Vue.use(VueBus)
Vue.use(SvgVue)
Vue.use(VueMoment)
Vue.use(VueCookies)
Vue.use(VueSimpleAlert)

Vue.prototype.$super = VueSuperMethod

Vue.mixin({
    methods: {
        route: (name, params, absolute) => route(name, params, absolute, Ziggy),
        shared: (key) => shared()[key]
    }
})
