/**
 * JavaScript for Product Variations Swatches
 * Works both on the product page and in the product loop
 * With support for AJAX filtering
 */
(function($) {
    'use strict';
    
    const selectedAttributes = {};
    
    // Main initialization function that will work with both initial load and AJAX
    function initializeVariationSwatches() {
        // Initialize the click events only once
        if (!window.variationSwatchesInitialized) {
            initVariationSwatches();
            window.variationSwatchesInitialized = true;
        }
        
        // Process all variation swatch containers
        $('.variation-swatches-container').each(function() {
            const $container = $(this);
            const productId = $container.data('product_id');
            // Get product parent element
            const $product = $container.closest('.product');
            
            // Skip already initialized containers
            if ($container.data('initialized')) {
                return;
            }
            
            // Mark as initialized
            $container.data('initialized', true);
            
            // Initialize product attributes
            selectedAttributes[productId] = selectedAttributes[productId] || {};
            
            // Set initial active swatches
            $container.find('.variation-swatches-attribute').each(function() {
                const $attributeContainer = $(this);
                const attributeName = $attributeContainer.data('attribute');
                const $firstButton = $attributeContainer.find('.variation-swatch-button').first();

                if ($firstButton.length) {
                    $firstButton.addClass('active');

                    const value = $firstButton.data('value');
                    const weight = $firstButton.data('weight');

                    $product.find('.product-variation-name').text(value);
 
                    $product.find('.product-weight').text(weight);

                    selectedAttributes[productId][attributeName] = value;
                }
            });
            
            // Find and apply matching variation
            const matchingVariation = findMatchingVariation(productId, selectedAttributes[productId]);
            if (matchingVariation) {
                updateProductData($product, productId, matchingVariation);
            }
        });
        
        // Convert variable products to simple for add to cart functionality
        $('.add_to_cart_button.product_type_variable').removeClass('product_type_variable').addClass('product_type_simple');
    }
    
    // Initialize swatch click events
    function initVariationSwatches() {
        $(document).on('click', '.variation-swatch-button', function(e) {
            e.preventDefault();
            
            const $button = $(this);
            const $container = $button.closest('.variation-swatches-container');
            const productId = $container.data('product_id');
            const attribute = $button.data('attribute');
            const value = $button.data('value');
            const weight = $button.data('weight');
            const $product = $button.closest('.product');
            
            // Update UI
            $container.find(`.variation-swatch-button[data-attribute="${attribute}"]`).removeClass('active');
            $product.find('.product-variation-name').text(value);

            $product.find('.product-weight').text(weight);
            $button.addClass('active');

            // Update selected attributes
            selectedAttributes[productId] = selectedAttributes[productId] || {};
            selectedAttributes[productId][attribute] = value;
            
            // Find and apply matching variation
            const matchingVariation = findMatchingVariation(productId, selectedAttributes[productId]);
            if (matchingVariation) {
                updateProductData($product, productId, matchingVariation);
            }
        });
    }
    
    // Find a matching variation based on selected attributes
    function findMatchingVariation(productId, selectedAttrs) {
        const $container = $(`.variation-swatches-container[data-product_id="${productId}"]`);
        const variationsData = JSON.parse($container.attr('data-product_variations'));
        
        // Early return if no variations
        if (!variationsData) return null;
        
        // Find a matching variation
        for (const variationId in variationsData) {
            const variation = variationsData[variationId];
            let isMatch = true;
            
            for (const attrName in selectedAttrs) {
                if (variation.attributes[attrName] !== selectedAttrs[attrName] && 
                    variation.attributes[attrName] !== 'any') {
                    isMatch = false;
                    break;
                }
            }
            
            if (isMatch) {
                return variation;
            }
        }
        
        return null;
    }
    
    // Update product data based on the selected variation
    function updateProductData($product, productId, variation) {
        const $container = $product.find(`.variation-swatches-container[data-product_id="${productId}"]`);
        const isProductPage = $container.hasClass('product-page');
        
        // Update price
        if (isProductPage) {
            $product.find('.woocommerce-variation-price').html(variation.price_html);
        } else {
            $product.find('.price').html(variation.price_html);
        }
        
        // Update SKU if element exists
        const $sku = $product.find('.product-sku');
        if ($sku.length) {
            $sku.html(variation.sku);
        }
        
        // Update image if available
        if (variation.image_url) {
            const $img = $product.find('img.attachment-woocommerce_thumbnail, img.wp-post-image');
        
            // Save original image data if not already saved
            if (!$img.data('original-src')) {
                $img.data('original-src', $img.attr('src'));
                $img.data('original-srcset', $img.attr('srcset') || '');
            }
        
            // Update image source
            $img.attr('src', variation.image_url);

            // Handle srcset
            if (variation.image_srcset) {
                $img.attr('srcset', variation.image_srcset);
            } else {
                $img.removeAttr('srcset');
            }
        
            // Trigger WooCommerce's variation found event on product page
            if (isProductPage && typeof wc_single_product_params !== 'undefined') {
                $('body').trigger('found_variation', [variation]);
            }
        }
        
        // Update add to cart button on product loops
        if (!isProductPage) {
            const $addToCartBtn = $product.find('.add_to_cart_button');
            if ($addToCartBtn.length) {
                // Update button data attributes
                $addToCartBtn
                    .data('variation_id', variation.id)
                    .attr('data-variation_id', variation.id)
                    .data('product_sku', variation.sku)
                    .attr('data-product_sku', variation.sku);
                
                // Update stock status
                if (variation.is_in_stock) {
                    $addToCartBtn.removeClass('disabled').attr('aria-disabled', 'false');
                } else {
                    $addToCartBtn.addClass('disabled').attr('aria-disabled', 'true');
                }
            }
        }
    }

    // Initialize on document ready
    $(document).ready(initializeVariationSwatches);
    
    // Fallback for other AJAX events
    $(document).ajaxComplete(initializeVariationSwatches);
    
})(jQuery);