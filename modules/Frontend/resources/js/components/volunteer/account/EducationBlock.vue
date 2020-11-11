<template>
    <div class="sector sector-middle sector-education">
        <div class="sector-label">Education</div>
        <div class="item-box">
            <div class="sector-header">
                <button v-b-modal.modal-education
                        class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add Education</span>
                </button>
            </div>
        </div>
        <b-modal id="modal-education" hide-footer>
            <template v-slot:modal-header="{ close }">
                <button aria-label="Close" class="close" type="button" @click="close()">
                    <svg-vue icon="close"></svg-vue>
                </button>
                <h5 class="title medium-size semi-bold-weight">Education</h5>
            </template>
            <div class="form-group">
                <input-material placeholder="School"></input-material>
            </div>
            <div class="form-group">
                <input-material placeholder="Degree"></input-material>
            </div>
            <div class="form-group">
                <input-material placeholder="Major or field of study (optional)"></input-material>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <input-material placeholder="Start Year"></input-material>
                </div>
                <div class="col-sm-6 form-group">
                    <input-material placeholder="End Year"></input-material>
                </div>
            </div>
            <div class="form-group">
                        <textarea id="" class="form-control form-control-material" cols="30" name=""
                                  placeholder="Description (optional)"
                                  rows="5"></textarea>
            </div>
            <div class="modal-actions">
                <button class="btn btn-outline-silver min-width-100 btn-drop-shadow btn-scale-active"
                        @click="$bvModal.hide('modal-education')">Cancel
                </button>
                <button class="btn btn-green min-width-100 btn-shadow btn-scale-active">Save</button>
            </div>
        </b-modal>
    </div>
</template>

<script>
export default {}
</script>
