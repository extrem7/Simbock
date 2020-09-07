<template>
    <div class="d-flex">
        <a :href="route(`admin.${resource}.edit`,id)" class="btn btn-primary">
            Edit
        </a>
        <button @click.prevent="$emit('delete')" class="btn btn-danger ml-2">
            Delete
        </button>
    </div>
</template>

<script>
    export default {
        props: {
            id: Number
        },
        inject: ['resource']
    }
</script>

