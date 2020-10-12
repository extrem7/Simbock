import Vue from 'vue'

import AlertNotification from "./includes/AlertNotification"

import HeaderGuest from "./layout/header/HeaderGuest"
import HeaderVolunteer from "./layout/header/HeaderVolunteer"
import HeaderCompany from "./layout/header/HeaderCompany"

import VacancyCard from "./layout/VacancyCard"
import VolunteerCard from "./layout/VolunteerCard"
import CompanyCard from "./layout/CompanyCard"
import SelectMaterial from "./layout/SelectMaterial"
import SimbokSelect from "./layout/SimbokSelect"
import InputMaterial from "./layout/InputMaterial"
import InputTypeahead from "./layout/InputTypeahead"
import InputSearch from "./layout/InputSearch"
import InputTag from "./layout/InputTag"
import TheBottomMenuCompany from "./layout/TheBottomMenuCompany"
import TheBottomMenuVolunteer from "./layout/TheBottomMenuVolunteer"
import TheInnerFooter from "./layout/TheInnerFooter"
import TheFooter from "./layout/TheFooter"
import VacancySettings from "./layout/VacancySettings"
import AccessBox from "./layout/AccessBox"
import CompanyCardActions from "./layout/CompanyCardActions"
import TheMainSearch from "./layout/TheMainSearch"

import Register from "./auth/Register"
import Login from './auth/Login'
import EmailReset from "./auth/EmailReset"
import PasswordReset from "./auth/PasswordReset"

export default {
    AlertNotification,
    SimbokSelect,
    VacancySettings,
    SelectMaterial,
    InputTag,
    AccessBox,
    CompanyCard,
    CompanyCardActions,
    TheInnerFooter,
    TheMainSearch,

    HeaderGuest,
    HeaderVolunteer,
    HeaderCompany,
    TheFooter,

    TheBottomMenuVolunteer,
    TheBottomMenuCompany,
    VolunteerCard,
    InputSearch,
    InputTypeahead,
    VacancyCard,
    InputMaterial,

    RegisterForm: Register,
    LoginForm: Login,
    EmailResetForm: EmailReset,
    PasswordResetForm: PasswordReset
}

import vSelect from 'vue-select'
import VueTypeaheadBootstrap from 'vue-typeahead-bootstrap';
import VueTagsInput from '@johmun/vue-tags-input';
import RadialProgressBar from 'vue-radial-progress'

Vue.component('v-select', vSelect)
Vue.component('vue-typeahead-bootstrap', VueTypeaheadBootstrap)
Vue.component('vue-tags-input', VueTagsInput)
Vue.component('radial-progress-bar', RadialProgressBar)

Vue.component('InputMaterial', InputMaterial)

