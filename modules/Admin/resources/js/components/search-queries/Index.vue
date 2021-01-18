<template>
    <div class="col-12">
        <b-overlay :opacity="0.5" :show="isBusy" variant="dark">
            <b-table
                v-show="total"
                ref="table"

                :busy.async="isBusy"
                :current-page="currentPage"

                :fields="fields"
                :items="items"
                :per-page="perPage"

                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"

                bordered
                hover
                sort-icon-left>
                <template v-slot:cell(company_id)="{item:{company}}">
                    <a v-if="company"
                       :href="route('frontend.companies.show',company.id)"
                       target="_blank">
                        {{ company.name }}
                    </a>
                </template>
                <template v-slot:cell(volunteer_id)="{item:{volunteer}}">
                    <a v-if="volunteer"
                       :href="route('frontend.volunteers.show',volunteer.id)"
                       target="_blank">
                        {{ volunteer.name }}
                    </a>
                </template>
                <template v-slot:cell(created_at)="{item:{created_at}}">
                    {{ created_at | moment('DD.MM.YYYY HH:mm') }}
                </template>
            </b-table>
        </b-overlay>

        <b-pagination
            v-if="total"
            v-model="currentPage"
            :per-page="perPage"
            :total-rows="total">
        </b-pagination>
    </div>
</template>

<script>
import {datatable} from '@/mixins/index-table'

export default {
    data() {
        return {
            initialData: this.shared('searchQueries'),
            resource: 'search-queries',
            fields: [
                {key: 'company_id', label: 'Company'},
                {key: 'volunteer_id', label: 'Volunteer'},
                {key: 'query', sortable: true},
                {key: 'location', label: 'City'},
                {key: 'created_at', label: 'Date', sortable: true}
            ],
        }
    },
    mixins: [datatable]
}
</script>
