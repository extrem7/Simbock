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
import inputMixin from "../../mixins/inputMixin";

export default {
    mixins: [inputMixin],
    props: {
        options: Array,
        value: null
    }
}
</script>
