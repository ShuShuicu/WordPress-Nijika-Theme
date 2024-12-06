<?php
if (!defined('ABSPATH')) exit;
?>
<div id="sidebar">
    <div class="mdui-col-xl-3 mdui-col-lg-3 mdui-col-md-3 mdui-col-sm-12 mdui-col-xs-12">

        <div class="mdui-card mdui-hoverable mdui-card-content mdui-m-b-2">
            <form method="get" action="<?php echo Get::HomeUrl('/'); ?>">
                <div class="mdui-textfield">
                    <i class="mdui-icon material-icons">search</i>
                    <input class="mdui-textfield-input" type="text" name="s" class="text" size="32" placeholder="输入关键词..." />
                </div>
            </form>
        </div>

        <div class="mdui-card mdui-hoverable mdui-m-b-2">
            <ul class="mdui-list">
                <?php
                // 获取菜单项
                $menu_name = 'sidebar-menu';
                $locations = get_nav_menu_locations();
                if (isset($locations[$menu_name])) {
                    $menu = wp_get_nav_menu_object($locations[$menu_name]);
                    $menu_items = wp_get_nav_menu_items($menu->term_id);
                } else {
                    $menu_items = array();
                }

                // 检查菜单项是否为空
                if (!empty($menu_items)) {
                    // 显示菜单
                    wp_nav_menu(array(
                        'theme_location' => $menu_name,
                        'container' => false,
                        'items_wrap' => '%3$s',
                        'walker' => new Custom_Walker_Nav_Menu() // 使用自定义的 Walker_Nav_Menu 类
                    ));
                } else {
                    // 显示首页链接
                    ?>
                    <a href="<?php echo Get::HomeUrl('/'); ?>">
                        <li class="mdui-list-item mdui-ripple">
                            <i class="mdui-list-item-icon mdui-icon material-icons">home</i>
                            <div class="mdui-list-item-content">首页</div>
                        </li>
                    </a>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>