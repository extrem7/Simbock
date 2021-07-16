<template>
    <nav class="menu-account">
        <a v-b-tooltip.hover
           :href="route('company.vacancies.create')"
           class="menu-account-link link-stroke"
           title="Post vacancy">
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
         title="Vacancies">
        <SvgVue icon="job"/>
      </a>
      <a v-b-tooltip.hover
         :class="{'has-message':unviewedMessages}"
         :href="route('chat.page')"
         class="menu-account-link link-stroke"
         title="ChatMessages">
        <SvgVue icon="chat"/>
      </a>
      <a v-b-tooltip.hover
         :href="route('volunteers.search')"
         class="menu-account-link link-stroke"
         title="Search candidates">
        <SvgVue icon="file"/>
      </a>
      <a v-b-tooltip.hover
         :href="route('company.volunteers.saved')"
         class="menu-account-link link-stroke"
         title="Saved Candidates">
        <SvgVue icon="box"/>
      </a>
    </nav>
</template>

<script>
import messagesNotifications from '~/mixins/messages-notifications'

export default {
    mixins: [messagesNotifications]
}
</script>
