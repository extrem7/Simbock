<template>
    <TheHeader>
       <VolunteerMenu class="hidden-sm"/>
        <b-dropdown class="drop-account-wrapper" no-caret variant="dropdown-account">
            <template v-slot:button-content>
                <img alt="dots" class="dropdown-item-icon" src="/dist/img/icons/dots.svg">
            </template>
            <b-dropdown-item
                v-b-tooltip.hover.left
                :href="route('volunteer.account.form')"
                title="Your account">
                <img alt="company" class="dropdown-item-icon" src="/dist/img/icons/volunteer.svg">
            </b-dropdown-item>
            <BDropdownItem v-b-tooltip.hover.left
                           :href="route('auth.change_password.form')"
                           title="Change password">
                <img alt="settings" class="dropdown-item-icon" src="/dist/img/icons/settings.svg">
            </BDropdownItem>
            <b-dropdown-item v-b-tooltip.hover.left title="Tooltip directive content">
                <img alt="support" class="dropdown-item-icon" src="/dist/img/icons/support.svg">
            </b-dropdown-item>
            <TheLogout/>
        </b-dropdown>
    </TheHeader>
</template>

<script>
import TheHeader from "./TheHeader"
import VolunteerMenu from "./VolunteerMenu"
import TheLogout from "./TheLogout"

export default {
    components: {
        VolunteerMenu,
        TheHeader,
        TheLogout
    }
}
</script>
