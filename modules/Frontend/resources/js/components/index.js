import Vue from 'vue'

import App from './App'

import ArticlesList from "./articles/ArticlesList"

import CompanyInfoForm from "~/components/company/InfoForm"
import CompanyShow from "~/components/companies/Show"

import VacancyForm from "~/components/company/vacancies/Form"
import CompanyVacanciesList from "~/components/company/vacancies/List"

import VacanciesHomeForm from "~/components/vacancies/VacanciesHomeForm";
import VacanciesIndex from "~/components/vacancies/VacanciesIndex";
import VacancyShow from '~/components/vacancies/Show'

import VolunteerAccountPage from '~/components/volunteer/account/AccountPage'

import Register from './auth/Register'
import Login from './auth/Login'
import EmailReset from './auth/EmailReset'
import PasswordReset from './auth/PasswordReset'
import PasswordChange from './auth/PasswordChange'

import SubscriptionManagement from './company/SubscriptionManagement'

export default {
    App,

    ArticlesList,

    CompanyInfoForm,
    CompanyShow,

    VacancyForm,
    CompanyVacanciesList,

    VacanciesHomeForm,
    VacanciesIndex,
    VacancyShow,

    VolunteerAccountPage,

    RegisterForm: Register,
    LoginForm: Login,
    EmailResetForm: EmailReset,
    PasswordResetForm: PasswordReset,
    PasswordChangeForm: PasswordChange,
    SubscriptionManagement
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

