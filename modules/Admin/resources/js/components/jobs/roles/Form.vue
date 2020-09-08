<template>
    <div class="col-md-7 col-lg-5">
        <form @submit.prevent="submit" class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" id="name" placeholder="name" v-model="form.name" v-valid.name>
                    <invalid name="name"></invalid>
                </div>
                <div class="form-group">
                    <multiselect :multiple="true" :options="sectors"
                                 label="name" placeholder="Add sector" track-by="id"
                                 v-model="selectedSectors"></multiselect>
                    <invalid is-array name="sectors"></invalid>
                </div>
            </div>
            <card-footer></card-footer>
        </form>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'

    import form from "@/mixins/form"

    export default {
        components: {
            Multiselect
        },
        mixins: [form],
        data() {
            return {
                form: {
                    name: '',
                    sectors: []
                },
                resource: 'roles',
                singular: 'role',

                sectors: this.shared('sectors'),
                selectedSectors: []
            }
        },
        created() {
            const role = this.shared('role')
            if (role) {
                this.setupEdit(role)
                this.selectedSectors = this.sectors.filter(s => this.form.sectors.includes(s.id))
            }
        },
        watch: {
            selectedSectors(sectors) {
                this.form.sectors = sectors.map(s => s.id)
            }
        },
        methods: {
            submit() {
                this.easySubmit()
            }
        }
    }
</script>

