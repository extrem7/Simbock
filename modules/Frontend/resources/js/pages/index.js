export default {
    RegisterPage: () => import('./auth/Register'),

    WorkPage: () => import('./Work'),
    HelpPage: () => import('./Help'),

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

    DefaultPage: () => import('./Default'),
}
