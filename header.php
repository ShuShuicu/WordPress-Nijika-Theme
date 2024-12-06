<?php 
if (!defined('ABSPATH')) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo Get::Title(); ?></title>
    <?php if (is_front_page()) : ?>
    <meta name="keywords" content="<?php echo esc_attr(get_option('NijikaOptions_SEO_Key', '')); ?>">
    <meta name="description" content="<?php echo esc_attr(get_option('NijikaOptions_SEO_Des', '')); ?>">
<?php elseif (is_single()) : ?>
    <?php
    $tags = get_the_tags();
    $categories = get_the_category();
    $keywords = array();

    if ($tags) {
        foreach ($tags as $tag) {
            $keywords[] = $tag->name;
        }
    }

    if ($categories) {
        foreach ($categories as $category) {
            $keywords[] = $category->name;
        }
    }
    ?>
    <meta name="keywords" content="<?php echo esc_attr(join(', ', $keywords)); ?>">
    <meta name="description" content="<?php echo esc_attr(get_the_excerpt()); ?>">
<?php endif; ?>
    <?php wp_head(); ?>
    <?php 
        $cssFiles = [
            'style',
            'code/BlackMac',
            'mdui/css/mdui.min',
            'nprogress/nprogress.min',
        ];
        foreach ($cssFiles as $css){
    ?>
    <link rel="stylesheet" href="<?php echo Get::AssetsUrl() . "/" . $css , '.css?ver=' . Get::ThemeVersion(); ?>">
    <?php }; ?>
</head>
<body <?php body_class('mdui-color-grey-200'); ?>>
    <div class="mdui-appbar-with-toolbar" id="app">
        <div class="mdui-container" id="content">
            <div class="mdui-col-xs-12">
                <div class="mdui-col-xl-9 mdui-col-lg-9 mdui-col-md-9 mdui-col-sm-12 mdui-col-xs-12">
                    