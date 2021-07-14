<template>
    <div class="access-box">
        <a v-b-tooltip.hover.auto
           :href="route('vacancies.search')"
           class="access-box-link"
           title="Search job">
            <SvgVue
                class="access-icon access-icon-search"
                icon="search-large"/>
        </a>
        <a v-b-tooltip.hover.auto
           :class="{'active-bookmark' : inBookmarks}"
           class="access-box-link"
           title="Save to bookmarks"
           @click.prevent="bookmark">
            <SvgVue
                class="access-icon access-icon-bookmark"
                icon="bookmark"/>
        </a>
        <a v-b-modal.contacts-modal
           v-b-tooltip.hover.auto
           class="access-box-link"
           title="Send message"
           @click.prevent>
            <SvgVue
                class="access-icon access-icon-chat"
                icon="chat-mod"/>
        </a>
        <!--<a href="" class="access-box-link" v-b-tooltip.hover.auto title="Tooltip directive content">
              <svg-vue icon="promotion" class="access-icon access-icon-promotion"></svg-vue>
          </a>-->
        <BModal
            id="contacts-modal"
            ref="contacts"
            hide-footer>
            <template v-slot:modal-header="{ close }">
                <ModalHeader
                    :close="close"
                    title="Send message"/>
            </template>
            <form class="chat-send-message mx-auto"
                  @submit.prevent="chat">
                <textarea v-model="message"
                          class="form-control"
                          maxlength="510"
                          placeholder="Write a message..." required></textarea>
                <button class="btn btn-silver btn-send-message min-width-100">
                    <SvgVue icon="telegramm"/>
                </button>
            </form>
        </BModal>
    </div>
</template>

<script>
import {BModal} from 'bootstrap-vue'
import ModalHeader from '~/components/volunteer/account/components/ModalHeader'

export default {
    props: {
        id: Number,
        inBookmarks: {
            type: Boolean,
            default: false
        }
    },
    components: {BModal, ModalHeader},
    data() {
        return {
            message: ''
        }
    },
    methods: {
        // todo refactor to mixin
        async bookmark() {
            const {status, data} = await this.axios.post(this.route('vacancies.actions.bookmark', this.id))
            if (status === 200) {
                this.$emit('update:bookmarked', data.inBookmarks)
                this.notify(data.message)
            }
        },
        async chat() {
            try {
                const {status, data: {message}} = await this.axios.post(this.route('vacancies.actions.chat', this.id), {
                    message: this.message
                })
                if (status === 201) {
                    this.$root.$emit('bv::hide::modal', 'contacts-modal')
                    this.notify(message)
                    setTimeout(() => {
                        location.href = this.route('chat.page')
                    }, 1500)
                }
            } catch (e) {
                console.log(e)
            }
        }
    }
}
</script>
