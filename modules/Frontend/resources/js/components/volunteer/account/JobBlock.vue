<template>
    <div class="sector sector-middle sector-looking">
        <div class="sector-label">Looking to volunteer</div>
        <div class="item-box">
            <div v-if="!Object.values(sectors).length" class="sector-header">
                <button @click="showModal"
                        class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add Desired job</span>
                </button>
            </div>
            <div v-else class="sector-body">
                <div class="sector-body-inner">
                    <div class="sector-text-between">
                        <div class="sector-name mb-1">{{ job_title }}</div>
                        <div class="sector-actions">
                            <button class="btn btn-sector-action btn-sector-edit"
                                    @click="showModal">
                                <svg-vue icon="settings"></svg-vue>
                            </button>
                            <button class="btn btn-sector-action btn-sector-delete"
                                    @click="destroy">
                                <svg-vue icon="close"></svg-vue>
                            </button>
                        </div>
                    </div>
                    <div class="sector-text small-size">{{ locationsFormatted }}</div>
                    <div class="mt-3">
                        <div class="sector-text extra-small-size mt-1">{{ employmentFormatted }}</div>
                        <div class="sector-text extra-small-size mt-1">{{ sectorsFormatted }}</div>
                    </div>
                </div>
            </div>
        </div>
        <BModal ref="modal" hide-footer>
            <template v-slot:modal-header="{ close }">
                <ModalHeader :close="close" title="Looking to volunteer"/>
            </template>
            <div :class="[invalid('job_title')]" class="form-group">
                <InputMaterial
                    v-model="form.job_title"
                    placeholder="Desired job title*"/>
                <Invalid name="job_title"/>
            </div>
            <div :class="[invalid('locations')]" class="form-group">
                <div v-for="(location,i) in form.locations"
                     :key="`location-select-${i}`"
                     :class="[invalid(`locations.${i}`)]"
                     class="mt-2">
                    <SimbokSelect
                        :class="{'mt-2':i>0}"
                        :filterable="false"
                        :options="cities[i]"
                        :value="location"
                        placeholder="Select city"
                        @input="changeLocation(i,$event)"
                        @search="(query,loading)=>searchCity(i,query,loading)"/>
                    <Invalid :name="`locations.${i}`"/>
                </div>
                <Invalid name="locations"/>
            </div>
            <div v-if="form.locations[0]" class="form-group">
                <button class="btn-add-info btn-rotate-icon btn-add-info-green btn-add-info-sm"
                        @click="addLocation">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add location</span>
                </button>
            </div>
            <div class="control-label">Job type</div>
            <div :class="[invalid('types')]" class="inline-custom-control form-group">
                <div v-for="{text,value} in typesOptions" class="custom-control custom-checkbox">
                    <input :id="`job-types-${value}`"
                           v-model="form.types"
                           :value="value"
                           class="custom-control-input"
                           type="checkbox">
                    <label :for="`job-types-${value}`"
                           class="custom-control-label">
                        {{ text }}
                    </label>
                </div>
                <Invalid name="types"/>
            </div>
            <div class="control-label">Hours</div>
            <div :class="[invalid('hours')]" class="inline-custom-control form-group">
                <div v-for="{text,value} in hoursOptions" class="custom-control custom-checkbox">
                    <input :id="`job-hours-${value}`"
                           v-model="form.hours"
                           :value="value"
                           class="custom-control-input"
                           type="checkbox">
                    <label :for="`job-hours-${value}`"
                           class="custom-control-label">
                        {{ text }}
                    </label>
                </div>
                <Invalid name="hours"/>
            </div>
            <div :class="[invalid('sectors')]" class="add-sector-item">
                <div class="control-label">Select up to 10 sectors</div>
                <div v-for="(sector,i) in form.sectors" :key="`sector-${i}`">
                    <div :class="[invalid(`sectors.${i}.id`)]" class="form-group">
                        <div class="d-flex align-items-center">
                            <SimbokSelect
                                :options="filteredSectors(i)"
                                :value="form.sectors[i]"
                                class="flex-grow-1"
                                placeholder="Choose your sector"
                                @input="changeSector(i,$event)"/>
                            <button v-if="i>0"
                                    class="btn btn-sector-action btn-sector-delete ml-3"
                                    @click="removeSector(sector,i)">
                                <svg-vue icon="close"></svg-vue>
                            </button>
                        </div>
                        <Invalid :name="`sectors.${i}.id`"/>
                    </div>
                    <div v-if="sector" class="control-label">Select up to 5 roles</div>
                    <div v-if="sector" :class="[invalid(`sectors.${i}.roles`)]" class="row form-group">
                        <div v-for="chunk in sectorsOptions.find(({value})=>value===sector).roles"
                             class="col-sm-6">
                            <div v-for="{id,name} in chunk"
                                 class="custom-control custom-checkbox mb-1">
                                <input :id="`sector-${sector}-role-${id}`"
                                       v-model="roles[sector]"
                                       :value="id"
                                       class="custom-control-input"
                                       type="checkbox"
                                       @click="selectRole(sector,$event)">
                                <label :for="`sector-${sector}-role-${id}`"
                                       class="custom-control-label">
                                    {{ name }}
                                </label>
                            </div>
                        </div>
                        <Invalid :name="`sectors.${i}.roles`" class="col-12"/>
                    </div>
                </div>
                <button class="btn-add-info btn-rotate-icon btn-add-info-green btn-add-info-sm"
                        @click="addSector">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add sector</span>
                </button>
                <Invalid name="sectors"/>
            </div>
            <ModalActions @cancel="hideModal" @save="update"/>
        </BModal>
    </div>
</template>

<script>
import Vue from 'vue'

import volunteerBlock from "~/mixins/volunteerBlock"
import locationService from "~/services/location"
import {mapState} from "vuex";

export default {
    mixins: [volunteerBlock],
    data() {
        const volunteer = this.shared('volunteer'),
            sectors = this.shared('sectors')

        return {
            id: null,
            form: {
                job_title: '',
                locations: [null],
                types: [],
                hours: [],
                sectors: [null],
            },
            roles: {},
            typesOptions: this.shared('types'),
            hoursOptions: this.shared('hours'),
            sectorsOptions: sectors,
            cities: volunteer.cities.length ? volunteer.cities : [[]]
        }
    },
    computed: {
        ...mapState('volunteer', {
            job_title: state => state.form.job_title,
            locations: state => state.locations,
            types: state => state.types,
            hours: state => state.hours,
            sectors: state => state.sectors
        }),
        locationsFormatted() {
            return this.locations ? [...this.locations]
                .map((id, i) => this.cities[i].find(({value}) => value === id).text)
                .join(' | ') : ''
        },
        employmentFormatted() {
            let string = ''
            if (this.types.length) string += [...this.types]
                .map(id => this.typesOptions.find(({value}) => value === id).text)
                .join(' & ')
            if (this.hours.length) string += ' & ' + [...this.hours]
                .map(id => this.hoursOptions.find(({value}) => value === id).text)
                .join(' & ')
            return string
        },
        sectorsFormatted() {
            return this.sectors ? [...Object.keys(this.sectors)]
                .map((id) => this.sectorsOptions.find(({value}) => value === parseInt(id)).text)
                .join(' | ') : ''
        }
    },
    methods: {
        async update() {
            const form = {...this.form}
            if (form.locations[0] === null) form.locations = []
            form.sectors = form.sectors[0] !== null ? form.sectors.map(id => ({id, roles: this.roles[id]})) : []
            if (await this.$store.dispatch('volunteer/updateJob', form)) {
                this.$refs.modal.hide()
            }
        },
        destroy() {
            this.$store.dispatch('volunteer/destroyJob')
        },

        async searchCity(i, query, loading) {
            if (query.length) Vue.set(this.cities, i, await locationService.searchCity(query, loading))
        },
        addLocation() {
            if (this.form.locations[this.form.locations.length - 1]) {
                this.form.locations.push(null)
                this.cities.push([])
            }
        },
        changeLocation(i, value) {
            const old = this.form.locations[i]
            if (this.form.locations.length > 1 && old && value === null) {
                Vue.delete(this.form.locations, i)
                Vue.delete(this.cities, i)
            } else {
                Vue.set(this.form.locations, i, value)
            }
        },

        addSector() {
            if (this.form.sectors[this.form.sectors.length - 1] && this.form.sectors.length <= 10) {
                this.form.sectors.push(null)
            }
        },
        changeSector(i, sector) {
            const old = this.form.sectors[i]

            if (sector === null) {
                this.removeSector(sector, i)
            } else {
                Vue.set(this.form.sectors, i, sector)
                Vue.delete(this.roles, old)
                Vue.set(this.roles, sector, [])
            }
        },
        removeSector(sector, i) {
            if (i > 0) {
                Vue.delete(this.form.sectors, i)
                Vue.delete(this.roles, sector)
            }
        },
        filteredSectors(i) {
            const used = [...this.form.sectors]
            delete used[i]
            return this.sectorsOptions.filter(({value}) => !used.includes(value))
        },
        selectRole(sector, e) {
            if (this.roles[sector].length >= 5 && e.target.checked) e.preventDefault()
        },

        fill() {
            this.form.job_title = this.$store.state.volunteer.form.job_title
            if (this.locations.length) this.form.locations = [...this.locations]
            if (this.types.length) this.form.types = [...this.types]
            if (this.hours.length) this.form.hours = [...this.hours]
            if (Object.values(this.sectors).length) {
                this.form.sectors = Object.keys(this.sectors).map(i => parseInt(i))
                for (let sector of this.form.sectors) {
                    this.roles[sector] = this.sectors[sector]
                }
            }
        },
    }
}
</script>
