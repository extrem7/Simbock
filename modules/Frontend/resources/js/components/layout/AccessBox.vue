<template>
    <div class="access-box">
        <a v-b-tooltip.hover.auto
           :href="route('vacancies.search')"
           class="access-box-link"
           title="Search job">
            <SvgVue
                class="access-icon access-icon-search"
                icon="search-large"/>
        </a>
        <span v-b-tooltip.hover.auto
              :class="{'active-bookmark' : inBookmarks}"
              class="access-box-link"
              title="Save to bookmarks"
              @click.prevent="bookmark">
            <SvgVue
                class="access-icon access-icon-bookmark"
                icon="bookmark"/>
        </span>
        <a v-b-tooltip.hover.auto class="access-box-link" href="" title="Tooltip directive content">
            <svg-vue class="access-icon access-icon-chat" icon="chat-mod"></svg-vue>
        </a>
        <!--
          <a href="" class="access-box-link" v-b-tooltip.hover.auto title="Tooltip directive content">
              <svg-vue icon="promotion" class="access-icon access-icon-promotion"></svg-vue>
          </a>
          -->
    </div>
</template>

<script>
export default {
    props: {
        id: Number,
        inBookmarks: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        // todo refactor to mixin
        async bookmark() {
            const {status, data} = await this.axios.post(this.route('vacancies.actions.bookmark', this.id))
            if (status === 200) {
                this.$emit('update:bookmarked', data.inBookmarks)
                this.notify(data.message)
            }
        },
    }
}
</script>
