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

    ChatNotifications: () => import('./ChatNotifications'),

    SeoText: () => import('./SeoText')
}

Vue.component('SimbokSelect', () => import('./layout/SimbokSelect'))
Vue.component('InputMaterial', () => import('./layout/InputMaterial'))

