<template>
    <BDropdownItem v-b-tooltip.hover.left title="Logout from account">
        <img alt="logout" class="dropdown-item-icon" src="/dist/img/icons/logout.svg" @click="logout">
    </BDropdownItem>
</template>

<script>
export default {
    methods: {
        async logout() {
            await this.axios.post(this.route('logout'))
            location.href = this.route('home')
        }
    }
}
</script>

