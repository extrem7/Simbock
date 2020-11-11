<template>
    <div class="sector sector-sidebar">
        <div class="sector-label">Contact Information</div>
        <div class="item-box">
            <div class="sector-body">
                <div class="sector-actions sector-actions-absolute">
                    <button class="btn btn-sector-action btn-sector-edit"
                            @click="showModal">
                        <svg-vue icon="settings"></svg-vue>
                    </button>
                </div>
                <div class="sector-body-inner">
                    <div class="sector-contact-info">
                        <div class="sector-contact-icon">
                            <img alt="" src="/dist/img/icons/mail.svg">
                        </div>
                        <div class="sector-contact-text">
                            <a v-if="email"
                               :href="`mailto:${email}`"
                               class="line-nowrap link-inherit d-block">
                                {{ email }}
                            </a>
                            <button v-else class="btn btn-sector-link base-size"
                                    @click="showModal">
                                Add Email
                            </button>
                        </div>
                    </div>
                    <div class="sector-contact-info">
                        <div class="sector-contact-icon">
                            <img alt="" src="/dist/img/icons/phone.svg">
                        </div>
                        <div class="sector-contact-text pr-0">
                            <a v-if="phone"
                               :href="`tel:${phone}`"
                               class="line-nowrap link-inherit d-block">
                                {{ phone }}
                            </a>
                            <button v-else class="btn btn-sector-link base-size"
                                    @click="showModal">
                                Add Phone Number
                            </button>
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
                <h5 class="title medium-size semi-bold-weight">Contact Info</h5>
            </template>
            <div :class="[invalid('email')]" class="form-group">
                <InputMaterial
                    v-model="form.email"
                    placeholder="Email"/>
                <Invalid name="email"/>
            </div>
            <div :class="[invalid('phone')]" class="form-group">
                <InputMaterial
                    v-model="form.phone"
                    placeholder="Phone"/>
                <Invalid name="phone"/>
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
                phone: '',
                email: ''
            }
        }
    },
    computed: {
        ...mapState('volunteer', {
            phone: state => state.form.phone,
            email: state => state.form.email
        })
    }
}
</script>
