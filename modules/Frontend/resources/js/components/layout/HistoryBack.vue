<template>
    <div :class="{'col-xl-2':!small}"
         class="col-lg-1 d-none d-lg-block">
        <a :href="prev"
           class="btn back-to-page btn-scale-active d-flex"
           @click.prevent="back">
            <SvgVue icon="arrow-solid-right"/>
        </a>
    </div>
</template>

<script>
export default {
    props: {
        small: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        prev() {
            return document.referrer
        }
    },
    methods: {
        back() {
            history.back()
        }
    }
}
</script>
