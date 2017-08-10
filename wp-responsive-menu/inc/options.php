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

function wpr_support_link() { ?>
	<div class="queries-holder">
		<div class="wpr_pro"> <?php echo __('WP Responsive Menu Pro is out and it has much more features that you ever wanted.') ?> 
			<div> 
				<?php echo __('Check out the'); ?> 
				<a href="http://magnigenie.com/wp-responsive-menu-pro/" target="_blank"><?php echo __('Pro Features'); ?></a> <br>
			</div>
		</div>
	</div>
	<div class="queries-holder">
		<div class="wpr_help"><?php echo __('Need help? No Problem.'); ?>
			<div> 
				<a href="http://magnigenie.com/support/queries/wp-responsive-menu/" target="_blank"><?php echo __('Visit Our Support Forum'); ?></a>
			</div>
		</div>
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
/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */
$options = get_option( 'wprmenu_options' );
function wpr_optionsframework_options() {
	$options = array();

  $options[] = array( 'name' => __( 'General Settings', 'wprmenu' ),
        'type' => 'heading' );  
		
	$options[] = array( 'name' => __( 'Enable Responsive Menu Plugin', 'wprmenu' ),
		'desc' => __( 'Check if you want to enable the plugin.', 'wprmenu' ),
		'id' => 'enabled',
		'std' => '1',
		'type' => 'checkbox' );
		$menus = get_terms( 'nav_menu',array( 'hide_empty'=>false ) );
		$menu = array();
		foreach( $menus as $m ) {
			$menu[$m->term_id] = $m->name;
		}

	$options[] = array( 'name' => __( 'Enable Desktop Navigation', 'wprmenu' ),
		'desc' => __( 'Check if you want to activate desktop navigation.', 'wprmenu' ),
		'id' => 'desktopview',
		'std' => '0',
		'type' => 'checkbox' );

	$options[] = array( 'name' => __( 'Enable RTL Mode', 'wprmenu' ),
		'desc' => __( 'Check if you want to activate rtl mode.', 'wprmenu' ),
		'id' => 'rtlview',
		'std' => '0',
		'type' => 'checkbox' );

	$options[] = array( 'name' => __( 'Menu Type', 'wprmenu' ),
		'desc' => __( 'Choose menu type to default/custom menus.', 'wprmenu' ),
		'id' => 'menu_type',
		'std' => 'default',
		'options' => array( 'default' => 'Default','custom' => 'Custom' ),
		'type' => 'radio' );

	$options[] = array( 'name' => __( 'Custom Menu Icon Top Position', 'wprmenu' ),
		'desc' => __( '( Eg. 10px ) Enter the top position of custom menus.', 'wprmenu' ),
		'id' => 'custom_menu_top',
		'class' => 'mini',
		'std' => '0',
		'type' => 'text' );

	$options[] = array( 'name' => __( 'Custom Menu Icon Left Position', 'wprmenu' ),
		'desc' => __( '( Eg. 10px ) Enter the left position of custom menus.', 'wprmenu' ),
		'id' => 'custom_menu_left',
		'class' => 'mini',
		'std' => '0',
		'type' => 'text' );

	$options[] = array( 'name' => __( 'Select Menu', 'wprmenu' ),
		'desc' => __( 'Select the menu you want to display for mobile devices.', 'wprmenu' ),
		'id' => 'menu',
		'std' => '',
		'class' => 'mini',
		'options' => $menu,
		'type' => 'select' );
	
	$options[] = array( 'name' => __( 'Elements to hide in mobile:', 'wprmenu' ),
		'desc' => __( 'Enter the css class/ids for different elements you want to hide on mobile separated by a comma( , ). Example: .nav,#main-menu ', 'wprmenu' ),
		'id' => 'hide',
		'std' => '',
		'type' => 'text' );
	
	$options[] = array( 'name' => __( 'Enable Swipe', 'wprmenu' ),
		'desc' => __( 'Enable swipe gesture to open/close menus, Only applicable for left/right menu.', 'wprmenu' ),
		'id' => 'swipe',
		'std' => 'yes',
		'options' => array( 'yes' => 'Yes','no' => 'No' ),
		'type' => 'radio' );
	
	$options[] = array( 'name' => __( ' Search Box', 'wprmenu' ),
		'desc' => __( ' Select the position of search box or simply hide the search box if you don\'t need it.', 'wprmenu' ),
		'id' => 'search_box',
		'std' => 'hide',
		'options' => array( 'above_menu' => 'Above Menu','below_menu' => 'Below Menu', 'hide'=> 'Hide search box' ),
		'type' => 'select' );

	$options[] = array( 'name' => __( ' Search Box Text', 'wprmenu' ),
		'desc' => __( 'Enter the text that would be displayed on the search box placeholder.', 'wprmenu' ),
		'id' => 'search_box_text',
		'std' => 'Search...',
		'type' => 'text' );
		
	$options[] = array( 'name' => __( 'Allow zoom on mobile devices', 'wprmenu' ),
		'desc' => __( '', 'wprmenu' ),
		'id' => 'zooming',
		'std' => 'yes',
		'options' => array( 'yes' => 'Yes','no' => 'No' ),
		'type' => 'radio' );
		
	$options[] = array( 'name' => __( 'Menu Appearance', 'wprmenu' ),
		'type' => 'heading' );
	
	$options[] = array( 'name' => __( 'Menu Symbol Position', 'wprmenu' ),
		'desc' => __( 'Select menu icon position which will be displayed on the menu bar.', 'wprmenu' ),
		'id' => 'menu_symbol_pos',
		'std' => 'left',
		'class' => 'mini',
		'options' => array( 'left' => 'Left','right' => 'Right' ),
		'type' => 'select' );

	$options[] = array( 'name' => __( 'Menu Text', 'wprmenu' ),
		'desc' => __( 'Enter the text you would like to display on the menu bar.', 'wprmenu' ),
		'id' => 'bar_title',
		'std' => 'MENU',
		'class' => 'mini',
		'type' => 'text' );

	$options[] = array( 'name' => __( 'Menu Background', 'wprmenu' ),
		'desc' => __( 'Select background.', 'wprmenu' ),
		'id' => 'menu_bg',
		'std' => '',
		'type' => 'upload' );

	$options[] = array( 'name' => __( 'Menu background size', 'wprmenu' ),
		'desc' => __( '', 'wprmenu' ),
		'id' => 'menu_bg_size',
		'std' => 'cover',
		'options' => array( 'contain' => 'Contain','cover' => 'Cover','100%' => '100%' ),
		'type' => 'radio' );

	$options[] = array( 'name' => __( 'Menu background repeat', 'wprmenu' ),
		'desc' => __( '', 'wprmenu' ),
		'id' => 'menu_bg_rep',
		'std' => 'repeat',
		'options' => array( 'repeat' => 'Repeat','no-repeat' => 'No repeat' ),
		'type' => 'radio' );

	$options[] = array( 'name' => __( 'Menu Bar Background', 'wprmenu' ),
	'desc' => __( 'Select bar background.', 'wprmenu' ),
	'id' => 'menu_bar_bg',
	'std' => '',
	'type' => 'upload' );

	$options[] = array( 'name' => __( 'Menu bar background size', 'wprmenu' ),
	'desc' => __( '', 'wprmenu' ),
	'id' => 'menu_bar_bg_size',
	'std' => 'cover',
	'options' => array( 'contain' => 'Contain','cover' => 'Cover','100%' => '100%' ),
	'type' => 'radio' );

	$options[] = array( 'name' => __( 'Menu bar background repeat', 'wprmenu' ),
	'desc' => __( '', 'wprmenu' ),
	'id' => 'menu_bar_bg_rep',
	'std' => 'repeat',
	'options' => array( 'repeat' => 'Repeat','no-repeat' => 'No repeat' ),
	'type' => 'radio' );

	$options[] = array( 'name' => __( 'Menu Logo', 'wprmenu' ),
	'desc' => __( 'Select menu logo.', 'wprmenu' ),
	'id' => 'bar_logo',
	'std' => '',
	'type' => 'upload' );

	$options[] = array( 'name' => __( 'Menu Slide Options', 'wprmenu' ),
	'desc' => __( 'Select Slide Options for Body push slide or Normal slide.', 'wprmenu' ),
	'id' => 'slide_type',
	'std' => 'normalslide',
	'class' => 'mini',
	'options' => array( 'normalslide' => 'Normal slide', 'bodyslide' => 'Body push slide' ),
	'type' => 'select' );

	$options[] = array( 'name' => __( 'Menu Open Direction', 'wprmenu' ),
	'desc' => __( 'Select the direction from where menu will open.', 'wprmenu' ),
	'id' => 'position',
	'std' => 'left',
	'class' => 'mini',
	'options' => array( 'left' => 'Left','right' => 'Right', 'top' => 'Top', 'bottom' => 'Bottom' ),
	'type' => 'select' );

	$options[] = array( 'name' => __( 'Display menu from width ( in px )', 'wprmenu' ),
	'desc' => __( ' Enter the width ( in px ) below which the responsive menu will be visible on screen', 'wprmenu' ),
	'id' => 'from_width',
	'std' => '768',
	'class' => 'mini',
	'type' => 'text' );

	$options[] = array( 'name' => __( 'Menu Width', 'wprmenu' ),
	'desc' => __( 'Enter menu width in ( % ) only applicable for left and right menu.', 'wprmenu' ),
	'id' => 'how_wide',
	'std' => '80',
	'class' => 'mini',
	'type' => 'text' );
	
	$options[] = array( 'name' => __( 'Menu bar background color', 'wprmenu' ),
	'desc' => __( '', 'wprmenu' ),
	'id' => 'bar_bgd',
	'std' => '#4C656C',
	'type' => 'color' );

	$options[] = array( 'name' => __( 'Menu bar text color', 'wprmenu' ),
	'desc' => __( '', 'wprmenu' ),
	'id' => 'bar_color',
	'std' => '#F2F2F2',
	'type' => 'color' );
	
	$options[] = array( 'name' => __( 'Menu background color', 'wprmenu' ),
	'desc' => __( '', 'wprmenu' ),
	'id' => 'menu_bgd',
	'std' => '#4C656C',
	'type' => 'color' );

	$options[] = array( 'name' => __( 'Menu text color', 'wprmenu' ),
	'desc' => __( '', 'wprmenu' ),
	'id' => 'menu_color',
	'std' => '#CFCFCF',
	'type' => 'color' );
	
	$options[] = array( 'name' => __( 'Menu text hover color', 'wprmenu' ),
	'desc' => __( '', 'wprmenu' ),
	'id' => 'menu_color_hover',
	'std' => '#606060',
	'type' => 'color' );	

	$options[] = array( 'name' => __( 'Menu text hover background color', 'wprmenu' ),
	'desc' => __( '', 'wprmenu' ),
	'id' => 'menu_textovrbgd',
	'std' => '#47A3DA',
	'type' => 'color' );
	
	$options[] = array( 'name' => __( 'Menu icon color', 'wprmenu' ),
	'desc' => __( '', 'wprmenu' ),
	'id' => 'menu_icon_color',
	'std' => '#FFFFFF',
	'type' => 'color' );
	
	$options[] = array('name' => __('Menu borders(top & left) color', 'wprmenu'),
	'desc' => __('', 'wprmenu'),
	'id' => 'menu_border_top',
	'std' => '#0D0D0D',
	'type' => 'color');
	
	$options[] = array('name' => __('Menu borders(bottom) color', 'wprmenu'),
	'desc' => __('', 'wprmenu'),
	'id' => 'menu_border_bottom',
	'std' => '#131212',
	'type' => 'color');

	$options[] = array('name' => __('Menu search icon color', 'wprmenu'),
	'desc' => __('', 'wprmenu'),
	'id' => 'menu_search_color',
	'std' => '#666666',
	'type' => 'color');
	
	$options[] = array( 'name' => __( 'Enable borders for menu items', 'wprmenu' ),
	'desc' => __( '', 'wprmenu' ),
	'id' => 'menu_border_bottom_show',
	'std' => 'yes',
	'options' => array( 'yes' => 'Yes','no' => 'No' ),
	'type' => 'radio' );

    return $options;
}