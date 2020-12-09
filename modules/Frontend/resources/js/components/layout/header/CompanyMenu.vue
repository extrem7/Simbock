<template>
    <nav class="menu-account">
        <a v-b-tooltip.hover
           :href="route('company.vacancies.create')"
           class="menu-account-link link-stroke"
           title="Post a job">
            <SvgVue icon="add"/>
        </a>
        <a v-b-tooltip.hover
           :href="route('company.board')"
           class="menu-account-link"
           title="Board">
            <SvgVue icon="board"/>
        </a>
        <a v-b-tooltip.hover
           :href="route('company.volunteers.candidates')"
           class="menu-account-link"
           title="Candidates">
            <SvgVue icon="group"/>
        </a>
        <a v-b-tooltip.hover
           :href="route('company.vacancies.index')"
           class="menu-account-link"
           title="Jobs">
            <SvgVue icon="job"/>
        </a>
        <a v-b-tooltip.hover
           :href="route('volunteers.search')"
           class="menu-account-link has-message link-stroke"
           title="Messenger">
            <SvgVue icon="chat"/>
        </a>
        <a v-b-tooltip.hover
           :href="route('volunteers.search')"
           class="menu-account-link link-stroke"
           title="Search resume">
            <SvgVue icon="file"/>
        </a>
    </nav>
</template>
