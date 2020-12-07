<template>
    <div :class="{'completed-account' : isCompleted}"
         class="card-work card-work-volunteer">
        <div class="card-work-profile">
            <a :href="link" class="profile-avatar">
                <img :src="avatar" alt="" class="profile-avatar-img">
            </a>
            <div>
                <a :href="link" class="card-work-post link-inherit">{{ job_title }}</a>
                <a :href="link" class="card-work-title">{{ name }}</a>
                <div class="card-work-info">
                    <div class="card-work-place">{{ location }}</div>
                    <span class="vertical-divider"></span>
                    <div class="card-work-posted">Posted {{ updated_at }}</div>
                </div>
            </div>
        </div>
        <div class="card-work-time">{{ employment }}</div>
        <div class="card-work-text">{{ sectors.join(', ') }}</div>
        <div class="card-work-actions justify-content-between">
            <a :href="link" class="link link-border semi-bold-weight mr-3">See more</a>
            <div>
                <button
                    class="btn btn-outline-violet min-width-100 btn-scale-active"
                    @click="$emit('contact')">
                    Contact
                </button>
                <button
                    :class="{active : inBookmarks}"
                    class="btn btn-bookmark btn-scale-active"
                    @click.prevent="bookmark">
                    <SvgVue icon="bookmark"/>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        id: Number,
        job_title: String,
        avatar: String,
        name: String,
        location: String,
        updated_at: String,
        employment: String,
        sectors: Array,

        isCompleted: {
            type: Boolean,
            default: false
        },
        inBookmarks: {
            type: Boolean,
            default: false
        },
    },
    computed: {
        link() {
            return this.route('volunteers.show', this.id)
        },
    },
    methods: {
        async bookmark() {
            const {
                status,
                data: {message, inBookmarks}
            } = await this.axios.post(this.route('volunteers.actions.bookmark', this.id))
            if (status === 200) {
                this.$emit('update:bookmarked', inBookmarks)
                this.notify(message)
            }
        }
    }
}
</script>
