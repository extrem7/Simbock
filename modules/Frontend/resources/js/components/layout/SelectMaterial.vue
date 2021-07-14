<template>
    <div class="form-group-material">
        <label :class="{'is-active' : isFocus || value}" class="control-label-material">{{ placeholder }}</label>
        <BFormSelect :options="options"
                     :value="value"
                     class="form-control form-control-material"
                     @blur="isFocus = false"
                     @change="$emit('input',$event)"
                     @focus="isFocus = true"/>
    </div>
</template>

<script>
import {BFormSelect} from 'bootstrap-vue'
import input from '~/mixins/input'

export default {
    components: {BFormSelect},
    mixins: [input],
    props: {
        options: Array,
        value: null
    }
}
</script>
