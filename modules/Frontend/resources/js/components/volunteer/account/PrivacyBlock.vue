<template>
    <div class="sector sector-sidebar sector-hidden-account">
        <div class="item-box">
            <div class="sector-body">
                <div class="sector-body-inner">
                    <div class="d-flex align-items-center">
                        <div class="sector-name semi-bold-weight">Let those in Need Find You</div>
                        <div class="custom-control custom-switch">
                            <input id="isPrivate"
                                   v-model="is_private"
                                   class="custom-control-input"
                                   type="checkbox">
                            <label class="custom-control-label" for="isPrivate"></label>
                        </div>
                    </div>
                    <div class="sector-text extra-small-size mt-2 mb-2">
                        {{ !is_private ? 'Private' : 'Public' }}:
                        Your profile is {{ !is_private ? 'not' : '' }} publicly accessible.
                        However, it is viewable as a part of your applications.
                    </div>
                    <div class="item-box item-box-survey extra-small-size">
                        <span class="semi-bold-weight">
                            Were you recently hired?</span> Take a minute and fill out our
                        <a :href="route('volunteer.survey.page')"
                           class="link">
                            short survey.
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    computed: {
        is_private: {
            get() {
                return !this.$store.state.volunteer.form.is_private
            },
            set() {
                this.$store.dispatch('volunteer/togglePrivacy')
            }
        }
    }
}
</script>
