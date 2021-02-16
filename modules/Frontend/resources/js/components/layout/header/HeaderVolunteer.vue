<template>
    <TheHeader>
        <VolunteerMenu class="hidden-sm"/>
        <BDropdown class="drop-account-wrapper" no-caret variant="dropdown-account">
            <template v-slot:button-content>
                <img alt="dots" class="dropdown-item-icon" src="/dist/img/icons/dots.svg">
            </template>
            <BDropdownItem
                :href="route('volunteer.account.form')"
                v-b-tooltip.hover.left
                title="Your account">
                <img alt="company" class="dropdown-item-icon" src="/dist/img/icons/volunteer.svg">
            </BDropdownItem>
            <BDropdownItem
                v-b-tooltip.hover.left
                :href="route('volunteer.vacancies.history')"
                title="Application History">
                <img alt="history" class="dropdown-item-icon" src="/dist/img/icons/history-apply.svg">
            </BDropdownItem>
            <BDropdownItem v-b-tooltip.hover.left
                           :href="route('auth.change_password.form')"
                           title="Change password">
                <img alt="settings" class="dropdown-item-icon" src="/dist/img/icons/settings.svg">
            </BDropdownItem>
            <BDropdownItem v-b-tooltip.hover.left
                           href="/help"
                           title="Help and support">
                <img alt="support" class="dropdown-item-icon" src="/dist/img/icons/support.svg">
            </BDropdownItem>
            <TheLogout/>
        </BDropdown>
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
