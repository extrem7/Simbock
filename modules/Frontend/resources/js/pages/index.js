import Work from "./Work"
import Help from "./Help"

import VolunteerShow from './volunteer/Show'
import Companies from "./volunteer/Companies"
import SavedVacancies from "./volunteer/SavedVacancies"
import HistoryVacancies from "./volunteer/HistoryVacancies"

import Board from "./company/Board"
import CompanyVolunteersIndexPage from "./company/volunteers/Index"
import CompanySavedVolunteersPage from "./company/volunteers/Saved"
import CompanyCandidatesPage from "./company/volunteers/Candidates"

import Default from "./Default"

export default {
    WorkPage: Work,
    HelpPage: Help,

    VolunteerShowPage: VolunteerShow,
    VolunteerCompaniesPage: Companies,
    VolunteerSavedVacanciesPage: SavedVacancies,
    VolunteerHistoryVacanciesPage: HistoryVacancies,

    CompanyBoardPage: Board,
    CompanyVolunteersIndexPage,
    CompanySavedVolunteersPage,
    CompanyCandidatesPage,

    DefaultPage: Default,
}
