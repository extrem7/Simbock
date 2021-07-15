<template>
    <div :class="{'is-focused' : isFocus||value}" class="form-group-material form-group-typeahead"
         @click="isFocus = !isFocus">
        <button class="btn btn-clear-input" @click.prevent="$emit('input',null)">
            <svg-vue icon="close"></svg-vue>
        </button>
        <label :class="{'is-active' : isFocus||value}" class="control-label-material">{{ placeholder }}</label>
        <VueTypeaheadBootstrap
            :data="options"
            :minMatchingChars="minMatchingChars"
            :showOnFocus="showOnFocus"
            :value="value"
            @input="$emit('input',$event)"
        />
    </div>
</template>

<script>
import VueTypeaheadBootstrap from 'vue-typeahead-bootstrap'
import input from '~/mixins/input'

export default {
    components: {VueTypeaheadBootstrap},
    mixins: [input],
    props: {
        options: Array,
        minMatchingChars: {
            type: Number,
            default: 2
        },
        showOnFocus: {
            type: Boolean,
            default: false
        },
        value: String
    }
}
</script>
