<template>
    <div class="row pt-4 pb-4">
        <div class="col-lg-6">
            <h2 class="title title-line title-page line-large">Payment method</h2>

            <InputMaterial v-model="name"
                           class="mt-4 mb-3"
                           placeholder="Card Holder Name"/>

            <div id="card-element"></div>

            <button id="add-card-button" class="btn btn-primary mt-3" v-on:click="submitPaymentMethod()">
                Save Payment Method
            </button>

            <div class="mt-3 mb-3">
                OR
            </div>

            <div v-show="paymentMethodsLoadStatus == 2
            && paymentMethods.length == 0"
                 class="">
                No payment method on file, please add a payment method.
            </div>

            <div v-show="paymentMethodsLoadStatus == 2
                && paymentMethods.length > 0">
                <div v-for="(method, key) in paymentMethods"
                     v-bind:key="'method-'+key"
                     class="border rounded row p-1"
                     v-bind:class="{
                    'bg-success text-light': paymentMethodSelected == method.id
                }"
                     v-on:click="paymentMethodSelected = method.id">
                    <div class="col-2">
                        {{ method.brand.charAt(0).toUpperCase() }}{{ method.brand.slice(1) }}
                    </div>
                    <div class="col-7">
                        Ending In: {{ method.last_four }} Exp: {{ method.exp_month }} / {{ method.exp_year }}
                    </div>
                    <div class="col-3">
                        <span v-on:click.stop="removePaymentMethod( method.id )">Remove</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            stripeAPIToken: 'pk_test_FwjvH3gKEDV81Z84p4cnXeyZ',

            stripe: '',
            elements: '',
            card: '',

            intentToken: '',

            name: '',
            addPaymentStatus: 0,
            addPaymentStatusError: '',

            paymentMethods: [],
            paymentMethodsLoadStatus: 0,
            paymentMethodSelected: {},

            selectedPlan: '',
        }
    },

    mounted() {
        this.includeStripe('js.stripe.com/v3/', function () {
            this.configureStripe()
        }.bind(this))

        this.loadIntent()

        this.loadPaymentMethods()
    },

    methods: {
        includeStripe(URL, callback) {
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
        },
    }
}
</script>
