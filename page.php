<?php 
if (!defined('ABSPATH')) exit;
get_header(); 
?>

<div id="Page">
    <div class="mdui-card mdui-m-b-2">
        <div class="mdui-card-primary">
            <div class="mdui-card-primary-title">{{ page.title }}</div>
            <div class="mdui-card-primary-subtitle">{{ page.date }}</div>
            <div class="mdui-card-content mdui-typo" id="PostContent" v-html="page.content"></div>
        </div>
    </div>
</div>

<script>
function initializeVue() {
    new Vue({
        el: '#Page',
        data: {
            page: {
                title: '<?php echo esc_js(get_the_title()); ?>',
                content: `<?php echo wp_kses_post(get_the_content()); ?>`,
                date: '<?php echo esc_js(get_the_time('Y/m/d')); ?>',
            }
        }
    });
}

document.addEventListener('DOMContentLoaded', initializeVue);
</script>

<?php 
get_footer(); 
?>
