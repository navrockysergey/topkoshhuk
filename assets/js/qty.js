jQuery(document).ready(function ($) {
	let cartForm = '.cart';
	let ajaxTimer;
	let initialActiveButton = $('.box-variations .active');

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

	function setWhoMethod( input = 'wholesale' ) {
		let inputs = $( '.qty-container' ).find( 'input' );
		let activeButton = $( '.box-variations' ).find( '.box-variation.'+input );
		let qtySuffix = activeButton.data('qty-suffix');

		inputs.each( function() {
			$( this ).toggleClass( 'hidden' );
		} );

		$( '.box-variations .active' ).removeClass( 'active' );
		activeButton.addClass('active');
		
		$('#qty-suffix').text(qtySuffix);
	}

	$( '.box-variation' ).on( 'click', function() {
		let input = '';

		if ( $( this ).hasClass( 'retail' ) ) {
			input = 'retail';
		} else if ( $( this ).hasClass( 'wholesale' ) ) {
			input = 'wholesale';
		}

		setWhoMethod( input );

		let qtySuffix = $(this).data('qty-suffix');
		$('#qty-suffix').text(qtySuffix);
	} )

	if (initialActiveButton.length) {
		let initialQtySuffix = initialActiveButton.data('qty-suffix');
		$('#qty-suffix').text(initialQtySuffix);
	}

	function replaceActualyWholesale( quentity, is_wholesale = false ) {
		let wholesales = $('.product-wholesales').find('.wholesale-item');

		if (is_wholesale) {
			wholesales.each(function(i, el) {
				let data_q = parseInt($(el).data('pr-count'));
				let next_q = false;

				if (wholesales.length > i+1) {
					next_q = $(wholesales[i+1]).data('pr-count');
				}

				if (next_q && parseInt(data_q) <= parseInt(quentity) && parseInt(next_q) > parseInt(quentity) || !next_q && parseInt(data_q) <= parseInt(quentity)) {
					$('.product-wholesales').find('.wholesale-item.active').removeClass('active');
					$(el).addClass('active');
				}
			});
		} else {
			$('.product-wholesales').find('.wholesale-item.active').removeClass('active');
		}
	}

	function replaceActualyProductPrice( prodId , prodQty ) {		
		$.ajax({
			type 	 : 'POST',
			dataType : 'json',
			url      : dataObj['ajaxUrl'],
			data	 : {
				action : 'get_product_prices',
				prodId : prodId,
				prodQty: prodQty,
			},
			success : function( response ) {
				let innerPrice = response['price'];
				let regular = response['regular'];

				if ( 0 !== response['who_price'] ) {
					innerPrice  = response['who_price'];

					if ( ! $( '.price .old-price' ).length ) {
						let oldHtml = '<span class="old-price"><del aria-hidden="true">' + regular + '</del></span>';
						$( '.price' ).prepend( oldHtml );
					}
				} else if ( $( '.price .old-price' ).length && ! response['has_sale'] ) {
					$( '.price' ).find( '.old-price' ).remove();
				}
				
				$( 'form .actual-price' ).find( '.woocommerce-Price-amount' ).replaceWith( innerPrice );
			}
		});
	}

	function ajaxAddToCart( prodId, qty ) {
		$(cartForm).block({
			message: null,
			overlayCSS: {
				background: '#fff',
				opacity: 0.6
			}
		});

		$.ajax({
			type : 'POST',
			dataType : 'json',
			url : dataObj['ajaxUrl'],
			data : {
				action : 'dynamic_add_to_cart',
				prodId : prodId,
				prodQuentity : qty,
			},
			success : function( response ) {
				if ( response['success'] ) {
					if ( $('body').hasClass('single-product') ) {
						
						if (response['data'] && response['data']['number_of_positions'] !== undefined) {
							$('.header-cart .cart-count').text(response['data']['number_of_positions']);
						}

						replaceActualyProductPrice( prodId , qty );

						$(cartForm).unblock();
					} else {
						window.location.reload();
					}
				}
			}
		});
	}

	$(document).on('click', '.button-qty', function(e) {
		e.preventDefault();
		
		let parent     = $(this).closest('.qty-container');
		let in_box     = parseInt($('form.cart').data('in-box'));
		let input      = parent.find('input.qty');
		let fake_input = parent.find('input.fake-qty');
		let input_val  = parseInt(input.val());
		let step       = 1;
		let new_val;
		let fake_val;
		let is_wholesale = false;

		if ($(this).hasClass('qty-plus')) {
			if ((input_val + step) == in_box) {
				step = 1;

				new_val      = input_val + step;
				fake_val     = new_val/in_box;
				is_wholesale = true;
			} else if ((input_val + step) > in_box) {
				step = in_box;

				new_val      = roundToNearestMultiple(in_box, input_val + step);
				fake_val     = new_val/in_box;
				is_wholesale = true;
			} else {
				step = 1;

				new_val     = input_val + step;
				fake_val     = new_val;
				is_wholesale = false;
			}
		} else {
			if ((input_val - step) >= in_box) {
				step = in_box;

				new_val      = roundToNearestMultiple(in_box, input_val - step);
				fake_val     = new_val/in_box;
				is_wholesale = true;
			} else {
				step = 1;

				new_val = Math.max(1, input_val - step);
				fake_val = new_val;
				is_wholesale = false;
			}
		}

		replaceActualyWholesale( new_val, is_wholesale );

		input.val(new_val);
		fake_input.val(fake_val);

		console.log('in_box:', in_box);
		console.log('input_val:', input_val);
		console.log('new_val:', new_val);
		console.log('fake_val:', fake_val);
		
		clearTimeout(ajaxTimer);
		
		ajaxTimer = setTimeout(function() {
			ajaxAddToCart(parent.data('product-id'), new_val);
		}, 500);
	});

	function setupNumberInputValidation() {
		$('input[type="number"]:not([readonly]), .qty, .fake-qty').each(function() {
			const $input = $(this);
			const MAX_DIGITS = 5;
	
			$input.on('input', function() {
				let value = $input.val().replace(/\D/g, '');
				
				if (value.length > MAX_DIGITS) {
					value = value.substring(0, MAX_DIGITS);
				}
				
				$input.val(value === '' ? '' : value);
			});
	
			$input.on('focus', function() {
				$input.select();
			});
		});
	}

	$('.qty-container').find('input').on('change', function(e){
		let new_val, fake_val, parent, in_box;
			parent     = $(this).closest('.qty-container');
			in_box     = parseInt($('form.cart').data('in-box'));

		if( $(this).hasClass('fake-qty') ) {
			new_val = parseInt($(this).val()*in_box);

			parent.find('input.qty').val(new_val);
		} else {
			new_val = roundToNearestMultiple(in_box, parseInt($(this).val()));
			fake_val = new_val/in_box;

			$(this).val(new_val);
			parent.find('input.fake-qty').val(fake_val);
		}

		replaceActualyWholesale( new_val, new_val > in_box );

		ajaxTimer = setTimeout(function() {
			ajaxAddToCart( parent.data( 'product-id' ), new_val );
		}, 500);
	})

	setupNumberInputValidation();
});