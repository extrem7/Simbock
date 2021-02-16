<template>
    <main class="container content-inner">
        <AccessBox
            v-if="this.user && this.user.is_volunteer"
            :id="vacancy.id"
            :in-bookmarks="vacancy.in_bookmarks"
            @update:bookmarked="updateVacancyBookmarked"/>
        <div class="row">
            <HistoryBack/>
            <div class="col-xl-8 col-lg-10">
                <div class="vacancy-open">
                    <VacancyCard
                        v-bind="vacancyProps(vacancy)"
                        :has-description="false"
                        :in-bookmarks="vacancy.in_bookmarks"
                        :is-applied="vacancy.is_applied"
                        :has-actions="hasActions"
                        @update:applied="updateVacancyApplied"
                        @update:bookmarked="updateVacancyBookmarked"
                        class="border-r-10 border-left-0"/>

                    <div class="sector sector-vacancy-description">
                        <div class="sector-label">Job Description</div>
                        <div class="item-box">
                            <div class="sector-body">
                                <div class="sector-body-inner dynamic-sector-text">{{ vacancy.description }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="sector sector-vacancy-description">
                        <div class="sector-label">Other information</div>
                        <div class="item-box">
                            <div class="sector-body">
                                <div class="sector-body-inner dynamic-text">
                                    <div v-if="vacancy.benefits.length" class="mb-3">
                                        <div class="sector-name mb-1">Benefits</div>
                                        <div class="sector-text small-size">
                                            {{ vacancy.benefits.map(b => b.name).join(', ') }}.
                                        </div>
                                    </div>
                                    <div v-if="vacancy.address" class="mb-3">
                                        <div class="sector-name mb-1">Street Address</div>
                                        <div class="sector-text small-size">{{ vacancy.address }}</div>
                                    </div>
                                    <div v-if="vacancy.incentives.length" class="mb-3">
                                        <div class="sector-name">Incentives</div>
                                        <div class="tag-list">
                                            <div v-for="{name} in vacancy.incentives" class="tag-item tag-item-info">
                                                {{ name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="vacancy.skills.length" class="mb-3">
                                        <div class="sector-name">Skills</div>
                                        <div class="tag-list">
                                            <div v-for="{name} in vacancy.skills" class="tag-item tag-item-info">
                                                {{ name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="vacancy.is_relocation || vacancy.is_remote_work">
                                        <div v-if="vacancy.is_relocation" class="sector-name">
                                            I am willing to relocate
                                        </div>
                                        <div v-if="vacancy.is_remote_work" class="sector-name">
                                            I am willing to work remotely
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sector sector-about-company">
                        <div class="sector-label">About Company</div>
                        <div class="item-box">
                            <div class="sector-body">
                                <div class="sector-body-inner dynamic-sector-text">
                                    <div class="sector-name">{{ vacancy.company_title }}</div>
                                    <div class="sector-text small-size mt-1">{{ vacancy.company_description }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import Vue from "vue"
import AccessBox from "~/components/layout/AccessBox"
import HistoryBack from "~/components/layout/HistoryBack"
import VacancyCard from "./VacancyCard"


export default {
    components: {
        HistoryBack,
        AccessBox,
        VacancyCard
    },
    data() {
        return {
            vacancy: this.shared('vacancy')
        }
    },
    computed: {
        user() {
            return this.$store.state.user
        },
        hasActions() {
            return (this.user === null || this.user.is_volunteer) && this.enableActions
        }
    },
    methods: {
        updateVacancyApplied() {
            Vue.set(this.vacancy, 'is_applied', true)
        },
        updateVacancyBookmarked(in_bookmarks) {
            Vue.set(this.vacancy, 'in_bookmarks', in_bookmarks)
        },
        vacancyProps(vacancy) {
            const props = {}
            const fields = ['id', 'title', 'location', 'employment', 'date', 'company', 'company_title']
            for (let field of fields) props[field] = vacancy[field]
            return props
        }
    }
}
</script>
