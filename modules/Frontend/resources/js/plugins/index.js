import Vue from 'vue'

Vue.mixin({
    methods: {
        shared: (key) => shared()[key],
        notify(text, variant = 'success', delay = 3, position = 'top') {
            this.$bus.emit('alert', {variant, text, delay, position})
        }
    }
})

import route, {Ziggy} from 'ziggy'

Vue.mixin({
    methods: {
        route: (name, params, absolute) => route('frontend.' + name, params, absolute, Ziggy),
        isRoute: (name) => route(null, {}, null, Ziggy).current('frontend.' + name),
        routeIncludes: (fragments) => route(null, {}, null, Ziggy)
            .current()
            .match(new RegExp(`(${fragments.join('|')})`))
    }
})

import './axios'

import VueBus from 'vue-bus'
import SvgVue from 'svg-vue'
import './bootstrap'
import './ls'
import './broadcasting'

import VueMoment from 'vue-moment'
import VueLazyload from 'vue-lazyload'
import VueScrollTo from 'vue-scrollto'
import VueSimpleAlert from 'vue-simple-alert'
import VueObserveVisibility from 'vue-observe-visibility'

Vue.use(VueBus)
Vue.use(SvgVue)
Vue.use(VueMoment)
Vue.use(VueLazyload, {
    error: '/dist/img/no-image.jpg',
})
Vue.use(VueScrollTo)
Vue.use(VueSimpleAlert)
Vue.use(VueObserveVisibility)

import VueLodash from 'vue-lodash'
import lodash from 'lodash'

Vue.use(VueLodash, {lodash})
