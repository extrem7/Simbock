<template>
    <div class="card-footer">
        <a :href="route(`admin.${footerInject.resource}.index`)" class="btn btn-secondary">Back</a>
        <button @click="$emit('submit')" class="btn btn-success float-right" type="submit">
            {{footerInject.isEdit?'Save':'Create'}}
            <b-spinner small v-show="footerInject.isLoading"></b-spinner>
        </button>
    </div>
</template>

<script>
    export default {
        inject: ['footerInject']
    }
</script>
