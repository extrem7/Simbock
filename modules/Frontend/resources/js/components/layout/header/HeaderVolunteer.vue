<template>
    <TheHeader>
        <button class="btn btn-show-search" @click="$bus.emit('search-toggle')">
            <svg-vue icon="search-thin"></svg-vue>
        </button>
        <div class="menu-account hidden-sm">
            <a v-b-tooltip.hover class="menu-account-link" href="" title="Tooltip directive content">
                <svg-vue icon="cup"></svg-vue>
            </a>
            <a v-b-tooltip.hover class="menu-account-link" href="">
                <svg-vue icon="job"></svg-vue>
            </a>
            <a v-b-tooltip.hover class="menu-account-link link-stroke" href="">
                <svg-vue icon="company"></svg-vue>
            </a>
            <a v-b-tooltip.hover class="menu-account-link link-stroke has-message" href="">
                <svg-vue icon="chat"></svg-vue>
            </a>
            <a v-b-tooltip.hover class="menu-account-link link-stroke" href="">
                <svg-vue icon="box"></svg-vue>
            </a>
        </div>
        <b-dropdown class="drop-account-wrapper" no-caret variant="dropdown-account">
            <template v-slot:button-content>
                <img alt="dots" class="dropdown-item-icon" src="dist/img/icons/dots.svg">
            </template>
            <b-dropdown-item v-b-tooltip.hover.left title="Tooltip directive content">
                <img alt="company" class="dropdown-item-icon" src="dist/img/icons/volunteer.svg">
            </b-dropdown-item>
            <b-dropdown-item v-b-tooltip.hover.left title="Tooltip directive content">
                <img alt="settings" class="dropdown-item-icon" src="dist/img/icons/settings.svg">
            </b-dropdown-item>
            <b-dropdown-item v-b-tooltip.hover.left title="Tooltip directive content">
                <img alt="support" class="dropdown-item-icon" src="dist/img/icons/support.svg">
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
