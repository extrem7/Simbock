<template>
    <main class="container content-inner">
        <TransitionGroup :style="{ '--total': articles.length }"
                         appear
                         class="row"
                         name="blog"
                         tag="div">
            <TheArticle v-for="article in articles"
                        :key="article.id"
                        v-bind="article"/>
        </TransitionGroup>
        <div v-if="page!==lastPage" class="text-center">
            <button class="btn btn-outline-violet violet-color medium-weight btn-load-more btn-scale-active"
                    @click="loadMore">
                Load More News
                <svg-vue icon="arrow-down"></svg-vue>
            </button>
        </div>
    </main>
</template>

<script>
import TheArticle from "./TheArticle"

export default {
    components: {
        TheArticle
    },
    data() {
        return {
            articles: this.shared('articles').data || [],
            page: this.shared('articles').currentPage,
            lastPage: this.shared('articles').lastPage || 1,
            opacity: 1
        }
    },
    methods: {
        async loadMore() {
            if (this.page < this.lastPage) {
                this.page += 1
                try {
                    const {data} = await this.axios.get(`?page=${this.page}`)
                    this.articles = this.articles.concat(data.data)
                } catch (e) {
                    console.log(e)
                }
            }
        }
    },
}
</script>

<style lang="scss" scoped>
.blog-enter-active, .blog-leave-active {
    transition: all 1s;
}

.blog-enter, .blog-leave-to {
    opacity: 0;
}
</style>
