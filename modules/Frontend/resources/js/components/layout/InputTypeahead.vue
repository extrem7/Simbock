<template>
    <div :class="{'is-focused' : isFocus}" class="form-group-material form-group-typeahead" @click="isFocus = !isFocus">
        <button class="btn btn-clear-input">
            <svg-vue icon="close"></svg-vue>
        </button>
        <label :class="{'is-active' : isFocus}" class="control-label-material" for="">{{ placeholder }}</label>
        <vue-typeahead-bootstrap :data="options"
        />
    </div>
</template>

<script>
import inputMixin from "../../mixins/inputMixin";

export default {
    mixins: [inputMixin],
    data() {
        return {
            options: ['Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada',
                'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'CaUnited States', 'CaMexico'],

        }
    },
}
</script>

<style scoped>

</style>
