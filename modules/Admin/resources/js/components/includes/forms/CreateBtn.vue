<template>
    <div class="form-group">
        <a :href="route(`admin.${resource}.create`)" class="btn btn-success">Create</a>
    </div>
</template>
<script>
    export default {
        inject: ['resource']
    }
</script>
