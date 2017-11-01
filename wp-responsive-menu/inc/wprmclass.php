<?php
class MgWprm {

	protected $options = '';
	/**
	*
	* Bootstraps the class and hooks required actions & filters.
	*
	*/
	public function __construct() {
		
		add_action( 'wp_enqueue_scripts',  array( $this, 'wprm_enque_scripts' ) );
		
		add_action( 'wp_footer', array( $this, 'wprmenu_menu' ) );
		//Load wp responsive menu settings
		$this->options = get_option( 'wprmenu_options' );
	}

	public function option( $option ){
		if( !empty( $this->options[$option] ) )
			return $this->options[$option];
		return '';
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
		if( $this->option('enabled') ) :
			$from_width = $this->option('from_width') != '' ? $this->option('from_width') : '768';
			if ( $this->option("desktopview") != '' ) $from_width = '5500';
			$inlinecss .= '@media only screen and ( max-width: '.$from_width.'px ) {';
			$how_wide = $this->option('how_wide') != '' ? $this->option('how_wide') : '40';
			$menu_max_width = $this->option('menu_max_width');

			$border_top_color = $this->hex2rgba($this->option("menu_border_top"), $this->option("menu_border_top_opacity"));

			$border_bottom_color = $this->hex2rgba($this->option("menu_border_bottom"), $this->option("menu_border_bottom_opacity"));
			$menu_title_font = $this->option('menu_title_size') == '' ? '20' : $this->option('menu_title_size');

			//manu background image
			if( $this->option('menu_bg') != '' ) :
				$inlinecss .= '#mg-wprm-wrap {
					background-image: url( '.$this->option("menu_bg").' ) !important;
					background-size: '.$this->option("menu_bg_size").' !important;
					background-repeat: '.$this->option("menu_bg_rep").' !important;
			}';
			endif;

			if( $this->option('menu_border_bottom_show') == 'yes' ):
				$inlinecss .= '
				#mg-wprm-wrap ul li {
					border-top: solid 1px '.$border_top_color.';
					border-bottom: solid 1px '.$border_bottom_color.';
				}
				';
			endif;

			if( $this->option('menu_bar_bg') != '' ) :
				$inlinecss .= '
					#wprmenu_bar {
					background-image: url( '.$this->option("menu_bar_bg").' ) !important;
					background-size: '.$this->option("menu_bar_bg_size").' !important;
					background-repeat: '.$this->option("menu_bar_bg_rep").' !important;
				}
				';
			endif;

			$inlinecss .= '
				#wprmenu_bar {
					background-color: '.$this->option("bar_bgd").';
				}
			
				html body div#mg-wprm-wrap .wpr_submit .icon.icon-search {
					color: '.$this->option("search_icon_color").' !important;
				}
				#wprmenu_bar .menu_title, #wprmenu_bar .wprmenu_icon_menu {
					color: '.$this->option("bar_color").';
				}
				#wprmenu_bar .menu_title {
					font-size: '.$menu_title_font.'px;
					font-weight: '.$this->option('menu_title_weight').';
				}
				#mg-wprm-wrap li.menu-item a {
					font-size: '.$this->option('menu_font_size').'px !important;
					text-transform: '.$this->option('menu_font_text_type').';
					font-weight: '.$this->option('menu_font_weight').';
				}
				#mg-wprm-wrap li.menu-item-has-children ul.sub-menu a {
					font-size: '.$this->option('sub_menu_font_size').'px !important;
					text-transform: '.$this->option('sub_menu_font_text_type').';
					font-weight: '.$this->option('sub_menu_font_weight').';
				}
				#mg-wprm-wrap li.current-menu-item > a {
					color: '.$this->option('active_menu_color').'!important;
					background: '.$this->option('active_menu_bg_color').'!important;
				}
				#mg-wprm-wrap {
					background-color: '.$this->option("menu_bgd").'!important;
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
					color: '.$this->option("menu_color").';
				}
				html body #mg-wprm-wrap ul li a:hover {
					background: '.$this->option("menu_textovrbgd").'!important;
					color: '.$this->option("menu_color_hover").';
				}
				#wprmenu_menu .wprmenu_icon_par {
					color: '.$this->option("menu_color").';
				}
				#wprmenu_menu .wprmenu_icon_par:hover {
					color: '.$this->option("menu_color_hover").';
				}
				
				.wprmenu_bar .hamburger-inner, .wprmenu_bar .hamburger-inner::before, .wprmenu_bar .hamburger-inner::after {
					background: '.$this->option("menu_icon_color").' !important;
				}

				.wprmenu_bar .hamburger:hover .hamburger-inner, .wprmenu_bar .hamburger:hover .hamburger-inner::before,
			 .wprmenu_bar .hamburger:hover .hamburger-inner::after {
				background: '.$this->option("menu_icon_hover_color").' !important;
				}
			';

			if( $this->option('menu_symbol_pos') == 'left' ) :
				$inlinecss .= 'div.wprmenu_bar div.hamburger{padding-right: 6px !important;}';
			endif;
			
			if( $this->option("menu_border_bottom_show") == 'no' ):
				$inlinecss .= '
				#wprmenu_menu, #wprmenu_menu ul, #wprmenu_menu li, .wprmenu_no_border_bottom {
					border-bottom:none!important;
				}
				#wprmenu_menu.wprmenu_levels ul li ul {
					border-top:none!important;
				}
			';
			endif;

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

			if( $this->option("menu_symbol_pos") == 'right' ) :
				$inlinecss .= '
					.wprmenu_bar .hamburger {
						float: '.$this->option("menu_symbol_pos").'!important;
					}
					.wprmenu_bar #custom_menu_icon.hamburger {
						top: '.$this->option("custom_menu_top").'px;
						right: '.$this->option("custom_menu_left").'px;
						float: right !important;
						background-color: '.$this->option("custom_menu_bg_color").' !important;
					}
				';
			endif;
			if( $this->option("menu_symbol_pos") == 'left' ) :
				$inlinecss .= '
					.wprmenu_bar .hamburger {
						float: '.$this->option("menu_symbol_pos").'!important;
					}
					.wprmenu_bar #custom_menu_icon.hamburger {
						top: '.$this->option("custom_menu_top").'px;
						left: '.$this->option("custom_menu_left").'px;
						float: left !important;
						background-color: '.$this->option("custom_menu_bg_color").' !important;
					}
					

				';
			endif;
			if( $this->option('hide') != '' ):
				$inlinecss .= $this->option('hide').'{ display: none!important; }';
			endif;
			$inlinecss .= '.custMenu #custom_menu_icon {
				display: block !important;
			}';
			if( $this->option("menu_type") == 'default' ) : 
				$inlinecss .= 'html { padding-top: 42px!important; }';
			endif;
			$inlinecss .= '#wprmenu_bar,#mg-wprm-wrap { display: block !important; }
			div#wpadminbar { position: fixed; }';

			$inlinecss .=	'}';
		
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
		wp_enqueue_script( 'touchSwipe', plugins_url(). '/wp-responsive-menu/js/jquery.touchSwipe.min.js', array( 'jquery' ), '1.0' );

		//wprmenu js
		wp_enqueue_script('wprmenu.js', plugins_url( '/wp-responsive-menu/js/wprmenu.js'), array( 'jquery', 'touchSwipe' ), '1.0' );
		
		$options 		= get_option( 'wprmenu_options' );

		$wpr_options = array(
		 		'zooming' 		=> $this->option('zooming'),
		 		'from_width' 	=> $this->option('from_width'),
		 		'parent_click' 	=> $this->option('parent_click'),
		 		'swipe' 		=> $this->option('swipe'),
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
		$search_placeholder = $this->option('search_box_text');
		$unique_id = esc_attr( uniqid( 'search-form-' ) );
		return '<form role="search" method="get" class="wpr-search-form" action="' . site_url() . '"><label for="'.$unique_id.'"></label><input type="search" class="wpr-search-field" placeholder="' . $search_placeholder . '" value="" name="s" title="Search for:"><button type="submit" class="wpr_submit"><i class="wpr-icon-search"></i></button></form>';
	}

	/**
	*
	* Function to show responsive menu with custom markup
	*
	*/	
	public function wprmenu_menu() {
		if( $this->option('enabled') ) :
			$openDirection = $this->option('position');

			$menu_icon_animation = $this->option('menu_icon_animation') != '' ? $this->option('menu_icon_animation') : 'hamburger--slider'; 
			
			if( $this->option('menu_type') == 'cusstom' ): ?>
				<div class="wprmenu_bar custMenu <?php if ( $this->option('slide_type') == 'bodyslide' ) { echo $this->option('slide_type'); echo ' '.$this->option('position'); } ?>">
					<div id="custom_menu_icon" class="hamburger <?php echo $menu_icon_animation; ?>">
  					<span class="hamburger-box">
    					<span class="hamburger-inner"></span>
  					</span>
					</div>
				</div>
			<?php else: ?>
				<div id="wprmenu_bar" class="wprmenu_bar <?php if ( $this->option('slide_type') == 'bodyslide' ) { echo $this->option('slide_type'); echo ' '.$this->option('position'); } ?>">
					<div class="hamburger <?php echo $menu_icon_animation; ?>">
  						<span class="hamburger-box">
    						<span class="hamburger-inner"></span>
  						</span>
					</div>
					<div class="menu_title">
						<?php 
							echo $this->option('bar_title');
						?>
						<?php 
						$logo_link = $this->option('logo_link') != '' ? $this->option('logo_link') : get_site_url();
						if( $this->option('bar_logo') != '' ) :
							echo '<a href="'.$logo_link.'"><img class="bar_logo" src="'.$this->option('bar_logo').'"/></a>';
						endif; 
					?>
					</div>
				</div>
			<?php endif; ?>

			<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-<?php echo $openDirection; ?> <?php echo $this->option('menu_type'); ?> " id="mg-wprm-wrap">
				<?php if( $this->option('menu_type') == 'custom' ): ?>
					<div class="menu_title">
						<?php echo $this->option('bar_title') ?>
						<?php if( $this->option('bar_logo') ) echo '<img class="bar_logo" src="'.$this->option('bar_logo').'"/>' ?>
					</div>
				<?php endif; ?>
				<ul id="wprmenu_menu_ul">
					<?php
					$search_position = $this->option('order_menu_items') != '' ? $this->option('order_menu_items') : 'Menu,Search,Social';
					$search_position = explode(',', $search_position);
					foreach( $search_position as $key => $menu_element ) :
						if( $menu_element == 'Menu' ) : 
							$menus = get_terms( 'nav_menu',array( 'hide_empty'=>false ) );
							if( $menus ) : foreach( $menus as $m ) :
								if( $m->term_id == $this->option('menu') ) $menu = $m;
							endforeach; endif;
							
							if( is_object( $menu ) ) :
								wp_nav_menu( array( 'menu'=>$menu->name,'container'=>false,'items_wrap'=>'%3$s' ) );
							endif;
						endif;

						if( $menu_element == 'Search' ) :
							if( $this->option('search_box_menu_block') != '' && $this->option('search_box_menu_block') == 1  ) : 
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