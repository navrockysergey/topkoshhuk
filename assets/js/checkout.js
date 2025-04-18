jQuery(document).ready(function($) {

    /*
    let timer;
    let isAdjusting = false;
    let delay = 500;

    $(document).on('click', '.qty-plus, .qty-minus', function(e) {
        e.preventDefault();

        clearTimeout(timer);

        const $input = $(this).siblings('.quantity').find('.qty');
        const currentVal = parseFloat($input.val()) || 0;

        if ($(this).hasClass('qty-plus')) {
            const max = parseFloat($input.attr('max'));
            if (!max || currentVal < max) {
                $input.val(currentVal + 1);
            }
        } else {
            const min = parseFloat($input.attr('min')) || 0;
            if (currentVal > min) {
                $input.val(currentVal - 1);
            }
        }

        isAdjusting = true;
        $input.trigger('change');

        timer = setTimeout(function() {
            isAdjusting = false;
            ajaxUpdateCart($input);
        }, delay);
    });

    $(document).on('change input', '.qty', function() {
        clearTimeout(timer);
        const $input = $(this);

        timer = setTimeout(function() {
            ajaxUpdateCart($input);
        }, delay);
    });

    function ajaxUpdateCart($input) {
        if (!isAdjusting) {
            const $cartItem = $input.closest('.cart_item');
            const cartItemKey = $cartItem.data('key');
            
            if (!cartItemKey) {
                console.log('Cart item key not found');
                return;
            }

            $cartItem.block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });

            $.ajax({
                url: wc_cart_params.ajax_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'update_cart',
                    cart_nonce: wc_cart_params.cart_nonce,
                    cart_item_key: cartItemKey,
                    quantity: $input.val(),
                },
                success: function(response) {
                    $cartItem.unblock();
                    if (response.success) {

                        triggerCheckoutUpdate();
                        updateCartCount();

                    } else {

                        if (response.data && response.data.message) {
                            alert(response.data.message);
                        }
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    $cartItem.unblock();
                    console.error('Error updating cart:', textStatus, errorThrown);
                }
            });
        }
    }

    function updateCartCount() {
        $.ajax({
            url: wc_cart_params.ajax_url,
            type: 'GET',
            dataType: 'json',
            data: {
                action: 'get_cart_count',
                security: wc_cart_params.cart_nonce
            },
            success: function(response) {
                if (response.success) {
                    $('.cart-count').text(response.data.count);
                    $('.cart-items-count .value').text(response.data.count);
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error('Error updating cart count:', textStatus, errorThrown);
            }
        });
    }

    function triggerCheckoutUpdate() {
        window.location.reload();
    }
    */

    function updateShippingAddressVisibility() {
        let isLocalPickupSelected = $('.shipping_method:checked[value*=local_pickup]').length > 0;
        let isNovaPoshtaSelected = $('.shipping_method:checked[value*=nova_poshta]').length > 0;
        let $shippingAddress = $('.woocommerce-shipping-fields');
        
        if (isLocalPickupSelected) {

            $shippingAddress.hide();
        } else if (isNovaPoshtaSelected) {

            $shippingAddress.show();
            let isShipToDifferent = $('#ship-to-different-address-checkbox').is(':checked');
            
            if (isShipToDifferent) {
                $('.shipping_address').show();
            } else {
                $('.shipping_address').hide();
            }
        } else {
            $shippingAddress.show();
            $('.shipping_address').show();
        }
    }
      
    $('.shipping_method').change(function () {
        updateShippingAddressVisibility();
    });

    updateShippingAddressVisibility();

    function processCheckboxLabels() {
        $('.woocommerce-checkout .form-row input[type="checkbox"], .woocommerce-checkout .wc-urk-shipping-form-group input[type="checkbox"]').each(function() {
            let $checkbox = $(this);
            let $label = $checkbox.closest('label');
            
            if ($label.length) {

                if ($label.data('processed')) {
                    return;
                }
                
                $label.data('processed', true);
                
                $label.find('.checkbox-text').remove();
                
                $label.find('.optional').remove();
                
                let labelText = '';
                $label.contents().filter(function() {
                    return this.nodeType === 3;
                }).each(function() {
                    labelText += this.textContent;
                });
                
                $label.contents().filter(function() {
                    return this.nodeType === 3;
                }).remove();
                
                if (labelText.trim() !== '') {
                    $checkbox.after($('<span class="checkbox-text"></span>').text(labelText.trim()));
                }
            }
        });
    }

    processCheckboxLabels();

    function moveCallbackField() {
        let $callbackField = $('#shipping_call_back_field');
        let $customerDetails = $('#customer_details');
        
        if ($callbackField.length && $customerDetails.length) {
            $customerDetails.append($callbackField);
        }
    }
    
    moveCallbackField();

    $(document.body).on('updated_checkout', function () {
        updateShippingAddressVisibility();
        processCheckboxLabels();
        moveCallbackField();
    });
});

