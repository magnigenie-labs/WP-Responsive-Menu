<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function wpr_optionsframework_option_name() {
	$wpr_optionsframework_settings = get_option( 'wpr_optionsframework' );
	$wpr_optionsframework_settings['id'] = 'wprmenu_options';
	update_option( 'wpr_optionsframework', $wpr_optionsframework_settings );
}
add_action( 'wpr_optionsframework_after', 'wpr_support_link' );

function wpr_support_link() { 
	$options = get_option( 'wprmenu_options' );
	if( !empty($options['wpr_live_preview']) && $options['wpr_live_preview'] == 1 ) : ?>
	<div class="queries-holder live-preview">	
		<div class="wpr-mobile-view">
			<iframe scrolling="no" src="<?php echo get_site_url(); ?>"></iframe>
		</div>
	</div>
	<?php endif; ?>	

	<div class="queries-holder">
		<a href="http://magnigenie.com/downloads/wp-responsive-menu-pro/" target="_blank">
			<img src="<?php echo WPR_OPTIONS_FRAMEWORK_DIRECTORY;?>/images/pro.jpg" alt="pro">
		</a>
		<a href="https://wordpress.org/support/plugin/wp-responsive-menu/reviews/" target="_blank">
			<img src="<?php echo WPR_OPTIONS_FRAMEWORK_DIRECTORY;?>/images/review.jpg" alt="review">
		</a>
		<a href="http://magnigenie.com/support/queries/wp-responsive-menu/" target="_blank">
			<img src="<?php echo WPR_OPTIONS_FRAMEWORK_DIRECTORY;?>/images/support.jpg" alt="support">
		</a>
	</div>
	<?php
}

add_filter( 'wpr_optionsframework_menu', 'wpr_add_responsive_menu' );

function wpr_add_responsive_menu( $menu ) {
	$menu['page_title']  = 'WP Responsive Menu';
	$menu['menu_title']  = 'WPR Menu';
	$menu['mode']		 = 'menu';
	$menu['menu_slug']   = 'wp-responsive-menu';
	$menu['position']    = '200';
	return $menu;
}

function woocommerce_installed() {
	if (  class_exists( 'woocommerce' ) ) {
			return true;
		}
	}

function get_google_fonts() {
	$fonts = array(
		"Arial, Helvetica, sans-serif"                         => "Arial, Helvetica, sans-serif",
		"'Arial Black', Gadget, sans-serif"                    => "'Arial Black', Gadget, sans-serif",
		"'Bookman Old Style', serif"                           => "'Bookman Old Style', serif",
		"'Comic Sans MS', cursive"                             => "'Comic Sans MS', cursive",
		"Courier, monospace"                                   => "Courier, monospace",
		"Garamond, serif"                                      => "Garamond, serif",
		"Georgia, serif"                                       => "Georgia, serif",
		"Impact, Charcoal, sans-serif"                         => "Impact, Charcoal, sans-serif",
		"'Lucida Console', Monaco, monospace"                  => "'Lucida Console', Monaco, monospace",
		"'Lucida Sans Unicode', 'Lucida Grande', sans-serif"   => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
		"'MS Sans Serif', Geneva, sans-serif"                  => "'MS Sans Serif', Geneva, sans-serif",
		"'MS Serif', 'New York', sans-serif"                   => "'MS Serif', 'New York', sans-serif",
		"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
		"Tahoma,Geneva, sans-serif"                            => "Tahoma, Geneva, sans-serif",
		"'Times New Roman', Times,serif"                       => "'Times New Roman', Times, serif",
		"'Trebuchet MS', Helvetica, sans-serif"                => "'Trebuchet MS', Helvetica, sans-serif",
		"Verdana, Geneva, sans-serif"                          => "Verdana, Geneva, sans-serif",
        );

	return $fonts;
}

function get_google_web_fonts() {
	$file_path = plugin_dir_path(__FILE__).'google-web-fonts.php';
	if( file_exists($file_path) ) {
		require_once dirname( __FILE__ ) . '/google-web-fonts.php';
		$fonts = get_custom_fonts();
		$fonts = json_decode($fonts);
		return $fonts;
	}
}

$options = get_option( 'wprmenu_options' );
function wpr_optionsframework_options() {
	$options = array();

  $options[] = array( 'name' => __( 'General', 'wprmenu' ),
        'type' => 'heading' );  
		
	$options[] = array( 'name' => __( 'Enable Responsive Menu', 'wprmenu' ),
		'desc' => __( 'Turn on if you want to enable WP Responsive Menu functionality on your site.', 'wprmenu' ),
		'id' => 'enabled',
		'std' => '1',
		'type' => 'checkbox' );
		$menus = get_terms( 'nav_menu',array( 'hide_empty'=>false ) );
		$menu = array();
		foreach( $menus as $m ) {
			$menu[$m->term_id] = $m->name;
		}

	$options[] = array( 'name' => __( 'Large screen view', 'wprmenu' ),
		'desc' => __( 'Turn on display of menu on computers too.', 'wprmenu' ),
		'id' => 'desktopview',
		'std' => '1',
		'type' => 'checkbox' );

	$options[] = array( 'name' => __( 'Live preview', 'wprmenu' ),
		'desc' => __( 'You can see a live preview of menu directly on your dashboard.', 'wprmenu' ),
		'id' => 'wpr_live_preview',
		'std' => '1',
		'type' => 'checkbox' );

	$options[] = array( 'name' => __( 'Search input within menu', 'wprmenu' ),
		'desc' => __( 'Enables the display of search input box inside the menu.', 'wprmenu' ),
		'id' => 'search_box_menu_block',
		'std' => '1',
		'type' => 'checkbox' );

	$options[] = array( 'name' => __( 'Search on menu bar', 'wprmenu' ),
		'desc' => __( 'Enables the display of search option on menu bar.', 'wprmenu' ),
		'id' => 'search_box_menubar',
		'std' => '0',
		'class'	=> 'pro-feature',
		'type' => 'checkbox' );

	$options[] = array( 'name' => __( 'Enable RTL mode', 'wprmenu' ),
		'desc' => __( 'If your site uses RTL styles then enable it.', 'wprmenu' ),
		'id' => 'rtlview',
		'class'	=> 'pro-feature',
		'std' => '0',
		'type' => 'checkbox' );

	$options[] = array( 'name' => __( 'Keep submenus open', 'wprmenu' ),
		'desc' => __( 'This option allows you to keep the submenus opened by default.', 'wprmenu' ),
		'id' => 'submenu_opened',
		'class' => 'pro-feature',
		'std'	=> '0',
		'type' => 'checkbox' );

	$options[] = array( 'name' => __( 'Select menu', 'wprmenu' ),
		'desc' => __( 'Select the menu you want to display for mobile devices.', 'wprmenu' ),
		'id' => 'menu',
		'std' => '',
		'class' => 'mini',
		'options' => $menu,
		'type' => 'radio' );

	$options[] = array( 'name' => __( 'Elements to hide on mobile', 'wprmenu' ),
		'desc' => __( 'Enter the css class/ids for different elements you want to hide on mobile separated by a comma( , ). Example: .nav,#main-menu', 'wprmenu' ),
		'id' => 'hide',
		'std' => '',
		'type' => 'text' );

	$options[] = array( 'name' => __( 'Search box placeholder', 'wprmenu' ),
		'desc' => __( 'Enter the text that would be displayed on the search box placeholder.', 'wprmenu' ),
		'id' => 'search_box_text',
		'std' => 'Search...',
		'type' => 'text' );
	
	$options[] = array( 'name' => __( 'Menu title text', 'wprmenu' ),
		'id' => 'bar_title',
		'std' => 'MENU',
		'class' => 'mini',
		'type' => 'text' );

	$options[] = array( 'name' => __( 'Menu bar logo', 'wprmenu' ),
	'id' => 'bar_logo',
	'std' => '',
	'type' => 'upload' );

	$options[] = array( 'name' => __( 'Menu logo position', 'wprmenu' ),
	'desc' => __( 'Position of logo on menu bar.', 'wprmenu' ),
	'id' => 'bar_logo_pos',
	'std' => 'left',
	'class' => 'pro-feature',
	'options' => array( 'left' => 'Left','center' => 'Center' ),
	'type' => 'radio' );

	$options[] = array('name' => __('Logo link', 'wprmenu'),
		'desc' => __('Enter custom link you would like to open when clicking on the logo. If no link has been entered your site link would be use by default ', 'wprmenu'),
		'id' => 'logo_link',
		'std' => site_url(),
		'type' => 'text');

	$options[] = array( 'name' => __( 'Swipe', 'wprmenu' ),
		'desc' => __( 'Enables swipe gesture to open/close menus, Only applicable for left/right menu.', 'wprmenu' ),
		'id' => 'swipe',
		'std' => 'yes',
		'options' => array( 'yes' => 'Yes','no' => 'No' ),
		'type' => 'radio' );

	$options[] = array( 'name' => __( 'Zoom on mobile devices', 'wprmenu' ),
		'desc' => __( 'Enable/Disable zoom on mobile devices', 'wprmenu' ),
		'id' => 'zooming',
		'std' => 'no',
		'options' => array( 'yes' => 'Yes','no' => 'No' ),
		'type' => 'radio' );

	$options[] = array('name' => __('Open submenu on parent click' , 'wprmenu'),
		'desc' => __('Enable this option if you would like to open submenu when clicking on the parent menu.', 'wprmenu'),
		'id' => 'parent_click',
		'std' => 'yes',
		'options' => array('yes' => 'Yes','no' => 'No'),
		'type' => 'radio');

	if( woocommerce_installed() ) :

		$options[] = array( 'name' => __( 'WooCommerce integration', 'wprmenu' ),
				'desc' => __( 'This option integrates woocommerce option', 'wprmenu' ),
				'id' => 'woocommerce_integration',
				'std' => 'no',
				'class' => 'pro-feature',
				'options' => array( 'yes' => 'Yes','no' => 'No' ),
				'type' => 'radio' );

		$options[] = array( 'name' => __( 'Search Woocommerce products', 'wprmenu' ),
			'desc' => __( 'This will only search products from your woocommerce store', 'wprmenu' ),
			'id' => 'woocommerce_product_search',
			'std' => 'no',
			'class' => 'pro-feature',
			'options' => array( 'yes' => 'Yes','no' => 'No' ),
			'type' => 'radio' );

	endif;
		
	$options[] = array( 'name' => __( 'Appearance', 'wprmenu' ),
		'type' => 'heading' );

	$options[] = array( 'name' => __( 'Menu icon position', 'wprmenu' ),
		'desc' => __( 'You can choose to display the menu bar or put the menu icon as per your needs.', 'wprmenu' ),
		'id' => 'menu_type',
		'std' => 'default',
		'options' => array( 'default' => 'Default','custom' => 'Custom' ),
		'type' => 'radio' );

	$options[] = array( 'name' => __( 'Menu icon top distance(px)', 'wprmenu' ),
		'desc' => __( 'Enter the menu icon distance from top in px( Eg. 10px ).', 'wprmenu' ),
		'id' => 'custom_menu_top',
		'class' => 'mini',
		'std' => '0',
		'type' => 'text' );

	$options[] = array( 'name' => __( 'Menu icon direction', 'wprmenu' ),
		'id' => 'menu_symbol_pos',
		'std' => 'left',
		'class' => 'mini',
		'options' => array( 'left' => 'Left','right' => 'Right' ),
		'type' => 'radio' );

	$options[] = array( 'name' => __( 'Menu icon horizontal distance(px)', 'wprmenu' ),
		'desc' => __( 'Enter the menu icon distance from left/right based on direction chosen in px(Eg. 10px).', 'wprmenu' ),
		'id' => 'custom_menu_left',
		'class' => 'mini',
		'std' => '0',
		'type' => 'text' );

	$options[] = array( 'name' => __( 'Menu icon background color', 'wprmenu' ),
		'desc' => __( 'Select custom menu icon background color.', 'wprmenu' ),
		'id' => 'custom_menu_bg_color',
		'std' => '#CCCCCC',
		'type' => 'color' );
	
	$options[] = array( 'name' => __( 'Menu icon animation', 'wprmenu' ),
	'desc' => __( 'Select the animation for menu icon', 'wprmenu' ),
	'id' => 'menu_icon_animation',
	'options' => array( 'hamburger--3dx' => '3DX','hamburger--3dx-r' => '3DX Reverse', 'hamburger--3dy' => '3DY', 'hamburger--3dy-r' => '3DY Reverse', 'hamburger--3dxy' => '3DXY', 'hamburger--3dxy-r' => '3DXY Reverse', 'hamburger--arrow' => 'Arrow', 'hamburger--arrow-r' => 'Arrow Reverse', 'hamburger--arrowalt' => 'Arrow Alt', 'hamburger--arrowalt-r' => 'Arrow Alt Reverse', 'hamburger--arrowturn' => 'Arrow Turn', 'hamburger--arrowturn-r' => 'Arrow Turn Reverse', 'hamburger--boring' => 'Boring', 'hamburger--collapse' => 'Collapse', 'hamburger--collapse-r' => 'Collapse Reverse', 'hamburger--elastic' => 'Elastic', 'hamburger--elastic-r' => 'Elastic Reverse', 'hamburger--emphatic' => 'Emphatic', 'hamburger--emphatic-r' => 'Emphatic Reverse', 'hamburger--minus' => 'Minus', 'hamburger--slider' => 'Slider', 'hamburger--slider-r' => 'Slider Reverse', 'hamburger--spring' => 'Spring', 'hamburger--spring-r' => 'Spring Reverse', 'hamburger--stand' => 'Stand', 'hamburger--stand-r' => 'Stand Reverse', 'hamburger--spin' => 'Spin', 'hamburger--spin-r' => 'Spin Reverse', 'hamburger--squeeze' => 'Squeeze', 'hamburger--vortex' => 'Vortex', 'hamburger--vortex-r' => 'Vortex Reverse' ),
	'std' => 'hamburger--slider',
	'type' => 'select' );


	$options[] = array( 'name' => __( 'Menu slide style', 'wprmenu' ),
	'id' => 'slide_type',
	'std' => 'normalslide',
	'class' => 'mini',
	'options' => array( 'normalslide' => 'Normal', 'bodyslide' => 'Body push' ),
	'type' => 'radio' );

	$options[] = array( 'name' => __( 'Menu open direction', 'wprmenu' ),
	'desc' => __( 'Select the direction from where menu will open.', 'wprmenu' ),
	'id' => 'position',
	'std' => 'left',
	'class' => 'mini',
	'options' => array( 'left' => 'Left','right' => 'Right', 'top' => 'Top', 'bottom' => 'Bottom' ),
	'type' => 'radio' );

	$options[] = array( 'name' => __( 'Display menu from width(px)', 'wprmenu' ),
	'desc' => __( 'Enter the width (Eg. 768) below which the responsive menu will be visible on screen', 'wprmenu' ),
	'id' => 'from_width',
	'std' => '768',
	'class' => 'mini',
	'type' => 'text' );

	$options[] = array( 'name' => __( 'Menu container width(%)', 'wprmenu' ),
	'id' => 'how_wide',
	'std' => '80',
	'class' => 'mini',
	'type' => 'text' );

	$options[] = array( 'name' => __( 'Menu container max width(px)', 'wprmenu' ),
	'desc' => __( 'Enter menu container max width(px).', 'wprmenu' ),
	'id' => 'menu_max_width',
	'std' => '400',
	'class' => 'mini',
	'type' => 'text' );

	$options[] = array( 'name' => __( 'Menu title font size', 'wprmenu' ),
		'id' => 'menu_title_size',
		'std' => '16',
		'class' => 'mini',
		'type' => 'text' );

	$options[] = array( 'name' => __( 'Menu title font weight', 'wprmenu' ),
		'id' => 'menu_title_weight',
		'std' => 'normal',
		'options' => array('100' => '100', '200' => '200', '300' =>'300', '400' => '400', '500' => '500', '600' => '600', '700' => '700', '800' => '800', '900' => '900', 'bold' => 'Bold', 'bolder' => 'Bolder', 'lighter' => 'Lighter' ,'normal' => 'Normal'),
		'type' => 'select' );

	$options[] = array( 'name' => __( 'Menu item font size', 'wprmenu' ),
		'desc' => __( 'Enter the font size in(px) for main menu items.', 'wprmenu' ),
		'id' => 'menu_font_size',
		'std' => '15',
		'type' => 'text' );

	$options[] = array( 'name' => __( 'Menu item font weight', 'wprmenu' ),
		'desc' => __( 'Enter the font weight for main menu elements', 'wprmenu' ),
		'id' => 'menu_font_weight',
		'std' => 'bold',
		'options' => array('100' => '100', '200' => '200', '300' =>'300', '400' => '400', '500' => '500', '600' => '600', '700' => '700', '800' => '800', '900' => '900', 'bold' => 'Bold', 'bolder' => 'Bolder', 'lighter' => 'Lighter' ,'normal' => 'Normal'),
		'type' => 'select' );

	$options[] = array( 'name' => __( 'Menu item text style', 'wprmenu' ),
		'id' => 'menu_font_text_type',
		'std' => 'uppercase',
		'options' => array('none' => 'None', 'capitalize' => 'Capitalize', 'uppercase' =>'Uppercase', 'lowercase' => 'Lowercase'),
		'type' => 'select' );

	$options[] = array('name' => __('Submenu alignment', 'wprmenu'),
		'desc' => __('Select the text alignment of submenu items.', 'wprmenu'),
		'id' => 'submenu_alignment',
		'std' => 'left',
		'class' => 'mini pro-feature',
		'options' => array('left' => 'Left','right' => 'Right', 'center' => 'Center' ),
		'type' => 'radio');
		
	$options[] = array( 'name' => __( 'Submenu font size', 'wprmenu' ),
		'desc' => __( 'Enter the font size in(px) for submenu items.', 'wprmenu' ),
		'id' => 'sub_menu_font_size',
		'std' => '15',
		'type' => 'text' );

	$options[] = array( 'name' => __( 'Submenu font weight', 'wprmenu' ),
		'desc' => __( 'Enter the font weight for sub menu elements', 'wprmenu' ),
		'id' => 'sub_menu_font_weight',
		'std' => 'bold',
		'options' => array('100' => '100', '200' => '200', '300' =>'300', '400' => '400', '500' => '500', '600' => '600', '700' => '700', '800' => '800', '900' => '900', 'bold' => 'Bold', 'bolder' => 'Bolder', 'lighter' => 'Lighter' ,'normal' => 'Normal'),
		'type' => 'select' );

	$options[] = array( 'name' => __( 'Submenu text style', 'wprmenu' ),
		'id' => 'sub_menu_font_text_type',
		'std' => 'uppercase',
		'options' => array('none' => 'None', 'capitalize' => 'Capitalize', 'uppercase' =>'Uppercase', 'lowercase' => 'Lowercase'),
		'type' => 'select' );


	$options[] = array( 'name' => __( 'Cart quantity text size', 'wprmenu' ),
	'id' => 'cart_contents_bubble_text_size',
	'std' => '12',
	'class' => 'pro-feature',
	'type' => 'text' );


	$options[] = array( 'name' => __( 'Borders For Menu Items', 'wprmenu' ),
	'desc' => __( 'Enable to show border for main menu items', 'wprmenu' ),
	'id' => 'menu_border_bottom_show',
	'std' => 'yes',
	'options' => array( 'yes' => 'Yes','no' => 'No' ),
	'type' => 'radio' );

	$options[] = array('name' => __('Menu border top opacity', 'wprmenu'),
	'id' => 'menu_border_top_opacity',
	'std' => '0.05',
	'type' => 'text');

	$options[] = array('name' => __('Menu border bottom opacity', 'wprmenu'),
	'id' => 'menu_border_bottom_opacity',
	'std' => '0.05',
	'type' => 'text');
	$options[] = array( 'name' => __( 'Menu container background image', 'wprmenu' ),
		'id' => 'menu_bg',
		'std' => '',
		'type' => 'upload' );

	$options[] = array( 'name' => __( 'Menu container background size', 'wprmenu' ),
		'id' => 'menu_bg_size',
		'std' => 'cover',
		'options' => array( 'contain' => 'Contain','cover' => 'Cover','100%' => '100%' ),
		'type' => 'radio' );

	$options[] = array( 'name' => __( 'Menu container background repeat', 'wprmenu' ),
		'id' => 'menu_bg_rep',
		'std' => 'repeat',
		'options' => array( 'repeat' => 'Repeat','no-repeat' => 'No repeat' ),
		'type' => 'radio' );

	$options[] = array( 'name' => __( 'Menu bar background image', 'wprmenu' ),
	'id' => 'menu_bar_bg',
	'std' => '',
	'type' => 'upload' );

	$options[] = array( 'name' => __( 'Menu bar background size', 'wprmenu' ),
	'id' => 'menu_bar_bg_size',
	'std' => 'cover',
	'options' => array( 'contain' => 'Contain','cover' => 'Cover','100%' => '100%' ),
	'type' => 'radio' );

	$options[] = array( 'name' => __( 'Menu bar background repeat', 'wprmenu' ),
	'id' => 'menu_bar_bg_rep',
	'std' => 'repeat',
	'options' => array( 'repeat' => 'Repeat','no-repeat' => 'No repeat' ),
	'type' => 'radio' );

	$options[] = array( 'name' => __( 'Menu elements position', 'wprmenu' ),
		'desc' => __( 'Drag and drop to reorder the menu elements.', 'wprmenu' ),
		'id' => 'order_menu_items',
		'type' => 'menusort' );

	$options[] = array( 'name' => __( 'Color', 'wprmenu' ),
		'type' => 'heading' );

	$options[] = array( 'name' => __( 'Menu bar background', 'wprmenu' ),
	'id' => 'bar_bgd',
	'std' => '#C92C2C',
	'type' => 'color' );

	$options[] = array( 'name' => __( 'Menu Bar Text Color', 'wprmenu' ),
	'id' => 'bar_color',
	'std' => '#FFFFFF',
	'type' => 'color' );
	
	$options[] = array( 'name' => __( 'Menu container background', 'wprmenu' ),
	'id' => 'menu_bgd',
	'std' => '#c82d2d',
	'type' => 'color' );

	$options[] = array( 'name' => __( 'Menu item text', 'wprmenu' ),
	'id' => 'menu_color',
	'std' => '#FFFFFF',
	'type' => 'color' );
	
	$options[] = array( 'name' => __( 'Menu item text hover', 'wprmenu' ),
	'id' => 'menu_color_hover',
	'std' => '#FFFFFF',
	'type' => 'color' );	

	$options[] = array( 'name' => __( 'Menu item hover background', 'wprmenu' ),
	'id' => 'menu_textovrbgd',
	'std' => '#d53f3f',
	'type' => 'color' );

	$options[] = array( 'name' => __( 'Active menu item', 'wprmenu' ),
	'id' => 'active_menu_color',
	'std' => '#FFFFFF',
	'type' => 'color' );

	$options[] = array( 'name' => __( 'Active menu item background', 'wprmenu' ),
	'id' => 'active_menu_bg_color',
	'std' => '#d53f3f',
	'type' => 'color' );
	
	$options[] = array( 'name' => __( 'Menu icon color', 'wprmenu' ),
	'id' => 'menu_icon_color',
	'std' => '#FFFFFF',
	'type' => 'color' );

	$options[] = array( 'name' => __( 'Menu icon hover/focus', 'wprmenu' ),
	'id' => 'menu_icon_hover_color',
	'std' => '#FFFFFF',
	'type' => 'color' );
	
	$options[] = array('name' => __('Menu border top', 'wprmenu'),
	'id' => 'menu_border_top',
	'std' => '#FFFFFF',
	'type' => 'color');
	
	$options[] = array('name' => __('Menu border bottom', 'wprmenu'),
	'id' => 'menu_border_bottom',
	'std' => '#FFFFFF',
	'type' => 'color');

	$options[] = array( 'name' => __( 'Social icon', 'wprmenu' ),
	'id' => 'social_icon_color',
	'std' => '#FFFFFF',
	'class' => 'pro-feature',
	'type' => 'color' );

	$options[] = array( 'name' => __( 'Social icon hover', 'wprmenu' ),
	'id' => 'social_icon_hover_color',
	'class' => 'pro-feature',
	'std' => '#FFFFFF',
	'type' => 'color' );

	$options[] = array( 'name' => __( 'Search icon', 'wprmenu' ),
	'id' => 'search_icon_color',
	'class' => 'pro-feature',
	'std' => '#FFFFFF',
	'type' => 'color' );

	$options[] = array( 'name' => __( 'Search icon hover', 'wprmenu' ),
	'id' => 'search_icon_hover_color',
	'class' => 'pro-feature',
	'std' => '#FFFFFF',
	'type' => 'color' );

	if( woocommerce_installed() ) :

		$options[] = array( 'name' => __( 'Cart icon', 'wprmenu' ),
		'id' => 'cart_icon_color',
		'class' => 'pro-feature',
		'std' => '#FFFFFF',
		'type' => 'color' );

		$options[] = array( 'name' => __( 'Cart icon hover', 'wprmenu' ),
		'id' => 'cart_icon_active_color',
		'class' => 'pro-feature',
		'std' => '#FFFFFF',
		'type' => 'color' );

		$options[] = array( 'name' => __( 'Cart quantity text', 'wprmenu' ),
		'id' => 'cart_contents_bubble_text_color',
		'std' => '#FFFFFF',
		'class' => 'pro-feature',
		'type' => 'color' );

		$options[] = array( 'name' => __( 'Cart quantity background', 'wprmenu' ),
		'id' => 'cart_contents_bubble_color',
		'std' => '#d53f3f',
		'class' => 'pro-feature',
		'type' => 'color' );

	endif;

	$options[] = array( 'name' => __( 'Fonts<span class="badge badge-info">Pro</span>', 'wprmenu' ),
		'type' => 'heading', 
	);

	$options[] = array( 'name' => __( 'Google Font Type', 'wprmenu' ),
	'desc' => __( '', 'wprmenu' ),
	'class' => 'wpr_font_type pro-feature',
	'id' => 'google_font_type',
	'std' => '',
	'options' => array('standard' => 'Standard', 'web_fonts' => 'Web Fonts'),
	'type' => 'select' );	

	$options[] = array( 'name' => __( 'Font Family', 'wprmenu' ),
	'class' => 'wpr_font_family pro-feature',
	'id' => 'google_font_family',
	'std' => '',
	'options' => get_google_fonts(),
	'type' => 'select' );

	$options[] = array( 'name' => __( 'Web Font Family', 'wprmenu' ),
	'class' => 'wpr_web_font_family pro-feature',
	'id' => 'google_web_font_family',
	'std' => '',
	'options' => get_google_web_fonts(),
	'type' => 'select' );


	$options[] = array( 'name' => __( 'Icons <span class="badge badge-info">Pro</span>', 'wprmenu' ),
		'type' => 'heading' );

	$options[] = array( 'name' => __( 'Menu icon type', 'wprmenu' ),
		'id' => 'menu_icon_type',
		'std' => 'default',
		'class' => 'pro-feature',
		'options' => array( 'default' => 'Default','custom' => 'Custom' ),
		'type' => 'radio' );

	$options[] = array( 'name' => __( 'Menu icon font size', 'wprmenu' ),
		'id' => 'custom_menu_font_size',
		'class'	=> 'mini pro-feature',
		'std' => '40',
		'type' => 'text' );

	$options[] = array( 'name' => __( 'Menu top position', 'wprmenu' ),
		'desc' => __( 'Menu icon position from top', 'wprmenu' ),
		'id' => 'custom_menu_icon_top',
		'class'	=> 'mini pro-feature',
		'std' => '-7',
		'type' => 'text' );

	$options[] = array('name' => __('Menu icon', 'wprmenu'),
		'id' => 'menu_icon',
		'std' => 'wpr-icon-menu',
		'class' => 'mini pro-feature',
		'type' => 'icon');

	$options[] = array('name' => __('Menu active icon', 'wprmenu'),
		'id' => 'menu_close_icon',
		'std' => 'wpr-icon-cancel2',
		'class' => 'mini pro-feature',
		'type' => 'icon');

	$options[] = array('name' => __('Submenu open icon', 'wprmenu'),
		'desc' => __('This icon will appear for the menu items having submenu. Which will be used to expand the submenu.', 'wprmenu'),
		'id' => 'submenu_open_icon',
		'std' => 'wpr-icon-plus',
		'class' => 'mini pro-feature',
		'type' => 'icon');

	$options[] = array('name' => __('Submenu close ccon', 'wprmenu'),
		'desc' => __('This icon will appear for closing an expanded submenu.', 'wprmenu'),
		'id' => 'submenu_close_icon',
		'class' => 'mini pro-feature',
		'std' => 'wpr-icon-minus',
		'type' => 'icon');
	
	$options[] = array('name' => __('Search icon', 'wprmenu'),
		'desc' => __('', 'wprmenu'),
		'id' => 'search_icon',
		'class' => 'mini pro-feature',
		'std' => 'wpr-icon-search',
		'type' => 'icon');

	if( woocommerce_installed() ) :

		$options[] = array('name' => __('Cart icon', 'wprmenu'),
			'desc' => __('', 'wprmenu'),
			'id' => 'cart-icon',
			'class' => 'mini pro-feature',
			'std' => 'wpr-icon-cart',
			'type' => 'icon');

	endif;

	$options[] = array( 'name' => __( 'Social <span class="badge badge-info">Pro</span>', 'wprmenu' ),
		'type' => 'heading' );

	$options[] = array( 'name' => __( 'Social Icon Font Size', 'wprmenu' ),
		'id' => 'social_icon_font_size',
		'class'	=> 'mini pro-feature',
		'std' => '16',
		'type' => 'text' );
	
	$options[] = array('name' => __('Add Your Social Links', 'wprmenu'),
		'id' => 'social',
		'class' => 'pro-feature',
		'std' => '',
		'type' => 'social');
    return $options;
}