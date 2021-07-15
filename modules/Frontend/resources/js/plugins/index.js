import Vue from 'vue'
import dayjs from 'dayjs'

Vue.mixin({
    methods: {
        shared: (key) => shared()[key],
        notify(text, variant = 'success', delay = 3, position = 'top') {
            this.$bus.emit('alert', {variant, text, delay, position})
        },
        dayjs
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
import {VBModal, VBTooltip} from 'bootstrap-vue'

Vue.directive('b-modal', VBModal)
Vue.directive('b-tooltip', VBTooltip)

import VueBus from 'vue-bus'
import SvgVue from 'svg-vue'
import './ls'

import VueLazyload from 'vue-lazyload'
import VueScrollTo from 'vue-scrollto'
import VueObserveVisibility from 'vue-observe-visibility'

Vue.use(VueBus)
Vue.use(SvgVue)
Vue.use(VueLazyload, {
    error: '/dist/img/no-image.jpg',
})
Vue.use(VueScrollTo)
Vue.use(VueObserveVisibility)
