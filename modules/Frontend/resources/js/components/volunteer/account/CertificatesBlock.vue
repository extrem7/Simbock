<template>
    <div class="sector sector-middle sector-cert">
        <div class="sector-label">Certificates and Licenses</div>
        <div class="item-box">
            <div class="sector-header">
                <button v-b-modal.modal-certificates
                        class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add Certificates and Licenses</span>
                </button>
            </div>
        </div>
        <b-modal id="modal-certificates" hide-footer>
            <template v-slot:modal-header="{ close }">
                <button aria-label="Close" class="close" type="button" @click="close()">
                    <svg-vue icon="close"></svg-vue>
                </button>
                <h5 class="title medium-size semi-bold-weight">Certificates and Licenses</h5>
            </template>
            <div class="form-group">
                <input-material placeholder="Certificates and Licenses"></input-material>
            </div>
            <div class="form-group">
                <input-material placeholder="Issuing Authority (optional)"></input-material>
            </div>
            <div class="form-group">
                <input-material placeholder="Year Received (optional)"></input-material>
            </div>
            <div class="form-group">
                        <textarea id="" class="form-control form-control-material" cols="30" name=""
                                  placeholder="Description (optional)"
                                  rows="5"></textarea>
            </div>
            <div class="modal-actions">
                <button class="btn btn-outline-silver min-width-100 btn-drop-shadow btn-scale-active"
                        @click="$bvModal.hide('modal-certificates')">Cancel
                </button>
                <button class="btn btn-green min-width-100 btn-shadow btn-scale-active">Save</button>
            </div>
        </b-modal>
    </div>
</template>

<script>
export default {}
</script>
