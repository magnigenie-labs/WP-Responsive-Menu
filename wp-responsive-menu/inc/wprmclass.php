<?php
class MgWprm {
	/**
	*
	* Bootstraps the class and hooks required actions & filters.
	*
	*/
	public function __construct() {
		add_action( 'wp_enqueue_scripts',  array( $this, 'wprm_enque_scripts' ) );
		add_action( 'wp_footer', array( $this, 'wprmenu_menu' ) );
	}
	
	function hex2rgba($color, $opacity = false) {
		$default = 'rgb(0,0,0)';
 
		//Return default if no color provided
		if(empty($color))
    	return $default; 
 
		//Sanitize $color if "#" is provided 
    if ($color[0] == '#' ) {
    	$color = substr( $color, 1 );
    }
 
    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
    	$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
    	$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
    	return $default;
    }
 
    //Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if($opacity){
    	if(abs($opacity) > 1)
    		$opacity = 1.0;
    	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
    } else {
    	$output = 'rgb('.implode(",",$rgb).')';
    }

    //Return rgb(a) color string
    return $output;
	}

	/**
	*
	* Added inline style to the responsive menu
	*
	*/
	public function inlineCss() {
		$inlinecss = '';
		$options = get_option( 'wprmenu_options' );
		if( $options['enabled'] ) :
			$how_wide = !empty($options['how_wide']) ? $options['how_wide'] : '40';
			$menu_max_width = !empty($options['menu_max_width']) ? $options['menu_max_width'] : '';
			$from_width = !empty($options['from_width']) ? $options['from_width'] : '768';
			$border_top_color = $this->hex2rgba($options["menu_border_top"], $options["menu_border_top_opacity"]);

			$border_bottom_color = $this->hex2rgba($options["menu_border_bottom"], $options["menu_border_bottom_opacity"]);

			//manu background image
			if( !empty($options['menu_bg']) ) :
				$inlinecss .= '#mg-wprm-wrap {
					background-image: url( '.$options["menu_bg"].' ) !important;
					background-size: '.$options["menu_bg_size"].' !important;
					background-repeat: '.$options["menu_bg_rep"].' !important;
			}';
			endif;

			if( $options['menu_border_bottom_show'] == 'yes' ):
				$inlinecss .= '
				#mg-wprm-wrap ul li {
					border-top: solid 1px '.$border_top_color.';
					border-bottom: solid 1px '.$border_bottom_color.';
				}
				';
			endif;

			if( !empty($options['menu_bar_bg']) ) :
				$inlinecss .= '
					#wprmenu_bar {
					background-image: url( '.$options["menu_bar_bg"].' ) !important;
					background-size: '.$options["menu_bar_bg_size"].' !important;
					background-repeat: '.$options["menu_bar_bg_rep"].' !important;
				}
				';
			endif;

			if( $options['menu_symbol_pos'] == 'right' ) :
				$inlinecss .= '
				#wprmenu_bar .menu_title {
					float: right;
				}';
			endif;

			$inlinecss .= '
				#wprmenu_bar {
					background-color: '.$options["bar_bgd"].'!important;
				}
			
				html body div#mg-wprm-wrap .wpr_submit .icon.icon-search {
					color: '.$options["search_icon_color"].' !important;
				}
				#wprmenu_bar .menu_title, #wprmenu_bar .wprmenu_icon_menu {
					color: '.$options["bar_color"].' !important
				}
				#wprmenu_bar .menu_title {
					font-size: '.$options['menu_title_size'].'px !important;
					font-weight: '.$options['menu_title_weight'].';
				}
				#mg-wprm-wrap li.menu-item a {
					font-size: '.$options['menu_font_size'].'px !important;
					text-transform: '.$options['menu_font_text_type'].';
					font-weight: '.$options['menu_font_weight'].';
				}
				#mg-wprm-wrap li.menu-item-has-children ul.sub-menu a {
					font-size: '.$options['sub_menu_font_size'].'px !important;
					text-transform: '.$options['sub_menu_font_text_type'].';
					font-weight: '.$options['sub_menu_font_weight'].';
				}
				#mg-wprm-wrap li.current-menu-item > a {
					color: '.$options['active_menu_color'].'!important;
					background: '.$options['active_menu_bg_color'].'!important;
				}
				#mg-wprm-wrap {
					background-color: '.$options["menu_bgd"].'!important;
				}
				.cbp-spmenu-push-toright {
					left: '.$how_wide.'% !important
				}
				.cbp-spmenu-push-toright .mm-slideout {
					left:'.$how_wide.'% !important
				}
				.cbp-spmenu-push-toleft {
					left: -'.$how_wide.'% !important
				}
				#mg-wprm-wrap.cbp-spmenu-right,
				#mg-wprm-wrap.cbp-spmenu-left,
				#mg-wprm-wrap.cbp-spmenu-right.custom,
				#mg-wprm-wrap.cbp-spmenu-left.custom,
				.cbp-spmenu-vertical {
					width: '.$how_wide.'%;
					max-width: '.$menu_max_width.'px;
				}
				#mg-wprm-wrap ul li a {
					color: '.$options["menu_color"].';
				}
				html body #mg-wprm-wrap ul li a:hover {
					background: '.$options["menu_textovrbgd"].'!important;
					color: '.$options["menu_color_hover"].';
				}
				#wprmenu_menu .wprmenu_icon_par {
					color: '.$options["menu_color"].';
				}
				#wprmenu_menu .wprmenu_icon_par:hover {
					color: '.$options["menu_color_hover"].';
				}
				
				.wprmenu_bar .hamburger-inner, .wprmenu_bar .hamburger-inner::before, .wprmenu_bar .hamburger-inner::after {
					background: '.$options["menu_icon_color"].' !important;
				}

				.wprmenu_bar .hamburger:hover .hamburger-inner, .wprmenu_bar .hamburger:hover .hamburger-inner::before,
			 .wprmenu_bar .hamburger:hover .hamburger-inner::after {
				background: '.$options["menu_icon_hover_color"].' !important;
				}
			';

			if( $options['hide'] != '' ):
				$inlinecss .= $options['hide'].'{ display:none!important; }';
			endif;

			if( $options['menu_symbol_pos'] == 'left' ) :
				$inlinecss .= 'div.wprmenu_bar div.hamburger{padding-right: 6px !important;}';
			endif;
			
			if( $options["menu_border_bottom_show"] == 'no' ):
				$inlinecss .= '
				#wprmenu_menu, #wprmenu_menu ul, #wprmenu_menu li, .wprmenu_no_border_bottom {
					border-bottom:none!important;
				}
				#wprmenu_menu.wprmenu_levels ul li ul {
					border-top:none!important;
				}
			';
			endif;
			$inlinecss .= '@media only screen and ( min-width: '.$from_width.'px ) {';
			$inlinecss .= '#mg-wprm-wrap.cbp-spmenu-right, #mg-wprm-wrap.cbp-spmenu-left, #mg-wprm-wrap.cbp-spmenu-right.custom, #mg-wprm-wrap.cbp-spmenu-left.custom {
					overflow-y: auto;
				}';
			$inlinecss .= '}';

			$inlinecss .= '
				#wprmenu_menu.left {
					width:'.$how_wide.'%;
					left: -'.$how_wide.'%;
					right: auto;
				}
				#wprmenu_menu.right {
					width:'.$how_wide.'%;
					right: -'.$how_wide.'%;
					left: auto;
				}
			';

			if( $options["menu_symbol_pos"] == 'right' ) :
				$inlinecss .= '
					.wprmenu_bar .hamburger {
						float: '.$options["menu_symbol_pos"].'!important;
					}
					.wprmenu_bar #custom_menu_icon.hamburger {
						top: '.$options["custom_menu_top"].'px;
						right: '.$options["custom_menu_left"].'px;
						float: right !important;
						background-color: '.$options["custom_menu_bg_color"].' !important;
					}
				';
			endif;
			if( $options["menu_symbol_pos"] == 'left' ) :
				$inlinecss .= '
					.wprmenu_bar .hamburger {
						float: '.$options["menu_symbol_pos"].'!important;
					}
					.wprmenu_bar #custom_menu_icon.hamburger {
						top: '.$options["custom_menu_top"].'px;
						left: '.$options["custom_menu_left"].'px;
						float: left !important;
						background-color: '.$options["custom_menu_bg_color"].' !important;
					}
					

				';
			endif;
		
			/* show the bar and hide othere navigation elements */
			if ( $options["desktopview"] ) {
				$from_width = '1700';
			}
			else {
				$from_width = $from_width;
			}
			$inlinecss .= '@media only screen and ( max-width: '.$from_width.'px ) {';
					$inlinecss .= '.custMenu #custom_menu_icon {
						display: block !important;
					}';
					if( $options["menu_type"] == 'default' ) : 
						$inlinecss .= 'html { padding-top: 42px!important; }';
					endif;
					$inlinecss .= '#wprmenu_bar { display: block!important; }
					div#wpadminbar { position: fixed; }';
					 

			$inlinecss .=	'}';
			$inlinecss .= '@media only screen and ( min-width: '.$from_width.'px ) {';

					$inlinecss .= '.cbp-spmenu-vertical { display: none!important; }';

			$inlinecss .=	'}';
		
		endif;

		if( $options['desktopview'] == 0 ) :
			$inlinecss .= '@media only screen and ( min-width: 1024px  ) {div#wprmenu_bar, #mg-wprm-wrap{ display:none !important; }}';
		endif;

		return $inlinecss;

	}

	/**
	*
	* Add necessary js and css files for the menu
	*
	*/	
	public function wprm_enque_scripts() {
		//hamburger menu icon style
		wp_enqueue_style( 'hamburger.css' , plugins_url().'/wp-responsive-menu/css/wpr-hamburger.css', array(), '1.0' );
		//menu css
		wp_enqueue_style( 'wprmenu.css' , plugins_url().'/wp-responsive-menu/css/wprmenu.css', array(), '1.0' );

		//menu css
		wp_enqueue_style( 'wpr_icons', plugins_url().'/wp-responsive-menu/inc/icons/style.css', array(),  '1.0' );

		//inline css
      wp_add_inline_style( 'wprmenu.css', $this->inlineCss() );
		
		//mordenizer js
		wp_enqueue_script( 'modernizr', plugins_url(). '/wp-responsive-menu/js/modernizr.custom.js', array( 'jquery' ), '1.0' );

		//touchswipe js
		wp_enqueue_script( 'touchSwipe', plugins_url(). '/wp-responsive-menu/js/jquery.touchSwipe.js', array( 'jquery' ), '1.0' );

		//wprmenu js
		wp_enqueue_script('wprmenu.js', plugins_url( '/wp-responsive-menu/js/wprmenu.js'), array( 'jquery', 'touchSwipe' ), '1.0' );
		
		$options 		= get_option( 'wprmenu_options' );

		$wpr_options = array(
		 		'zooming' 		=> !empty($options['zooming']) ? $options['zooming'] : '',
		 		'from_width' 	=> !empty($options['from_width']) ? $options['from_width'] : '',
		 		'parent_click' => !empty($options['parent_click']) ? $options['parent_click'] : '',
		 		'swipe' => !empty($options['swipe']) ? $options['swipe'] : '',
		 	);
		//Localize necessary variables
		wp_localize_script( 'wprmenu.js', 'wprmenu', $wpr_options );
	}

	/**
	*
	* Wordpress default search form
	*
	*/
	public function wpr_search_form() {
		$options = get_option( 'wprmenu_options' );
		$search_placeholder = !empty($options['search_box_text']) ? $options['search_box_text'] : 'Search...';
		$unique_id = esc_attr( uniqid( 'search-form-' ) );
		return '<form role="search" method="get" class="wpr-search-form" action="' . site_url() . '"><label for="'.$unique_id.'"></label><input type="search" class="wpr-search-field" placeholder="' . $search_placeholder . '" value="" name="s" title="Search for:"><button type="submit" class="wpr_submit"><i class="wpr-icon-search"></i></button></form>';
	}

	/**
	*
	* Function to show responsive menu with custom markup
	*
	*/	
	public function wprmenu_menu() {
		$options = get_option( 'wprmenu_options' );
		if( $options['enabled'] ) :
			$openDirection = $options['position'];

			$menu_icon_animation = !empty($options['menu_icon_animation']) ? $options['menu_icon_animation'] : 'hamburger--boring'; 
			
			if( $options['menu_type'] == 'default' ): ?>
				<div id="wprmenu_bar" class="wprmenu_bar <?php if ( $options['slide_type'] == 'bodyslide' ) { echo $options['slide_type']; echo ' '.$options['position']; } ?>">
					<div class="hamburger <?php echo $menu_icon_animation; ?>">
  						<span class="hamburger-box">
    						<span class="hamburger-inner"></span>
  						</span>
					</div>
					<div class="menu_title">
						<?php 
							$menu_title = !empty($options['bar_title']) ? $options['bar_title'] : 'Menu';
							echo $menu_title; 
						?>
						<?php 
						$logo_link = !empty($options['logo_link']) ? $options['logo_link'] : get_site_url();
						if( !empty($options['bar_logo']) ) :
							echo '<a href="'.$logo_link.'"><img class="bar_logo" src="'.$options['bar_logo'].'"/></a>';
						endif; 
					?>
					</div>
				</div>
			<?php else: ?>
				<div class="wprmenu_bar custMenu <?php if ( $options['slide_type'] == 'bodyslide' ) { echo $options['slide_type']; echo ' '.$options['position']; } ?>">
					<div id="custom_menu_icon" class="hamburger <?php echo $menu_icon_animation; ?>">
  					<span class="hamburger-box">
    					<span class="hamburger-inner"></span>
  					</span>
					</div>
				</div>
			<?php endif; ?>

			<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-<?php echo $openDirection; ?> <?php echo $options['menu_type']; ?> " id="mg-wprm-wrap">
				<?php if( $options['menu_type'] == 'custom' ): ?>
					<div class="menu_title">
						<?php echo $options['bar_title'] ?>
						<?php if( $options['bar_logo'] ) echo '<img class="bar_logo" src="'.$options['bar_logo'].'"/>' ?>
					</div>
				<?php endif; ?>
				<ul id="wprmenu_menu_ul">
					<?php
					$search_position = !empty($options['order_menu_items']) ? $options['order_menu_items'] : 'Menu,Search,Social';
					$search_position = explode(',', $search_position);
					foreach( $search_position as $key => $menu_element ) :
						if( $menu_element == 'Menu' ) : 
							$menus = get_terms( 'nav_menu',array( 'hide_empty'=>false ) );
							if( $menus ) : foreach( $menus as $m ) :
								if( $m->term_id == $options['menu'] ) $menu = $m;
							endforeach; endif;
							
							if( is_object( $menu ) ) :
								wp_nav_menu( array( 'menu'=>$menu->name,'container'=>false,'items_wrap'=>'%3$s' ) );
							endif;
						endif;

						if( $menu_element == 'Search' ) :
							if( !empty($options['search_box_menu_block']) && $options['search_box_menu_block'] == 1  ) : 
						?>
							<li>
								<div class="wpr_search search_top">
									<?php echo $this->wpr_search_form(); ?>
								</div>
							</li>
						<?php
						endif;
					endif;
						?>
					<?php
					endforeach;
					 ?>					
				</ul>
			</div>
			<?php
		endif;
	}
}