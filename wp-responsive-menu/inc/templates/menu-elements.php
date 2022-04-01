<?php
/**
 *
 * The template for displaying menu elements
 */

defined( 'ABSPATH' ) || exit;

?>
<ul id="wprmenu_menu_ul">
  <?php
  if ( $this->option( 'content_before_menu_element' ) !== '' ) :
    $content_before_menu_element = preg_replace( '/\\\\/', '', $this->option( 'content_before_menu_element' ) );
  ?>
    <li class="wprm_before_menu_content"><?php echo apply_filters( 'wpr_content_before_menu_element',  $content_before_menu_element ); ?></li>
  <?php endif; ?>

  <?php
    $search_position = $this->option( 'order_menu_items' ) != '' ? $this->option( 'order_menu_items' ) : 'Menu,Search,Social';
    
    $search_position = explode( ',', $search_position );
    
    foreach ( $search_position as $key => $menu_element ) :
      if ( $menu_element == 'Menu' ) : 
        $menus = get_terms( 'nav_menu', array( 'hide_empty'=>false ) );
        
        if ( !empty( $menus ) ) :
          foreach( $menus as $m ) :
            if ( $m->term_id == $this->option( 'menu' ) )
              $menu = $m;
          endforeach;
        endif;
        //Display the selected menu
        if ( !empty( $menu ) && is_object( $menu ) ) :
          wp_nav_menu( array( 'menu' => $menu->name, 'container' => false, 'items_wrap' => '%3$s' ) );
        endif;

      endif;

      if ( $menu_element == 'Search' ) :
        if ( $this->option( 'search_box_menu_block' ) != '' && $this->option( 'search_box_menu_block' ) == 1  ) : 
      ?>
        <li>
          <div class="wpr_search search_top">
            <?php $this->get_template_part( 'search-form' ); ?>
          </div>
        </li>
        <?php
        endif;
      endif;
    endforeach;
    ?>

    <?php
    /* After Menu Element */
    if ( $this->option( 'content_after_menu_element' ) !== '' ) :
      $content_after_menu_element = preg_replace( '/\\\\/', '', $this->option( 'content_after_menu_element' ) );
    ?>
    <li class="wprm_after_menu_content"><?php echo apply_filters( 'wpr_content_after_menu_element',  $content_after_menu_element ); ?></li>
    <?php endif; ?> 
</ul>