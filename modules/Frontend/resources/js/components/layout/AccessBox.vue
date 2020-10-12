<template>
    <!--
    active-bookmark к икони букмаорка когда нажали
    -->
    <div class="access-box">
        <a v-b-tooltip.hover.auto class="access-box-link" href="" title="Tooltip directive content">
            <svg-vue class="access-icon access-icon-search" icon="search-large"></svg-vue>
        </a>
        <span v-b-tooltip.hover.auto :class="{'active-bookmark' : inBookmark}" class="access-box-link"
              title="Tooltip directive content" @click="inBookmark = !inBookmark">
            <svg-vue class="access-icon access-icon-bookmark" icon="bookmark"></svg-vue>
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
        inBookmark: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {}
    }
}
</script>
