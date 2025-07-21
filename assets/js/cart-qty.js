jQuery(document).ready(function ($) {
	let updateTimer;
	let isAdjusting = false;
	const UPDATE_DELAY = 300;

	const isCheckoutPage = $('body').hasClass('woocommerce-checkout');

	function updateButtonStates(qty, maxQty, minQty, parent) {
		const plusBtn = parent.find('.qty-plus');
		const minusBtn = parent.find('.qty-minus');
		
		minusBtn.prop('disabled', qty <= minQty);
		plusBtn.prop('disabled', maxQty && qty >= maxQty);
	}

	function triggerCartUpdate() {
		clearTimeout(updateTimer);
		
		updateTimer = setTimeout(function() {
			// $('.woocommerce-cart-form, .cart').block({
			// 	message: null,
			// 	overlayCSS: {
			// 		background: '#fff',
			// 		opacity: 0.6
			// 	}
			// });
			
			const updateButton = $('button[name="update_cart"], .update-cart');
			if (updateButton.length) {
				updateButton.prop('disabled', false);
				updateButton.trigger('click');
			}
		}, UPDATE_DELAY);
	}

	function updateCheckout() {
		clearTimeout(updateTimer);
		
		updateTimer = setTimeout(function() {
			$('.woocommerce-cart-form').block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});
			
			const cartData = $('.woocommerce-cart-form');
			if (cartData.length) {
				const cartInputs = cartData.find('input[name*="cart"]');
				const nonce = $('#woocommerce-cart-nonce').val();
				const referer = $('input[name="_wp_http_referer"]').val();
				
				const $tempForm = $('<form>', {
					method: 'POST',
					action: window.location.href
				});
				
				cartInputs.each(function() {
					$tempForm.append($('<input>', {
						type: 'hidden',
						name: $(this).attr('name'),
						value: $(this).val()
					}));
				});
				
				$tempForm.append($('<input>', {
					type: 'hidden',
					name: 'update_cart',
					value: 'Оновити кошик'
				}));
				
				$tempForm.append($('<input>', {
					type: 'hidden',
					name: 'woocommerce-cart-nonce',
					value: nonce
				}));
				
				$tempForm.append($('<input>', {
					type: 'hidden',
					name: '_wp_http_referer',
					value: referer
				}));
				
				$('body').append($tempForm);
				$tempForm.submit();
			} else {
				window.location.reload();
			}
		}, UPDATE_DELAY);
	}

	$(document).on('click', '.qty-plus, .qty-minus', function(e) {
		e.preventDefault();
		
		clearTimeout(updateTimer);

		const $input 	 = $(this).siblings('.qty');
		const currentVal = parseFloat($input.val()) || 0;
		const maxQty 	 = parseFloat($input.attr('max'));
		const minQty 	 = parseFloat($input.attr('min')) || 0;
		const parent 	 = $(this).closest('.qty-container');
		const inBox  	 = parseInt(parent.data('in-box'));
		let step   	 	 = currentVal >= inBox ? inBox : 1;
		let newVal   	 = currentVal;

		if ($(this).hasClass('qty-plus')) {
			if (!maxQty || currentVal < maxQty) {
				newVal = currentVal + step;
				Math.round(newVal / inBox) * inBox;
				$input.val(newVal);
			}
		} else {
			if (currentVal > minQty) {
				step   = currentVal > inBox ? inBox : 1;
				newVal = currentVal - step;
				Math.round(newVal / inBox) * inBox;
				$input.val(newVal);
			}
		}

		updateButtonStates(newVal, maxQty, minQty, parent);

		isAdjusting = true;
		$input.trigger('change');

		updateTimer = setTimeout(function() {
			isAdjusting = false;
			
			if (isCheckoutPage) {
				updateCheckout();
			} else {
				triggerCartUpdate();
			}
		}, UPDATE_DELAY);
	});

	$(document).on('change input', '.qty', function() {
		clearTimeout(updateTimer);
		const $input 	= $(this);
		let qty 		= parseFloat($input.val()) || 0;
		const maxQty 	= parseFloat($input.attr('max'));
		const minQty 	= parseFloat($input.attr('min')) || 0;
		const parent 	= $input.closest('.qty-container');
		const inBox  	= parseInt(parent.data('in-box'));

		if ( qty > inBox ) {
			qty = Math.round(qty / inBox) * inBox;
		}

		$input.val(qty);

		updateButtonStates(qty, maxQty, minQty, parent);

		updateTimer = setTimeout(function() {
			if (isCheckoutPage) {
				updateCheckout();
			} else {
				triggerCartUpdate();
			}
		}, UPDATE_DELAY);
	});

	function initializeButtonStates() {
		$('.qty-container').each(function() {
			const parent = $(this);
			const input = parent.find('.qty');
			const qty = parseFloat(input.val()) || 0;
			const maxQty = parseFloat(input.attr('max'));
			const minQty = parseFloat(input.attr('min')) || 0;
			
			updateButtonStates(qty, maxQty, minQty, parent);
		});
	}

	initializeButtonStates();

	$(document.body).on('updated_wc_div', function() {
		setTimeout(function() {
			initializeButtonStates();
		}, 100);
	});

	$(document.body).on('wc_fragments_refreshed wc_fragments_loaded', function() {
		setTimeout(function() {
			initializeButtonStates();
		}, 100);
	});
});