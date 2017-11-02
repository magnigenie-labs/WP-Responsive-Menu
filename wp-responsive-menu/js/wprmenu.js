( function( window ) {

'use strict';

// class helper functions from bonzo https://github.com/ded/bonzo

function classReg( className ) {
  return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
}

// classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once
var hasClass, addClass, removeClass;

if ( 'classList' in document.documentElement ) {
  hasClass = function( elem, c ) {
    return elem.classList.contains( c );
  };
  addClass = function( elem, c ) {
    elem.classList.add( c );
  };
  removeClass = function( elem, c ) {
    elem.classList.remove( c );
  };
}
else {
  hasClass = function( elem, c ) {
    return classReg( c ).test( elem.className );
  };
  addClass = function( elem, c ) {
    if ( !hasClass( elem, c ) ) {
      elem.className = elem.className + ' ' + c;
    }
  };
  removeClass = function( elem, c ) {
    elem.className = elem.className.replace( classReg( c ), ' ' );
  };
}

function toggleClass( elem, c ) {
  var fn = hasClass( elem, c ) ? removeClass : addClass;
  fn( elem, c );
}

window.classie = {
  // full names
  hasClass: hasClass,
  addClass: addClass,
  removeClass: removeClass,
  toggleClass: toggleClass,
  // short names
  has: hasClass,
  add: addClass,
  remove: removeClass,
  toggle: toggleClass
};

})( window );

jQuery( document ).ready( function( $ ) {
	var	Mgwprm = document.getElementById( 'mg-wprm-wrap' );
	var	wprm_menuDir = document.getElementById( 'wprMenu' );
	body = document.body;

	//Body slide from one side ( left or right ) 
	$('body').addClass('cbp-spmenu-push');

		$('.wprmenu_bar').click( function(event) {
			if( $(event.target).hasClass('bar_logo') )
				return;
			
			classie.toggle( this, 'active' );
			$(this).find('div.hamburger').toggleClass('is-active');
			// For the right side body push
			if ($(this).hasClass('bodyslide') && $(this).hasClass('left')) {
				classie.toggle(body, 'cbp-spmenu-push-toright');
			}
			// For the left side body push
			if ($(this).hasClass('bodyslide') &&  $(this).hasClass('right')) {
				classie.toggle(body, 'cbp-spmenu-push-toleft');
			}
			classie.toggle(Mgwprm, 'cbp-spmenu-open');

			close_sub_uls();

		});

	$('.wprmenu_icon').click( function(){
		$(this).toggleClass('open');
	});

	$('#page').click( function(){
		$('.wprmenu_icon.open').trigger("click");
	});

	// Click on body remove the menu
	$('body').click( function( event ) {	
		if ( $( '#wprmenu_bar' ).hasClass( 'active' ) ) {
			$('#wprmenu_bar .wprmenu_icon').addClass('open');
		}	
		else {
			$('#wprmenu_bar .wprmenu_icon').removeClass('open');
		}
	});


	menu = $('#mg-wprm-wrap');
	menu_ul = $('#wprmenu_menu_ul'), //the menu ul

	//add arrow element to the parent li items and chide its child uls
	menu.find('ul.sub-menu').each(function() {
		var sub_ul = $(this),
			parent_a = sub_ul.prev('a'),
			parent_li = parent_a.parent('li').first();

			parent_a.addClass('wprmenu_parent_item');
			parent_li.addClass('wprmenu_parent_item_li');

			var expand = parent_a.before('<span class="wprmenu_icon wprmenu_icon_par icon_default"></span> ').find('.wprmenu_icon_par');
			sub_ul.hide();
	});

	//adjust the a width on parent uls so it fits nicely with th eicon elemnt
	function adjust_expandable_items() {
		$('.wprmenu_parent_item_li').each(function() {
			var t = $(this),
			main_ul_width = 0,
			icon = t.find('.wprmenu_icon_par').first(),
			link = t.find('a.wprmenu_parent_item').first();

			if(menu.hasClass('top')) 
				main_ul_width = window.innerWidth;
			else 
				main_ul_width = menu_ul.innerWidth();
			
		});
	}
	
	adjust_expandable_items();

	//expand / collapse action (SUBLEVELS)
	$('.wprmenu_icon_par').on('click',function() {
		var t = $(this),
		child_ul = t.parent('li').find('ul.sub-menu').first();
		child_ul.slideToggle('300');
		t.toggleClass('wprmenu_par_opened');
		t.parent('li').first().toggleClass('wprmenu_no_border_bottom');
	});

	//helper - close all submenus when menu is hiding
	function close_sub_uls() {
		menu.find('ul.sub-menu').each(function() {
			var ul = $(this),
			icon = ul.parent('li').find('.wprmenu_icon_par'),
			li = ul.parent('li');

			if(ul.is(':visible')) ul.slideUp(300);
			icon.removeClass('wprmenu_par_opened');
			li.removeClass('wprmenu_no_border_bottom');
		});
	}

	//submenu opened
	function open_sub_uls() {
		menu.find('ul.sub-menu').each(function() {
			var ul = $(this),
			icon = ul.parent('li').find('.wprmenu_icon_par'),
			li = ul.parent('li');

			ul.slideDown(300);
			icon.removeClass('wprmenu_par_opened');
			icon.addClass('wprmenu_par_opened');
		});
	}

	if( wprmenu.parent_click == 'yes' ) {
		$('a.wprmenu_parent_item').on('click', function(e){
			e.preventDefault();
			$(this).prev('.wprmenu_icon_par').trigger('click');
		});
	}

	if( wprmenu.swipe == 'yes' ) {
		$('body').swipe({
			excludedElements: "button, input, select, textarea, .noSwipe",
			threshold: 200,
			swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
				menu_el = $('.wprmenu_bar .hamburger, .wprmenu_bar .wpr-custom-menu');
				if( direction =='left' && menu_el.hasClass('is-active') )
					menu_el.trigger('click');
				
				if( direction =='right' && !menu_el.hasClass('is-active') )
					menu_el.trigger('click');
    		}
		});
	}

});