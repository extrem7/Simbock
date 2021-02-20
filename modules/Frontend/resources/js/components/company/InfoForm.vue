<template>
    <div class="company-info-wrapper">
        <LogoUploader v-if="isEdit" v-model="logo"/>
        <form @submit.prevent="submit">
            <div :class="[invalid('name')]" class="form-group">
                <InputMaterial v-model="form.name" placeholder="Company Name*"/>
                <Invalid name="name"/>
            </div>
            <div :class="[invalid('user_name')]" class="form-group">
                <InputMaterial v-model="form.user_name" placeholder="Your name*"/>
                <Invalid name="user_name"/>
            </div>
            <div :class="[invalid('title')]" class="form-group">
                <InputMaterial v-model="form.title" placeholder="Your current title"/>
                <Invalid name="title"/>
            </div>
            <div :class="[invalid('sector_id')]" class="form-group">
                <SimbokSelect v-model="form.sector_id" :options="sectors" placeholder="Industry*"/>
                <Invalid name="sector_id"/>
            </div>

            <div :class="[invalid('description')]" class="form-group">
                <div class="control-label">Hiring Company Description</div>
                <textarea v-model="form.description" class="form-control form-control-material"
                          placeholder="Describe your company"
                          rows="4"></textarea>
                <Invalid name="description"/>
            </div>
            <div :class="[invalid('size_id')]" class="form-group">
                <SelectMaterial v-model="form.size_id" :options="sizes" placeholder="Company Size*"/>
                <Invalid name="size_id"/>
            </div>
            <div :class="[invalid('address')]" class="form-group">
                <InputMaterial v-model="form.address" placeholder="Address*"/>
                <Invalid name="address"/>
            </div>
            <div :class="[invalid('address_2')]" class="form-group">
                <InputMaterial v-model="form.address_2" placeholder="Address Line 2"/>
                <Invalid name="address_2"/>
            </div>
            <div class="form-group company-address-column">
                <div :class="[invalid('city_id')]" class="address-column address-city">
                    <SimbokSelect v-model="form.city_id"
                                  :filterable="false"
                                  :options="cities"
                                  placeholder="City*"
                                  @search="searchCity"/>
                    <Invalid name="city_id"/>
                </div>
                <div :class="[invalid('zip')]" class="address-column address-zip">
                    <InputTypeahead v-model="form.zip"
                                    :min-matching-chars="0"
                                    :options="zips"
                                    :show-on-focus="true"
                                    placeholder="ZIP Code*"/>
                    <Invalid name="zip"/>
                </div>
            </div>

            <div :class="[invalid('phone')]" class="form-group">
                <InputMaterial
                    v-model="form.phone"
                    placeholder="Phone*"
                    type="tel"/>
                <Invalid name="phone"/>
            </div>
            <div :class="[invalid('email')]" class="form-group">
                <InputMaterial v-model="form.email" placeholder="Email Address"/>
                <Invalid name="email"/>
            </div>

            <div :class="[invalid('social.website')]" class="form-group">
                <InputMaterial v-model="form.social.website" placeholder="Website URL"/>
                <Invalid name="social.website"/>
            </div>
            <div :class="[invalid('social.linkedin')]" class="form-group">
                <InputMaterial v-model="form.social.linkedin" placeholder="LinkedIn URL"/>
                <Invalid name="social.linkedin"/>
            </div>
            <div :class="[invalid('social.twitter')]" class="form-group">
                <InputMaterial v-model="form.social.twitter" placeholder="Twitter URL"/>
                <Invalid name="social.twitter"/>
            </div>
            <div :class="[invalid('social.facebook')]" class="form-group">
                <InputMaterial v-model="form.social.facebook" placeholder="Facebook URL"/>
                <Invalid name="social.facebook"/>
            </div>
            <div :class="[invalid('social.instagram')]" class="form-group">
                <InputMaterial v-model="form.social.instagram" placeholder="Instagram URL"/>
                <Invalid name="social.instagram"/>
            </div>
            <div :class="[invalid('social.youtube')]" class="form-group">
                <InputMaterial v-model="form.social.youtube" placeholder="YouTube URL"/>
                <Invalid name="social.youtube"/>
            </div>
            <div :class="[invalid('social.reddit')]" class="form-group">
                <InputMaterial v-model="form.social.reddit" placeholder="Reddit URL"/>
                <Invalid name="social.reddit"/>
            </div>
            <div :class="[invalid('social.pinterest')]" class="form-group">
                <InputMaterial v-model="form.social.pinterest" placeholder="Pinterest URL"/>
                <Invalid name="social.pinterest"/>
            </div>
            <div :class="[invalid('social.quora')]" class="form-group">
                <InputMaterial v-model="form.social.quora" placeholder="Quora URL"/>
                <Invalid name="social.quora"/>
            </div>

            <div class="d-inline-flex align-items-center btn-group-save-form mt-3">
                <button class="btn btn-green btn-shadow btn-save-form btn-scale-active">
                    Save
                    <BSpinner v-show="isLoading" small></BSpinner>
                </button>
                <button v-if="isEdit"
                        class="btn btn-outline-silver min-width-100 btn-shadow btn-scale-active"
                        @click.prevent="cancel">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</template>

<script>
import locationService from '~/services/location'
import validation from '~/mixins/validation'
import LogoUploader from './LogoUploader'

export default {
    components: {
        LogoUploader
    },
    mixins: [validation],
    data() {
        return {
            form: {
                name: '',
                user_name: '',
                title: '',
                sector_id: null,
                description: '',
                size_id: null,
                address: '',
                address_2: null,
                city_id: null,
                zip: '',
                phone: '',
                email: '',
                social: {
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
            },
            logo: null,
            sectors: this.shared('sectors'),
            sizes: this.shared('sizes'),
            cities: [],
            isEdit: false
        }
    },
    computed: {
        zips() {
            const city = this.cities.filter(({value}) => value === this.form.city_id)[0]
            if (city) return city.zips.split(' ')
            return []
        }
    },
    created() {
        const user = this.shared('user')
        this.form.user_name = user.name

        const company = this.shared('company')
        if (company) {
            this.isEdit = true
            if (company.logo) this.logo = company.logo
            this.cities = [company.city]

            for (let field in this.form) {
                if (company[field] !== undefined && company[field] !== null) {
                    if (company[field] instanceof Object) {
                        for (let subField in company[field]) {
                            if (company[field][subField] !== undefined && company[field][subField] !== null)
                                this.form[field][subField] = company[field][subField]
                        }
                        continue
                    }
                    this.form[field] = company[field]
                }
            }
        }

        if (!this.form.email) this.form.email = user.email
    },
    methods: {
        async submit() {
            try {
                const {status, data} = await this.send(this.route('company.info.update'), {
                    ...this.form
                })
                if (status === 200) {
                    this.notify(data.message)
                    setTimeout(() => {
                        if (!this.isEdit) location.reload()
                    }, 2500)
                }
            } catch (e) {
                console.log(e)
            }
        },
        cancel() {
            if (this.isEdit) {
                location.href = this.route('company.upgrade.page')
            } else {
                location.reload()
            }
        },
        async searchCity(query, loading) {
            if (query.length) this.cities = await locationService.searchCity(query, loading)
        }
    }
}
</script>

