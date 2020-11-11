<template>
    <div class="sector sector-middle sector-resume">
        <div class="sector-label">Resume</div>
        <div class="item-box">
            <div class="sector-header">
                <button v-b-modal.modal-resume
                        class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add Resume</span>
                </button>
            </div>
        </div>
        <b-modal id="modal-resume" hide-footer>
            <template v-slot:modal-header="{ close }">
                <button aria-label="Close" class="close" type="button" @click="close()">
                    <svg-vue icon="close"></svg-vue>
                </button>
                <h5 class="title medium-size semi-bold-weight">Certificates and Licenses</h5>
            </template>
            <div class="form-group">
                <input-material placeholder="Title"></input-material>
            </div>
            <div class="form-group">
                <b-form-file
                    drop-placeholder="Drop file here..."
                    placeholder="Choose a file..."
                ></b-form-file>
            </div>
            <div class="modal-actions">
                <button class="btn btn-outline-silver min-width-100 btn-drop-shadow btn-scale-active"
                        @click="$bvModal.hide('modal-resume')">Cancel
                </button>
                <button class="btn btn-green min-width-100 btn-shadow btn-scale-active">Save</button>
            </div>
        </b-modal>
    </div>
</template>

<script>
export default {}
</script>
