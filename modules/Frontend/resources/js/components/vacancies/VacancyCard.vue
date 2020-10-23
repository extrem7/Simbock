<template>
    <div :class="{'completed-account' : isCompleted}" class="card-work card-work-vacancy">
        <div v-if="hasLogoAndName" class="card-work-company">
            <div class="card-work-company-name">{{ company_title }}</div>
            <img :alt="company_title" :src="company.logo" class="card-work-company-logo">
        </div>
        <div class="card-work-title">{{ title }}</div>
        <div class="card-work-info">
            <div class="card-work-place">{{ location }}</div>
            <span class="vertical-divider"></span>
            <div class="card-work-posted flex-shrink-0">{{ date }}</div>
        </div>
        <div class="card-work-time">{{ employment }}</div>
        <div v-if="hasDescription" class="card-work-text">
            {{ excerpt }}
            <a :href="route('vacancies.show',this.id)" class="link link-border semi-bold-weight">See more</a>
        </div>
        <div v-if="hasActions" class="card-work-actions justify-content-end">
            <a :class="{'was-apply disabled' : isApply}" class="btn btn-outline-violet min-width-100" href="">Apply</a>
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
        id: Number,
        title: String,
        location: String,
        employment: String,
        date: String,
        excerpt: String,
        company: Object,
        company_title: String,

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
        hasDescription: {
            type: Boolean,
            default: true
        },
        //есть карточки где не надо кнопок
        hasActions: {
            type: Boolean,
            default: true
        },
        //есть карточки где не надо лого и имени компании
        hasLogoAndName: {
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
