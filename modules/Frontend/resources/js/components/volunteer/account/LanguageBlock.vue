<template>
    <div class="sector sector-middle sector-language">
        <div class="sector-label">Languages</div>
        <div class="item-box">
            <div class="sector-header">
                <button v-b-modal.modal-languages
                        class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add languages</span>
                </button>
            </div>
        </div>
        <b-modal id="modal-languages" hide-footer>
            <template v-slot:modal-header="{ close }">
                <button aria-label="Close" class="close" type="button" @click="close()">
                    <svg-vue icon="close"></svg-vue>
                </button>
                <h5 class="title medium-size semi-bold-weight">Languages</h5>
            </template>
            <div class="extra-small-size control-label">Add up to 5 languages</div>
            <div class="form-group">
                <simbok-select placeholder="Choose a language.."></simbok-select>
            </div>
            <div class="extra-small-size mb-1">Fluency</div>
            <div class="inline-custom-control mb-2">
                <div class="custom-control custom-radio">
                    <input id="customCheck4444" class="custom-control-input" type="radio">
                    <label class="custom-control-label silver-color" for="customCheck4444">Basic</label>
                </div>
                <div class="custom-control custom-radio">
                    <input id="customCheck3333" class="custom-control-input" type="radio">
                    <label class="custom-control-label silver-color" for="customCheck3333">Intermediate</label>
                </div>
                <div class="custom-control custom-radio">
                    <input id="customCheck2222" class="custom-control-input" type="radio">
                    <label class="custom-control-label silver-color" for="customCheck2222">Fluent</label>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn btn-outline-silver min-width-100 btn-drop-shadow btn-scale-active"
                        @click="$bvModal.hide('modal-languages')">Cancel
                </button>
                <button class="btn btn-green min-width-100 btn-shadow btn-scale-active">Save</button>
            </div>
        </b-modal>
    </div>
</template>

<script>
export default {}
</script>
