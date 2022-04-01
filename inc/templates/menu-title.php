<?php
/**
 *
 * The template for displaying menu title
 */

defined( 'ABSPATH' ) || exit;

$menu_title = isset( $data['menu_title'] ) ? $data['menu_title'] : '';
$bar_logo = isset( $data['bar_logo'] ) ? $data['bar_logo'] : '';
?>
<div class="menu_title">
  <?php echo esc_html( $menu_title ); ?>
  <?php if ( !empty( $bar_logo ) ) : ?>
    <img class="bar_logo" alt="logo" src="<?php echo esc_url( $bar_logo ); ?>"/>'
  <?php endif; ?>
</div>