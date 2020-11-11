<template>
    <div class="sector sector-middle sector-looking">
        <div class="sector-label">Looking to volunteer</div>
        <div class="item-box">
            <div class="sector-header">
                <button v-b-modal.modal-looking-volunteer
                        class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add Desired job title</span>
                </button>
            </div>
        </div>
        <b-modal id="modal-looking-volunteer" hide-footer>
            <template v-slot:modal-header="{ close }">
                <button aria-label="Close" class="close" type="button" @click="close()">
                    <svg-vue icon="close"></svg-vue>
                </button>
                <h5 class="title medium-size semi-bold-weight">Looking to volunteer</h5>
            </template>
            <div class="form-group">
                <input-material placeholder="Desired job title"></input-material>
            </div>
            <div class="form-group">
                <input-typeahead placeholder="Preferred work location"></input-typeahead>
            </div>
            <div class="form-group">
                <button class="btn-add-info btn-rotate-icon btn-add-info-green btn-add-info-sm">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add location</span>
                </button>
            </div>
            <div class="control-label">Job type</div>
            <div class="inline-custom-control form-group">
                <div class="custom-control custom-checkbox">
                    <input id="customCheck2" class="custom-control-input" type="checkbox">
                    <label class="custom-control-label" for="customCheck2">Permanent</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input id="customCheck2" class="custom-control-input" type="checkbox">
                    <label class="custom-control-label" for="customCheck2">Temporary</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input id="customCheck2" class="custom-control-input" type="checkbox">
                    <label class="custom-control-label" for="customCheck2">Contract</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input id="customCheck2" class="custom-control-input" type="checkbox">
                    <label class="custom-control-label" for="customCheck2">Graduate Jobs <span
                        class="extra-small-size"> (Select if you are a recent graduate)</span></label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input id="customCheck2" class="custom-control-input" type="checkbox">
                    <label class="custom-control-label" for="customCheck2">Weekend volunteering Jobs</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input id="customCheck2" class="custom-control-input" type="checkbox">
                    <label class="custom-control-label" for="customCheck2">No experience volunteering
                        Jobs</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input id="customCheck2" class="custom-control-input" type="checkbox">
                    <label class="custom-control-label" for="customCheck2">Evening volunteering Jobs</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input id="customCheck2" class="custom-control-input" type="checkbox">
                    <label class="custom-control-label" for="customCheck2">Sport volunteering</label>
                </div>
            </div>
            <div class="control-label">Hours</div>
            <div class="inline-custom-control form-group">
                <div class="custom-control custom-checkbox">
                    <input id="customCheck2" class="custom-control-input" type="checkbox">
                    <label class="custom-control-label" for="customCheck2">Full-time</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input id="customCheck2" class="custom-control-input" type="checkbox">
                    <label class="custom-control-label" for="customCheck2">Part-time</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input id="customCheck2" class="custom-control-input" type="checkbox">
                    <label class="custom-control-label" for="customCheck2">Per diem</label>
                </div>
            </div>
            <div class="add-sector-item">
                <div class="form-group d-flex align-items-center">
                    <simbok-select class="flex-grow-1" placeholder="Choose your sector ..."></simbok-select>
                    <button class="btn btn-sector-action btn-sector-delete ml-3">
                        <svg-vue icon="close"></svg-vue>
                    </button>
                </div>
                <div class="control-label">Select up to 5 roles</div>
                <div class="row form-group">
                    <div class="col-sm-6">
                        <div class="custom-control custom-checkbox mb-1">
                            <input id="customCheck2" class="custom-control-input" type="checkbox">
                            <label class="custom-control-label" for="customCheck2">Accounts Admin</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                            <input id="customCheck2" class="custom-control-input" type="checkbox">
                            <label class="custom-control-label" for="customCheck2">Accounts Assistant</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                            <input id="customCheck2" class="custom-control-input" type="checkbox">
                            <label class="custom-control-label" for="customCheck2">Accounts Manager</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="custom-control custom-checkbox mb-1">
                            <input id="customCheck2" class="custom-control-input" type="checkbox">
                            <label class="custom-control-label" for="customCheck2">Accounts Admin</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                            <input id="customCheck2" class="custom-control-input" type="checkbox">
                            <label class="custom-control-label" for="customCheck2">Accounts Assistant</label>
                        </div>
                        <div class="custom-control custom-checkbox mb-1">
                            <input id="customCheck2" class="custom-control-input" type="checkbox">
                            <label class="custom-control-label" for="customCheck2">Accounts Manager</label>
                        </div>
                    </div>
                </div>
                <button class="btn-add-info btn-rotate-icon btn-add-info-green btn-add-info-sm">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add sector</span>
                </button>
            </div>
            <div class="modal-actions">
                <button class="btn btn-outline-silver min-width-100 btn-drop-shadow btn-scale-active"
                        @click="$bvModal.hide('modal-looking-volunteer')">Cancel
                </button>
                <button class="btn btn-green min-width-100 btn-shadow btn-scale-active">Save</button>
            </div>
        </b-modal>
    </div>
</template>

<script>
export default {}
</script>
