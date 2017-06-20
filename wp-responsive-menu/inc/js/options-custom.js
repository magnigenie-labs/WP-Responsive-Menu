/**
 * Custom scripts needed for the colorpicker, image button selectors,
 * and navigation tabs.
 */

jQuery( document ).ready( function( $ ) {

	// Loads the color pickers
	$( '.of-color' ).wpColorPicker();

	// Image Options
	$( '.of-radio-img-img' ).click( function(){
		$( this ).parent().parent().find( '.of-radio-img-img' ).removeClass( 'of-radio-img-selected' );
		$( this ).addClass( 'of-radio-img-selected' );
	} );

	$( '.of-radio-img-label' ).hide();
	$( '.of-radio-img-img' ).show();
	$( '.of-radio-img-radio' ).hide();

	// Loads tabbed sections if they exist
	if (  $( '.nav-tab-wrapper' ).length > 0  ) {
		options_framework_tabs();
	}

	function options_framework_tabs() {

		var $group = $( '.group' ),
			$navtabs = $( '.nav-tab-wrapper a' ),
			active_tab = '';

		// Hides all the .group sections to start
		$group.hide();

		// Find if a selected tab is saved in localStorage
		if (  typeof( localStorage ) != 'undefined'  ) {
			active_tab = localStorage.getItem( 'active_tab' );
		}

		// If active tab is saved and exists, load it's .group
		if (  active_tab != '' && $( active_tab ).length  ) {
			$( active_tab ).fadeIn();
			$( active_tab + '-tab' ).addClass( 'nav-tab-active' );
		} else {
			$( '.group:first' ).fadeIn();
			$( '.nav-tab-wrapper a:first' ).addClass( 'nav-tab-active' );
		}

		// Bind tabs clicks
		$navtabs.click( function( e ) {

			e.preventDefault();

			// Remove active class from all tabs
			$navtabs.removeClass( 'nav-tab-active' );

			$( this ).addClass( 'nav-tab-active' ).blur();

			if ( typeof( localStorage ) != 'undefined'  ) {
				localStorage.setItem( 'active_tab', $( this ).attr( 'href' )  );
			}

			var selected = $( this ).attr( 'href' );

			$group.hide();
			$( selected ).fadeIn();

		} );
	}
	var slideOpt = $( '#section-slide_type option:selected' ).val();
	if (  slideOpt == 'bodyslide' ) {
		$( '#section-position option:eq( 2 )' ).css(  'display', 'none'  );
		$( '#section-position option:eq( 3 )' ).css(  'display', 'none'  );
	}
	$( '#slide_type' ).change( function() {
		if (  $( this ).val() == 'bodyslide' ) {
			$( '#section-position option:eq( 2 )' ).css(  'display', 'none'  );
			$( '#section-position option:eq( 3 )' ).css(  'display', 'none'  );
		}
		else {
			$( '#section-position option:eq( 2 )' ).css(  'display', 'block'  );
			$( '#section-position option:eq( 3 )' ).css(  'display', 'block'  );			
		}
	} )
    var menutype = $( "input[name='wprmenu_options[menu_type]']:checked" ).val();
	if (  menutype == 'default' ) {
		$( '#section-custom_menu_top' ).css(  'display', 'none' );
		$( '#section-custom_menu_left' ).css(  'display', 'none' );   			
	}
    $( '#section-menu_type input' ).on( 'change', function() {
   		var menuType = $( 'input[name="wprmenu_options[menu_type]"]:checked', '#section-menu_type' ).val(); 
   		if (  menuType == 'default' ) {
   			$( '#section-custom_menu_top' ).css(  'display', 'none' );
   			$( '#section-custom_menu_left' ).css(  'display', 'none' );   			
   		}
   		else {
   			$( '#section-custom_menu_top' ).css(  'display', 'block' );
   			$( '#section-custom_menu_left' ).css(  'display', 'block' );   			   			
   		}
	} );

} );