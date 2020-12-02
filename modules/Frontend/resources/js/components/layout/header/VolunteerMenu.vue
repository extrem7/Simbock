<template>
    <div class="menu-account">
        <a v-b-tooltip.hover
           class="menu-account-link"
           href=""
           title="Tooltip directive content">
            <SvgVue icon="cup"/>
        </a>
        <a v-b-tooltip.hover
           :href="route('vacancies.index')"
           class="menu-account-link"
           title="Search vacancies">
            <SvgVue icon="job"/>
        </a>
        <a v-b-tooltip.hover
           class="menu-account-link link-stroke"
           href=""
           title="Recommended companies">
            <SvgVue icon="company"/>
        </a>
        <a v-b-tooltip.hover
           class="menu-account-link link-stroke has-message"
           href=""
           title="Messages">
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
