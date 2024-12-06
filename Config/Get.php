<?php 
if (!defined('ABSPATH')) exit;
class Get {
    // 主页URL
    public function HomeUrl() {
        $HomeUrl = home_url();
        return $HomeUrl;
    }

    // 获取Title
    public function Title() {
        if (is_front_page()) {
            // 首页标题
            $site_name = get_bloginfo('name');
            $site_description = get_bloginfo('description');
            
            if (!empty($site_description)) {
                return $site_name . ' - ' . $site_description;
            } else {
                return $site_name;
            }
        } else {
            // 内页标题
            $page_title = get_the_title();
            $site_name = get_bloginfo('name');
            return $page_title . ' - ' . $site_name;
        }
    }

    // 主题Url
    public function ThemeUrl() {
        $ThemeUrl = get_template_directory_uri();
        return $ThemeUrl;
    }

    // 主题AssetsUrl
    public function AssetsUrl() {
        $AssetsUrl = get_template_directory_uri() . '/Assets';
        return $AssetsUrl;
    }

    // 主题版本
    public function ThemeVersion() {
        $ThemeVersion = wp_get_theme()->get('Version');
        return $ThemeVersion;
    }

    // 获取设置项
    public static function Options($option) {
        $optionValue = get_option($option);
        return $optionValue;
    }

    // 获取bloginfo
    public static function Info($info) {
        $Info = get_bloginfo($info);
        return $Info;
    }

    // 引用Src文件
    public static function Src($file) {
        require_once get_theme_file_path() . '\/Src/' . $file . '.php'; 
    }
}