<template>
    <div class="sector sector-middle sector-car">
        <div class="sector-label">Car & driving license</div>
        <div class="item-box">
            <div v-if="!(has_driver_license || has_car)" class="sector-header">
                <button class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg"
                        @click="showModal">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add car & driving license</span>
                </button>
            </div>
            <div v-else class="sector-body sector-body-divider">
                <div class="sector-actions sector-actions-absolute">
                    <button class="btn btn-sector-action btn-sector-edit" @click="showModal">
                        <svg-vue icon="settings"></svg-vue>
                    </button>
                    <button class="btn btn-sector-action btn-sector-delete" @click="clear">
                        <svg-vue icon="close"></svg-vue>
                    </button>
                </div>
                <div class="sector-body-inner">
                    <div>
                        <div class="sector-name">Licence</div>
                        <div class="sector-text small-size mt-1">
                            I have{{ !has_driver_license ? 'n\'t' : '' }} a full licence
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="sector-name">Car</div>
                        <div class="sector-text small-size mt-1">
                            I have{{ !has_car ? 'n\'t' : '' }} a car
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <BModal ref="modal" hide-footer>
            <template v-slot:modal-header="{ close }">
                <button aria-label="Close" class="close" type="button" @click="close()">
                    <svg-vue icon="close"></svg-vue>
                </button>
                <h5 class="title medium-size semi-bold-weight">Car & driving licence</h5>
            </template>
            <div class="extra-small-size mb-1">I have a full licence</div>
            <div class="inline-custom-control mb-2">
                <div class="custom-control custom-radio flex-grow-0">
                    <input id="has_driver_license-yes"
                           v-model="form.has_driver_license"
                           :value="true"
                           class="custom-control-input"
                           type="radio">
                    <label class="custom-control-label silver-color" for="has_driver_license-yes">Yes</label>
                </div>
                <div class="custom-control custom-radio flex-grow-0">
                    <input id="has_driver_license-no"
                           v-model="form.has_driver_license"
                           :value="false"
                           class="custom-control-input"
                           type="radio">
                    <label class="custom-control-label silver-color" for="has_driver_license-no">No</label>
                </div>
            </div>
            <div class="extra-small-size mb-1">I have a car</div>
            <div class="inline-custom-control">
                <div class="custom-control custom-radio flex-grow-0">
                    <input id="has_car-yes"
                           v-model="form.has_car"
                           :value="true"
                           class="custom-control-input"
                           type="radio">
                    <label class="custom-control-label silver-color" for="has_car-yes">Yes</label>
                </div>
                <div class="custom-control custom-radio flex-grow-0">
                    <input id="has_car-no"
                           v-model="form.has_car"
                           :value="false"
                           class="custom-control-input"
                           type="radio">
                    <label class="custom-control-label silver-color" for="has_car-no">No</label>
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
    </div>
</template>

<script>
import volunteerBlock from "~/mixins/volunteerBlock"
import {mapState} from "vuex"

export default {
    mixins: [volunteerBlock],
    data() {
        return {
            form: {
                has_driver_license: false,
                has_car: false
            }
        }
    },
    computed: {
        ...mapState('volunteer', {
            has_driver_license: state => state.form.has_driver_license,
            has_car: state => state.form.has_car
        }),
    },
    methods: {
        clear() {
            this.form.has_driver_license = false
            this.form.has_car = false
            this.update()
        }
    }
}
</script>

