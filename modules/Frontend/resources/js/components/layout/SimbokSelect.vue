<template>
    <div>
        <v-select :options="optionsSelect" class="simbok-custom-select" @search:blur="isFocus = false"
                  @search:focus="isFocus = true">
            <template #header>
                <label :class="{'is-active' : isFocus}" class="control-label-material">{{ placeholder }}</label>
            </template>
            <template #open-indicator="{ attributes }">
                <div class="vs__open-indicator">
                    <svg fill="none" height="10" viewBox="0 0 16 10" width="16" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.99574 9.17582C7.90343 9.17599 7.81484 9.13947 7.74949 9.07425L0.0976384 1.4224C-0.0358232 1.28424 -0.0319755 1.06405 0.106182 0.930584C0.24098 0.800416 0.454656 0.800416 0.589421 0.930584L7.99571 8.33619L15.4013 0.9299C15.5348 0.791742 15.7549 0.787927 15.8931 0.921356C16.0313 1.05482 16.0351 1.27498 15.9017 1.41317C15.8989 1.41607 15.896 1.41891 15.8931 1.42172L8.24131 9.07357C8.17622 9.13885 8.08789 9.1756 7.99574 9.17582Z"
                            fill="black"/>
                    </svg>
                </div>
            </template>
        </v-select>
    </div>
</template>

<script>
import inputMixin from "../../mixins/inputMixin";

export default {
    mixins: [inputMixin],
    data() {
        return {
            optionsSelect: ['Choose your sector', 'Account manager', 'Apprenticeships', 'Admin', 'Education', 'Energy', 'Banking', 'Simbok', 'Fifa', 'Raxkor', 'Iphone', ' Admin, Secretarial & PA',
                'Customer Service', 'Construction & Property', ' Charity & Voluntary']
        }
    },
}
</script>
