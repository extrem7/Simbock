<template>
    <div class="sector sector-middle sector-skills">
        <div class="sector-label">Skills</div>
        <div class="item-box">
            <div class="sector-header">
                <button v-b-modal.modal-skills
                        class="btn-add-info btn-rotate-icon btn-add-info-violet btn-add-info-lg">
                    <span class="add-info-circle"><svg-vue icon="plus"></svg-vue></span>
                    <span class="add-info-text">Add Skills</span>
                </button>
            </div>
        </div>
        <b-modal id="modal-skills" hide-footer>
            <template v-slot:modal-header="{ close }">
                <button aria-label="Close" class="close" type="button" @click="close()">
                    <svg-vue icon="close"></svg-vue>
                </button>
                <h5 class="title medium-size semi-bold-weight">Skills</h5>
            </template>
            <div class="form-group">
                <InputTag v-model="value"
                          :options="skills"
                          placeholder="Enter Skill"/>
            </div>
            <div class="modal-actions">
                <button class="btn btn-outline-silver min-width-100 btn-drop-shadow btn-scale-active"
                        @click="$bvModal.hide('modal-skills')">Cancel
                </button>
                <button class="btn btn-green min-width-100 btn-shadow btn-scale-active">Save</button>
            </div>
        </b-modal>
    </div>
</template>

<script>
export default {
    data() {
        return {
            skills: this.shared('skills'),
            value: []
        }
    }
}
</script>
