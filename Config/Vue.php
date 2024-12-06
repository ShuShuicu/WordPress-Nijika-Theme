<?php
if (!defined('ABSPATH')) exit;

function add_vue_scripts() {
    wp_enqueue_script('vue-js', Get::AssetsUrl() . '/vue.min.js', array(), null, true);
    wp_enqueue_script('app-js', Get::AssetsUrl() . '/app.js', array('vue-js'), null, true);
}
add_action('wp_enqueue_scripts', 'add_vue_scripts');

function pass_posts_to_vue() {
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
    );
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
    ));
}
add_action('wp_enqueue_scripts', 'pass_posts_to_vue');