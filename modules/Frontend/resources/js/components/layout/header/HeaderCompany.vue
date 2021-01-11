<template>
    <TheHeader>
        <CompanyMenu class="hidden-sm"/>
        <BDropdown class="drop-account-wrapper" no-caret variant="dropdown-account">
            <template v-slot:button-content>
                <img alt="dots" class="dropdown-item-icon" src="/dist/img/icons/dots.svg">
            </template>
            <BDropdownItem v-b-tooltip.hover.left :href="route('companies.self')" title="Company info">
                <img alt="company" class="dropdown-item-icon" src="/dist/img/icons/company-profile.svg">
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
            <BDropdownItem v-b-tooltip.hover.left
                           :href="route('company.upgrade.page')"
                           title="Upgrade subscription plan">
                <img alt="support" class="dropdown-item-icon" src="/dist/img/icons/upgrade.svg">
            </BDropdownItem>
            <TheLogout/>
        </BDropdown>
    </TheHeader>
</template>

<script>
import TheHeader from "./TheHeader"
import CompanyMenu from './CompanyMenu'
import TheLogout from "./TheLogout"

export default {
    components: {
        TheHeader,
        CompanyMenu,
        TheLogout
    }
}
</script>
