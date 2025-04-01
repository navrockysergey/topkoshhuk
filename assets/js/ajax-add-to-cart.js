(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Handle adding products to the cart

        $('.add_to_cart_button').removeClass('ajax_add_to_cart');

        $(document).on('click', '.add_to_cart_button, .single_add_to_cart_button', function(e) {
            e.preventDefault();
            
            const $button = $(this);
            const $product = $button.closest('.product');
            const $container = $product.find('.variation-swatches-container');
            const $form = $button.closest('form');

            let selectedAttributesText = '';

            // Data product variations
            const productVariations = $container.attr('data-product_variations') 
                ? JSON.parse($container.attr('data-product_variations')) 
                : null;

            // Default value for productImage if variations aren't available
            let productImage = '';
            if (productVariations) {
                const selectedVariationId = $button.data('variation_id') || $form.find('input[name="variation_id"]').val(); // Get variation ID from button or input
                const selectedVariation = productVariations[selectedVariationId]; // Get the selected variation object
                productImage = selectedVariation ? selectedVariation.image_url : '';
            } else {
                // Fallback to data-product_image if no variations are present
                productImage = $button.data('product_image') || '';
            }
            
            // Get product title from data attribute or fallback to element text
            let productTitle = $button.data('product_title');
            if (!productTitle) {
                productTitle = $product.find('.woocommerce-loop-product__title, .product_title').text().trim();
            }
            
            // Get product ID and quantity
            let productId = $button.data('product_id');
            if (!productId && $form.length) {
                productId = $form.find('input[name="product_id"]').val() || $form.find('[name="add-to-cart"]').val();
            }
            
            const $qtyInput = $form.length ? $form.find('input.qty') : $(`#quantity_${productId}`);
            const quantity = parseInt($qtyInput.val()) || 1;
            
            // Prepare data for AJAX request
            const data = {
                action: 'variation_swatches_add_to_cart',
                security: variations_params.nonce,
                nonce: variations_params.nonce,
                product_id: productId,
                quantity: quantity
            };
        
            // Check if the product is a variable product
            if ($container.length > 0 || ($form.length > 0 && $form.hasClass('variations_form'))) {
                // Handle variable product
                const $variationContainer = $container.length > 0 ? $container : $form;
                
                // Get variation ID from the form or container
                const variationId = $form.find('input[name="variation_id"]').val() || $button.data('variation_id');
                
                if (variationId) {
                    data.variation_id = variationId;
                }
        
                // Get selected variations
                const $selectedButtons = $container.length > 0 ? 
                    $container.find('.variation-swatch-button.active') : 
                    $form.find('.variation-swatch-button.active');

                $selectedButtons.each(function() {
                    const $selected = $(this);
                    const attrName = `attribute_${$selected.data('attribute')}`;
                    const attrValue = $selected.data('value');
                    selectedAttributesText += ` <span class="selected-attribute">${attrValue}</span>`;
                    data[attrName] = attrValue;
                });
                
                // If no selected buttons found, try to get attributes from the form's select elements
                if ($selectedButtons.length === 0 && $form.length > 0) {
                    $form.find('.variations select').each(function() {
                        const $select = $(this);
                        const attrName = $select.attr('name');
                        const attrValue = $select.val();
                        if (attrName && attrValue) {
                            selectedAttributesText += ` <span class="selected-attribute">${attrValue}</span>`;
                            data[attrName] = attrValue;
                        }
                    });
                }
            } else {
                // Simple product - no additional data needed
                data.is_simple_product = true;
            }
        
            // Indicate loading
            $button.addClass('loading');
        
            // Execute AJAX request
            $.ajax({
                type: 'POST',
                url: variations_params.ajax_url,
                data: data,
                success: function(response) {
                    if (response.success) {

                        $button.removeClass('loading').addClass('added');
                        updateCartCount();

                        $.notiny({
                            text: productTitle + selectedAttributesText + ' додано до кошика!',
                            position: 'left-bottom',
                            theme: 'dark',
                            width: '300',
                            delay: 7000,
                            autohide: true,
                            clickhide: true,
                            image: productImage
                        });

                        let $updateCartButton = $('.cart button[name="update_cart"]');
                        
                        if ($updateCartButton.length > 0) {
                            $updateCartButton.prop('disabled', false).trigger('click');
                        }
                                        
                        if (typeof wc_add_to_cart_params !== 'undefined' && 
                            wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
                            window.location = wc_add_to_cart_params.cart_url;
                        }
                    } else {
                        // Handle errors from server
                        const errorMsg = response.data?.message || 'There was an error adding the product to the cart.';
                        alert(errorMsg);
                        $button.removeClass('loading');
                    }
                },
                error: function(xhr, status, error) {
                    $button.removeClass('loading');
                    console.error('AJAX Error:', status, error);
                    console.log('Response:', xhr.responseText);
                    alert('An error occurred. Please try again.');
                }
            });
        });

        // Initialize swatches on page load
        initializeSwatches();
        
        // Handle swatch selection
        $(document).on('click', '.variation-swatch-button', function() {
            const $swatch = $(this);
            const attributeName = $swatch.data('attribute');
            const attributeValue = $swatch.data('value');
            
            // Update select field
            updateSelectField(attributeName, attributeValue);
            
            // Update UI
            $swatch.addClass('active').siblings().removeClass('active');
            
            // Trigger WooCommerce events
            $('form.variations_form').trigger('woocommerce_variation_has_changed');
        });

        // Handle WooCommerce added_to_cart event
        $(document.body).on('added_to_cart', function(event, fragments, cart_hash, $button) {
            if (fragments) {
                updateCartCount();
            }
        });
    });
    
    // Initialize swatches on page load
    function initializeSwatches() {
        $('.variation-swatches-attribute').each(function() {
            const $attr = $(this);
            const $firstSwatch = $attr.find('.variation-swatch-button').first();
            
            if ($firstSwatch.length) {
                const attributeName = $firstSwatch.data('attribute');
                const attributeValue = $firstSwatch.data('value');
                
                // Update select field with initial value
                updateSelectField(attributeName, attributeValue);
                
                // Update UI
                $firstSwatch.addClass('active').siblings().removeClass('active');
            }
        });
        
        // Trigger WooCommerce events
        $('form.variations_form').trigger('woocommerce_variation_has_changed');
    }
    
    // Update select field associated with a swatch
    function updateSelectField(attributeName, attributeValue) {
        const $select = $(`select[name="attribute_${attributeName}"]`);
        
        if ($select.length) {
            $select.val(attributeValue);
            $select.trigger('change');
            $select[0].dispatchEvent(new Event('change', { bubbles: true }));
        }
    }
    
    // Update cart count via AJAX
    function updateCartCount() {
        $.ajax({
            url: wc_add_to_cart_params.ajax_url,
            type: 'POST',
            data: {
                action: 'get_cart_count'
            },
            success: function(response) {
                $('.cart-count').text(response);
            }
        });
    }
    
})(jQuery);
