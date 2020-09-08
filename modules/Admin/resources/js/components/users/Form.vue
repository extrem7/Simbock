<template>
    <div class="col-md-5 col-lg-4">
        <form @submit.prevent="submit" class="card card-primary">
            <div class="card-body">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" id="email" placeholder="Email" type="email"
                           v-model="form.email" v-valid.email>
                    <invalid name="email"></invalid>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" id="name" placeholder="Name" type="text"
                           v-model="form.name" v-valid.name>
                    <invalid name="name"></invalid>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" id="password" placeholder="Password" type="text"
                           v-model="form.password" v-valid.password>
                    <invalid name="password"></invalid>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <b-form-select :options="roles" id="role" v-model="form.role" v-valid="form.role"></b-form-select>
                    <invalid name="role"></invalid>
                </div>

                <red-cropper :old="oldAvatar" ref="cropper" validate="avatar"></red-cropper>
            </div>
            <card-footer resource="users"></card-footer>
        </form>
    </div>
</template>

<script>
    import form from '@/mixins/form'

    export default {
        mixins: [form],
        created() {
            const user = this.shared('user')
            if (user) {
                this.setupEdit(user)
                this.oldAvatar = user.avatar
            }
            if (!this.isEdit)
                this.form.role = this.roles[0].value
        },
        data() {
            return {
                form: {
                    email: '',
                    name: '',
                    password: '',
                    role: null,
                },
                roles: [...this.shared('roles')],
                oldAvatar: null,
                resource: 'users'
            }
        },
        methods: {
            async submit() {
                const form = this.jtf(this.form)

                const avatar = await this.$refs.cropper.getBlob()
                if (avatar) form.append('avatar', avatar, avatar.name)

                try {
                    if (this.isEdit) {
                        const {status, data} = await this.send(this.route(`admin.${this.resource}.update`, this.id), form, true)
                        if (status === 200) {
                            const user = data.user
                            this.setupEdit(user)
                            this.form.password = null
                            if (avatar) {
                                this.$refs.cropper.resetImage()
                                this.oldAvatar = user.avatar
                            }
                            this.$bus.emit('alert', {text: data.status})
                        }
                    } else {
                        const {status, data} = await this.send(this.route(`admin.${this.resource}.store`), form, true)
                        if (status === 201) {
                            const user = data.user
                            this.setupEdit(user)
                            this.form.password = null
                            if (avatar) {
                                this.$refs.cropper.resetImage()
                                this.oldAvatar = user.avatar
                            }
                            document.title = data.title
                            history.pushState(
                                null, data.title, this.route(`admin.${this.resource}.edit`, user.id)
                            )
                            this.$bus.emit('alert', {text: data.status})
                        }
                    }
                } catch (e) {
                    console.log(e)
                }
            }
        }
    }
</script>
