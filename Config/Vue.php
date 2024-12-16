<?php
if (!defined('ABSPATH')) exit;

function add_vue_scripts() {
    wp_enqueue_script('vue-js', Get::AssetsUrl() . '/vue.min.js', array(), null, true);
    wp_enqueue_script('app-js', Get::AssetsUrl() . '/app.js', array('vue-js'), null, true);
}
add_action('wp_enqueue_scripts', 'add_vue_scripts');

function pass_posts_to_vue() {
    // 获取每页显示的文章数量
    $posts_per_page = get_option('posts_per_page', 10); // 默认值为10

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $posts_per_page,
        'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
    );

    if (is_home() || is_front_page()) {
        // 首页显示最新文章
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    } elseif (is_category()) {
        // 分类归档页面显示特定分类的文章
        $current_cat = get_queried_object();
        $cat_id = isset($current_cat->term_id) ? $current_cat->term_id : null;
        if (!is_null($cat_id)) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $cat_id,
                ),
            );
        }
    } elseif (is_tag()) {
        // 标签归档页面显示特定标签的文章
        $current_tag = get_queried_object();
        $tag_id = isset($current_tag->term_id) ? $current_tag->term_id : null;
        if (!is_null($tag_id)) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'post_tag',
                    'field'    => 'term_id',
                    'terms'    => $tag_id,
                ),
            );
        }
    }

    $query = new WP_Query($args);
    $posts = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $categories = get_the_category();
            $categories_data = array();
            foreach ($categories as $category) {
                $categories_data[] = array(
                    'id' => $category->term_id,
                    'name' => $category->name,
                    'url' => get_category_link($category->term_id),
                );
            }

            $tags = get_the_tags();
            $tags_data = array();
            if ($tags) {
                foreach ($tags as $tag) {
                    $tags_data[] = array(
                        'id' => $tag->term_id,
                        'name' => $tag->name,
                        'url' => get_tag_link($tag->term_id),
                    );
                }
            }

            $posts[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'date' => get_the_time('Y/m/d'),
                'content' => get_the_content(),
                'excerpt' => get_the_excerpt(),
                'permalink' => get_the_permalink(),
                'categories' => $categories_data,
                'tags' => $tags_data,
            );
        }
    }
    wp_reset_postdata();

    wp_localize_script('vue-js', 'vueData', array(
        'posts' => $posts,
        'SiteUrl' => home_url(),
        'SiteTitle' => get_bloginfo('name'),
        'currentPage' => $args['paged'],
        'totalPages' => $query->max_num_pages,
        'prevPageLink' => get_previous_posts_page_link(),
        'nextPageLink' => get_next_posts_page_link(),
    ));

    // 添加标识符以便在 PJAX 加载完成后调用
    echo '<script type="text/javascript">window.vueDataLoaded = true;</script>';
}
add_action('wp_enqueue_scripts', 'pass_posts_to_vue');