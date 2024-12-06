<?php 
if (!defined('ABSPATH')) exit;
function NijikaTheme() {
    add_submenu_page(
        'themes.php', // 父菜单页面（这里是主题页面）
        'Nijika Theme', // 页面标题
        'Nijika 设置', // 菜单标题
        'manage_options', // 权限要求
        'NijikaTheme', // 菜单页面标识符
        'NijikaTheme_Settings_Page' // 处理页面显示的回调函数
    );

    // 注册设置字段
    // SEO设置
    register_setting(
        'NijikaOptions', // 设置组
        'NijikaOptions_SEO_Key',
        'nijika_validate_seo_key' // 使用特定的验证函数
    );
    register_setting(
        'NijikaOptions', // 设置组
        'NijikaOptions_SEO_Des',
        'nijika_validate_seo_des' // 使用特定的验证函数
    );

    // ICP备案号
    register_setting(
        'NijikaOptions', // 设置组
        'NijikaOptions_ICP',
        'NijikaOptions_icp' // 使用特定的验证函数
    );

    // 单选框 头像源
    register_setting(
        'NijikaOptions', // 设置组
        'NijikaOptions_Avatar',
        'nijika_validate_code_load' // 使用特定的验证函数
    );

    // 多选框 增强功能
    register_setting(
        'NijikaOptions', // 设置组
        'NijikaOptions_Functions',
        'nijika_validate_code_load' // 使用特定的验证函数
    );
    
    // 初始化 NijikaOptions_Functions 为数组
    $code_load = get_option('NijikaOptions_Functions');
    if (!is_array($code_load)) {
        update_option('NijikaOptions_Functions', []);
    }
}
add_action('admin_menu', 'NijikaTheme');

function NijikaTheme_Settings_Page() {
?>
<script>
    setTimeout(function() {
        mdui.snackbar({
            message: '感谢使用Nijika Theme！',
            position: 'bottom',
        });
    }, 1145);
</script>
<style>
    body {
        background-color: #eee !important;
    }

    body .mdui-list-item-avatar {
        background-color: transparent;
    }
</style>
<link rel="stylesheet" href="<?php echo Get::AssetsUrl(); ?>/style.css">
<link rel="stylesheet" href="<?php echo Get::AssetsUrl(); ?>/mdui/css/mdui.min.css">
<script src="<?php echo Get::AssetsUrl(); ?>/mdui/js/mdui.min.js"></script>
<script src="<?php echo Get::AssetsUrl(); ?>/vue.min.js"></script>
<div class="mdui-container" id="Nijika">
    <div class="mdui-card mdui-card-content" style="margin-top: 50px;">
        <div class="mdui-card-primary-title"><i class="mdui-icon material-icons" style="font-size: 28px;color: #c60000;">favorite</i>Nijika Theme</div>
        <div class="mdui-card-actions mdui-card-primary-subtitle">
            作者：<a :href="Author.Bilibili">{{ Author.Name }}</a>丨忘れてやらない
        </div>
        <div class="mdui-divider"></div>
        <div class="mdui-tab mdui-tab-full-width" mdui-tab>
            <a href="#基础" class="mdui-ripple">{{ tab1 }}</a>
            <a href="#推荐" class="mdui-ripple">{{ tab2 }}</a>
        </div>
        <div class="mdui-divider"></div>
        <form method="post" action="options.php">
            <?php 
                    settings_fields('NijikaOptions'); 
                    do_settings_sections('NijikaOptions');
                ?>
            <form method="post" action="options.php">
                <?php 
                    settings_fields('NijikaOptions'); 
                    do_settings_sections('NijikaOptions');
                ?>
            <div id="基础">
                <table class="form-table">
                    <div class="mdui-textfield">
                        <label>SEO设置</label>
                        <label class="mdui-textfield-label">网站关键词(Keywords)</label>
                        <input class="mdui-textfield-input" type="text" name="NijikaOptions_SEO_Key" placeholder="木柜子,乐队" value="<?php echo esc_attr(Get::Options('NijikaOptions_SEO_Key', '')); ?>" />
                    </div>
                    <div class="mdui-textfield">
                        <label class="mdui-textfield-label">网站描述(Description)</label>
                        <textarea name="NijikaOptions_SEO_Des" class="mdui-textfield-input" rows="4" placeholder="Nijika Theme"><?php echo esc_textarea(Get::Options('NijikaOptions_SEO_Des', '')); ?></textarea>
                    </div>

                    <div class="mdui-textfield">
                        <label>备案号</label>
                        <input class="mdui-textfield-input" type="text" name="NijikaOptions_ICP" placeholder="沪ICP备13002172号-3" value="<?php echo esc_attr(Get::Options('NijikaOptions_ICP', '')); ?>" />
                    </div>

                    <div class="mdui-textfield">
                        <label>头像源</label>
                        <div class="mdui-row-md-4">
                            <div class="mdui-col">
                                <label class="mdui-radio">
                                    <input type="radio" name="NijikaOptions_Avatar" value="1" <?php checked(Get::Options('NijikaOptions_Avatar', 'default'), '1'); ?> checked />
                                    <i class="mdui-radio-icon"></i>
                                    CrAvatar
                                </label>
                            </div>
                            <div class="mdui-col">
                                <label class="mdui-radio">
                                    <input type="radio" name="NijikaOptions_Avatar" value="2" <?php checked(Get::Options('NijikaOptions_Avatar',), '2'); ?> />
                                    <i class="mdui-radio-icon"></i>
                                    WeAvatar
                                </label>
                            </div>
                            <div class="mdui-col">
                                <label class="mdui-radio">
                                    <input type="radio" name="NijikaOptions_Avatar" value="3" <?php checked(Get::Options('NijikaOptions_Avatar',), '3'); ?> />
                                    <i class="mdui-radio-icon"></i>
                                    GrAvatar(镜像源)
                                </label>
                            </div>
                            <div class="mdui-col">
                                <label class="mdui-radio">
                                    <input type="radio" name="NijikaOptions_Avatar" value="4" <?php checked(Get::Options('NijikaOptions_Avatar',), '4'); ?> />
                                    <i class="mdui-radio-icon"></i>
                                    GrAvatar(官方源)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mdui-textfield">
                        <label>增强功能</label>
                        <div class="mdui-row-md-4">
                            <div class="mdui-col">
                                <label class="mdui-checkbox">
                                    <input type="checkbox" name="NijikaOptions_Functions[]" value="1" <?php checked(in_array('1', Get::Options('NijikaOptions_Functions', [])), true); ?> />
                                    <i class="mdui-checkbox-icon"></i>
                                    禁止缩略图
                                </label>
                            </div>
                            <div class="mdui-col">
                                <label class="mdui-checkbox">
                                    <input type="checkbox" name="NijikaOptions_Functions[]" value="2" <?php checked(in_array('2', Get::Options('NijikaOptions_Functions', [])), true); ?> />
                                    <i class="mdui-checkbox-icon"></i>
                                    禁用文章修订/自动保存
                                </label>
                            </div>
                            <div class="mdui-col">
                                <label class="mdui-checkbox">
                                    <input type="checkbox" name="NijikaOptions_Functions[]" value="3" <?php checked(in_array('3', Get::Options('NijikaOptions_Functions', [])), true); ?> />
                                    <i class="mdui-checkbox-icon"></i>
                                    禁用emoji's
                                </label>
                            </div>
                            <div class="mdui-col">
                                <label class="mdui-checkbox">
                                    <input type="checkbox" name="NijikaOptions_Functions[]" value="4" <?php checked(in_array('4', Get::Options('NijikaOptions_Functions', [])), true); ?> />
                                    <i class="mdui-checkbox-icon"></i>
                                    净化WordPress
                                </label>
                            </div>
                        </div>
                </table>
                    <button type="submit" id="submit" class="submit mdui-float-right mdui-btn mdui-btn-raised mdui-ripple mdui-color-blue-grey" style="border-radius: 8px;">保存设置</button>
            </form>
            </div>
            <div id="推荐">
                <ul class="mdui-list mdui-col-xs-12">
                    <a :href="Site.Url1" target="_blank">
                        <li class="mdui-list-item mdui-ripple mdui-col-xs-6">
                            <div class="mdui-list-item-avatar">
                                <img :src="Site.Icon1" />
                            </div>
                            <div class="mdui-list-item-content">{{ Site.Title1 }}</div>
                            <i class="mdui-list-item-icon mdui-icon material-icons">favorite</i>
                        </li>
                    </a>
                    <a :href="Site.Url2" target="_blank">
                        <li class="mdui-list-item mdui-ripple mdui-col-xs-6">
                            <div class="mdui-list-item-avatar">
                                <img :src="Site.Icon2" />
                            </div>
                            <div class="mdui-list-item-content">{{ Site.Title2 }}</div>
                            <i class="mdui-list-item-icon mdui-icon material-icons">favorite</i>
                        </li>
                    </a>
                    <a :href="Site.Url3" target="_blank">
                        <li class="mdui-list-item mdui-ripple mdui-col-xs-6">
                            <div class="mdui-list-item-avatar">
                                <img :src="Site.Icon3" />
                            </div>
                            <div class="mdui-list-item-content">{{ Site.Title3 }}</div>
                            <i class="mdui-list-item-icon mdui-icon material-icons">favorite_border</i>
                        </li>
                    </a>
                    <a :href="Site.Url4" target="_blank">
                        <li class="mdui-list-item mdui-ripple mdui-col-xs-6">
                            <div class="mdui-list-item-avatar">
                            <i class="mdui-list-item-icon mdui-icon material-icons" style="font-size: 30px;height: 30px;">cloud</i>
                            </div>
                            <div class="mdui-list-item-content">{{ Site.Title4 }}</div>
                            <i class="mdui-list-item-icon mdui-icon material-icons">favorite_border</i>
                        </li>
                    </a>
                </ul>
            </div>
    </div>
    <script>
        new Vue({
            el: '#Nijika',
            data: {
                tab1: '基本设置',
                tab2: '其他推荐',
                Site: {
                    Url1: 'https://www.zibll.com/?ref=26762',
                    Title1: '子比主题优惠购买',
                    Icon1: 'https://oss.zibll.com/zibll.com/2020/03/favicon-1.png',
                    Url2: 'https://www.scbkw.com/?ref=153',
                    Title2: '苏晨博客网',
                    Icon2: 'https://www.scbkw.com/wp-content/uploads/2024/05/20240516160919306.png',
                    Url3: 'https://www.zbtool.cn/?ref=13',
                    Title3: '子比插件商城',
                    Icon3: 'https://www.zbtool.cn/wp-content/uploads/2024/08/favicon.png',
                    Url4: 'https://cloud.zheanyun.com/',
                    Title4: '低价高配服务器购买',
                    Icon4: 'https://cloud.zheanyun.com/themes/web/www/upload/local66667fbfa96d9.png',
                },
                Author: {
                    Name: '鼠子(Tomoriゞ)',
                    Blog: 'https://blog.miomoe.cn/',
                    Bilibili: 'https://space.bilibili.com/435502585',
                }
            },
            methods: {
                getSiteTitle: function(index) {
                    return this.Site['Title' + index]; // 根据索引获取标题
                },
                getSiteUrl: function(index) {
                    return this.Site['Url' + index]; // 根据索引获取链接
                },
                getSiteIcon: function(index) {
                    return this.Site['Icon' + index]; // 根据索引获取图标
                },
            }
        })
    </script>
    <?php
}