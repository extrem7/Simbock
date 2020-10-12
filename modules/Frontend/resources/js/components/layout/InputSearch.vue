<template>
    <div :class="{'is-focused' : isFocus}" class="form-group-typeahead form-group-search" @click="isFocus = !isFocus">
        <button class="btn btn-clear-input">
            <svg-vue icon="close"></svg-vue>
        </button>
        <vue-typeahead-bootstrap :data="options" :placeholder="placeholder"
        />
        <svg-vue :icon="icon" class="form-search-icon"></svg-vue>
    </div>
</template>

<script>
import inputMixin from "../../mixins/inputMixin";

export default {
    props: {
        icon: {
            type: String
        }
    },
    mixins: [inputMixin],
    data() {
        return {
            options: ['Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada',
                'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'Canada', 'CaUnited States', 'CaMexico'],

        }
    },
}
</script>
