<template>
    <div class="form-group-material">
        <label :class="{'is-active' : isFocus}" class="control-label-material" for="name">{{ placeholder }}</label>
        <select id="name" class="form-control form-control-material custom-select" name="" @blur="isFocus = false"
                @focus="isFocus = true">
            <option></option>
            <option>value 1</option>
        </select>
    </div>
</template>

<script>
import inputMixin from "../../mixins/inputMixin";

export default {
    mixins: [inputMixin],
    data() {
        return {}
    },
}
</script>
