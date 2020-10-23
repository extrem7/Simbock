<template>
    <nav class="menu-account">
        <a v-b-tooltip.hover
           :href="route('company.vacancies.create')"
           class="menu-account-link link-stroke"
           title="Post new vacancy">
            <svg-vue icon="add"></svg-vue>
        </a>
        <a v-b-tooltip.hover
           :href="route('company.vacancies.index')"
           class="menu-account-link"
           title="Your company vacancies">
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
    </nav>
</template>
