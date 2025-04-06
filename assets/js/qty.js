jQuery(document).ready(function ($) {
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

	$(document).on('click', '.button-qty', function(e) {
		e.preventDefault();
		let productId  = $(this).closest('form').find('button[name="add-to-cart"]').prop('value');
		let wholesales = $('.product-wholesales').find('.wholesale-item');
		let parent     = $(this).closest('form');
		let in_box     = parseInt(parent.data('in-box'));
		let input      = parent.find('input[name="quantity"]');
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

		if (is_wholesale) {
			$('.box-variation.wholesale').addClass('active');
			$('.box-variation.retail').removeClass('active');

			wholesales.each(function(i, el) {
				let data_q = parseInt($(el).data('pr-count'));
				let next_q = false;

				if (wholesales.length > i+1) {
					next_q = $(wholesales[i+1]).data('pr-count');
				}

				if (next_q && parseInt(data_q) <= parseInt(new_val) && parseInt(next_q) > parseInt(new_val) || !next_q && parseInt(data_q) <= parseInt(new_val)) {
					$('.product-wholesales').find('.wholesale-item.active').removeClass('active');
					$(el).addClass('active');
				}
			});
		} else {
			$('.product-wholesales').find('.wholesale-item.active').removeClass('active');
			$('.box-variation.retail').addClass('active');
			$('.box-variation.wholesale').removeClass('active');
		}

		input.val(new_val);
		fake_input.val(fake_val);

		replaceActualyProductPrice( productId, new_val );
	});

	function setupNumberInputValidation() {
        $('input[type="number"]:not([readonly]), .qty, .fake-qty').each(function() {
            const $input = $(this);

            $input.on('input', function() {
                let value = $input.val().replace(/\D/g, '');
                $input.val(value === '' ? '' : value);
            });

            $input.on('focus', function() {
                $input.select();
            });
        });
    }

	setupNumberInputValidation();
});