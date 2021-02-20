<template>
    <main class="container content-inner">
        <div class="row flex-column-reverse flex-lg-row">
            <main v-if="!company.is_subscribed"
                  class="col-lg-7">
                <h1 class="title medium-size text-center text-lg-left">
                    To see recommended volunteers
                    <a :href="route('company.upgrade.page')"
                       class="link-border link">
                        upgrade your plan
                    </a>.
                </h1>
            </main>
            <VolunteersIndex
                v-else
                :enable-filter="false"
                :is-container="false"
                class="col-lg-7"
                title="Recommended Candidates"/>
            <div class="col-lg-4 aside-right-board">
                <CompanyCardActions
                    :employment="company.employment"
                    :location="company.location"
                    :logo="company.logo"
                    :name="company.name"
                    can-edit
                />
                <div v-if="resumeViews.available && resumeViews.available!=='∞'"
                     class="card-work card-company border-left-0 border-r-10 text-center">
                    <div>Viewed
                        <span class="text-danger">
                            {{ resumeViews.viewed }}/{{ resumeViews.available }} vacancies
                        </span>
                    </div>
                    <div v-if="resumeViews.viewed===resumeViews.available">If you want you can
                        <a :href="route('company.upgrade.page')"
                           class="link-border link">
                            upgrade your plan
                        </a>
                    </div>
                </div>
                <div class="item-box board d-none d-lg-block">
                    <div class="board-header">
                        <a :href="route('company.vacancies.index','active')"
                           class="job-status job-status-active"
                           @click="preventVacancyLink('active',$event)">
                            Active ({{ counts.active }})
                        </a>
                        <a :href="route('company.vacancies.index','draft')"
                           class="job-status job-status-draft"
                           @click="preventVacancyLink('draft',$event)">
                            Draft ({{ counts.draft }})
                        </a>
                        <a :href="route('company.vacancies.index','closed')"
                           class="job-status job-status-closed"
                           @click="preventVacancyLink('closed',$event)">
                            Closed ({{ counts.closed }})
                        </a>
                    </div>
                    <div v-if="vacancies.length" class="board-body">
                        <div class="board-vacancy">
                            <div v-for="{id,title,status,days} in vacancies"
                                 class="board-vacancy-item">
                                <div class="board-vacancy-item-wrapper">
                                    <div class=flex-grow-1>
                                        <a :href="route('vacancies.show',id)"
                                           class="board-vacancy-title">
                                            {{ title }}
                                        </a>
                                        <div class="board-vacancy-time">
                                            Posted {{ days }} days ago
                                        </div>
                                    </div>
                                    <div :class="[`job-status-${status.toLocaleLowerCase()}`]"
                                         class="job-status">
                                        {{ statuses[status] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a :href="route('company.vacancies.index')"
                           class="link link-border medium-weight small-size mt-3">
                            View all
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import VolunteersIndex from './volunteers/Index'
import CompanyCardActions from '~/components/layout/CompanyCardActions'
import HistoryBack from '~/components/layout/HistoryBack'

import statuses from '~/components/vacancies/statuses.json'

export default {
    components: {
        VolunteersIndex,
        CompanyCardActions,
        HistoryBack
    },
    data() {
        return {
            vacancies: this.shared('lastVacancies'),
            counts: this.shared('counts'),
            resumeViews: this.shared('resumeViews'),
            statuses
        }
    },
    computed: {
        user() {
            return this.$store.state.user
        },
        company() {
            return this.user.company
        },
    },
    methods: {
        preventVacancyLink(status, e) {
            if (!this.counts[status]) e.preventDefault()
        }
    }
}
</script>
