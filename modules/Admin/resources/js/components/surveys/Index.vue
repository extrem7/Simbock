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
                <template v-slot:cell(volunteer_id)="{item:{volunteer}}">
                    <a v-if="volunteer"
                       :href="route('frontend.volunteers.show',volunteer.id)"
                       target="_blank">
                        {{ volunteer.name }}
                    </a>
                </template>
                <template v-slot:cell(source_id)="{item:{source}}">
                    {{ source.name }}
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
            initialData: this.shared('surveys'),
            resource: 'surveys',
            fields: [
                {key: 'id', sortable: true},
                {key: 'volunteer_id', label: 'Volunteer'},
                {key: 'source_id', sortable: true},
                {key: 'specified'},
                {key: 'name'},
                {key: 'email'},
                {key: 'address'},
                {key: 'phone'},
                {key: 'company_name'},
                {key: 'description'},
                {key: 'created_at', label: 'Date', sortable: true}
            ],
        }
    },
    mixins: [datatable]
}
</script>
