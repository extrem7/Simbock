<template>
    <div class="modal-actions">
        <button class="btn btn-outline-silver min-width-100 btn-drop-shadow btn-scale-active"
                @click="$emit('cancel')">
            Cancel
        </button>
        <button class="btn btn-green min-width-100 btn-shadow btn-scale-active"
                @click="$emit('save')">
            Save
        </button>
    </div>
</template>
