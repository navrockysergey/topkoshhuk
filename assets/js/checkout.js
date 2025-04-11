jQuery(document).ready(function($) {
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
                        updateCartCollaterals();

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
        const $checkoutForm = $('.woocommerce-checkout');
        
        $checkoutForm.addClass('processing').css('position', 'relative');
        
        $checkoutForm.block({
            message: null,
            overlayCSS: {
                background: '#F2F2F2',
                opacity: 0.3
            }
        });
    
        $.ajax({
            url: wc_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'get_refreshed_fragments'),
            type: 'POST',
            success: function(response) {
                if (response && response.fragments) {
                    $.each(response.fragments, function(key, value) {
                        $(key).replaceWith(value);
                    });
                }
                
                $(document.body).trigger('update_checkout');
            }
        });
        
        $(document.body).one('updated_checkout', function() {
            $checkoutForm.unblock().removeClass('processing').css('position', '');
        });
    }

    function updateCartCollaterals() {
        
    }

    function updateShippingAddressVisibility() {
        var isNovaPoshtaSelected = $('.shipping_method:checked[value*=nova_poshta]').length > 0;
        var $shippingAddress = $('.shipping_address');

        if (isNovaPoshtaSelected) {
            $shippingAddress.css('display', 'none');
        } else {
            $shippingAddress.css('display', '');
        }
    }

    $('.shipping_method').change(function () {
        updateShippingAddressVisibility();
    });

    updateShippingAddressVisibility();

    $(document.body).on('updated_checkout', function () {
        updateShippingAddressVisibility();
    });
});

