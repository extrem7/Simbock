<template>
    <div class="menu-account">
        <a v-b-tooltip.hover
           :href="route('vacancies.search')"
           class="menu-account-link"
           title="Sport volunteering">
            <SvgVue icon="cup"/>
        </a>
        <a v-b-tooltip.hover
           :href="route('vacancies.search')"
           class="menu-account-link"
           title="Search job">
            <SvgVue icon="job"/>
        </a>
        <a v-b-tooltip.hover
           :href="route('volunteer.vacancies.companies')"
           class="menu-account-link link-stroke"
           title="Recommended companies">
            <SvgVue icon="company"/>
        </a>
        <a v-b-tooltip.hover
           href=""
           class="menu-account-link link-stroke has-message"
           title="Messenger">
            <SvgVue icon="chat"/>
        </a>
        <a v-b-tooltip.hover
           :href="route('volunteer.vacancies.saved')"
           class="menu-account-link link-stroke"
           title="Saved vacancies">
            <SvgVue icon="box"/>
        </a>
    </div>
</template>
