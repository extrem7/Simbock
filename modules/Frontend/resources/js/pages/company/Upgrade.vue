<template>
    <main class="container content-inner">
        <h1 class="title title-line title-page line-large">Subscription</h1>
        <StripeCheckout
            ref="sessionRef"
            :pk="stripeAPIToken"
            :session-id="stripeSession"
            mode="subscription"
        />
        <div class="row subscription mt-md-5 mt-4">
            <div v-for="plan in plans"
                 class="col-xl-3 col-lg-6">
                <div :class="{'subscription-item-active-plan':plan.isActive,'subscription-item-free-trial':hasTrial}"
                     class="subscription-item item-box">
                    <div v-if="hasTrial"
                         class="subscription-trial-text">15 days free
                    </div>
                    <div class="text-center">
                        <h2 class="title large-size semi-bold-weight">{{ plan.name }}</h2>
                        <div class="medium-size silver-color mt-3 mb-3">${{ plan.price }}</div>
                        <div class="extra-small-size silver-color mt-3 mb-3">{{ plan.description }}</div>
                        <button v-if="plan.isActive"
                                class="btn btn-outline-silver mod-dark btn-drop-shadow btn-scale-active disabled"
                                disabled>
                            Current Plan
                            <br>
                            <SvgVue
                                v-if="['mastercard','visa'].includes(card.brand)"
                                :icon="`cc-${card.brand}`"
                                width="25px"
                            />
                            <span v-else class="text-capitalize">{{ card.brand }}</span>
                            <span class="ml-2">**** {{ card.lastFour }}</span>
                        </button>
                        <button v-if="plan.isActive"
                                class="btn btn-red-outline btn-scale-active mt-3"
                                @click="cancel">
                            Cancel
                            <BSpinner
                                v-show="isCanceling"
                                small/>
                        </button>
                        <button v-if="!plan.isActive"
                                class="btn btn-green-outline btn-drop-shadow btn-scale-active"
                                @click="selectPlan(plan.stripe_plan)">
                            Select
                            <BSpinner
                                v-show="isLoading"
                                small/>
                        </button>
                    </div>
                    <ul class="custom-list mt-3">
                        <li v-for="item in plan.advantages"
                            class="custom-list-li">
                            {{ item }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--<div class="row justify-content-center pt-4 pb-4">
            <div class="col-lg-4">
                <h2 class="title title-line title-page line-large">Payment method</h2>
                <form ref="validationForm" @submit.prevent>
                    <InputMaterial v-model="name"
                                   placeholder="Card Holder Name"
                                   class="mt-4 mb-4"
                                   required/>
                </form>
                <div id="card-element"></div>

                <p v-if="addPaymentStatusError"
                   class="text-danger mt-2">
                    {{ addPaymentStatusError }}
                </p>
                <div class="d-flex justify-content-center">
                    <button
                        @click="submitPaymentMethod"
                        class="btn btn-outline-violet min-width-100 btn-scale-active mt-3">
                        Add payment method
                    </button>
                </div>

                <div class="text-center mt-3 mb-3">OR</div>

                <div v-show="paymentMethodsLoadStatus === 2 && paymentMethods.length === 0">
                    No payment method on file, please add a payment method.
                </div>

                <div v-show="paymentMethodsLoadStatus === 2 && paymentMethods.length > 0">
                    <div v-for="(method, key) in paymentMethods"
                         :key="'method-'+key"
                         @click="paymentMethodSelected = method.id"
                         class="d-flex justify-content-between py-1 px-2"
                         :class="{'bg-success text-light': paymentMethodSelected == method.id}">
                        <div>
                            <SvgVue
                                v-if="['mastercard','visa'].includes(method.brand)"
                                :icon="`cc-${method.brand}`"
                                width="25px"
                            />
                            <span class="text-capitalize" v-else>{{ method.brand }}</span>
                        </div>
                        <div>**** {{ method.lastFour }} | {{ method.expMonth }}/{{ method.expYear }}</div>
                        <div>
                            <SvgVue
                                @click.stop="removePaymentMethod( method.id )"
                                icon="close"
                                width="14px"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    </main>
</template>

<script>
import {StripeCheckout} from 'vue-stripe-checkout'

export default {
    components: {
        StripeCheckout
    },
    data() {
        return {
            plans: this.shared('plans'),
            hasTrial: this.shared('hasTrial'),
            card: this.shared('card'),

            stripeAPIToken: this.shared('stripeAPIToken'),
            stripeSession: null,

            isLoading: false,
            isCanceling: false,

            /*stripe: '',
            elements: '',
            card: '',

            intentToken: '',

            name: '',
            addPaymentStatus: 0,
            addPaymentStatusError: '',

            paymentMethods: [],
            paymentMethodsLoadStatus: 0,
            paymentMethodSelected: {},*/
        }
    },
    mounted() {
        // this.$refs.sessionRef.redirectToCheckout()
    },
    methods: {
        async selectPlan(plan) {
            this.isLoading = true
            try {
                const {data: {session}} = await this.axios.get(this.route('company.upgrade.checkout', plan))
                this.stripeSession = session
                this.$refs.sessionRef.redirectToCheckout()
            } catch (e) {
                console.log(e)
            } finally {
                this.isLoading = false
            }
        },
        async cancel() {
            this.isCanceling = true
            try {
                const {data: {message}} = await this.axios.post(this.route('company.upgrade.cancel'))
                this.plans.forEach(plan => {
                    if (plan.isActive) plan.isActive = false
                })
                this.notify(message)
            } catch (e) {
                console.log(e)
            } finally {
                this.isCanceling = false
            }
        },
        /*includeStripe(URL, callback) {
            const documentTag = document, tag = 'script',
                object = documentTag.createElement(tag),
                scriptTag = documentTag.getElementsByTagName(tag)[0]
            object.src = '//' + URL
            if (callback) {
                object.addEventListener('load', function (e) {
                    callback(null, e)
                }, false)
            }
            scriptTag.parentNode.insertBefore(object, scriptTag)
        },
        configureStripe() {
            this.stripe = Stripe(this.stripeAPIToken)

            this.elements = this.stripe.elements()
            this.card = this.elements.create('card')

            this.card.mount('#card-element')
        },
        async loadIntent() {
            const {data} = await this.axios.get(this.route('company.upgrade.intent'))
            this.intentToken = data
        },
        async submitPaymentMethod() {
            if (!this.$refs.validationForm.reportValidity()) return
            this.addPaymentStatus = 1

            const result = await this.stripe.confirmCardSetup(
                this.intentToken.client_secret, {
                    payment_method: {
                        card: this.card,
                        billing_details: {
                            name: this.name
                        }
                    }
                }
            )

            if (result.error) {
                this.addPaymentStatus = 3
                this.addPaymentStatusError = result.error.message
            } else {
                await this.savePaymentMethod(result.setupIntent.payment_method)
                this.addPaymentStatus = 2
                this.card.clear()
                this.name = ''
            }
        },
        async savePaymentMethod(method) {
            await this.axios.post(this.route('company.upgrade.payments.create'), {
                payment_method: method
            })
            await this.loadPaymentMethods()
        },
        async loadPaymentMethods() {
            this.paymentMethodsLoadStatus = 1

            const {data} = await this.axios.get(this.route('company.upgrade.payments.index'))

            this.paymentMethods = data
            this.paymentMethods.forEach(({id, isDefault}) => {
                if (isDefault) this.paymentMethodSelected = id
            })
            this.paymentMethodsLoadStatus = 2
        },
        async removePaymentMethod(paymentID) {
            await this.axios.post(this.route('company.upgrade.payments.destroy'), {
                id: paymentID
            })
            await this.loadPaymentMethods()
        },
        async updateSubscription() {
            await this.axios.put(this.route('company.upgrade.update'), {
                plan: this.selectedPlan,
                payment: this.paymentMethodSelected
            })
        },*/
    }
}
</script>
