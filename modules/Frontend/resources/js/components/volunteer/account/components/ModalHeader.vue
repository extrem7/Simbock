<template>
    <div>
        <button aria-label="Close" class="close" type="button" @click="close">
            <svg-vue icon="close"></svg-vue>
        </button>
        <h5 v-if="title" class="title medium-size semi-bold-weight">{{ title }}</h5>
    </div>
</template>

<script>
export default {
    props: {
        close: Function,
        title: String
    }
}
</script>
