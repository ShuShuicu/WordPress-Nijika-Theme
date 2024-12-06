<?php 
if (!defined('ABSPATH')) exit;

// 注册小工具
function register_my_widgets() {
    register_widget( 'Nijika_Widget' );
}
// 注册菜单栏
function register_my_menus() {
    register_nav_menus(
        array(
            'sidebar-menu' => __( '侧边导航栏' ),
        )
    );
}
add_action( 'init', 'register_my_menus' ); // 确保注册菜单的动作被添加

// 添加自定义字段到菜单编辑器
function add_custom_nav_fields( $item_id, $item, $depth, $args ) {
    wp_nonce_field( basename(__FILE__), 'custom_nav_fields_nonce_name' );
    $icon_value = get_post_meta( $item_id, '_menu_icon', true );
    $new_window = get_post_meta( $item_id, '_menu_new_window', true );
    ?>
    <p class="field-icon description description-wide">
        <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
            <?php _e( '图标:', 'textdomain' ); ?>
            <br />
            <input type="text" name="menu-item-icon[<?php echo $item_id; ?>]" id="edit-menu-item-icon-<?php echo $item_id; ?>" value="<?php echo esc_attr( $icon_value ); ?>" class="widefat code edit-menu-item-custom" />
            <p>自定义显示图标，使用MDUI的图标组件：<a href="https://www.mdui.org/docs/material_icon" target="_blank">https://www.mdui.org/docs/material_icon</a></p>
        </label>
    </p>
    <p class="field-new-window description description-wide">
        <label for="edit-menu-item-new-window-<?php echo $item_id; ?>">
            <input type="checkbox" id="edit-menu-item-new-window-<?php echo $item_id; ?>" name="menu-item-new-window[<?php echo $item_id; ?>]" value="1" <?php checked( $new_window, '1' ); ?>>
            <?php _e( '新窗口打开', 'textdomain' ); ?>
        </label>
    </p>
    <?php
}
add_action( 'wp_nav_menu_item_custom_fields', 'add_custom_nav_fields', 10, 4 );

// 保存自定义字段
function save_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {
    if ( ! isset( $_POST['custom_nav_fields_nonce_name'] ) || ! wp_verify_nonce( $_POST['custom_nav_fields_nonce_name'], basename(__FILE__) ) ) {
        return $menu_item_db_id;
    }

    if ( isset( $_POST['menu-item-icon'][$menu_item_db_id] ) ) {
        $icon_value = sanitize_text_field( $_POST['menu-item-icon'][$menu_item_db_id] );
        update_post_meta( $menu_item_db_id, '_menu_icon', $icon_value );
    } else {
        delete_post_meta( $menu_item_db_id, '_menu_icon' );
    }

    if ( isset( $_POST['menu-item-new-window'][$menu_item_db_id] ) ) {
        update_post_meta( $menu_item_db_id, '_menu_new_window', '1' );
    } else {
        delete_post_meta( $menu_item_db_id, '_menu_new_window' );
    }
}
add_action( 'wp_update_nav_menu_item', 'save_custom_nav_fields', 10, 3 );

// 自定义 Walker_Nav_Menu 类
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $icon_value = get_post_meta( $item->ID, '_menu_icon', true );
        $new_window = get_post_meta( $item->ID, '_menu_new_window', true );
        $target = $new_window ? ' target="_blank"' : '';

        $output .= '<a href="' . esc_url( $item->url ) . '"' . $target . '>';
        $output .= '<li class="mdui-list-item mdui-ripple">';
        if ( ! empty( $icon_value ) ) {
            $output .= '<i class="mdui-list-item-icon mdui-icon material-icons">' . esc_html( $icon_value ) . '</i>';
        }
        $output .= '<div class="mdui-list-item-content">' . esc_html( $item->title ) . '</div>';
        $output .= '</li>';
        $output .= '</a>';
    }
}

function left_admin_footer_text($text) {
    // 左边信息
    $text = '<span id="footer-thankyou">感谢使用 <a href="https://cn.wordpress.org/">WordPress</a> & Nijika 进行创作。</span>'; 
    return $text;
}
add_filter('admin_footer_text', 'left_admin_footer_text'); 

// 修改自Hello Dolly插件
function hello_dolly_get_lyric() {
	/** These are the lyrics to Hello Dolly */
$lyrics = "重要的，珍惜的，一直在身边，一旦成为理所当然，就难以发现。
如果你说最喜欢 我会回你最最喜欢
重要的…珍视的东西总是伴随在身边， 却当成理所当然没有察觉。​
大家都好厉害啊，不要扔下我自己长大哦?
但是我遇到了 那美丽的天使 毕业不是终点 以后我们还是朋友。
无论走到哪里，我们都是放课后茶会！
就算相隔两地，我们看到的仍是同一片天空。
但是我遇到了 那美丽的天使 毕业不是终点 以后我们还是朋友 你说“最喜欢你”， 我回一句“最最喜欢你” 不要留下遗憾， 永远都在一起哦…";

	// Here we split it into lines.
	$lyrics = explode( "\n", $lyrics );

	// And then randomly choose a line.
	return wptexturize( $lyrics[ mt_rand( 0, count( $lyrics ) - 1 ) ] );
}

// This just echoes the chosen line, we'll position it later.
function hello_dolly() {
	$chosen = hello_dolly_get_lyric();
	$lang   = '';
	if ( 'en_' !== substr( get_user_locale(), 0, 3 ) ) {
		$lang = ' lang="en"';
	}

	printf(
		'<p id="dolly"><span class="screen-reader-text">%s </span><span dir="ltr"%s>%s</span></p>',
		__( 'Quote from Hello Dolly song, by Jerry Herman:' ),
		$lang,
		$chosen
	);
}

// Now we set that function up to execute when the admin_notices action is called.
add_action( 'admin_notices', 'hello_dolly' );

// We need some CSS to position the paragraph.
function dolly_css() {
	echo "
	<style type='text/css'>
	#dolly {
		float: right;
		padding: 5px 10px;
		margin: 0;
		font-size: 12px;
		line-height: 1.6666;
	}
	.rtl #dolly {
		float: left;
	}
	.block-editor-page #dolly {
		display: none;
	}
	@media screen and (max-width: 782px) {
		#dolly,
		.rtl #dolly {
			float: none;
			padding-left: 0;
			padding-right: 0;
		}
	}
	</style>
	";
}

add_action( 'admin_head', 'dolly_css' );