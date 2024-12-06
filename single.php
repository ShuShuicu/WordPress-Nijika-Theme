<?php 
if (!defined('ABSPATH')) exit;
get_header(); 
?>

<div id="Post">
    <div class="mdui-card mdui-m-b-2">
        <div class="mdui-card-primary">
            <div class="mdui-card-primary-title">{{ post.title }}</div>
            <div class="mdui-card-primary-subtitle">{{ post.date }}</div>
            <div class="mdui-card-primary-subtitle">
                <span v-for="category in post.categories" :key="category.id" class="mdui-chip">
                    <a :href="category.url" class="mdui-chip-title">{{ category.name }}</a>
                </span>
                <span v-for="tag in post.tags" :key="tag.id" class="mdui-chip">
                    <a :href="tag.url" class="mdui-chip-title">{{ tag.name }}</a>
                </span>
            </div>
            <div class="mdui-card-content" id="PostContent" v-html="post.content"></div>
        </div>
    </div>
</div>
<script>
function initializeVue() {
    new Vue({
        el: '#Post',
        data: {
            post: vueData.posts.find(post => post.id == <?php echo json_encode(get_the_ID()); ?>) || {}
        }
    });
}

document.addEventListener('DOMContentLoaded', initializeVue);
</script>

<?php 
get_footer(); 
?>