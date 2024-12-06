<?php 
if (!defined('ABSPATH')) exit;
get_header(); 
?>

<div id="Index">
    <div v-for="post in posts" :key="post.id" class="mdui-card mdui-hoverable mdui-m-b-2">
        <div class="mdui-card-primary">
            <a :href="post.permalink">
                <div class="mdui-card-primary-title">{{ post.title }}</div>
            </a>
            <div class="mdui-card-primary-subtitle">{{ post.date }}</div>
            <div class="mdui-card-primary-subtitle">
                <span v-for="category in post.categories" :key="category.id" class="mdui-chip">
                    <a :href="category.url" class="mdui-chip-title" target="_blank">{{ category.name }}</a>
                </span>
                <span v-for="tag in post.tags" :key="tag.id" class="mdui-chip">
                    <a :href="tag.url" class="mdui-chip-title" target="_blank">{{ tag.name }}</a>
                </span>
            </div>
            <a :href="post.permalink">
                <div class="mdui-card-content" v-html="post.excerpt"></div>
            </a>
        </div>
    </div>
</div>

<script>
function initializeVue() {
    new Vue({
        el: '#Index',
        data: {
            posts: vueData.posts || []
        }
    });
}

document.addEventListener('DOMContentLoaded', initializeVue);
</script>

<?php get_footer(); ?>