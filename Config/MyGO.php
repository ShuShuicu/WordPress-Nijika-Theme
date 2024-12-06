<?php 
if (!defined('ABSPATH')) exit;
// 显示页面查询次数、加载时间和内存占用
function performance( $visible = false ) {
    $stat = sprintf(  '%d 次查询 %.3f 秒, %.2fMB 内存',
        get_num_queries(),
        timer_stop( 0, 3 ),
        memory_get_peak_usage() / 1024 / 1024
    );
    echo $visible ? $stat : "<!-- {$stat} -->" ;
}
add_action( 'wp_footer', 'performance', 20 );

// 获取加载时间
function get_load_time() {
    return timer_stop( 0, 3 );
}

// 替换Gravatar头像为指定源的头像
function replace_gravatar_url( $url, $source ) {
    $sources = array(
        'www.gravatar.com',
        '0.gravatar.com',
        '1.gravatar.com',
        '2.gravatar.com',
        'secure.gravatar.com',
        'cn.gravatar.com'
    );
    return str_replace( $sources, $source, $url );
}

// 主题自定义设置
function load_custom_code_based_on_option() {
    $avatar_source = get_option('NijikaOptions_Avatar', 'default');

    switch ($avatar_source) {
        case '1':
            add_filter( 'um_user_avatar_url_filter', function($url) { return replace_gravatar_url($url, 'cravatar.cn'); }, 1 );
            add_filter( 'bp_gravatar_url', function($url) { return replace_gravatar_url($url, 'cravatar.cn'); }, 1 );
            add_filter( 'get_avatar_url', function($url) { return replace_gravatar_url($url, 'cravatar.cn'); }, 1 );
            break;
        case '2':
            add_filter( 'um_user_avatar_url_filter', function($url) { return replace_gravatar_url($url, 'weavatar.com'); }, 1 );
            add_filter( 'bp_gravatar_url', function($url) { return replace_gravatar_url($url, 'weavatar.com'); }, 1 );
            add_filter( 'get_avatar_url', function($url) { return replace_gravatar_url($url, 'weavatar.com'); }, 1 );
            break;
        case '3':
            add_filter( 'um_user_avatar_url_filter', function($url) { return replace_gravatar_url($url, 'api.x-x.work/get/Avatar?WPGravatar='); }, 1 );
            add_filter( 'bp_gravatar_url', function($url) { return replace_gravatar_url($url, 'api.x-x.work/get/Avatar?WPGravatar='); }, 1 );
            add_filter( 'get_avatar_url', function($url) { return replace_gravatar_url($url, 'api.x-x.work/get/Avatar?WPGravatar='); }, 1 );
            break;
        case '4':
            // 默认Gravatar
            break;
    }
}
add_action('after_setup_theme', 'load_custom_code_based_on_option');

// 增强功能
function load_selected_features() {
    $selected_features = get_option('NijikaOptions_Functions', []);

    // 确保 $selected_features 是一个数组
    if (!is_array($selected_features)) {
        $selected_features = [];
    }

    error_log(print_r($selected_features, true)); // 调试输出

    if (in_array('1', $selected_features)) {
        // 禁止缩略图
        add_filter('intermediate_image_sizes_advanced', function($sizes) {
            unset($sizes['thumbnail']);
            unset($sizes['medium']);
            unset($sizes['medium_large']);
            unset($sizes['large']);
            unset($sizes['full']);
            unset($sizes['1536x1536']);
            unset($sizes['2048x2048']);
            return $sizes;
        });
    }

    if (in_array('2', $selected_features)) {
        // 禁用文章修订
        add_filter('wp_revisions_to_keep', function($num, $post) {
            return 0;
        }, 10, 2);
        // 禁用文章自动保存
        add_action('wp_print_scripts', function() {
            wp_deregister_script('autosave');
        });
    }

    if (in_array('3', $selected_features)) {
        // 禁用 emoji's
        function disable_emojis() {
            remove_action('wp_head', 'print_emoji_detection_script', 7);
            remove_action('admin_print_scripts', 'print_emoji_detection_script');
            remove_action('wp_print_styles', 'print_emoji_styles');
            remove_action('admin_print_styles', 'print_emoji_styles');
            remove_filter('the_content_feed', 'wp_staticize_emoji');
            remove_filter('comment_text_rss', 'wp_staticize_emoji');
            remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
            add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
        }
        add_action('init', 'disable_emojis');
        // 用于删除tinymce插件的emoji
        function disable_emojis_tinymce($plugins) {
            if (is_array($plugins)) {
                return array_diff($plugins, ['wpemoji']);
            } else {
                return [];
            }
        }
    }

    if (in_array('4', $selected_features)) {
        // 净化WordPress
        remove_action('wp_head', 'wp_generator'); // 移除WordPress版本
        remove_filter('comment_text', 'make_clickable', 9); // 移除wordpress留言中自动链接功能
        remove_action('wp_head', 'rsd_link'); // 移除离线编辑器开放接口
        remove_action('wp_head', 'index_rel_link'); // 去除本页唯一链接信息
        remove_action('wp_head', 'wlwmanifest_link'); // 移除离线编辑器开放接口
        remove_filter('the_content', 'wptexturize'); // 禁止代码标点符合转义
        add_filter('show_admin_bar', '__return_false'); // 彻底移除管理员工具条
    }
}
add_action('init', 'load_selected_features');
