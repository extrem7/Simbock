<template>
    <div class="col-md-4 col-lg-3">
        <form @submit.prevent="submit" class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" id="name" placeholder="name" v-model="form.name" v-valid.name>
                    <invalid name="name"></invalid>
                </div>
            </div>
            <card-footer></card-footer>
        </form>
    </div>
</template>

<script>
    import form from "@/mixins/form"

    export default {
        mixins: [form],
        data() {
            return {
                form: {
                    name: ''
                },
                resource: 'sectors',
                singular: 'sector'
            }
        },
        created() {
            const sector = this.shared('sector')
            if (sector) this.setupEdit(sector)
        },
        methods: {
            submit() {
                this.easySubmit()
            }
        }
    }
</script>

