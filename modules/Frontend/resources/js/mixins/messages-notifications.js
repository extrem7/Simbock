export default {
    data() {
        return {
            unviewedMessages: this.shared('unviewedMessages')
        }
    },
    mounted() {
        this.$bus.on('unviewed-messages', unviewedMessages => {
            this.unviewedMessages = unviewedMessages
        })
    }
}
