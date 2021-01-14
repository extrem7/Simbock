<template>
    <div class="col-12">
        <div class="d-flex justify-content-lg-between">
            <search v-model="searchQuery" @search="search"></search>
        </div>

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
                <template v-slot:cell(id)="{item:{id}}">
                    <a :href="route('frontend.companies.show',id)"
                       target="_blank">
                        {{ id }}
                    </a>
                </template>
                <template v-slot:cell(user_id)="{item:{user}}">
                    <a :href="route('admin.users.edit',user.id)"
                       target="_blank">
                        {{ user.name }}
                    </a>
                </template>

                <template v-slot:cell(city_id)="{item:{city}}">
                    {{ city.name }}, {{ city.county }}, {{ city.state_id }}
                </template>
                <template v-slot:cell(plan)="{item:{plan,stripe_id,card_brand,card_last_four}}">
                    <p v-if="plan"
                       class="text-center">
                        {{ plan.name }}
                        <br>
                        <a :href="`https://dashboard.stripe.com/test/customers/${stripe_id}`"
                           target="_blank">
                            {{ stripe_id }}
                        </a>
                        <br>
                        <span class="text-capitalize">{{ card_brand }}</span> **** {{ card_last_four }}
                    </p>
                </template>
            </b-table>

            <div v-if="!total && searchQuery.length" class="d-flex justify-content-center">
                <b-alert class="w-25 text-center" show variant="warning">No users found</b-alert>
            </div>
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
            initialData: this.shared('companies'),
            resource: 'companies',
            fields: [
                {key: 'id', sortable: true},
                {key: 'user_id', label: 'User'},
                {key: 'name', sortable: true},
                {key: 'city_id', label: 'City'},
                {key: 'vacancies_count', sortable: true},
                {key: 'plan'}
            ],
        }
    },
    mixins: [datatable]
}
</script>
