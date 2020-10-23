<template>
    <div class="company-info-wrapper">
        <LogoUploader v-if="isEdit" v-model="logo"/>
        <form @submit.prevent="submit">
            <div :class="[invalid('name')]" class="form-group">
                <input-material v-model="form.name" placeholder="Company Name*"></input-material>
                <Invalid name="name"></Invalid>
            </div>
            <div :class="[invalid('user_name')]" class="form-group">
                <input-material v-model="form.user_name" placeholder="Your name*"></input-material>
                <Invalid name="user_name"></Invalid>
            </div>
            <div :class="[invalid('title')]" class="form-group">
                <input-material v-model="form.title" placeholder="Your current title"></input-material>
                <Invalid name="title"></Invalid>
            </div>
            <div :class="[invalid('sector_id')]" class="form-group">
                <simbok-select v-model="form.sector_id" :options="sectors" placeholder="Industry*"></simbok-select>
                <Invalid name="sector_id"></Invalid>
            </div>

            <div :class="[invalid('description')]" class="form-group">
                <div class="control-label">Hiring Company Description</div>
                <textarea v-model="form.description" class="form-control form-control-material"
                          placeholder="Describe your company"
                          rows="4"></textarea>
                <Invalid name="description"></Invalid>
            </div>
            <div :class="[invalid('size_id')]" class="form-group">
                <select-material v-model="form.size_id" :options="sizes" placeholder="Company Size*"></select-material>
                <Invalid name="size_id"></Invalid>
            </div>
            <div :class="[invalid('address')]" class="form-group">
                <input-material v-model="form.address" placeholder="Address*"></input-material>
                <Invalid name="address"></Invalid>
            </div>
            <div :class="[invalid('address_2')]" class="form-group">
                <input-material v-model="form.address_2" placeholder="Address Line 2"></input-material>
                <Invalid name="address_2"></Invalid>
            </div>
            <div class="form-group company-address-column">
                <div :class="[invalid('city_id')]" class="address-column address-city">
                    <simbok-select v-model="form.city_id"
                                   :filterable="false"
                                   :options="cities"
                                   placeholder="City*"
                                   @search="searchCity"></simbok-select>
                    <Invalid name="city_id"></Invalid>
                </div>
                <div :class="[invalid('zip')]" class="address-column address-zip">
                    <input-typeahead v-model="form.zip"
                                     :min-matching-chars="0"
                                     :options="zips"
                                     :show-on-focus="true"
                                     placeholder="ZIP Code*"/>
                    <Invalid name="zip"></Invalid>
                </div>
            </div>

            <div :class="[invalid('phone')]" class="form-group">
                <input-material v-model="form.phone" placeholder="Phone*"></input-material>
                <Invalid name="phone"></Invalid>
            </div>
            <div :class="[invalid('email')]" class="form-group">
                <input-material v-model="form.email" placeholder="Email Address*"></input-material>
                <Invalid name="email"></Invalid>
            </div>

            <div :class="[invalid('social.website')]" class="form-group">
                <input-material v-model="form.social.website" placeholder="Website URL"></input-material>
                <Invalid name="social.website"></Invalid>
            </div>
            <div :class="[invalid('social.linkedin')]" class="form-group">
                <input-material v-model="form.social.linkedin" placeholder="LinkedIn URL"></input-material>
                <Invalid name="social.linkedin"></Invalid>
            </div>
            <div :class="[invalid('social.twitter')]" class="form-group">
                <input-material v-model="form.social.twitter" placeholder="Twitter URL"></input-material>
                <Invalid name="social.twitter"></Invalid>
            </div>
            <div :class="[invalid('social.facebook')]" class="form-group">
                <input-material v-model="form.social.facebook" placeholder="Facebook URL"></input-material>
                <Invalid name="social.facebook"></Invalid>
            </div>
            <div :class="[invalid('social.instagram')]" class="form-group">
                <input-material v-model="form.social.instagram" placeholder="Instagram URL"></input-material>
                <Invalid name="social.instagram"></Invalid>
            </div>
            <div :class="[invalid('social.youtube')]" class="form-group">
                <input-material v-model="form.social.youtube" placeholder="YouTube URL"></input-material>
                <Invalid name="social.youtube"></Invalid>
            </div>
            <div :class="[invalid('social.reddit')]" class="form-group">
                <input-material v-model="form.social.reddit" placeholder="Reddit URL"></input-material>
                <Invalid name="social.reddit"></Invalid>
            </div>
            <div :class="[invalid('social.pinterest')]" class="form-group">
                <input-material v-model="form.social.pinterest" placeholder="Pinterest URL"></input-material>
                <Invalid name="social.pinterest"></Invalid>
            </div>
            <div :class="[invalid('social.quora')]" class="form-group">
                <input-material v-model="form.social.quora" placeholder="Quora URL"></input-material>
                <Invalid name="social.quora"></Invalid>
            </div>

            <div class="d-inline-flex align-items-center btn-group-save-form mt-3">
                <button class="btn btn-green btn-shadow btn-save-form btn-scale-active">
                    Save
                    <b-spinner v-show="isLoading" small></b-spinner>
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
import locationService from "~/services/location"
import validation from "~/mixins/validation"
import LogoUploader from "./LogoUploader"

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
                        continue;
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
                        if (!this.isEdit) location.href = this.route('companies.self')
                    }, 2500)
                }
            } catch (e) {
                console.log(e)
            }
        },
        cancel() {
            if (this.isEdit) {
                location.href = this.route('companies.self')
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

