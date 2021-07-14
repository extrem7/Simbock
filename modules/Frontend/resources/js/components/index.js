import Vue from 'vue'

export default {
    App: () => import('./App'),

    ArticlesList: () => import('./articles/ArticlesList'),

    CompanyInfoForm: () => import('./company/InfoForm'),
    CompanyShow: () => import('./companies/Show'),

    VacancyForm: () => import('./company/vacancies/Form'),
    CompanyVacanciesList: () => import('./company/vacancies/List'),

    VacanciesHomeForm: () => import('./vacancies/VacanciesHomeForm'),
    VacanciesIndex: () => import('./vacancies/VacanciesIndex'),
    VacancyShow: () => import('./vacancies/Show'),

    VolunteerAccountPage: () => import('./volunteer/account/AccountPage'),

    LoginForm: () => import('./auth/Login'),
    EmailResetForm: () => import('./auth/EmailReset'),
    PasswordResetForm: () => import('./auth/PasswordReset'),
    PasswordChangeForm: () => import('./auth/PasswordChange'),
    SubscriptionManagement: () => import('./company/SubscriptionManagement'),

    ChatNotifications: () => import('./ChatNotifications')
}

import SelectMaterial from "./layout/SelectMaterial"
import SimbokSelect from "./layout/SimbokSelect"
import InputMaterial from "./layout/InputMaterial"
import InputTypeahead from "./layout/InputTypeahead"
import InputTag from "./layout/InputTag"
import InputSearch from "./layout/InputSearch"

Vue.component('SelectMaterial', SelectMaterial)
Vue.component('SimbokSelect', SimbokSelect)
Vue.component('InputMaterial', InputMaterial)
Vue.component('InputTypeahead', InputTypeahead)
Vue.component('InputTag', InputTag)
Vue.component('InputSearch', InputSearch)

import vSelect from 'vue-select'
import VueTypeaheadBootstrap from 'vue-typeahead-bootstrap';
import VueTagsInput from '@johmun/vue-tags-input';

Vue.component('VSelect', vSelect)
Vue.component('VueTypeaheadBootstrap', VueTypeaheadBootstrap)
Vue.component('VueTagsInput', VueTagsInput)

Vue.component('InputMaterial', InputMaterial)

