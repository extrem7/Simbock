<template>
    <form class="post-vacancy-wrapper"
          @submit.prevent>
        <div :class="[invalid('title')]" class="form-group">
            <InputMaterial v-model="form.title"
                           placeholder="Volunteer job title*"/>
            <Invalid name="title"/>
        </div>
        <div :class="[invalid('sector_id')]" class="form-group">
            <SimbokSelect v-model="form.sector_id"
                          :options="sectors"
                          placeholder="Industry*"/>
            <Invalid name="sector_id"/>
        </div>
        <div :class="[invalid('city_id')]" class="form-group">
            <SimbokSelect v-model="form.city_id"
                          :filterable="false"
                          :options="cities"
                          placeholder="City*"
                          @search="searchCity"/>
            <Invalid name="city_id"/>
        </div>
        <div :class="[invalid('address')]" class="form-group">
            <InputMaterial v-model="form.address"
                           placeholder="Street Address"/>
            <Invalid name="address"/>
        </div>
        <div :class="[invalid('type_id')]" class="form-group">
            <div class="control-label">Job type</div>
            <div class="inline-custom-control">
                <div v-for="{value,text} in types"
                     class="custom-control custom-radio">
                    <input :id="`type-${value}`"
                           v-model="form.type_id"
                           :value="value"
                           class="custom-control-input"
                           type="radio">
                    <label :for="`type-${value}`" class="custom-control-label">{{ text }}</label>
                </div>
            </div>
            <Invalid name="type_id"/>
        </div>
        <div :class="[invalid('hours')]" class="form-group">
            <div class="control-label">Job type</div>
            <div class="inline-custom-control">
                <div v-for="{value,text} in hours"
                     class="custom-control custom-checkbox">
                    <input :id="`hour-${value}`"
                           v-model="form.hours"
                           :value="value"
                           class="custom-control-input"
                           type="checkbox">
                    <label :for="`hour-${value}`"
                           class="custom-control-label">{{ text }}</label>
                </div>
            </div>
            <Invalid name="hours"/>
        </div>
        <div :class="[invalid('description')]" class="form-group">
            <div class="control-label">Job Description*</div>
            <textarea v-model="form.description"
                      class="form-control form-control-material"
                      placeholder="Describe this job"
                      rows="4"/>
            <Invalid name="description"/>
        </div>
        <div :class="[invalid('benefits')]" class="form-group">
            <div class="control-label">Benefits*</div>
            <div class="inline-custom-control">
                <div v-for="{value,text} in benefits"
                     class="custom-control custom-checkbox">
                    <input
                        :id="`benefit-${value}`"
                        v-model="form.benefits"
                        :value="value"
                        class="custom-control-input"
                        type="checkbox">
                    <label :for="`benefit-${value}`"
                           class="custom-control-label">{{ text }}</label>
                </div>
            </div>
            <Invalid name="benefits"/>
        </div>
        <div :class="[invalid('incentives')]" class="form-group">
            <InputTag v-model="form.incentives"
                      :options="incentives"
                      placeholder="Enter a desired Incentives"/>
            <Invalid name="incentives"/>
        </div>
        <div :class="[invalid('is_relocation')]" class="form-group">
            <div class="row align-items-center">
                <div class="col-6 small-size">Willing to relocate</div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input id="is_relocation"
                               v-model="form.is_relocation"
                               class="custom-control-input"
                               type="checkbox">
                        <label class="custom-control-label pl-3" for="is_relocation">Yes</label>
                    </div>
                </div>
            </div>
            <Invalid name="is_relocation"/>
        </div>
        <div :class="[invalid('is_remote_work')]" class="form-group">
            <div class="row align-items-center">
                <div class="col-6 small-size">Willing to work remotely</div>
                <div class="col-6">
                    <div class="custom-control custom-switch">
                        <input id="is_remote_work"
                               v-model="form.is_remote_work"
                               class="custom-control-input"
                               type="checkbox">
                        <label class="custom-control-label pl-3" for="is_remote_work">Yes</label>
                    </div>
                </div>
            </div>
            <Invalid name="is_relocation"/>
        </div>
        <div :class="[invalid('skills')]" class="form-group">
            <InputTag v-model="form.skills"
                      :options="skills"
                      placeholder="Enter a desired skill"/>
            <Invalid name="skills"/>
        </div>
        <div :class="[invalid('company_title')]" class="form-group">
            <InputMaterial v-model="form.company_title"
                           placeholder="Hiring Company*"/>
            <Invalid name="company_title"/>
        </div>
        <div :class="[invalid('company_description')]" class="form-group">
            <div class="control-label">Hiring Company Description</div>
            <textarea v-model="form.company_description"
                      class="form-control form-control-material"
                      placeholder="Describe your company"
                      rows="4"/>
            <Invalid name="company_description"/>
        </div>
        <div class="d-inline-flex align-items-center btn-group-save-form mt-3">
            <button class="btn btn-green btn-shadow btn-save-form btn-scale-active"
                    @click.prevent="submit">Save & Post Now
            </button>
            <button class="btn btn-outline-silver min-width-100 btn-shadow btn-scale-active">Cancel</button>
        </div>
    </form>
</template>

<script>
import locationService from "~/services/location"
import validation from "~/mixins/validation"

export default {
    components: {},
    mixins: [validation],
    data() {
        return {
            form: {
                title: '',
                sector_id: null,
                city_id: null,
                address: '',
                type_id: null,
                hours: [],
                description: '',
                benefits: [],
                incentives: [],
                is_relocation: false,
                is_remote_work: false,
                skills: [],
                company_title: '',
                company_description: ''
            },
            sectors: this.shared('sectors'),
            types: this.shared('types'),
            hours: this.shared('hours'),
            benefits: this.shared('benefits'),
            incentives: this.shared('incentives'),
            skills: this.shared('skills'),
            cities: [],
            isEdit: false
        }
    },
    created() {
        const vacancy = this.shared('vacancy')
        if (vacancy) {
            this.isEdit = true
            if (vacancy.logo) this.logo = vacancy.logo
            this.cities = [vacancy.city]

            for (let field in this.form) {
                if (vacancy[field] !== undefined && vacancy[field] !== null) {
                    if (vacancy[field] instanceof Object) {
                        for (let subField in vacancy[field]) {
                            if (vacancy[field][subField] !== undefined && vacancy[field][subField] !== null)
                                this.form[field][subField] = vacancy[field][subField]
                        }
                        continue;
                    }
                    this.form[field] = vacancy[field]
                }
            }
        }
    },
    methods: {
        async submit() {
            const form = {...this.form}
            form.incentives = form.incentives.map(item => item.text)
            form.skills = form.skills.map(item => item.text)

            try {
                const {status, data} = await this.send(this.route('company.vacancies.store'), form)
                if (status === 200) {
                    this.isEdit = true
                    this.notify(data.message)
                }
            } catch (e) {
                console.log(e)
            }
        },
        cancel() {
            location.href = ''
        },
        async searchCity(query, loading) {
            if (query.length) this.cities = await locationService.searchCity(query, loading)
        }
    }
}
</script>

