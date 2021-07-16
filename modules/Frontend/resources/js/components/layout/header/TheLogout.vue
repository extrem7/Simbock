<template>
    <BDropdownItem
        v-b-tooltip.hover.left
        title="Logout"
        @click="logout">
        <img alt="logout" class="dropdown-item-icon" src="/dist/img/icons/logout.svg">
    </BDropdownItem>
</template>

<script>
import {BDropdownItem} from 'bootstrap-vue'

export default {
    components: {BDropdownItem},
    methods: {
        async logout() {
            await this.axios.post(this.route('logout'))
            location.href = this.route('home')
        }
    }
}
</script>

