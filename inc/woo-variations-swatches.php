<?php
/**
 * Product Variations Swatches for WooCommerce
 */

// Add script

function variation_swatches_scripts() {
    wp_enqueue_script('variation-swatches-script', get_template_directory_uri() . '/assets/js/variation-swatches.js', array('jquery'), '1.0.0', true);
    
    wp_localize_script('variation-swatches-script', 'variation_swatches_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('variation_swatches_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'variation_swatches_scripts');

// Available variations data

function get_available_variations_data($product_id) {
    $product = wc_get_product($product_id);
    
    if (!$product || !$product->is_type('variable')) {
        return false;
    }
    
    $variations = array();
    $available_variations = $product->get_available_variations();
    
    foreach ($available_variations as $variation) {
        $variation_id = $variation['variation_id'];
        $variation_obj = wc_get_product($variation_id);
        
        $attrs = array();
        foreach ($variation['attributes'] as $key => $value) {
            $taxonomy = str_replace('attribute_', '', $key);
            $term_name = $value;
            
            if ($value === '') {
                $term_name = 'any';
            }
            
            $attrs[$taxonomy] = $term_name;
        }
        
        $variations[$variation_id] = array(
            'id' => $variation_id,
            'price_html' => $variation_obj->get_price_html(),
            'sku' => $variation_obj->get_sku(),
            'image_id' => $variation['image_id'],
            'image_url' => wp_get_attachment_image_url($variation['image_id'], 'large'),
            'is_in_stock' => $variation_obj->is_in_stock(),
            'attributes' => $attrs,
            'weight' => $variation_obj->get_weight()
        );
    }
    
    return $variations;
}

// Variation data ajax

function get_variation_data_ajax() {
    check_ajax_referer('variation_swatches_nonce', 'nonce');
    
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $variation_id = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : 0;
    
    if (!$product_id || !$variation_id) {
        wp_send_json_error(array('message' => 'Missing product_id or variation_id'));
        wp_die();
    }
    
    $product = wc_get_product($product_id);
    $variation = wc_get_product($variation_id);
    
    if (!$product || !$variation) {
        wp_send_json_error(array('message' => 'Product or variation not found'));
        wp_die();
    }

    $data = array(
        'price_html' => $variation->get_price_html(),
        'sku' => $variation->get_sku(),
        'image_url' => wp_get_attachment_image_url($variation->get_image_id(), 'large'),
        'image_srcset' => wp_get_attachment_image_srcset($variation->get_image_id(), 'large'),
        'is_in_stock' => $variation->is_in_stock(),
        'weight' => $variation->get_weight()
    );
    
    wp_send_json_success($data);
    wp_die();
}
add_action('wp_ajax_get_variation_data', 'get_variation_data_ajax');
add_action('wp_ajax_nopriv_get_variation_data', 'get_variation_data_ajax');

// Add variation swatches

function add_variation_swatches() {
    global $product;
    
    if (!$product || !$product->is_type('variable')) {
        return;
    }
    
    $product_id = $product->get_id();
    $attributes = $product->get_variation_attributes();
    
    if (empty($attributes)) {
        return;
    }
    
    $variations_data = get_available_variations_data($product_id);

    if (empty($variations_data)) {
        return;
    }

    $variation_ids = wc_get_products([
        'status'    => 'publish',
        'type'      => 'variation',
        'parent'    => $product_id,
        'orderby'   => 'menu_order',
        'order'     => 'ASC',
        'return'    => 'ids',
    ]);


    $sorted_variations = [];
    foreach ($variation_ids as $variation_id) {
        foreach ($variations_data as $variation) {
            if (isset($variation['variation_id']) && $variation['variation_id'] == $variation_id) {
                $sorted_variations[] = $variation;
                break;
            }
        }
    }

    if (!empty($sorted_variations)) {
        $variations_data = $sorted_variations;
    }

    $is_any_in_stock = false;
    foreach ($variations_data as $variation) {
        if ($variation['is_in_stock']) {
            $is_any_in_stock = true;
            break;
        }
    }

    if (!$is_any_in_stock) {
        echo '<p class="stock out-of-stock">' . __('Out of stock', 'woocommerce') . '</p>';
        return;
    }
    
    $variations_json = esc_attr(json_encode($variations_data));
    
    printf(
        '<div class="variation-swatches-container" data-product_id="%s" data-product_variations="%s">',
        esc_attr($product_id),
        $variations_json
    );
    
    foreach ($attributes as $attribute_name => $attribute_values) {
        $attribute_label = wc_attribute_label($attribute_name);
        $is_taxonomy = taxonomy_exists($attribute_name);
        
        printf(
            '<div class="variation-swatches-attribute" data-attribute="%s">
                <span class="variation-swatches-label">%s: </span>
                <div class="variation-swatches-options">',
            esc_attr($attribute_name),
            esc_html($attribute_label)
        );

        foreach ($attribute_values as $attribute_value) {
            $term_slug = $attribute_value;
            $term_name = $attribute_value;
            
            if ($is_taxonomy) {
                $term = get_term_by('slug', $attribute_value, $attribute_name);
                if ($term) {
                    $term_name = $term->name;
                }
            }

            $weight = '';
            foreach ($variations_data as $variation) {
                if (isset($variation['attributes'][$attribute_name])) {
                    $variation_value = $variation['attributes'][$attribute_name];

                    $variation_value_clean = preg_replace('/-\w{2}$/', '', $variation_value);
                    $attribute_value_clean = preg_replace('/-\w{2}$/', '', $attribute_value);

                    if ($variation_value_clean == $attribute_value_clean) {
                        $weight = isset($variation['weight']) ? $variation['weight'] : '';
                        break;
                    }
                }
            }

            printf(
                '<button class="variation-swatch-button" data-attribute="%s" data-value="%s" data-weight="%s">%s</button>',
                esc_attr($attribute_name),
                esc_attr($term_slug),
                esc_attr($weight),
                esc_html($term_name)
            );
        }
        
        echo '</div></div>';
    }
    
    echo '</div>';

    if ( ! is_product() ) {

        printf(
            '<div class="qib-button-wrapper">
                <label class="screen-reader-text" for="quantity_%1$s">Quantity</label>
                <button type="button" class="minus qib-button">-</button>
                <div class="quantity wqpmb_quantity">
                    <input type="number" id="quantity_%1$s" class="wqpmb_input_text input-text qty text" 
                        step="1" data-product_id="%1$s" min="1" max="" name="quantity" 
                        value="1" title="Qty" size="4" inputmode="numeric">       
                </div>
                <span class="wqpmb_plain_input hidden">1</span>
                <button type="button" class="plus qib-button"></button>
            </div>',
            esc_attr($product_id)
        );

    }
}
add_action('woocommerce_after_shop_loop_item', 'add_variation_swatches', 8);
add_action('woocommerce_before_add_to_cart_form', 'add_variation_swatches', 10);

// Ajax add to cart

function variation_swatches_add_to_cart_ajax() {

    if ( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'wc-add-to-cart-nonce' ) ) {
        wp_send_json_error( array( 'error' => 'Nonce verification failed' ) );
        exit;
    }

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $variation_id = isset($_POST['variation_id']) ? intval($_POST['variation_id']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    if (!$product_id) {
        wp_send_json_error(array('error' => 'Missing product'));
        exit;
    }
    
    $variation = array();
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'attribute_') === 0) {
            $variation[$key] = $value;
        }
    }
    
    $add_to_cart_result = WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation);
    
    if ($add_to_cart_result) {
        do_action('woocommerce_ajax_added_to_cart', $product_id);
        
        $fragments = apply_filters('woocommerce_add_to_cart_fragments', array(
            'cart_count' => WC()->cart->get_cart_contents_count()
        ));
        
        wp_send_json_success(array(
            'fragments' => $fragments,
            'cart_hash' => WC()->cart->get_cart_hash()
        ));
    } else {
        wp_send_json_error(array('error' => 'Error adding product to cart'));
    }
    
    exit;
}
add_action('wp_ajax_variation_swatches_add_to_cart', 'variation_swatches_add_to_cart_ajax');
add_action('wp_ajax_nopriv_variation_swatches_add_to_cart', 'variation_swatches_add_to_cart_ajax');

function variation_swatches_enqueue_scripts() {
    // Enqueue the script for AJAX add to cart
    wp_enqueue_script('ajax-add-to-cart', get_template_directory_uri() . '/assets/js/ajax-add-to-cart.js', array('jquery'), '1.0.1', true);
    
    // In wp_localize_script, set nonce with the key 'security'
    wp_localize_script('ajax-add-to-cart', 'variations_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('wc-add-to-cart-nonce')  // Change to match the backend nonce
    )); 
}
add_action('wp_enqueue_scripts', 'variation_swatches_enqueue_scripts', 999);

// Replace add to cart button for all product types

function replace_add_to_cart_button($button, $product) {
    $product_id = $product->get_id();
    $product_type = $product->get_type();
    $product_title = $product->get_title();
    $button_text = esc_html($product->single_add_to_cart_text());
    $product_image = get_the_post_thumbnail_url($product_id, 'large'); 
    
    // Common attributes for all buttons
    $common_attributes = 'data-quantity="1" aria-label="' . esc_attr($button_text) . '" rel="nofollow"';
    
    // Different button handling based on product type
    if ($product_type === 'variable') {
        // For variable products, keep the standard behavior but ensure correct classes
        $button = '<a href="' . esc_url($product->add_to_cart_url()) . '" ' . $common_attributes . ' class="button variable_add_to_cart_button add_to_cart_button product_type_' . $product_type . '" data-product_id="' . $product_id . '" data-product_title="' . $product_title . '" data-product_image="' . $product_image . '">' . esc_html($button_text) . '</a>';
    } else {
        // For simple products and other types, ensure it has ajax_add_to_cart class
        $button = '<a href="' . esc_url($product->add_to_cart_url()) . '" ' . $common_attributes . ' class="button simple_add_to_cart_button add_to_cart_button product_type_' . $product_type . '" data-product_id="' . $product_id . '" data-product_title="' . $product_title . '" data-product_image="' . $product_image . '">' . esc_html($button_text) . '</a>';
    }
    
    return $button;
}
add_filter('woocommerce_loop_add_to_cart_link', 'replace_add_to_cart_button', 10, 2);
