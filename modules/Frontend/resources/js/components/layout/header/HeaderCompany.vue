<template>
    <header class="header header-account">
        <div class="header-wrapper container">
            <a :href="route('frontend.home')" class="d-block">
                <img alt="logo" class="header-logo" src="dist/img/logo.svg">
            </a>
            <nav class="header-account-navigation">
                <button class="btn btn-show-search" @click="$bus.emit('search-toggle')">
                    <svg-vue icon="search-thin"></svg-vue>
                </button>
                <div class="menu-account hidden-sm">
                    <a v-b-tooltip.hover class="menu-account-link link-stroke" href=""
                       title="Tooltip directive content">
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
                        <img alt="dots" class="dropdown-item-icon" src="dist/img/icons/dots.svg">
                    </template>
                    <b-dropdown-item v-b-tooltip.hover.left title="Tooltip directive content">
                        <img alt="company" class="dropdown-item-icon" src="dist/img/icons/company-profile.svg">
                    </b-dropdown-item>
                    <b-dropdown-item v-b-tooltip.hover.left title="Tooltip directive content">
                        <img alt="settings" class="dropdown-item-icon" src="dist/img/icons/settings.svg">
                    </b-dropdown-item>
                    <b-dropdown-item v-b-tooltip.hover.left title="Tooltip directive content">
                        <img alt="support" class="dropdown-item-icon" src="dist/img/icons/support.svg">
                    </b-dropdown-item>
                    <b-dropdown-item v-b-tooltip.hover.left title="Tooltip directive content">
                        <img alt="support" class="dropdown-item-icon" src="dist/img/icons/upgrade.svg">
                    </b-dropdown-item>
                    <b-dropdown-item v-b-tooltip.hover.left title="Tooltip directive content">
                        <img alt="logout" class="dropdown-item-icon" src="dist/img/icons/logout.svg">
                    </b-dropdown-item>
                </b-dropdown>
            </nav>
        </div>
    </header>
</template>
