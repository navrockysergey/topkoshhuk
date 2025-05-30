jQuery(document).ready(function ($) {
	let cartForm = '.cart';
	let ajaxTimer;
	let initialActiveButton = $('.box-variations .active');

	$(cartForm).find('input[name="quantity"][type="hidden"]').attr('type', 'number');

	function roundToNearestMultiple(n, q) {
		var remainder = q % n;
		if (remainder === 0) {
			return q;
		}

		var lower = q - remainder;
		var upper = q + (n - remainder);

		if (q - lower <= upper - q) {
			return lower;
		} else {
			return upper;
		}
	}

	function setWhoMethod(input = 'wholesale') {
		let qtyInput = $('.qty-container').find('input.qty');
		let fakeQtyInput = $('.qty-container').find('input.fake-qty');
		let activeButton = $('.box-variations').find('.box-variation.' + input);
		let qtySuffix = activeButton.data('qty-suffix');
		let in_box = parseInt($('form.cart').data('in-box'));

		// If in_box is 0, force retail mode and disable wholesale
		if (in_box === 0) {
			input = 'retail';
			activeButton = $('.box-variations').find('.box-variation.retail');
			qtySuffix = activeButton.data('qty-suffix');
			$('.box-variation.wholesale').prop('disabled', true).addClass('disabled');
		}

		if (input === 'wholesale') {
			// Wholesale mode (boxes): show fake-qty, hide qty
			qtyInput.addClass('hidden');
			fakeQtyInput.removeClass('hidden');
		} else {
			// Retail mode (units): show qty, hide fake-qty
			qtyInput.removeClass('hidden');
			fakeQtyInput.addClass('hidden');
		}

		// Remove active from all buttons first
		$('.box-variations .box-variation').removeClass('active');
		// Add active only to selected button
		activeButton.addClass('active');
		
		$('#qty-suffix').text(qtySuffix);
	}

	// Function to check and automatically switch modes
	function checkAndSwitchMode(qty, in_box, max_qty) {
		// If in_box is 0, always use retail mode
		if (in_box === 0) {
			$('.box-variation.wholesale').prop('disabled', true).addClass('disabled');
			setWhoMethod('retail');
			return false;
		}

		let is_wholesale = $('.box-variation.wholesale').hasClass('active');
		
		// If quantity is less than box size, switch to units mode
		if (qty < in_box && is_wholesale) {
			setWhoMethod('retail');
			return false; // units mode
		}
		
		// If max quantity is less than box size, disable wholesale mode
		if (max_qty < in_box) {
			$('.box-variation.wholesale').prop('disabled', true).addClass('disabled');
			if (is_wholesale) {
				setWhoMethod('retail');
			}
			return false;
		} else {
			$('.box-variation.wholesale').prop('disabled', false).removeClass('disabled');
		}
		
		return is_wholesale;
	}

	// Function to update +/- button states
	function updateButtonStates(qty, max_qty, in_box) {
		let parent = $('.qty-container');
		let plus_btn = parent.find('.qty-plus');
		let minus_btn = parent.find('.qty-minus');
		let is_wholesale = $('.box-variation.wholesale').hasClass('active');
		
		// If in_box is 0, wholesale mode should be disabled
		if (in_box === 0) {
			is_wholesale = false;
		}
		
		// Minus button
		if (is_wholesale) {
			// In wholesale mode: disable if less than one box
			if (qty < in_box) {
				minus_btn.prop('disabled', true);
			} else {
				minus_btn.prop('disabled', false);
			}
		} else {
			// In retail mode: disable if 0 or less
			if (qty <= 0) {
				minus_btn.prop('disabled', true);
			} else {
				minus_btn.prop('disabled', false);
			}
		}
		
		// Plus button
		if (is_wholesale) {
			// In wholesale mode: check if we can add another box
			if (qty + in_box > max_qty) {
				plus_btn.prop('disabled', true);
			} else {
				plus_btn.prop('disabled', false);
			}
		} else {
			// In retail mode: check maximum quantity
			if (qty >= max_qty) {
				plus_btn.prop('disabled', true);
			} else {
				plus_btn.prop('disabled', false);
			}
		}
		
		updateCheckoutButton();
	}

	function updateCheckoutButton() {
		let hasQuantity = false;
		
		$('.qty-container input.qty').each(function() {
			const qty = parseFloat($(this).val()) || 0;
			if (qty > 0) {
				hasQuantity = true;
				return false;
			}
		});
		
		const checkoutButton = $('.cart .button-checkout');
		if (hasQuantity) {
			checkoutButton.removeClass('disabled hidden').removeAttr('disabled');
		} else {
			checkoutButton.addClass('disabled hidden').attr('disabled', 'disabled');
		}
	}

	$('.box-variation').on('click', function() {
		let input = '';
		let in_box = parseInt($('form.cart').data('in-box'));

		// If in_box is 0, prevent switching to wholesale mode
		if (in_box === 0 && $(this).hasClass('wholesale')) {
			return false;
		}

		if ($(this).hasClass('retail')) {
			input = 'retail';
		} else if ($(this).hasClass('wholesale')) {
			input = 'wholesale';
		}

		// Get current values before switching
		let parent = $('.qty-container');
		let qty = parseInt(parent.find('input.qty').val()) || 0;
		let max_qty = parseInt(parent.find('input.qty').attr('max')) || 9999;
		let fake_input = parent.find('input.fake-qty');
		
		// Switch the mode
		setWhoMethod(input);

		let qtySuffix = $(this).data('qty-suffix');
		$('#qty-suffix').text(qtySuffix);
		
		// Recalculate fake_val based on new mode, but preserve original qty
		let new_fake_val;
		
		if (input === 'wholesale' && in_box > 0) {
			// Switched to boxes mode
			// Show how many full boxes current qty represents
			new_fake_val = Math.floor(qty / in_box);
		} else {
			// Switched to units mode  
			// fake_val should show total units count
			new_fake_val = qty;
			// Update box information
			if (qty > 0 && in_box > 0) {
				updateBoxDisplay(qty, in_box);
			}
		}
		
		// Update only fake input, keep qty unchanged
		fake_input.val(new_fake_val);
		
		updateButtonStates(qty, max_qty, in_box);
		
		// Update wholesale price highlighting
		if (qty > 0) {
			replaceActualyWholesale(qty);
		}
	});

	if (initialActiveButton.length) {
		let initialQtySuffix = initialActiveButton.data('qty-suffix');
		$('#qty-suffix').text(initialQtySuffix);
	}

	function replaceActualyWholesale(quantity) {
		let wholesales = $('.product-wholesales').find('.wholesale-item');
		
		// Always remove active class first
		$('.product-wholesales').find('.wholesale-item.active').removeClass('active');

		// Determine appropriate wholesale price based on quantity (always in units)
		let activeWholesale = null;
		let maxMatchingCount = 0;

		wholesales.each(function(i, el) {
			let data_count = parseInt($(el).data('pr-count'));
			
			// If product quantity is greater than or equal to minimum for this price
			if (quantity >= data_count && data_count > maxMatchingCount) {
				maxMatchingCount = data_count;
				activeWholesale = $(el);
			}
		});

		// Highlight appropriate wholesale price
		if (activeWholesale) {
			activeWholesale.addClass('active');
		}
	}

	function replaceActualyProductPrice(prodId, prodQty) {		
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: dataObj['ajaxUrl'],
			data: {
				action: 'get_product_prices',
				prodId: prodId,
				prodQty: prodQty,
			},
			success: function(response) {
				let innerPrice = response['price'];
				let regular = response['regular'];

				if (0 !== response['who_price']) {
					innerPrice = response['who_price'];

					if (!$('.price .old-price').length) {
						let oldHtml = '<span class="old-price"><del aria-hidden="true">' + regular + '</del></span>';
						$('.price').prepend(oldHtml);
					}
				} else if ($('.price .old-price').length && !response['has_sale']) {
					$('.price').find('.old-price').remove();
				}
				
				$('form .actual-price').find('.woocommerce-Price-amount').replaceWith(innerPrice);
			}
		});
	}

	function ajaxAddToCart(prodId, qty) {
		$(cartForm).block({
			message: null,
			overlayCSS: {
				background: '#fff',
				opacity: 0.6
			}
		});

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: dataObj['ajaxUrl'],
			data: {
				action: 'dynamic_add_to_cart',
				prodId: prodId,
				prodQuentity: qty,
			},
			success: function(response) {
				if (response['success']) {
					if ($('body').hasClass('single-product')) {
						
						if (response['data'] && response['data']['number_of_positions'] !== undefined) {
							$('.header-cart .cart-count').text(response['data']['number_of_positions']);
						}

						replaceActualyProductPrice(prodId, qty);

						// Show WooCommerce success notice
						if (response['data'] && response['data']['notice']) {
							showWooNotice(response['data']['notice'], 'success');
						} else {
							showWooNotice(dataObj.cartUpdated || 'Cart updated.', 'success');
						}

						$(cartForm).unblock();
					} else {
						window.location.reload();
					}
				}
			},
			error: function() {
				showWooNotice(dataObj.errorMessage || 'Something went wrong.', 'error');
				$(cartForm).unblock();
			}
		});
	}

	function showWooNotice(message, type = 'success') {
		// Remove existing notices
		$('.woocommerce-notices-wrapper .woocommerce-message, .woocommerce-notices-wrapper .woocommerce-error').remove();
		
		// Create notice HTML
		let noticeClass = type === 'success' ? 'woocommerce-message' : 'woocommerce-error';
		let noticeHtml = `<div class="${noticeClass}" role="alert">${message}</div>`;
		
		// Find or create notices wrapper
		let noticesWrapper = $('.woocommerce-notices-wrapper');
		if (!noticesWrapper.length) {
			noticesWrapper = $('<div class="woocommerce-notices-wrapper"></div>');
			$('form.cart').before(noticesWrapper);
		}
		
		// Add notice
		noticesWrapper.html(noticeHtml);
		
		// Scroll to notice
		$('html, body').animate({
			scrollTop: noticesWrapper.offset().top - 100
		}, 500);
		
		// Auto hide after 3 seconds
		setTimeout(function() {
			noticesWrapper.find(`.${noticeClass}`).fadeOut();
		}, 3000);
	}

	$(document).on('click', '.button-qty', function(e) {
		e.preventDefault();
		
		let parent = $(this).closest('.qty-container');
		let in_box = parseInt($('form.cart').data('in-box'));
		let input = parent.find('input.qty');
		let fake_input = parent.find('input.fake-qty');
		let input_val = parseInt(input.val()) || 0;
		let max_qty = parseInt(input.attr('max')) || 9999;
		let new_val, fake_val;
		let is_wholesale = $('.box-variation.wholesale').hasClass('active');

		// If in_box is 0, force retail mode
		if (in_box === 0) {
			is_wholesale = false;
		}

		if ($(this).hasClass('qty-plus')) {
			if (is_wholesale && in_box > 0) {
				// In wholesale mode add a whole box
				if (input_val === 0) {
					// If cart is empty, add first box
					new_val = in_box;
				} else {
					new_val = input_val + in_box;
				}
				if (new_val > max_qty) {
					new_val = max_qty;
				}
				fake_val = Math.floor(new_val / in_box);
			} else {
				// In retail mode add one unit
				if (input_val === 0) {
					// If cart is empty, add first unit
					new_val = 1;
				} else {
					new_val = Math.min(input_val + 1, max_qty);
				}
				fake_val = new_val;
				// Update box information
				if (in_box > 0) {
					updateBoxDisplay(new_val, in_box);
				}
			}
		} else {
			// Minus button
			if (is_wholesale && in_box > 0) {
				// In wholesale mode remove a whole box
				new_val = Math.max(0, input_val - in_box);
				fake_val = new_val > 0 ? Math.floor(new_val / in_box) : 0;
			} else {
				// In retail mode remove one unit
				new_val = Math.max(0, input_val - 1);
				fake_val = new_val;
				// Update box information
				if (new_val > 0 && in_box > 0) {
					updateBoxDisplay(new_val, in_box);
				}
			}
		}

		// Check and switch mode if necessary
		is_wholesale = checkAndSwitchMode(new_val, in_box, max_qty);
		
		// Recalculate fake_val after possible mode switch
		if (is_wholesale && in_box > 0) {
			fake_val = new_val > 0 ? Math.floor(new_val / in_box) : 0;
		} else {
			fake_val = new_val;
		}

		// Highlight wholesale price (always pass quantity in units)
		replaceActualyWholesale(new_val);

		input.val(new_val);
		fake_input.val(fake_val);
		
		// Update button states
		updateButtonStates(new_val, max_qty, in_box);
		
		clearTimeout(ajaxTimer);

		ajaxTimer = setTimeout(function() {
			if (new_val > 0) {
				input_qty_change(fake_input);
			} else {
				// Remove from cart
				ajaxAddToCart(parent.data('product-id'), 0);
			}
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

	function input_qty_change(input) {
		let new_val, fake_val, parent, in_box, max_qty;
		parent = input.closest('.qty-container');
		in_box = parseInt($('form.cart').data('in-box'));
		max_qty = parseInt(parent.find('input.qty').attr('max')) || 9999;
		let is_wholesale = $('.box-variation.wholesale').hasClass('active');

		// If in_box is 0, force retail mode
		if (in_box === 0) {
			is_wholesale = false;
		}

		if (input.hasClass('fake-qty')) {
			let fake_input_val = parseInt(input.val()) || 0;
			
			if (is_wholesale && in_box > 0) {
				// In wholesale mode - fake-qty is number of boxes
				new_val = fake_input_val * in_box;
			} else {
				// In retail mode - fake-qty is number of units
				new_val = fake_input_val;
			}
			
			// Limit by maximum quantity, but allow 0
			new_val = Math.min(Math.max(0, new_val), max_qty);
			
			// Update main input
			parent.find('input.qty').val(new_val);
			
			// If units changed, recalculate boxes
			if (!is_wholesale && new_val > 0 && in_box > 0) {
				// Update box display (how many full boxes + remainder)
				updateBoxDisplay(new_val, in_box);
			}
		} else {
			// Changing main input (qty)
			new_val = parseInt(input.val()) || 0;
			
			// Limit by maximum quantity, but allow 0
			new_val = Math.min(Math.max(0, new_val), max_qty);
			
			if (is_wholesale && in_box > 0) {
				// In wholesale mode round to nearest multiple of box size
				if (new_val > 0) {
					new_val = roundToNearestMultiple(in_box, new_val);
				}
				fake_val = new_val > 0 ? Math.floor(new_val / in_box) : 0;
			} else {
				// In retail mode keep as is
				fake_val = new_val;
				// Update box display
				if (new_val > 0 && in_box > 0) {
					updateBoxDisplay(new_val, in_box);
				}
			}

			input.val(new_val);
			parent.find('input.fake-qty').val(fake_val);
		}

		// Check and switch mode if necessary
		is_wholesale = checkAndSwitchMode(new_val, in_box, max_qty);
		
		// Recalculate fake_val after possible mode switch
		if (is_wholesale && in_box > 0) {
			fake_val = new_val > 0 ? Math.floor(new_val / in_box) : 0;
		} else {
			fake_val = new_val;
			if (new_val > 0 && in_box > 0) {
				updateBoxDisplay(new_val, in_box);
			}
		}
		
		// Update both fields after recalculation
		parent.find('input.qty').val(new_val);
		parent.find('input.fake-qty').val(fake_val);
		
		// Update button states
		updateButtonStates(new_val, max_qty, in_box);

		// Highlight wholesale price only if quantity is greater than 0
		if (new_val > 0) {
			replaceActualyWholesale(new_val);
		} else {
			// Remove highlighting if no items in cart
			$('.product-wholesales').find('.wholesale-item.active').removeClass('active');
		}

		clearTimeout(ajaxTimer);
		ajaxTimer = setTimeout(function() {
			ajaxAddToCart(parent.data('product-id'), new_val);
		}, 500);
	}

	// Function to update box information when working with units
	function updateBoxDisplay(qty, in_box) {
		if (qty <= 0 || in_box === 0) {
			// If quantity is 0 or less, or in_box is 0, clear information
			if ($('.box-info').length) {
				$('.box-info').text('');
			}
			return;
		}
		
		let full_boxes = Math.floor(qty / in_box);
		let remaining_items = qty % in_box;
		
		// Visual indication
		let box_info = '';
		if (full_boxes > 0) {
			box_info = full_boxes + ' boxes';
			if (remaining_items > 0) {
				box_info += ' + ' + remaining_items + ' units';
			}
		} else if (remaining_items > 0) {
			box_info = remaining_items + ' units';
		}
		
		// Update hint or indicator (if exists in your markup)
		if ($('.box-info').length) {
			$('.box-info').text(box_info);
		}
	}

	$(document).find('.qty-container input').on('change input', function(e){
		input_qty_change($(this));
	});

	// Initial setup
	let parent = $('.qty-container');
	let qty = parseInt(parent.find('input.qty').val()) || 0;
	let in_box = parseInt($('form.cart').data('in-box'));
	let max_qty = parseInt(parent.find('input.qty').attr('max')) || 9999;
	let fake_input = parent.find('input.fake-qty');
	
	// Remove any existing active classes from HTML
	$('.box-variations .box-variation').removeClass('active');
	
	let initial_mode = 'retail';
	// If in_box is 0, force retail mode
	if (in_box === 0) {
		initial_mode = 'retail';
		$('.box-variation.wholesale').prop('disabled', true).addClass('disabled');
	} else if (max_qty > in_box) {
		initial_mode = 'wholesale';
	}
	
	setWhoMethod(initial_mode);
	
	let fake_val;
	if (initial_mode === 'wholesale' && qty > 0 && in_box > 0) {
		fake_val = Math.floor(qty / in_box);
	} else {
		fake_val = qty;
	}
	fake_input.val(fake_val);
	
	checkAndSwitchMode(qty, in_box, max_qty);
	updateButtonStates(qty, max_qty, in_box);
	
	if (qty > 0) {
		replaceActualyWholesale(qty);
	} else {
		$('.product-wholesales').find('.wholesale-item.active').removeClass('active');
	}
	
	updateCheckoutButton();
	setupNumberInputValidation();
});