<template>
    <div
        :class="{'form-group-icon' : isPasswordType,'control-material_mod_gray' : materialGray,'control-material_mod' : material}"
        class="form-group-material">
    <span v-if="isPasswordType" class="form-control-icon" @click="togglePassword">
      <svg-vue icon="eye"></svg-vue>
    </span>
        <label :class="{'is-active' : isFocus||value}"
               :for="id"
               class="control-label-material">{{ placeholder }}</label>
        <input
            :id="id"
            :class="[inputClass]"
            :type="inputType"
            :value="value"
            class="form-control form-control-material"
            @blur="isFocus = false"
            @focus="isFocus = true"
            @input="$emit('input',$event.target.value)">
    </div>
</template>

<script>
import input from "~/mixins/inputMixin"

export default {
    mixins: [input],
    props: {
        value: String | Number,
        type: {
            type: String,
            default: 'text'
        },
        id: {
            type: String,
            required: false
        },
        inputClass: {
            type: String,
            required: false
        },
        isPasswordType: {
            type: Boolean,
            default: false,
        },
        materialGray: {
            type: Boolean,
            default: false
        },
        material: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            inputType: this.type
        }
    },
    methods: {
        togglePassword() {
            this.inputType = this.inputType === 'password' ? 'type' : 'password'
        }
    }
}
</script>
