<template>
    <div class="form-group-material form-group-tags" @click="isFocus = true">
        <label :class="{'is-active' : isFocus}" class="control-label-material">{{ placeholder }}</label>
        <button class="btn btn-add-value">Add</button>
        <vue-tags-input
            v-model="tag"
            :autocomplete-items="filteredItems"
            :tags="tags"
            placeholder=""
            @tags-changed="newTags => tags = newTags"
        />
        <div class="tag-list">
            <div v-for="tag in tags" class="tag-item">{{ tag.text }}
                <button class="btn btn-clear-input btn-clear-input-sm ti-icon-close">
                    <svg-vue icon="close"></svg-vue>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import inputMixin from "../../mixins/inputMixin";

export default {
    data() {
        return {
            tag: '',
            tags: [],
            autocompleteItems: [{
                text: 'Spain',
            }, {
                text: 'France',
            }, {
                text: 'USA',
            }, {
                text: 'Germany',
            }, {
                text: 'China',
            }],
        };
    },
    methods: {
        cancel() {
            // for some reason we need nextTick here
            this.$nextTick(() => this.handlers = []);
            this.tag = '';
        },
        add() {
            this.handlers.forEach(h => h());
            this.$nextTick(() => this.handlers = []);
        },
    },
    mixins: [inputMixin],
    computed: {
        filteredItems() {
            return this.autocompleteItems.filter(i => {
                return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
        },
    },
};
</script>

<style lang="scss">
.vue-tags-input {
    max-width: 100% !important;
    border-radius: 3px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
    border: 2px solid #fff;
    transition: border .2s ease-in-out;
    overflow: hidden;

    &.ti-focus {
        border-color: #5CEDAA;
    }

    .ti-item > div {
        font-size: 16px;
        color: #767676;
        font-weight: normal;
        padding: 3px 12px;

        &:hover {
            background-color: #5CEDAA;
        }
    }

    .ti-new-tag-input-wrapper {
        padding: 0;
        margin: 0;

        .ti-new-tag-input {
            width: 100%;
            background-color: #fff;
            border-radius: 3px;
            padding: 23px 65px 5px 12px;
            box-shadow: none !important;
            height: 46px;
            font-size: 14px;
            color: #000;

            &:focus {
                //border-color: #5CEDAA;
                ///box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
            }
        }
    }

    .ti-tag {
        display: none;
    }

    .ti-input {
        padding: 0;
        border: 0;
    }
}
</style>
