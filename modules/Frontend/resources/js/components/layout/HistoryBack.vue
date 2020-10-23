<template>
    <div class="col-xl-2 col-lg-1 d-none d-lg-block">
        <a class="btn back-to-page btn-scale-active d-flex" href="#" @click.prevent="back">
            <svg-vue icon="arrow-solid-right"></svg-vue>
        </a>
    </div>
</template>

<script>
export default {
    methods: {
        back() {
            history.back()
        }
    }
}
</script>
