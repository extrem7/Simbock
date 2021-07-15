<template>
    <article class="article-item col-md-6 col-xl-4">
        <div class="article-item-header">
            <a :href="link"><img v-lazy="thumbnail" alt="" class="article-item-image"></a>
            <h2>
                <a :href="link"
                   class="article-item-title title large-size line-cap semi-bold-weight">{{ title }}</a>
            </h2>
        </div>
        <div class="article-item-body line-cap">{{ excerpt }}</div>
        <a :href="link" class="link link-border semi-bold-weight">See more</a>
    </article>
</template>

<script>
export default {
    props: {
        id: Number,
        title: String,
        excerpt: String,
        thumbnail: String,
        link: String
    }
}
</script>
