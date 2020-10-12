<template>
    <div :class="{'completed-account' : isCompleted}" class="card-work card-work-vacancy">
        <div v-if="isLogoAndName" class="card-work-company">
            <div class="card-work-company-name">Approved Cash Advance</div>
            <img alt="" class="card-work-company-logo" src="dist/img/logo-company.jpg">
        </div>
        <div class="card-work-title">General Manager</div>
        <div class="card-work-info">
            <div class="card-work-place">Torrance, CA</div>
            <span class="vertical-divider"></span>
            <div class="card-work-posted flex-shrink-0">Posted 4 days ago</div>
        </div>
        <div class="card-work-time">Permanent, full-time</div>
        <div v-if="isDescription" class="card-work-text">
            ManagementCome Join Panera Bread! - an award winning leader in the restaurant industry. We are a top
            franchise group with great growth potential, looking for excellent people to join our team!
            <a class="link link-border semi-bold-weight" href="">See more</a>
        </div>
        <div v-if="isActions" class="card-work-actions justify-content-end">
            <a :class="{'was-apply disabled' : isApply}" class="btn btn-outline-violet min-width-100" href=""> Apply</a>
            <button :class="{'active' : isBookmark}" class="btn btn-bookmark btn-scale-active"
                    @click="isBookmark = !isBookmark">
                <svg-vue icon="bookmark"></svg-vue>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        //если заполнен профиль или чет такое- помнишь боковой бордер
        isCompleted: {
            type: Boolean,
            default: false
        },
        isBookmark: {
            type: Boolean,
            default: false
        },
        //есть карточки где не надо описания
        isDescription: {
            type: Boolean,
            default: true
        },
        //есть карточки где не надо кнопок
        isActions: {
            type: Boolean,
            default: true
        },
        //есть карточки где не надо лого и имени компании
        isLogoAndName: {
            type: Boolean,
            default: true
        },
        //когда был аплай
        isApply: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            isActive: false,
        }
    }
}
</script>
