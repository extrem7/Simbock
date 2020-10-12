<template>
    <div>
        <span v-for="error in errorsInject.errors[name]" v-if="name in errorsInject.errors"
              class="invalid-feedback">{{ error }}</span>
    </div>
</template>

<script>
export default {
    props: {
        name: String,
        isArray: {
            type: Boolean,
            default: false
        },
        deep: Boolean
    },
    inject: ['errorsInject']
}
</script>
