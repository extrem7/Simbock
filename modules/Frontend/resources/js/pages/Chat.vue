<template>
    <main class="container content-inner content-inner-chat">
        <div class="chat-wrapper">
            <div :class="{'is-open' : isOpenMessage}" class="chat-users-column">
                <div class="chat-wrapper-header justify-content-center">
                    <div class="chat-header-title">Messages</div>
                </div>
                <div class="chat-search">
                    <SvgVue
                        class="search-icon"
                        icon="search"/>
                    <input v-model="searchQuery"
                           class="form-control"
                           placeholder="Find chats by name or job title"
                           type="text">
                    <button class="btn btn-reset-search" @click="searchQuery=''">
                        <SvgVue
                            class="close-icon"
                            icon="close"/>
                    </button>
                </div>
                <div v-if="filteredChats.length" class="chat-users-list vertical-custom-scroll">
                    <div v-for="chat in filteredChats"
                         :key="chat.id"
                         :class="{ active: chat.id === selectedChatId }"
                         class="chat-users-list-item"
                         @click="selectContact(chat.id)">
                        <div class="chat-user-avatar chat-user-avatar-lg">
                            <img :alt="chat.name" :src="chat.avatar">
                        </div>
                        <div class="overflow-hidden w-100">
                            <div v-if="chat.job_title"
                                 class="chat-user-role chat-text-max">
                                {{ chat.job_title }}
                            </div>
                            <div class="chat-user-info">
                                <div class="chat-user-name chat-text-max">{{ chat.name }}</div>
                                <span class="chat-message-date">
                                    {{ dayjs(chat.lastMessage.created_at).format('MMM D') }}
                                </span>
                            </div>
                            <div class="chat-users-last-text chat-text-max">
                                {{ chat.lastMessage.isOwner ? 'You: ' : '' }}
                                {{ chat.lastMessage.text }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div :class="{'is-open' : isOpenMessage}" class="chat-message-column">
                <div v-if="selected"
                     class="chat-wrapper-header">
                    <button class="btn-back-user-list"
                            @click="isOpenMessage = !isOpenMessage">
                        <SvgVue icon="arrow-solid-right"/>
                    </button>
                    <div class="chat-user-avatar chat-user-avatar-sm">
                        <img :alt="selected.name" :src="selected.avatar">
                    </div>
                    <div class="chat-user-name chat-text-max">{{ selected.name }}</div>
                </div>
                <BOverlay
                    :class="{'h-100':!selected}"
                    :show="isLoading"
                    class="chat-messages-wrapper"
                    spinner-variant="info">
                    <div v-if="!messages.length"
                         class="text-center m-auto">
                        <img alt="chat-empty" class="mb-3" src="/dist/img/icons/chat-empty.svg">
                        <div class="extra-small-size silver-color">You have no active conversations.</div>
                    </div>
                    <div v-else
                         ref="feed"
                         class="chat-message-list vertical-custom-scroll">
                        <div v-for="(message,i) in messages" class="chat-item">
                            <div v-if="newDay(message,i-1)"
                                 class="chat-message-date">
                                {{ dayjs(message.created_at).format('MMMM D') }}
                            </div>
                            <div :class="[message.isOwner?'chat-message-item-my':'chat-message-item-user']"
                                 class="chat-message-item">
                                <div class="chat-message-item-wrapper">
                                    <div v-if="!message.isOwner"
                                         class="chat-user-avatar chat-user-avatar-sm">
                                        <img :alt="selected.name" :src="selected.avatar">
                                    </div>
                                    <div class="chat-message-box text-break"
                                         v-html="parseLinks(message.text)"></div>
                                </div>
                                <div class="chat-message-date chat-message-time text-right">
                                    {{ dayjs(message.created_at).format('HH:mm') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <form v-if="selected"
                          class="chat-send-message"
                          @submit.prevent="send">
                        <textarea v-model="message"
                                  class="form-control"
                                  maxlength="510"
                                  placeholder="Write a message..."
                                  required @keydown.enter.prevent="$refs.sendButton.click()"></textarea>
                        <button ref="sendButton" class="btn btn-silver btn-send-message min-width-100">
                            <SvgVue icon="telegramm"/>
                        </button>
                    </form>
                </BOverlay>
            </div>
        </div>
    </main>
</template>

<script>
import {BOverlay} from 'bootstrap-vue'
import Fuse from 'fuse.js'
import {sortBy} from 'lodash'
import {createTextLinks} from '~/helpers/helpers'

export default {
    components: {BOverlay},
    data() {
        return {
            searchQuery: '',
            isOpenMessage: !!this.shared('selectedChatId') || false,
            isLoading: false,
            message: '',
            chats: Object.values(this.shared('chats')),
            selectedChatId: this.shared('selectedChatId') || null,
            messages: this.shared('messages') || []
        }
    },
    computed: {
        user() {
            return this.$store.state.user
        },
        filteredChats() {
            const fuse = new Fuse(this.chats, {
                includeScore: true,
                threshold: .3,
                keys: ['name', 'job_title']
            })
            const searched = fuse.search(this.searchQuery).map(({item}) => item)
            let chats = this.searchQuery.length ? searched : this.chats
            return sortBy(chats, [(chat) => {
                return chat.lastMessage.created_at
            }]).reverse()
        },
        selected() {
            return this.chats.find(({id}) => id === this.selectedChatId)
        }
    },
    mounted() {
        if (this.selectedChatId) this.scrollToBottom()

        this.$echo.private(`chat.${this.user.type}.${this.user.client.id}`)
            .listen('.chat.message.created', ({message}) => {
                if (message.chat_id === this.selectedChatId) {
                    this.messages.push(message)
                    this.scrollToBottom()
                    this.$bus.emit('unviewed-messages', 0)
                }
                const contact = this.chats.find(({id}) => id === message.chat_id)
                if (contact) {
                    contact.lastMessage = message
                    contact.date = message.created_at
                }
            })
    },
    methods: {
        async selectContact(id) {
            this.isOpenMessage = true
            if (this.selectedChatId === id) return

            this.selectedChatId = id

            this.isLoading = true
            try {
                const {data: {messages, unviewedMessages}} = await this.axios.get(this.route('chat.messages', id))
                this.messages = messages
                this.$bus.emit('unviewed-messages', unviewedMessages)
                history.pushState(null, null, this.route('chat.page', this.selectedChatId))
            } catch (e) {
                console.log(e)
                this.isOpenMessage = false
                this.selectedChatId = null
            } finally {
                this.isLoading = false
                this.scrollToBottom()
            }
        },
        async send() {
            this.isLoading = true
            try {
                const {status, data: {message}} = await this.axios.post(
                    this.route('chat.messages.send', this.selectedChatId), {
                        message: this.message
                    }
                )
                if (status === 201) {
                    this.messages.push(message)
                    message.isOwner = true
                    this.selected.lastMessage = message
                    this.message = ''
                    this.scrollToBottom()
                }
            } catch (e) {
                console.log(e)
            } finally {
                this.isLoading = false
            }
        },
        newDay(curr, prev) {
            if (prev === -1) return true
            return new Date(curr.created_at).toLocaleDateString()
                !==
                new Date(this.messages[prev].created_at).toLocaleDateString()
        },
        parseLinks(text) {
            return createTextLinks(text)
        },
        scrollToBottom() {
            setTimeout(() => {
                this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight
            }, 50)
        }
    }
}
</script>
