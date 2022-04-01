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
 */
final class WPR_Menu_Loader {

  /**
   * WP Responsive Menu version.
   *
   * @var string
   */
  public $version = '3.1.7.2';


  /**
   * The single instance of the class.
   *
   * @var WP_Responsive_Menu
   * @since 3.1.4
   */
  protected static $_instance = null;


  /**
   * WPR_Menu_Loader Instance.
   *
   * @since 3.1.4
   * @static
   * @return WP_Responsive_Menu - Main instance.
   */
  public static function instance() {
    if ( is_null( self::$_instance ) ) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  public function __construct() {
    $this->define_constants();
    $this->includes();
    $this->load_plugin_textdomain();
  }

  
  /**
   * Define Constants.
   */
  private function define_constants() {
    $this->define( 'WPRMENU_VERSION', $this->version );
    $this->define( 'WPRMENU_ABSPATH', dirname( WPRMENU_FILE ) . '/' );
    $this->define( 'WPRMENU_OPTIONS_FRAMEWORK_DIRECTORY', plugins_url( '/', __FILE__ ) );
    $this->define( 'WPRMENU_OPTIONS_FRAMEWORK_PATH', dirname( __FILE__ ) . '/' );
    $this->define( 'WPRMENU_SITE_URL', 'https://www.magnigenie.com' );
    $this->define( 'WPRMENU_DEMO_SITE_URL', 'http://demo.magnigenie.com/wp-responsive-menu-pro' );
    $this->define( 'WPRMENU_PRO_LINK', WPRMENU_SITE_URL . '/downloads/wp-responsive-menu-pro/?utm_source=wp-plugins&utm_campaign=upgrade-to-pro&utm_medium=wp-dash' );
    $this->define( 'WPRMENU_SHOP_LINK', WPRMENU_SITE_URL . '/shop?utm_source=wp-plugins&utm_campaign=other-plugins&utm_medium=wp-dash' );
  }

  /**
   * Define constant if not already set.
   *
   * @param string      $name  Constant name.
   * @param string|bool $value Constant value.
   */
  private function define( $name, $value ) {
    if ( ! defined( $name ) ) {
      define( $name, $value );
    }
  }

  /**
   * Include required core files used in admin and on the frontend.
   */
  public function includes() {
    include_once WPRMENU_ABSPATH . 'inc/wprmenu-framework.php';

    include_once WPRMENU_ABSPATH . '/inc/wprmenu-styles.php';

    include_once WPRMENU_ABSPATH . '/inc/class-wp-responsive-menu.php';
  }

  /**
   * Load Language Localisation.
   */
  public function load_plugin_textdomain() {
    load_plugin_textdomain( 'wprmenu', false, plugin_basename( dirname( WPRMENU_FILE ) ) . '/languages' );
  }

  /**
   * Check whether WooCommerce has been installed and activated.
   */
  public static function check_woocommerce_installed() {
    $all_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );

    if ( stripos( implode( $all_plugins ), 'woocommerce.php' ) ) {
      return true;
    }
    return false;
  }

}