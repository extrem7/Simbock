export default {
    RegisterPage: () => import('./auth/Register'),

    WorkPage: () => import('./static/Work'),
    HelpPage: () => import('./static/Help'),
    SitemapPage: () => import('./static/Sitemap'),

    VolunteerShowPage: () => import('./volunteer/Show'),
    VolunteerCompaniesPage: () => import('./volunteer/Companies'),
    VolunteerSavedVacanciesPage: () => import('./volunteer/SavedVacancies'),
    VolunteerHistoryVacanciesPage: () => import('./volunteer/HistoryVacancies'),
    VolunteerSurveyPage: () => import('./volunteer/Survey'),

    CompanyBoardPage: () => import('./company/Board'),
    CompanyVolunteersIndexPage: () => import('./company/volunteers/Index'),
    CompanySavedVolunteersPage: () => import('./company/volunteers/Saved'),
    CompanyCandidatesPage: () => import('./company/volunteers/Candidates'),
    CompanyUpgradePage: () => import('./company/Upgrade'),

    ChatPage: () => import('./Chat'),

    DefaultPage: () => import('./static/Default'),
}
