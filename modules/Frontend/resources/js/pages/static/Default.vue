<template>
    <main class="container content-inner" v-html="content"></main>
</template>

<script>
export default {
    name: "DefaultPage",
    data() {
        return {
            content: this.shared('content')
        }
    }
}
</script>
