<template>
    <main class="container content-inner">
        <div v-if="step===1"
             class="survey-box form-box form-box-decorative_bg mx-auto">
            <div class="title title-page title-line line-large">Thank you for your<span
                class="d-block">application!</span></div>
            <div class="silver-color text-center mt-3 mb-3">How did you find your position?</div>
            <form @submit.prevent>
                <div class="form-group">
                    <div v-for="{id,name} in sources"
                         class="custom-control custom-radio mb-1">
                        <input :id="`source-${id}`"
                               v-model="source_id"
                               :value="id"
                               class="custom-control-input"
                               type="radio">
                        <label :for="`source-${id}`"
                               class="custom-control-label base-size">
                            {{ name }}
                        </label>
                    </div>
                </div>
                <div v-if="source_id===6" class="form-group">
                    <InputMaterial
                        v-model="specified"
                        placeholder="Specify"
                        required/>
                </div>
                <div class="form-box-actions mt-4">
                    <button class="btn btn-green btn-scale-active btn-shadow min-width-140" @click="create">
                        Submit
                    </button>
                </div>
            </form>
        </div>
        <div v-else-if="step===2"
             class="survey-box form-box form-box-decorative_bg mx-auto">
            <div class="title title-page title-line line-large">Thank for<span class="d-block">applying!</span></div>
            <div class="silver-color text-center mt-3 mb-3">Help us make sure your profile is up-to-date.</div>
            <div class="form-group">
                <label class="extra-small-size control-label">What is your new job title?</label>
                <InputMaterial
                    v-model="jobForm.job_title"
                    placeholder="Job Title"/>
            </div>
            <div class="form-group">
                <label class="extra-small-size control-label">What is your new job company?</label>
                <InputMaterial
                    v-model="jobForm.company_name"
                    placeholder="Company Name"/>
            </div>
            <div class="form-box-actions mt-4">
                <button class="btn btn-outline-silver btn-scale-active btn-shadow min-width-140 mod-dark"
                        @click="nextStep">
                    No, Thanks
                </button>
                <button class="btn btn-green btn-scale-active btn-shadow min-width-140"
                        @click="updateJob">
                    Submit
                </button>
            </div>
        </div>
        <div v-else-if="step===3"
             class="survey-box form-box form-box-decorative_bg mx-auto">
            <div class="title title-page title-line line-large">Thank for<span class="d-block">response!</span></div>
            <div class="silver-color mt-3 line-height-1-2">While you settle into your new role,
                we’ll hold off on sending you frequent jobs/volunteer alerts and suggestions.
                You may continue to receive updates on jobs that you previously applied to!
            </div>
            <div class="form-divider mt-3 mb-3 line-height-1-2"></div>
            <div class="silver-color">
                Tell us all about your new job, what it means to you, and your experience using Simboсk.
            </div>
            <div class="form-box-actions mt-4">
                <button class="btn btn-outline-silver btn-scale-active btn-shadow min-width-140 mod-dark"
                        @click="back">
                    No, Thanks
                </button>
                <button class="btn btn-green btn-scale-active btn-shadow min-width-140"
                        @click="nextStep">
                    Submit
                </button>
            </div>
        </div>
        <div v-else-if="step===4"
             class="survey-box form-box form-box-decorative_bg mx-auto">
            <div class="title title-page title-line line-large">Congrats on the New Job!</div>
            <div class="silver-color text-center mt-3 mb-3 line-height-1-2">We want to celebrate your success with you.
                Tell us about your job/volunterring search success story on Simboсk and we may feature you in an
                upcoming
                TV commercial.
            </div>
            <form @submit.prevent="shareStory">
                <div :class="[invalid('name')]"
                     class="form-group">
                    <InputMaterial
                        v-model="storyForm.name"
                        placeholder="Full Name"/>
                    <Invalid name="name"/>
                </div>
                <div :class="[invalid('email')]"
                     class="form-group">
                    <InputMaterial
                        v-model="storyForm.email"
                        type="email"
                        placeholder="Email"/>
                    <Invalid name="email"/>
                </div>
                <div :class="[invalid('address')]"
                     class="form-group">
                    <InputMaterial
                        v-model="storyForm.address"
                        placeholder="Home Address"/>
                    <Invalid name="address"/>
                </div>
                <div :class="[invalid('phone')]"
                     class="form-group">
                    <InputMaterial
                        v-model="storyForm.phone"
                        type="phone"
                        placeholder="Phone Number"/>
                    <Invalid name="phone"/>
                </div>
                <div :class="[invalid('company_name')]"
                     class="form-group">
                    <InputMaterial
                        v-model="storyForm.company_name"
                        placeholder="What is the name of the company that hired you?"/>
                    <Invalid name="company_title"/>
                </div>
                <div :class="[invalid('description')]"
                     class="form-group">
                <textarea
                    v-model="storyForm.description"
                    class="form-control form-control-material"
                    placeholder="Tell us how getting this job changed your life for the better."
                    rows="5"></textarea>
                    <Invalid name="description"/>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input id="agree" class="custom-control-input" required type="checkbox">
                        <label class="custom-control-label extra-small-size" for="agree">
                            <span>
                                By checking this box I confirm that I am at least 18 years of age and that I have read, understood and agreed to be bound by the <a
                                class="link link-stroke" href="">Consent and Release.</a>
                            </span>
                        </label>
                    </div>
                </div>
                <div class="form-box-actions mt-4">
                    <button class="btn btn-green btn-scale-active btn-shadow min-width-140">
                        Share Your Story
                    </button>
                </div>
            </form>
        </div>
    </main>
</template>

<script>
import validation from '~/mixins/validation'

export default {
    mixins: [validation],
    data() {
        return {
            source_id: 1,
            specified: '',

            jobForm: {
                job_title: '',
                company_name: ''
            },
            storyForm: {
                name: '',
                email: '',
                address: '',
                phone: '',
                company_name: '',
                description: '',
            },

            step: 1,
            sources: this.shared('sources')
        }
    },
    methods: {
        async create() {
            try {
                await this.axios.post(this.route('volunteer.survey.create'), {
                    source_id: this.source_id,
                    specified: this.specified
                })
                this.nextStep()
            } catch (e) {
                console.log(e)
            }
        },
        async updateJob() {
            try {
                const {data: {message}} = await this.send(this.route('volunteer.survey.job'), this.jobForm)
                this.notify(message)
                this.nextStep()
            } catch (e) {
                console.log(e)
            }
        },
        async shareStory() {
            try {
                const {data: {message}} = await this.send(this.route('volunteer.survey.complete'), this.storyForm)
                this.notify(message)
                setTimeout(() => {
                    this.back()
                }, 3000)
            } catch (e) {
                console.log(e)
            }
        },
        nextStep() {
            this.step += 1
        },
        back() {
            location.href = this.route('volunteer.account.form')
        }
    }
}
</script>
