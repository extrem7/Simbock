<template>
    <div class="form-group-material form-group-tags">
        <label :class="{'is-active' : isFocus || tag || value.length}" class="control-label-material">
            {{ placeholder }}
        </label>
        <button class="btn btn-add-value" @click.prevent="add">Add</button>
        <VueTagsInput
            ref="tags"
            v-model="tag"
            :add-on-blur="false"
            :tags="value"
            :autocomplete-items="filteredItems"
            :validation="validation"
            placeholder=""
            @blur="isFocus=false"
            @focus="isFocus=true"
            @tags-changed="newTags => $emit('input',newTags)"/>
        <div class="tag-list">
            <div v-for="(tag,i) in value" class="tag-item">{{ tag.text }}
                <button class="btn btn-clear-input btn-clear-input-sm ti-icon-close" @click="remove(i)">
                    <svg-vue icon="close"></svg-vue>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import VueTagsInput, {createTag} from '@johmun/vue-tags-input'
import input from '~/mixins/input'
import vClickOutside from 'v-click-outside'

export default {
    components: {VueTagsInput},
    mixins: [input],
    directives: {
        clickOutside: vClickOutside.directive
    },
    props: {
        value: {
            type: Array,
            default: () => []
        },
        options: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            tag: '',
            validation: [{
                classes: 'min-length',
                rule: tag => tag.text.length < 3,
                disableAdd: true
            }]
        }
    },
    methods: {
        add() {
            const tag = createTag(this.tag, [this.tag], this.validation)
            this.$refs.tags.addTag(tag)
        },
        remove(i) {
            const tags = this.value
            tags.splice(i, 1)
            this.$emit('input', tags)
        },
        disableFocus() {
            this.isFocus = false
        }
    },
    computed: {
        filteredItems() {
            return this.options.filter(i => i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1)
        }
    }
}
</script>
