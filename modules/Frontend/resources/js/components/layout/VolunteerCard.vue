<template>
    <div :class="{'completed-account' : isCompleted}" class="card-work card-work-volunteer">
        <div class="card-work-profile">
            <div class="profile-avatar"><img alt="" class="profile-avatar-img" src="dist/img/ava.jpg"></div>
            <div>
                <div class="card-work-post">Manager</div>
                <div class="card-work-title">Alex Zastavnyj</div>
                <div class="card-work-info">
                    <div class="card-work-place">Torrance, CA</div>
                    <span class="vertical-divider"></span>
                    <div class="card-work-posted">Posted 4 days ago</div>
                </div>
            </div>
        </div>
        <div class="card-work-time">Permanent, full-time</div>
        <div class="card-work-text">
            Media, Digital & Creative
        </div>
        <div class="card-work-actions justify-content-between">
            <a class="link link-border semi-bold-weight mr-3" href="">See more</a>
            <div>
                <button v-b-modal.modal-contact class="btn btn-outline-violet min-width-100 btn-scale-active" href="">
                    Contact
                </button>
                <button :class="{'active' : isBookmark}" class="btn btn-bookmark btn-scale-active"
                        @click="isBookmark = !isBookmark">
                    <svg-vue icon="bookmark"></svg-vue>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isCompleted: {
            type: Boolean,
            default: false
        },
        isBookmark: {
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
            isActive: false,
        }
    }
}
</script>
