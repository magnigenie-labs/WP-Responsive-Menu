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

	/**
	*
	* Added inline style to the responsive menu
	*
	*/
	public function inlineCss() {
		$inlinecss = '';
		$options = get_option( 'wprmenu_options' );
		if( $options['enabled'] ) :

		$inlinecss .= '
			#wprmenu_bar {
				background-color: '.$options["bar_bgd"].'!important;
				background-image: url( '.$options["menu_bar_bg"].' ) !important;
				background-size: '.$options["menu_bar_bg_size"].' !important;
				background-repeat: '.$options["menu_bar_bg_rep"].' !important;
			}
			html body #wprmenu_menu_ul li.wprmenu_parent_item_li > ul {
  				margin-left: 0px !important;
			}
			html body div#mg-wprm-wrap .wpr_submit .icon.icon-search {
				color: '.$options["menu_search_color"].' !important;
			}
			#wprmenu_bar .menu_title, #wprmenu_bar .wprmenu_icon_menu {
				color: '.$options["bar_color"].' !important
			}
			#mg-wprm-wrap {
				z-index: 999;
			}
			#mg-wprm-wrap {
				background-color: '.$options["menu_bgd"].'!important;
			}
			#mg-wprm-wrap {
				background-image: url( '.$options["menu_bg"].' ) !important;
				background-size: '.$options["menu_bg_size"].' !important;
				background-repeat: '.$options["menu_bg_rep"].' !important;
			}
			#mg-wprm-wrap.cbp-spmenu-left {
				top: 42px !important;
				width: '.$options["how_wide"].'% !important
			}
			.cbp-spmenu-push-toright {
				left: '.$options["how_wide"].'% !important
			}
			.cbp-spmenu-push-toright .mm-slideout {
				left:'. $options["how_wide"].'% !important
			}
			.cbp-spmenu-push-toleft {
				left: -'.$options["how_wide"].'% !important
			}
			#mg-wprm-wrap.cbp-spmenu-right,
			#mg-wprm-wrap.cbp-spmenu-left,
			#mg-wprm-wrap.cbp-spmenu-right.custom,
			#mg-wprm-wrap.cbp-spmenu-left.custom {
				overflow-y: scroll;
				top: 0px !important;
				width: '.$options["how_wide"].'% !important
			}
			#mg-wprm-wrap ul li {
				border-top:1px solid '.$options["menu_border_top"].';
			}
			#mg-wprm-wrap ul li a.wprmenu_parent_item {
				border-left:1px solid '.$options["menu_border_top"].';
				margin-left: 44px;
			}
			#mg-wprm-wrap ul li a {
				text-decoration: none;
				z-index: 9999;
				color: '.$options["menu_color"].';
			}	
			#mg-wprm-wrap ul li:hover, #mg-wprm-wrap ul li a:hover {
				background: '.$options["menu_textovrbgd"].'!important;
				color: '.$options["menu_color_hover"].';
			}
			#wprmenu_menu .wprmenu_icon_par {
				color: '.$options["menu_color"].';
			}
			#wprmenu_menu .wprmenu_icon_par:hover {
				color: '.$options["menu_color_hover"].';
			}
			#wprmenu_menu.wprmenu_levels ul li ul {
				border-top:1px solid '.$options["menu_border_bottom"].';
			}
			#wprmenu_menu.wprmenu_levels ul li, #mg-wprm-wrap ul#wprmenu_menu_ul  {
				border-bottom:1px solid '.$options["menu_border_bottom"].';
				border-top:1px solid '.$options["menu_border_top"].';
			}
			.wprmenu_bar .wprmenu_icon span {
				background: '.$options["menu_icon_color"].' !important;
			}
			';
			if( $options["menu_border_bottom_show"] == 'no' ):
				$inlinecss .= '
				#wprmenu_menu, #wprmenu_menu ul, #wprmenu_menu li {
					border-bottom:none!important;
				}
				#wprmenu_menu.wprmenu_levels > ul {
					border-bottom:1px solid '.$options["menu_border_top"].' !important;
				}
				.wprmenu_no_border_bottom {
					border-bottom:none!important;
				}
				#wprmenu_menu.wprmenu_levels ul li ul {
					border-top:none!important;
				}
				#wprmenu_menu ul#wprmenu_menu_ul, #mg-wprm-wrap ul#wprmenu_menu_ul {
					border-bottom:1px solid '.$options["menu_border_top"].' !important;
				}
			';
			endif;
			$inlinecss .= '@media only screen and ( min-width: '.$options["from_width"].'px ) {';
			$inlinecss .= '#mg-wprm-wrap.cbp-spmenu-right, #mg-wprm-wrap.cbp-spmenu-left, #mg-wprm-wrap.cbp-spmenu-right.custom, #mg-wprm-wrap.cbp-spmenu-left.custom {
					overflow-y: auto;
				}';
			$inlinecss .= '}';

			$inlinecss .= '
				#wprmenu_menu.left {
					width:'.$options["how_wide"].'%;
					left: -'.$options["how_wide"].'%;
					right: auto;
				}
				#wprmenu_menu.right {
					width:'.$options["how_wide"].'%;
					right: -'.$options["how_wide"].'%;
					left: auto;
				}
			';
			if( isset( $options["nesting_icon"] ) ) :
				$inlinecss .= '
					#wprmenu_menu .wprmenu_icon:before {
						font-family: "fontawesome"!important;
					}
				';
			endif;

			if( $options["menu_symbol_pos"] == 'right' ) :
				$inlinecss .= '
					.wprmenu_bar .wprmenu_icon {
						float: '.$options["menu_symbol_pos"].'!important;
					}
					.wprmenu_bar #custom_menu_icon.wprmenu_icon {
						position: fixed;
						top: '.$options["custom_menu_top"].';
						left: '.$options["custom_menu_left"].';
						z-index: 9999999;
					}
					#wprmenu_bar .bar_logo {
						pading-left: 0px;
					}
				';
			endif;
			if( $options["menu_symbol_pos"] == 'left' ) :
				$inlinecss .= '
					.wprmenu_bar .wprmenu_icon {
						float: '.$options["menu_symbol_pos"].'!important;
					}
					.wprmenu_bar #custom_menu_icon.wprmenu_icon {
						position: fixed;
						top: '.$options["custom_menu_top"].';
						left: '.$options["custom_menu_left"].';
						z-index: 9999999;
					}
					#wprmenu_bar .bar_logo {
						pading-left: 0px;
					}

				';
			endif;
		
			/* show the bar and hide othere navigation elements */
			if ( $options["desktopview"] ) {
				$from_width = '1700';
			}
			else {
				$from_width = $options["from_width"];
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
					 
					if( $options['hide'] != '' ):
						$inlinecss .= $options['hide'].'{ display:none!important; }';
					endif;

			$inlinecss .=	'}';
			$inlinecss .= '@media only screen and ( min-width: '.$from_width.'px ) {';

					$inlinecss .= '.cbp-spmenu-vertical { display: none!important; }';

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
		//menu css
		wp_enqueue_style( 'wprmenu.css' , plugins_url().'/wp-responsive-menu/css/wprmenu.css', array(), '1.0' );

		//component css
		wp_enqueue_style( 'component.css' , plugins_url().'/wp-responsive-menu/css/component.css', array(), '1.0' );

		//inline css
    wp_add_inline_style( 'wprmenu.css', $this->inlineCss() );
		
		//mordenizer js
		wp_enqueue_script( 'modernizr', plugins_url(). '/wp-responsive-menu/js/modernizr.custom.js', array( 'jquery' ), '1.0' );

		//touchswipe js
		wp_enqueue_script( 'touchSwipe', plugins_url(). '/wp-responsive-menu/js/jquery.touchSwipe.js', array( 'jquery' ), '1.0' );

		//wprmenu js
		wp_enqueue_script('wprmenu.js', plugins_url( '/wp-responsive-menu/js/wprmenu.js'), array( 'jquery', 'touchSwipe' ), '1.0' );
		
		
		$options 		= get_option( 'wprmenu_options' );
		$zooming 		= !empty($options['zooming']) ? $options['zooming'] : '';
		$form_width = !empty($options['from_width']) ? $options['from_width'] : '';
		$swipe 			= !empty($options['swipe']) ? $options['swipe'] : '';
		$direction 	= !empty($options['position']) ? $options['position'] : '';
		$wpr_options = array( 'zooming' => $zooming,'from_width' => $form_width,'swipe' => $swipe, 'direction' => $direction );

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
		$unique_id = esc_attr( uniqid( 'search-form-' ) );
		return '<form role="search" method="get" class="wpr-search-form" action="' . site_url() . '"><label for="'.$unique_id.'"></label><input type="search" class="wpr-search-field" placeholder="' . $options['search_box_text'] . '" value="" name="s" title="Search for:"><button type="submit" class="wpr_submit"><svg class="icon icon-search" aria-hidden="true" role="img"> <use href="#icon-search" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-search"></use></svg></button></form>';
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
			
			if( $options['menu_type'] == 'default' ): ?>
				<div id="wprmenu_bar" class="wprmenu_bar <?php if ( $options['slide_type'] == 'bodyslide' ) { echo $options['slide_type']; echo ' '.$options['position']; } ?>">
					<div class="wprmenu_icon">
				  	<span class="wprmenu_ic_1"></span>
				  	<span class="wprmenu_ic_2"></span>
				  	<span class="wprmenu_ic_3"></span>
				  	<span class="wprmenu_ic_4"></span>
					</div>
					<div class="menu_title">
						<?php echo $options['bar_title'] ?>
						<?php if( $options['bar_logo'] ) echo '<img class="bar_logo" src="'.$options['bar_logo'].'"/>' ?>
					</div>
				</div>
			<?php else: ?>
				<div class="wprmenu_bar custMenu <?php if ( $options['slide_type'] == 'bodyslide' ) { echo $options['slide_type']; echo ' '.$options['position']; } ?>">
					<div id="custom_menu_icon" class="wprmenu_icon">
						<span class="wprmenu_ic_1"></span>
						<span class="wprmenu_ic_2"></span>
						<span class="wprmenu_ic_3"></span>
						<span class="wprmenu_ic_4"></span>
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
				<div class="wpr-clear"></div>
				<ul id="wprmenu_menu_ul">
					<?php if( $options['search_box'] == 'above_menu' ) { ?>
					<li>
						<div class="wpr_search search_top">
							<?php echo $this->wpr_search_form(); ?>
						</div>
					</li>
					<?php } ?>
					<?php
					$menus = get_terms( 'nav_menu',array( 'hide_empty'=>false ) );
					if( $menus ) : foreach( $menus as $m ) :
						if( $m->term_id == $options['menu'] ) $menu = $m;
					endforeach; endif;
					if( is_object( $menu ) ) :
						wp_nav_menu( array( 'menu'=>$menu->name,'container'=>false,'items_wrap'=>'%3$s' ) );
					endif;
					?>
					<?php if( $options['search_box'] == 'below_menu' ) { ?>
					<li>
						<div class="wpr_search">
							<?php echo $this->wpr_search_form(); ?>
						</div>
					</li> 
				<?php } ?>
				</ul>
				<div class="wpr-clear"></div>
			</div>
			<?php
		endif;
	}
}