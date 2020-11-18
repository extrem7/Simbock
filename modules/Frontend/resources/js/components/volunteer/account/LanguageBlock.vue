<template>
    <div class="sector sector-middle sector-language">
        <div class="sector-label">Languages</div>
        <div class="item-box">
            <div class="sector-header">
                <button @click="showModal"
                        class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add languages</span>
                </button>
            </div>
            <div v-if="languages.length" class="sector-body">
                <div class="sector-actions sector-actions-absolute">
                    <button class="btn btn-sector-action btn-sector-edit">
                        <svg-vue icon="settings"></svg-vue>
                    </button>
                    <button class="btn btn-sector-action btn-sector-delete">
                        <svg-vue icon="close"></svg-vue>
                    </button>
                </div>
                <div class="sector-body-inner sector-body-inner-divider">
                    <div v-for="({id,name,fluency},i) in languages"
                         :class="{'mt-3':i>0}">
                        <div class="sector-name">{{ name }}</div>
                        <div class="sector-text small-size mt-1">
                            ({{ fluency }})
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <BModal ref="modal" hide-footer @hidden="clear">
            <template v-slot:modal-header="{ close }">
                <ModalHeader :close="close" title="Language"/>
            </template>
            <div class="extra-small-size control-label">Add up to 5 languages</div>
            <div :class="[invalid('language_id')]" class="form-group">
                <SimbokSelect
                    v-model="form.language_id"
                    :options="options"
                    class="language-select"
                    placeholder="Choose a language.."/>
                <Invalid name="language_id"/>
            </div>
            <div class="extra-small-size mb-1">Fluency</div>
            <div :class="[invalid('fluency')]" class="inline-custom-control mb-2">
                <div v-for="{text,value} in fluencies" class="custom-control custom-radio">
                    <input
                        :id="`fluency-${value}`"
                        v-model="form.fluency"
                        :value="value"
                        class="custom-control-input"
                        type="radio">
                    <label :for="`fluency-${value}`"
                           class="custom-control-label silver-color">
                        {{ text }}
                    </label>
                </div>
                <Invalid name="fluency"/>
            </div>
            <ModalActions @cancel="hideModal" @save="update"/>
        </BModal>
    </div>
</template>

<script>
import Vue from 'vue'
import volunteerBlock from "~/mixins/volunteerBlock"

const languages = Vue.options.methods.shared('languages')

export default {
    mixins: [volunteerBlock],
    data() {
        return {
            id: null,
            form: {
                language_id: null,
                fluency: null
            },
            fluencies: this.shared('fluencies')
        }
    },
    computed: {
        languages() {
            return this.$store.state.volunteer.languages.map(a => ({...a})).map(l => {
                l.name = languages.find(({value}) => value === l.id).text
                l.fluency = this.fluencies.find(({value}) => value === l.fluency).text
                return l
            })
        },
        options() {
            return languages.filter(({value}) => this.languages.find(({id}) => id === value) === undefined)
        }
    },
    methods: {
        async update() {
            if (await this.$store.dispatch('volunteer/updateOrCreateLanguage', {
                id: this.id, form: this.form
            })) {
                this.$refs.modal.hide()
                this.clear()
            }
        },
        edit(language) {
            this.id = language.id
            for (let field in this.form)
                if (language.hasOwnProperty(field))
                    this.form[field] = language[field]
            this.$refs.modal.show()
        },
        destroy(id) {
            this.$store.dispatch('volunteer/destroyLanguage', id)
        },
        clear() {
            if (this.id) this.id = null
            for (let field in this.form) this.form[field] = null
        }
    }
}
</script>
