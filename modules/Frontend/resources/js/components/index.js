import Vue from 'vue'

import AlertNotification from "./includes/AlertNotification"

import HeaderGuest from "./layout/header/HeaderGuest"
import HeaderVolunteer from "./layout/header/HeaderVolunteer"
import HeaderCompany from "./layout/header/HeaderCompany"
import VolunteerMenu from './layout/header/VolunteerMenu'

import ArticlesList from "./articles/ArticlesList"

import CompanyInfoForm from "~/components/company/InfoForm"
import CompanyShow from "~/components/companies/Show"

import VacancyForm from "~/components/company/vacancies/Form"
import CompanyVacanciesList from "~/components/company/vacancies/List"

import VacanciesHomeForm from "~/components/vacancies/VacanciesHomeForm";
import VacanciesIndex from "~/components/vacancies/VacanciesIndex";
import VacancyShow from "~/components/vacancies/Show"

import VolunteerAccountPage from "~/components/volunteer/account/AccountPage"

import VacancyCard from "./vacancies/VacancyCard"
import VolunteerCard from "./layout/VolunteerCard"
import CompanyCard from "./layout/CompanyCard"
import CompanyMenu from "./layout/header/CompanyMenu"
import TheBottomMenuVolunteer from "./layout/header/TheBottomMenuVolunteer"
import TheInnerFooter from "./layout/TheInnerFooter"
import TheFooter from "./layout/TheFooter"
import VacancySettings from "./vacancies/VacancySettings"
import AccessBox from "./layout/AccessBox"
import CompanyCardActions from "./layout/CompanyCardActions"
import TheMainSearch from "./layout/TheMainSearch"

import Register from "./auth/Register"
import Login from './auth/Login'
import EmailReset from "./auth/EmailReset"
import PasswordReset from "./auth/PasswordReset"
import PasswordChange from "./auth/PasswordChange"

export default {
    AlertNotification,
    SimbokSelect,
    VacancySettings,
    SelectMaterial,
    AccessBox,
    CompanyCard,
    CompanyCardActions,
    TheInnerFooter,
    TheMainSearch,

    HeaderGuest,
    HeaderVolunteer,
    HeaderCompany,
    TheFooter,

    ArticlesList,

    CompanyInfoForm,
    CompanyShow,

    VacancyForm,
    CompanyVacanciesList,

    VacanciesHomeForm,
    VacanciesIndex,
    VacancyShow,

    VolunteerMenu,
    VolunteerAccountPage,

    TheBottomMenuVolunteer,
    CompanyMenu,
    VolunteerCard,
    InputTypeahead,
    VacancyCard,
    InputMaterial,

    RegisterForm: Register,
    LoginForm: Login,
    EmailResetForm: EmailReset,
    PasswordResetForm: PasswordReset,
    PasswordChangeForm: PasswordChange
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

