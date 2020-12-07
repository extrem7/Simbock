<template>
    <div :class="{'is-focused' : isFocus}"
         class="form-group-typeahead form-group-search">
        <div class="btn btn-clear-input"
             @click.prevent="input('')">
            <SvgVue icon="close"/>
        </div>
        <VueTypeaheadBootstrap
            ref="typehead"
            :showAllResults="true"
            :value="value"
            :data="options"
            :placeholder="placeholder"
            @input="input"/>
        <SvgVue
            :icon="icon"
            class="form-search-icon"/>
    </div>
</template>

<script>
import input from "~/mixins/input"
import {debounce} from 'lodash'

export default {
    mixins: [input],
    props: {
        value: String | Number,
        options: Array,
        icon: {
            type: String
        }
    },
    data() {
        return {
            current: null,
            update: debounce(function () {
                this.$emit('change', this.current)
            }, 500),
        }
    },
    mounted() {
        this.$watch(() => {
            return this.$refs.typehead.isFocused
        }, (val) => {
            this.isFocus = val
        })
    },
    methods: {
        input(e) {
            this.current = e
            this.$emit('input', e)
            this.update()
        },
        disableFocus() {
            if (this.isFocus) this.isFocus = false
        }
    }
}
</script>
