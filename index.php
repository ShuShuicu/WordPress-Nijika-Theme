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

    <div class="mdui-m-y-1 mdui-valign mdui-card mdui-hoverable mdui-card-content">
        <a v-if="currentPage > 1" :href="prevPageLink" class="mdui-ripple mdui-btn mdui-btn-icon mdui-color-theme" no-pjax><i class="material-icons mdui-icon ignore-translate">chevron_left</i></a>
        <span class="mdui-typo-body-1-opacity mdui-text-center" style="flex-grow: 1;">
            第 {{ currentPage }} 页 / 共 {{ totalPages }} 页
        </span> 
        <a v-if="currentPage < totalPages" :href="nextPageLink" class="mdui-ripple mdui-btn mdui-btn-icon mdui-color-theme" no-pjax><i class="material-icons mdui-icon ignore-translate">chevron_right</i></a>
    </div>

</div>

<script>
function initializeVue() {
    new Vue({
        el: '#Index',
        data: {
            posts: vueData.posts || [],
            currentPage: vueData.currentPage || 1,
            totalPages: vueData.totalPages || 1,
            prevPageLink: vueData.prevPageLink || '#',
            nextPageLink: vueData.nextPageLink || '#'
        }
    });
}

document.addEventListener('DOMContentLoaded', initializeVue);
</script>

<?php get_footer(); ?>