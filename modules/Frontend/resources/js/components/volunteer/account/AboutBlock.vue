<template>
    <div class="sector sector-sidebar sector-profile">
        <div class="sector-label">About me</div>
        <div class="item-box">
            <div class="sector-body">
                <div class="sector-actions sector-actions-absolute">
                    <button class="btn btn-sector-action btn-sector-edit"
                            @click="showModal">
                        <svg-vue icon="settings"></svg-vue>
                    </button>
                </div>
                <div class="sector-body-inner">
                    <div class="position-relative mb-2">
                        <div class="profile-avatar">
                            <img :src="avatar||'/dist/img/avatar.svg'"
                                 alt="profile"
                                 class="profile-avatar-img">
                        </div>
                        <button v-b-modal.modal-avatar class="btn btn-action-img btn-upload-img">
                            <img alt="add-photo" src="/dist/img/icons/plus-light.svg">
                        </button>
                        <button v-if="avatar" class="btn btn-action-img btn-delete" @click="destroyAvatar">
                            <img alt="delete-photo" src="/dist/img/icons/delete-white.svg">
                        </button>
                    </div>
                    <div v-if="name" class="sector-name text-center profile-name mb-2">{{ name }}</div>
                    <button v-else
                            class="btn btn-sector-link mb-1 extra-small-size text-nowrap"
                            @click="showModal">
                        Add Full name
                    </button>
                    <div v-if="headline" class="sector-text text-center extra-small-size mt-1">{{ headline }}</div>
                    <button v-else
                            class="btn btn-sector-link mb-1 extra-small-size text-nowrap"
                            @click="showModal">
                        Add Headline
                    </button>
                    <div v-if="city_id && city"
                         class="sector-text text-center extra-small-size mt-1">{{ city.text }}
                    </div>
                    <button v-else
                            class="btn btn-sector-link extra-small-size text-nowrap"
                            @click="showModal">
                        Add Location
                    </button>
                    <div v-if="is_relocating||is_working_remotely"
                         class="mt-3">
                        <div v-if="is_relocating"
                             class="sector-text text-center extra-small-size mt-1">
                            I am willing to relocate
                        </div>
                        <div v-if="is_working_remotely"
                             class="sector-text text-center extra-small-size mt-1">
                            I am willing to work remotely
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <BModal id="about-modal" ref="modal" hide-footer>
            <template v-slot:modal-header="{ close }">
                <button aria-label="Close" class="close" type="button" @click="close()">
                    <svg-vue icon="close"></svg-vue>
                </button>
                <h5 class="title medium-size semi-bold-weight">About me</h5>
            </template>
            <div :class="[invalid('name')]" class="form-group">
                <InputMaterial v-model="form.name" placeholder="Full Name"/>
                <Invalid name="name"></Invalid>
            </div>
            <div :class="[invalid('headline')]" class="form-group">
                <InputMaterial v-model="form.headline" placeholder="Headline (optional)"/>
                <Invalid name="headline"></Invalid>
            </div>
            <div :class="[invalid('city_id')]" class="form-group">
                <SimbokSelect v-model="form.city_id"
                              :filterable="false"
                              :options="cities"
                              placeholder="City*"
                              @search="searchCity"/>
                <Invalid name="city_id"/>
            </div>
            <div :class="[invalid('zip')]" class="form-group">
                <InputTypeahead v-model="form.zip"
                                :min-matching-chars="0"
                                :options="zips"
                                :show-on-focus="true"
                                placeholder="ZIP Code*"/>
                <Invalid name="zip"/>
            </div>
            <div class="form-group">
                <div class="row align-items-center">
                    <div class="col-6 small-size">Willing to relocate</div>
                    <div class="col-6 text-right">
                        <div class="custom-control custom-switch d-inline-flex">
                            <input id="is_relocating"
                                   v-model="form.is_relocating"
                                   class="custom-control-input"
                                   type="checkbox">
                            <label class="custom-control-label pl-3" for="is_relocating">Yes</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row align-items-center">
                    <div class="col-6 small-size">Willing to work remotely</div>
                    <div class="col-6 text-right">
                        <div class="custom-control custom-switch d-inline-flex">
                            <input id="is_working_remotely"
                                   v-model="form.is_working_remotely"
                                   class="custom-control-input"
                                   type="checkbox">
                            <label class="custom-control-label pl-3" for="is_working_remotely">Yes</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn btn-outline-silver min-width-100 btn-drop-shadow btn-scale-active"
                        @click="cancel">
                    Cancel
                </button>
                <button class="btn btn-green min-width-100 btn-shadow btn-scale-active"
                        @click="update">
                    Save
                </button>
            </div>
        </BModal>
        <BModal id="modal-avatar" hide-footer>
            <template v-slot:modal-header="{ close }">
                <button aria-label="Close" class="close" type="button" @click="close()">
                    <svg-vue icon="close"></svg-vue>
                </button>
                <h5 class="title medium-size semi-bold-weight">Upload avatar</h5>
            </template>
            <AvatarUploader @update="avatar=$event"/>
        </BModal>
    </div>
</template>

<script>
import {mapState} from "vuex"
import AvatarUploader from "./AvatarUploader"
import locationService from "~/services/location"
import volunteerBlock from "~/mixins/volunteerBlock"

export default {
    components: {
        AvatarUploader
    },
    mixins: [volunteerBlock],
    data() {
        const volunteer = this.shared('volunteer')
        return {
            form: {
                name: '',
                headline: '',
                city_id: null,
                zip: '',
                is_relocating: false,
                is_working_remotely: false,
            },
            avatar: volunteer.avatar,
            //todo restore cities
            cities: volunteer.city ? [volunteer.city] : [],
        }
    },
    computed: {
        ...mapState('volunteer', {
            name: state => state.form.name,
            headline: state => state.form.headline,
            city_id: state => state.form.city_id,
            zip: state => state.form.zip,
            is_relocating: state => state.form.is_relocating,
            is_working_remotely: state => state.form.is_working_remotely,
        }),
        city() {
            return this.cities.find(({value}) => value === this.city_id)
        },
        zips() {
            const city = this.cities.find(({value}) => value === this.form.city_id)
            return city ? city.zips.split(' ') : []
        }
    },
    methods: {
        async destroyAvatar() {
            try {
                const {status, data} = await this.axios.delete(this.route('volunteer.account.avatar.destroy'))
                if (status === 200) {
                    this.avatar = data.avatar
                    //this.notify(data.message)
                }
            } catch (e) {
                console.log(e)
            }
        },
        async searchCity(query, loading) {
            if (query.length) this.cities = await locationService.searchCity(query, loading)
        }
    }
}
</script>
