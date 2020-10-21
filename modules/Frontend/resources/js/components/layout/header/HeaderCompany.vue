<template>
    <TheHeader>
        <div class="menu-account hidden-sm">
            <a v-b-tooltip.hover
               :href="route('company.vacancies.create')"
               class="menu-account-link link-stroke"
               title="Post new vacancy">
                <svg-vue icon="add"></svg-vue>
            </a>
            <a v-b-tooltip.hover class="menu-account-link" href="" title="Tooltip directive content">
                <svg-vue icon="board"></svg-vue>
            </a>
            <a v-b-tooltip.hover class="menu-account-link" href="" title="Tooltip directive content">
                <svg-vue icon="group"></svg-vue>
            </a>
            <a v-b-tooltip.hover class="menu-account-link" href="" title="Tooltip directive content">
                <svg-vue icon="job"></svg-vue>
            </a>
            <a v-b-tooltip.hover class="menu-account-link has-message link-stroke" href=""
               title="Tooltip directive content">
                <svg-vue icon="chat"></svg-vue>
            </a>
            <a v-b-tooltip.hover class="menu-account-link link-stroke" href=""
               title="Tooltip directive content">
                <svg-vue icon="file"></svg-vue>
            </a>
        </div>
        <b-dropdown class="drop-account-wrapper" no-caret variant="dropdown-account">
            <template v-slot:button-content>
                <img alt="dots" class="dropdown-item-icon" src="/dist/img/icons/dots.svg">
            </template>
            <b-dropdown-item v-b-tooltip.hover.left :href="route('company.info.form')" title="Company info">
                <img alt="company" class="dropdown-item-icon" src="/dist/img/icons/company-profile.svg">
            </b-dropdown-item>
            <b-dropdown-item v-b-tooltip.hover.left title="Tooltip directive content">
                <img alt="settings" class="dropdown-item-icon" src="/dist/img/icons/settings.svg">
            </b-dropdown-item>
            <b-dropdown-item v-b-tooltip.hover.left title="Tooltip directive content">
                <img alt="support" class="dropdown-item-icon" src="/dist/img/icons/support.svg">
            </b-dropdown-item>
            <b-dropdown-item v-b-tooltip.hover.left title="Tooltip directive content">
                <img alt="support" class="dropdown-item-icon" src="/dist/img/icons/upgrade.svg">
            </b-dropdown-item>
            <TheLogout/>
        </b-dropdown>
    </TheHeader>
</template>

<script>
import TheHeader from "./TheHeader"
import TheLogout from "./TheLogout"

export default {
    components: {
        TheHeader,
        TheLogout
    }
}
</script>
