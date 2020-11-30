<template>
    <div :class="{'is-focused' : isFocus}" class="form-group-typeahead form-group-search" @click="isFocus = !isFocus">
        <div class="btn btn-clear-input" @click.prevent="input('')">
            <svg-vue icon="close"></svg-vue>
        </div>
        <VueTypeaheadBootstrap
            :data="options"
            :placeholder="placeholder"
            :showAllResults="true"
            :value="value"
            @input="input"/>
        <svg-vue :icon="icon" class="form-search-icon"></svg-vue>
    </div>
</template>

<script>
import inputMixin from "../../mixins/inputMixin"

export default {
    mixins: [inputMixin],
    props: {
        value: String | Number,
        options: Array,
        icon: {
            type: String
        }
    },
    data: () => ({timeout: null}),
    methods: {
        input(e) {
            this.$emit('input', e)
            clearTimeout(this.timeout)
            this.timeout = setTimeout(() => {
                this.$emit('change', e)
            }, 750)
        }
    }
}
</script>
