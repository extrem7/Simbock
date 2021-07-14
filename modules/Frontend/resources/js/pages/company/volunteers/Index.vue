<template>
    <main :class="[isContainer?'container content-inner':'']">
        <h1 v-if="title"
            :class="[isContainer?'title-page title-line line-large':'medium-size text-center text-lg-left']"
            class="title">
            {{ title }}
        </h1>
        <Transition
            mode="out-in"
            name="fade">
            <VacanciesFilter
                v-if="enableFilter && isFilterOpen"
                key="filter"
            />
            <div v-else
                 key="list"
                 :class="{'mt-0':!title,'card-list-sm-top':!isContainer}"
                 class="row card-list">
                <div :class="[isContainer?'offset-xl-2 col-xl-8 offset-lg-1 col-lg-10':'col-12']">
                    <div v-if="volunteers.length">
                        <VolunteerCard
                            v-for="(volunteer,i) in volunteers"
                            :key="volunteer.id"
                            v-bind="volunteerProps(volunteer)"
                            :in-bookmarks="volunteer.in_bookmarks"
                            @contact="contactVolunteer(volunteer.id)"
                            @update:bookmarked="updateVolunteerBookmarked(i,$event)"
                        />
                        <div
                            v-if="page!==lastPage"
                            class="text-center">
                            <button
                                class="btn btn-outline-violet violet-color medium-weight btn-load-more btn-scale-active"
                                @click="loadMore">
                                Load More Vacancies
                                <SvgVue icon="arrow-down"/>
                            </button>
                        </div>
                        <BModal
                            id="contacts-modal"
                            ref="contacts"
                            hide-footer>
                            <template v-slot:modal-header="{ close }">
                                <ModalHeader
                                    :close="close"
                                    title="Contact"/>
                            </template>
                            <div class="row align-items-center">
                                <div class="col-4 mb-2">
                                    <div class="extra-small-size">Click to call</div>
                                </div>
                                <div class="col-8 violet-color mb-2">
                                    <a
                                        :href="`tel:${contacts.phone}`"
                                        class="extra-small-size link-inherit">
                                        {{ contacts.phone }}
                                    </a>
                                </div>
                                <div class="col-4 mb-2">
                                    <div class="extra-small-size">Email clipboard</div>
                                </div>
                                <div class="col-8 violet-color mb-2">
                                    <a
                                        :href="`mailto:${contacts.email}`"
                                        class="link-inherit extra-small-size"
                                        @click.prevent="copyVolunteerEmail">
                                        {{ contacts.email }}
                                    </a>
                                </div>
                            </div>
                            <form class="chat-send-message mx-auto"
                                  @submit.prevent="chat">
                                <textarea v-model="contacts.message"
                                          class="form-control"
                                          maxlength="510"
                                          placeholder="Write a message..."
                                          required>
                                </textarea>
                                <button class="btn btn-silver btn-send-message min-width-100">
                                    <SvgVue icon="telegramm"/>
                                </button>
                            </form>
                        </BModal>
                    </div>
                    <div v-else>
                        <BAlert
                            class="text-center"
                            show
                            variant="warning">
                            No volunteers found
                        </BAlert>
                    </div>
                </div>
            </div>
        </Transition>
    </main>
</template>

<script>
import Vue from 'vue'
import {BModal} from 'bootstrap-vue'
import VolunteerCard from '~/components/company/VolunteerCard'
import VacanciesFilter from '~/components/vacancies/VacanciesFilter'
import ModalHeader from '~/components/volunteer/account/components/ModalHeader'

import {copyTextToClipboard} from '~/helpers/helpers'

export default {
    components: {
        BModal,
        VolunteerCard,
        VacanciesFilter,
        ModalHeader
    },
    props: {
        title: String,
        enableActions: {
            type: Boolean,
            default: true
        },
        enableFilter: {
            type: Boolean,
            default: true
        },
        isContainer: {
            type: Boolean,
            default: true
        }
    },
    data() {
        const data = this.shared('volunteers')
        return {
            volunteers: data.data,
            page: data.current_page,
            lastPage: data.last_page || 1,

            contacts: {
                id: null,
                phone: null,
                email: null
            },

            isFilterOpen: false
        }
    },
    created() {
        this.$bus.on('toggle-filter', () => {
            this.isFilterOpen = !this.isFilterOpen
        })
        if (this.enableFilter) this.$bus.emit('enable-filter')
    },
    methods: {
        async loadMore() {
            if (this.page < this.lastPage) {
                this.page += 1
                try {
                    const params = new URL(location.href).searchParams
                    params.set('page', this.page)
                    const {data} = await this.axios.get(`?${decodeURI(params)}`)
                    this.volunteers = this.volunteers.concat(data.data)
                } catch (e) {
                    console.log(e)
                }
            }
        },
        updateVolunteerBookmarked(i, in_bookmarks) {
            Vue.set(this.volunteers[i], 'in_bookmarks', in_bookmarks)
        },
        async contactVolunteer(id) {
            try {
                const {data: {phone, email}} = await this.axios.get(this.route('volunteers.actions.contact', id))
                this.contacts.id = id
                this.contacts.phone = phone
                this.contacts.email = email
                this.$refs.contacts.show()
            } catch (e) {
                console.log(e)
            }
        },
        async chat() {
            try {
                const {
                    status,
                    data: {message}
                } = await this.axios.post(this.route('volunteers.actions.chat', this.contacts.id), {
                    message: this.contacts.message
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
        },
        copyVolunteerEmail() {
            copyTextToClipboard(this.contacts.email, () => {
                this.notify('Email has been copied to clipboard.', 'success', 3)
            })
        },
        volunteerProps(vacancy) {
            const props = {}
            const fields = [
                'id', 'job_title', 'avatar', 'name', 'location', 'updated_at', 'employment', 'sectors'
            ]
            for (let field of fields) props[field] = vacancy[field]
            props.isCompleted = vacancy.is_completed
            return props
        }
    }
}
</script>
