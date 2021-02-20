<template>
    <main class="container content-inner">
        <div class="row">
            <HistoryBack/>
            <div class="col-xl-3 col-lg-4 col-md-5">
                <CompanyCardActions
                    v-if="$root.isMobileGrid"
                    :employment="company.employment"
                    :location="company.location"
                    :logo="company.logo"
                    :name="company.name"
                    can-edit/>

                <div class="sector sector-sidebar">
                    <div class="sector-label">Contact Information</div>
                    <div class="item-box">
                        <div class="sector-body">
                            <div class="sector-body-inner">
                                <div class="sector-contact-info">
                                    <div class="sector-contact-icon"><img alt="" src="/dist/img/icons/mail.svg"></div>
                                    <div class="sector-contact-text">
                                        <a :href="`mailto:${company.email}`"
                                           class="line-nowrap link-inherit d-block">
                                            {{ company.email }}
                                        </a>
                                    </div>
                                </div>
                                <div class="sector-contact-info">
                                    <div class="sector-contact-icon"><img alt="" src="/dist/img/icons/phone.svg"></div>
                                    <div class="sector-contact-text">
                                        <a :href="`tel:+${company.phone}`"
                                           class="line-nowrap link-inherit d-block">
                                            {{ company.phone }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="Object.values(company.social).filter(i => i !== null).length"
                     class="sector sector-sidebar">
                    <div class="sector-label">Websites</div>
                    <div class="item-box">
                        <div class="sector-body">
                            <div class="sector-body-inner">
                                <div v-for="(link,name) in company.social"
                                     v-if="link"
                                     class="sector-contact-info">
                                    <div class="sector-contact-icon">
                                        <img :src="`/dist/img/icons/${name}.svg`">
                                    </div>
                                    <div class="sector-contact-text">
                                        <a :href="link"
                                           class="line-nowrap link d-block"
                                           target="_blank">
                                            {{ link }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-7 col-md-7">
                <div class="sector-label invisible">Company info</div>
                <CompanyCardActions
                    v-if="!$root.isMobileGrid"
                    :employment="company.employment"
                    :location="company.location"
                    :logo="company.logo"
                    :name="company.name"
                    can-edit/>
                <div v-if="company.description" class="sector sector-hiring-company-desc">
                    <div class="sector-label">Hiring Company Description</div>
                    <div class="item-box">
                        <div class="sector-body">
                            <div class="sector-body-inner dynamic-sector-text">{{ company.description }}</div>
                        </div>
                    </div>
                </div>
                <div v-if="company.vacancies.length" class="sector sector-volunteering-vacancies">
                    <div class="sector-label">All Volunteering Vacancies</div>
                    <div class="item-box">
                        <VacancyCard v-for="vacancy in company.vacancies"
                                     :key="vacancy.id"
                                     :company="company"
                                     v-bind="vacancyProps(vacancy)"
                                     :has-actions="false"
                                     :has-logo-and-name="false"
                                     class="border-left-0"/>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import CompanyCardActions from "~/components/layout/CompanyCardActions"
import VacancyCard from "../vacancies/VacancyCard"
import HistoryBack from "~/components/layout/HistoryBack"

export default {
    components: {
        HistoryBack,
        CompanyCardActions,
        VacancyCard
    },
    data() {
        return {
            company: this.shared('company')
        }
    },
    methods: {
        vacancyProps(vacancy) {
            const props = {}
            const fields = ['id', 'title', 'location', 'employment', 'date', 'excerpt']
            for (let field of fields) props[field] = vacancy[field]
            return props
        },
    }
}
</script>
