<?php
/**
 * WP Responsive Menu Setup
 *
 * @package WP Responsive Menu
 * @version 3.1.4
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main WP_Responsive_Menu Class.
 *
 * @class WP_Responsive_Menu
 */

class WP_Responsive_Menu {

	protected $options = '';

	public $translatables = array(
  	'search_box_text',
    'bar_title'
  );

	public function __construct() {
    $this->wprmenu_init_hooks();
	}

  /**
   * Hook into actions and filters.
   *
   * @since 3.1.4
   */
  private function wprmenu_init_hooks() {
    $this->options = get_option( 'wprmenu_options' );
    
    add_filter( 'plugin_action_links_'.WPRMENU_BASE, array( $this, 'plugin_action_links' ) );

    add_action( 'plugins_loaded', array( $this, 'wprmenu_register_strings' ) );

    if ( isset( $this->options['enabled'] ) && $this->options['enabled'] == '1' ) {
      add_action( 'wp_enqueue_scripts', array( $this, 'wprmenu_enqueue_styles' ) );
      add_action( 'wp_enqueue_scripts', array( $this, 'wprmenu_enqueue_scripts' ) );
      add_action( 'wp_footer', array( $this, 'render_wprmenu_menu' ) );
      add_action( 'wp_footer', array( $this, 'wpr_custom_css' ) );
    }
    

    // add_action( 'wpr_optionsframework_after_validate', array( $this, 'save_options_notice' ) );

    add_action( 'wp_ajax_wprmenu_import_data', array( $this, 'wprmenu_import_data' ) );

    add_action( 'wp_ajax_wpr_get_transient_from_data', array( $this, 'wpr_get_transient_from_data' ) );

    add_action( 'admin_bar_menu', array( $this, 'wprmenu_mobile_preview' ), 10 );

    add_filter( 'plugin_row_meta', array( $this, 'wprmenu_plugin_row_meta' ), 10, 2 );
  }

 /**
  * Get template file
  *
  * @param string template name
  * @param array data to be render in the template
  *
  */
  public function get_template_part( $template, $data = '' ){
    if ( ! empty( $template ) ) {
      require WPRMENU_ABSPATH . 'inc/templates/' . $template . '.php';
    }
  }

 /**
  * Add new links for the services under plugin links
  *
  * @param array $links an array of existing links.
  * @return array of links along with plugin settings link.
  *
  */
  public function wprm_meta_links( $links ) {
    $new_links = array();
    $settings_link = esc_url( add_query_arg( array(
                            'page' => 'wp-responsive-menu',
                            ), admin_url( 'admin.php' ) ) );

    $new_links[ 'settings' ] = sprintf( '<a href="%1$s" title="%2$s">%2$s</a>', $settings_link, esc_attr__( 'Settings', 'wprmenu' ) );
    $new_links[ 'go-pro' ] = sprintf( '<a target="_blank" style="color: #45b450; font-weight: bold;" href="%1$s" title="%2$s">%2$s</a>', WPRMENU_PRO_LINK, esc_attr__( 'Get Pro Version', 'wprmenu' ) );
    $new_links[ 'demo' ] = sprintf( '<a target="_blank" style="color: #45b450; font-weight: bold;" href="%1$s" title="%2$s">%2$s</a>', WPRMENU_DEMO_SITE_URL, esc_attr__( 'Check Demo', 'wprmenu' ) );

    return array_merge( $links, $new_links );
  }

  public function option( $option ){
    if ( isset( $this->options[$option] ) && $this->options[$option] != '' )
      return $this->options[$option];
      return '';
  }


  /**
   * Retrieves Menus created from the wp admin dashboard
   *
   * @since 3.1.4
   * @return array of Menus
   */

  static function wprm_get_created_menus() {
    $menus = get_terms( 'nav_menu', array( 'hide_empty'=>false ) );
    $menu = array();

    if ( is_array( $menus ) && !empty( $menus ) ) {
      foreach ( $menus as $m ) {
        $menu[ $m->term_id ] = $m->name;
      }
    }
    return $menu;
  }

  /**
  *
  * Register string to make translation string
  *
  * @since 1.0.2
  */
	public function wprmenu_register_strings() {
    if ( is_admin() ) {
      if ( function_exists( 'pll_register_string' ) ) {
        pll_register_string( 'search_box_text', $this->option( 'search_box_text' ), 'WP Responsive Menu');
        pll_register_string( 'bar_title', $this->option( 'bar_title' ), 'WP Responsive Menu');
      }
    }
	}

	/**
  *
  * Generate inline style for WP Responsive Menu
  *
  * @since 1.0.2
  * @return inline css
  */
	public function wpr_inline_css() {
		$wprmenu_style = new WPRMenu_Styles;
    $inlinecss = $wprmenu_style->generate_style();
    $inlinecss = WPRMenu_Styles::trim_css( $inlinecss );
    return $inlinecss;
	}

  /**
  *
  * Gets plugin url
  *
  * @since 3.4.1
  * @return string
  */
  public function plugin_url() {
    return untrailingslashit( plugins_url( '/', WPRMENU_FILE ) );
  }

  /**
   * Enqueue styles.
   */
  public function wprmenu_enqueue_styles() {
    wp_register_style( 'hamburger.css',  $this->plugin_url() . '/assets/css/wpr-hamburger.css', array(), WPRMENU_VERSION );
    wp_register_style( 'wprmenu.css', $this->plugin_url() . '/assets/css/wprmenu.css', array(), WPRMENU_VERSION );
    wp_register_style( 'wpr_icons', $this->plugin_url() . '/inc/assets/icons/wpr-icons.css', array(), WPRMENU_VERSION );

    wp_enqueue_style( 'hamburger.css' );
    wp_enqueue_style( 'wprmenu.css' );
    wp_enqueue_style( 'wpr_icons' );

    //inline css
    wp_add_inline_style( 'wprmenu.css', $this->wpr_inline_css() );
  }


	/**
   * Enqueue scripts.
   */	
	public function wprmenu_enqueue_scripts() {
		wp_register_script( 'modernizr', $this->plugin_url() . '/assets/js/modernizr.custom.js', array( 'jquery' ), WPRMENU_VERSION );
		wp_register_script( 'touchSwipe', $this->plugin_url() . '/assets/js/jquery.touchSwipe.min.js', array( 'jquery' ), WPRMENU_VERSION );
		wp_register_script('wprmenu.js', $this->plugin_url() . '/assets/js/wprmenu.js', array( 'jquery', 'touchSwipe' ), WPRMENU_VERSION );

		$params = array(
		 		'zooming' 				=> $this->option( 'zooming' ),
		 		'from_width' 			=> $this->option( 'from_width' ),
		 		'push_width' 			=> $this->option( 'menu_max_width' ),
		 		'menu_width' 			=> $this->option( 'how_wide' ),
		 		'parent_click'    => ( $this->option('parent_click') == 'yes' || $this->option('parent_click') == '1' ) ? 'yes' : '',
		 		'swipe' 					=> $this->option( 'swipe' ),
		 		'enable_overlay' 	=> $this->option( 'enable_overlay' ),
		 	);
    

		//Localize necessary variables
		wp_localize_script( 'wprmenu.js', 'wprmenu', $params );

    wp_enqueue_script( 'modernizr' );
    wp_enqueue_script( 'touchSwipe' );
    wp_enqueue_script( 'wprmenu.js' );
	}

	/**
	*
	* Outputs WP Responsive Menu Html
	*
	* @since 1.0
	* @return html
	*/	
	public function render_wprmenu_menu() {
		
    if ( $this->option( 'enabled' ) ) :

			$open_direction = $this->option( 'position' );
      $menu_type      = $this->option( 'menu_type' );

			$menu_title  =  $this->option( 'bar_title' );
			$menu_title  =  function_exists( 'pll__')  ? pll__( $menu_title ) : $menu_title;

      $slide_type =   $this->option( 'slide_type' );
      $position   =   $this->option( 'position' );
      $logo_link  =   $this->option( 'logo_link' ) != '' ? $this->option( 'logo_link' ) : get_site_url();
      $bar_logo = $this->option( 'bar_logo' );

      $icon_animation = $this->option( 'menu_icon_animation' ) != '' ? $this->option( 'menu_icon_animation' ) : 'hamburger--slider';

      $default_menu_bar = array( 
        'icon_animation'      => $icon_animation, 
        'menu_title'          => $menu_title,
        'slide_type'          => $slide_type, 
        'position'            => $position,
        'logo_link'           => $logo_link,
        'bar_logo'            => $bar_logo
      );

      $custom_menu_bar = array(
        'slide_type'         => $slide_type,
        'position'           => $position,
        'icon_animation'     => $icon_animation,
      );

      $menu_title_args = array(
        'menu_title'         =>  $menu_title,
        'bar_logo'           =>  $bar_logo
      );

			?>

			<div class="wprm-wrapper">
        
        <!-- Overlay Starts here -->
			 <?php if ( $this->option( 'enable_overlay' ) ) : ?>
			   <div class="wprm-overlay"></div>
			 <?php endif; ?>
        <!-- Overlay Ends here -->
			
			 <?php if ( $menu_type == 'custom' ) : ?>
        <?php $this->get_template_part( 'custom-menu-bar', $custom_menu_bar ); ?>
			 <?php else: ?>
        <?php $this->get_template_part( 'default-menu-bar', $default_menu_bar ); ?>
			 <?php endif; ?>

			<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-<?php echo esc_attr( $open_direction ); ?> <?php echo esc_attr( $menu_type ); ?> " id="mg-wprm-wrap">
				<?php if( $menu_type == 'custom' ): ?>
					<?php $this->get_template_part( 'menu-title', $menu_title_args ); ?>
				<?php endif; ?>

				<?php
				/**
				*
				* After Menu Header Hook
				*
				* @since 3.1
				*/
				do_action( 'wpr_after_menu_bar' ); 
				?>

				<?php $this->get_template_part( 'menu-elements' ); ?>

				<?php
				/**
				*
				* After Menu Container Hook
				*
				* @since 3.1
				*/
				do_action( 'wpr_after_menu_container' ); 
				?>

				</div>
			</div>
			<?php
		endif;
	}


	/**
	*
	* Show custom css from the plugin settings
	*
	* @since 3.1
	* @param empty
	* @return string
	*/
	public function wpr_custom_css() {
    $parse_css = $this->option( 'wpr_custom_css' );

    if ( '' != $parse_css ) {
      // trim white space for faster page loading.
      $parse_css = WPRMenu_Styles::trim_css( $parse_css );
    ?>
    <style type="text/css">
    <?php
      echo '/* WPR Custom CSS */' . "\n";
      echo esc_html( $parse_css ) . "\n";
    ?>
    </style>
    <?php
    }
  }

	/**
	*
	* Get demo settings from the file
	*
	* @since 3.1
	* @param empty
	* @return json object
	*/
	public function wprmenu_import_data() {
		
    if ( ! wp_verify_nonce( $_POST['nonce'], 'wprmenu-nonce' ) || ! current_user_can( 'administrator' ) ) {
        die ( __( 'Error while verifying your request! Try again.', 'wprmenu' ) );
    }

		$response = 'error';
		$menu = '';

		if ( $this->option('menu') ) {
			$menu = $this->option('menu');
		}
		
		if ( isset($_POST) ) {
			$settings_id = isset($_POST['settings_id']) ? sanitize_text_field( $_POST['settings_id'] ) : '';
			$demo_type = isset($_POST['demo_type']) ? sanitize_text_field( $_POST['demo_type'] ) : '';

			$demo_id = isset( $_POST['demo_id'] ) ? sanitize_text_field( $_POST['demo_id'] ) : '';

			if ( $settings_id !== '' 
				&& $demo_type !== '' 
				&& $demo_id !== ''  ) {
				$site_name = WPRMENU_DEMO_SITE_URL;
				$remoteLink = $site_name.'/wp-json/wprmenu-server/v2/type='.$demo_type.'/demo_name='.$demo_id.'/settings_id='.$settings_id;

				$content = wp_remote_get($remoteLink);

				if ( is_array( $content ) 
					&& isset( $content['response'] ) 
					&& $content['response']['code'] == 200  ) {
					
					$content = $content['body'];
					$items = json_decode( $content, true );
          $items = wpr_of_sanitize_array( $items );
					
					if( is_array( $items ) ) {
						$items['menu'] = $menu;
					}

					if( !empty( $content ) ) {
						$response = 'success';
            update_option( 'wprmenu_options', $content );
					}
					else {
						$response = 'error';
					}
				}
				else {
					$response = 'error';
				}
			}
			else {
				$response = 'error';
			}
		}
		else {
			$response = 'error';
		}
    wp_send_json( array( 'status' => $response ) );
	}


  /**
  *
  * Get error message if menu has not been created
  *
  * @since 3.1.4
  * @return string
  */
  public function save_options_notice() {
  
    $menus = wpr_get_menus();

    if ( !empty($menus) ) {
      if ( !isset($_POST['wprmenu_options']['menu']) ) {
        add_settings_error( 'wprmenu-framework', 'save_options', __( 'You have not set any menu in the menu settings. Please select a menu from General settings tab', 'wprmenu' ), 'error fade in' );
      }
    }

  }

	/**
	*
	* Get settings from transient and save into options api
	*
	* @since 3.1
	* @param empty
	* @return json object
	*/
	public function wpr_get_transient_from_data() {

    if ( ! wp_verify_nonce( $_POST['nonce'], 'wprmenu-nonce' ) || ! current_user_can( 'administrator' ) ) {
        die ( __( 'Error while verifying your request! Try again.', 'wprmenu' ) );
    }

		$response = 'error';
		$check_transient = get_transient( 'wpr_live_settings' );
		
		if ( $check_transient ) {
			$content = maybe_serialize( $check_transient );
			update_option( 'wprmenu_options', $check_transient );
			$response = 'success';
		}
		
		echo json_encode( array( 'status' => $response ) );		
		wp_die();
	}

  /**
  *
  * Add Live Preview in admin bar
  *
  * @since 3.4
  * @param array
  * @return array
  */
  public function wprmenu_mobile_preview( $wp_admin_bar ) {
    $args = array(
      'id'      => 'wprmenu-mobile-preview',
      'title'   => '<span class="ab-icon dashicons dashicons-visibility"></span>'.__( 'Live Preview', 'wprmenu' ),
      'href'    => '#',
      'parent' => 'top-secondary',
      'meta'    => array( 'class' => 'wprmenu-mobile-preview-btn' )
    );
    
    if ( isset( $_GET['page'] ) 
      && ( $_GET['page'] == 'wp-responsive-menu' || $_GET['page'] == 'wprmenu-demo-import'  ) ) {
      $wp_admin_bar->add_node( $args );
    }
    
  }


  /**
   * Show row meta on the plugin screen.
   *
   * @param mixed $links Plugin Row Meta.
   * @param mixed $file  Plugin Base file.
   * @since 3.1.4
   *
   * @return array
   */
  public function wprmenu_plugin_row_meta( $links, $file ) {
    if ( !empty( $file ) ) {
      $file_path = explode( '/', $file );

      if( in_array( 'wp-responsive-menu', $file_path ) ) {
        $row_meta = array(
          'get_pro'    => '<a target="_blank" href="' . esc_url( apply_filters( 'pro_url', WPRMENU_PRO_LINK ) ) . '" aria-label="' . esc_attr__( 'Get Pro Version', 'wprmenu' ) . '">' . esc_html__( 'Get Pro Version', 'wprmenu' ) . '</a>',
          'other_plugins' => '<a target="_blank" href="' . esc_url( apply_filters( 'other_plugins', WPRMENU_SHOP_LINK ) ) . '" aria-label="' . esc_attr__( 'Check Our Other Plugins', 'wprmenu' ) . '">' . esc_html__( 'Check Our Other Plugins', 'wprmenu' ) . '</a>',
        );
        return array_merge( $links, $row_meta );
      }
    }
    return (array) $links;
  }

  public function plugin_action_links( $links ) {
    $admin_link = admin_url( 'admin.php?page=wp-responsive-menu' );
    $settings_link = sprintf( '<a href="%1$s">%2$s</a>', $admin_link, esc_attr__( 'Settings', 'wprmenu' ) );
    array_unshift( $links, $settings_link );
    return $links;
  }

}

new WP_Responsive_Menu();