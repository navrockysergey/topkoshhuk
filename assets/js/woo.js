jQuery(document).ready(function ($) {

    let sliderSpeed = 1000;
    
    if ($('.category-header select').length > 0 && $.fn.select2) {
        $('.category-header select').select2({
            minimumResultsForSearch: 10,
            dropdownPosition: 'below'
        });
    }

    function removeNbsp() {
        $('.woocommerce-checkout-review-order td').each(function() {
            $(this).html($(this).html().replace(/&nbsp;/g, ''));
        });
    }

    removeNbsp();

    $(document.body).on('updated_checkout', function() {
        removeNbsp();
    });

	let carouselCategories = $('#menu-categories');

	carouselCategories.owlCarousel({
		items: 4,
		navSpeed: sliderSpeed,
		autoplaySpeed: sliderSpeed,
		nav: true,
		autoplay: false,
		autoplayTimeout: 6000,
		margin: 30,
		autoplayHoverPause: true,
		dots: true,
		loop: (carouselCategories.find('.product').length > 4),
		navText: ['', ''],
		mouseDrag: true,
		touchDrag: true,
		dragEndSpeed: sliderSpeed,
		dotsSpeed: sliderSpeed,
		autoHeight: true,
		autoplayHoverPause: true,
		responsive: {
			0: {
				items: 1,
				nav: false,
				margin: 0,
				autoplay: false,
				loop: (carouselCategories.find('.product').length > 1),
			},
			768: {
				items: 2,
				autoplay: false,
				nav: true,
				dots: true,
				loop: (carouselCategories.find('.product').length > 1),
			},
			1024: {
				items: 2,
				nav: true,
				dots: true,
				loop: (carouselCategories.find('.product').length > 3),
			},
			1200: {
				items: 3,
				nav: true,
				dots: true,
				loop: (carouselCategories.find('.product').length > 5),
			}
		}
	});

	$('#carousel-popular, #carousel-crosssell, #carousel-related-products, #carousel-upsell-products').each(function() {
		let $carousel = $(this);
		let productCount = $carousel.find('.product').length;
	
		$carousel.owlCarousel({
			items: 3,
			navSpeed: sliderSpeed,
			autoplaySpeed: sliderSpeed,
			nav: true,
			autoplay: true,
			autoplayTimeout: 6000,
			margin: 0,
			dots: false,
			loop: (productCount > 3),
			navText: ['', ''],
			mouseDrag: true,
			touchDrag: true,
			dragEndSpeed: sliderSpeed,
			dotsSpeed: sliderSpeed,
			autoHeight: true,
			autoplayHoverPause: true,
			responsive: {
				0: {
					items: 1,
					margin: 0,
					autoplay: false,
					nav: true,
					dots: false,
					loop: (productCount > 1),
				},
				768: {
					items: 2,
					autoplay: false,
					nav: true,
					dots: false,
					loop: (productCount > 2),
				},
				1024: {
					items: 2,
					nav: true,
					dots: false,
					loop: (productCount > 2),
				},
				1200: {
					items: 3,
					nav: true,
					dots: false,
					loop: (productCount > 3),
				}
			}
		});
	});	

    // $(document.body).on('change input', '.woocommerce-cart input.qty', function() {
    //     setTimeout(function() {
    //         $('.woocommerce-cart [name=update_cart]').trigger('click');
    //     }, 200);
    // });

	$(document.body).on('click', '.woocommerce-cart .checkout-button.disabled', function(e) {
		e.preventDefault();
	});


	// ===============================================================================

	function roundToNearestMultiple( n, q ) {
		var remainder = q % n;
		if ( remainder === 0 ) {
		  return q;
		}

		var lower = q - remainder;
		var upper = q + (n - remainder);

		if ( q - lower <= upper - q ) {
		  return lower;
		} else {
		  return upper;
		}
	  }

	$( document ).on( 'click', '.set-quantity', function( e ) {
		e.preventDefault();
		let wholesales = $( '.product-wholesales' ).find( '.wholesale-item' );
		let parent     = $( this ).closest( 'form' );
		let in_box     = parseInt( parent.data( 'in-box' ) );
		let input      = parent.find( 'input[name="quantity"]' );
		let fake_input = parent.find( 'input.fake-qty' );
		let input_val  = parseInt( input.val() );
		let step       = 1;
		let new_val;
		let fake_val;
		let is_wholesale = false;

		if ( $( this ).hasClass( 'plus' ) ) {
			if ( ( input_val + step ) == in_box ) {
				step = 1;

				new_val      = input_val + step;
				fake_val     = new_val/in_box;
				is_wholesale = true;
			} else if ( ( input_val + step ) > in_box ) {
				step = in_box;

				new_val      = roundToNearestMultiple( in_box, input_val + step );
				fake_val     = new_val/in_box;
				is_wholesale = true;
			} else {
				step = 1;

				new_val     = input_val + step;
				fake_val     = new_val;
				is_wholesale = false;
			}
		} else {
			if ( ( input_val - step ) >= in_box ) {
				step = in_box;

				new_val      = roundToNearestMultiple( in_box, input_val - step );
				fake_val     = new_val/in_box;
				is_wholesale = true;
			} else {
				step = 1;

				new_val      = input_val - step;
				fake_val     = new_val;
				is_wholesale = false;
			}
		}

		if ( is_wholesale ) {
			$( '.box-variation.wholesale' ).addClass( 'active' );
			$( '.box-variation.retail' ).removeClass( 'active' );

			wholesales.each( function( i, el ) {
				let data_q = parseInt( $(el).data( 'pr-count' ) );
				let next_q = false;

				if ( wholesales.length <= i+1 ) {
					next_q = $(wholesales[i+1]).data( 'pr-count' );
				}

				if ( next_q && parseInt( data_q ) <= parseInt( new_val ) && parseInt( next_q ) > parseInt( new_val ) || ! next_q && parseInt( data_q ) <= parseInt( new_val ) ) {
					$( '.product-wholesales' ).find( '.wholesale-item.active' ).removeClass( 'active' );
					$( el ).addClass( 'active' );
				}
			} )
		} else {
			$( '.product-wholesales' ).find( '.wholesale-item.active' ).removeClass( 'active' );
			$( '.box-variation.retail' ).addClass( 'active' );
			$( '.box-variation.wholesale' ).removeClass( 'active' );
		}

		input.val( new_val );
		fake_input.val( fake_val );
	})
});

