<template>

</template>

<script>
import {createTextLinks} from '~/helpers/helpers'

export default {
    computed: {
        user() {
            return this.$store.state.user
        }
    },
    mounted() {
        this.$bus.on('broadcasting-ready', () => {
            this.$echo.private(`chat.${this.user.type}.${this.user.client.id}`)
                .listen('.chat.message.created', ({message, sender}) => {
                    if (this.unviewedMessages === 0) this.unviewedMessages = 1
                    if (!this.isRoute('chat.page') || (+route().params.chat) !== message.chat_id) {
                        const href = this.route('chat.page', message.chat_id),
                            text = createTextLinks(message.text)

                        const title = this.$createElement('a', {attrs: {href}}, `You have new message from ${sender.name}`)

                        this.$bvToast.toast(this.$createElement('div', {domProps: {innerHTML: text}}), {
                            toaster: 'b-toaster-bottom-right',
                            href: href,
                            title: title,
                            autoHideDelay: 10000,
                            solid: true,
                            appendToast: true
                        })
                    }
                })
        })
    }
}

</script>
