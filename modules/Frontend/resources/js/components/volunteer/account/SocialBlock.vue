<template>
    <div class="sector sector-sidebar">
        <div class="sector-label">Websites</div>
        <div class="item-box">
            <div class="sector-body">
                <div class="sector-actions sector-actions-absolute">
                    <button class="btn btn-sector-action btn-sector-edit"
                            @click="showModal">
                        <svg-vue icon="settings"></svg-vue>
                    </button>
                </div>
                <div class="sector-body-inner">
                    <div v-for="(link,name) in social" class="sector-contact-info">
                        <div class="sector-contact-icon"><img :src="`/dist/img/icons/${name}.svg`" alt=""></div>
                        <div class="sector-contact-text">
                            <a v-if="link"
                               :href="link"
                               class="line-nowrap link d-block">{{ link }}</a>
                            <button v-else
                                    class="btn btn-sector-link base-size"
                                    @click="showModal">
                                Add {{ name }}
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
                <h5 class="title medium-size semi-bold-weight">Websites</h5>
            </template>
            <div v-for="(link,name) in form"
                 :class="[invalid(`social.${name}`)]"
                 class="form-group">
                <InputMaterial
                    v-model="form[name]"
                    :placeholder="`Add ${name} URL`"/>
                <Invalid :name="`social.${name}`"/>
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
                website: '',
                linkedin: '',
                twitter: '',
                facebook: '',
                instagram: '',
                youtube: '',
                reddit: '',
                pinterest: '',
                quora: '',
            }
        }
    },
    computed: {
        ...mapState('volunteer', {
            social: state => state.form.social
        })
    },
    methods: {
        async update() {
            if (await this.$store.dispatch('volunteer/updateAbout', {social: this.form})) this.$refs.modal.hide()
        },
        fill() {
            for (let field in this.form) {
                if (this.form.hasOwnProperty(field) && this.social.hasOwnProperty(field))
                    this.form[field] = this.$store.state.volunteer.form.social[field]
            }
        }
    }
}
</script>

