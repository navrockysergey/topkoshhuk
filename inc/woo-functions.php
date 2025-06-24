<?php

add_filter('woocommerce_cart_needs_payment', '__return_false');
add_filter('woocommerce_checkout_fields', function($fields) {
    foreach ($fields as $fieldset_key => $fieldset) {
        foreach ($fieldset as $field_key => $field) {
            $fields[$fieldset_key][$field_key]['required'] = false;
            
            if (strpos($field_key, 'payment_') === 0) {
                $fields[$fieldset_key][$field_key]['type'] = 'hidden';
            }
        }
    }
    return $fields;
}, 9999);

add_filter( 'woocommerce_product_tabs'                          , 'remove_all_woocommerce_tabs', 100 );
add_action( 'wp_loaded'                                         , 'woocommerce_single_product_summary_changes' );
add_filter( 'get_wholesale_prices'                              , 'get_wholesale_prices' );
add_action( 'admin_head'                                        , 'add_woocommerce_category_description_editor' );
add_action( 'woocommerce_product_options_shipping'              , 'add_custom_shipping_fields' );
add_action( 'woocommerce_product_options_general_product_data'  , 'add_wholesale_price_fields');
add_action( 'woocommerce_process_product_meta'                  , 'save_custom_options_fields' );
add_action( 'woocommerce_after_shop_loop_item'                  , 'add_sku_before_price', 9 );
add_action( 'get_cart_product_count'                            , 'get_cart_product_count', 10, 1 );
add_action( 'woocommerce_before_calculate_totals'               , 'dynamic_set_price', 10, 1 );
add_action( 'wp_ajax_dynamic_add_to_cart'                       , 'dynamic_add_to_cart' );
add_action( 'wp_ajax_nopriv_dynamic_add_to_cart'                , 'dynamic_add_to_cart' );
add_action( 'template_redirect'                                 , 'saved_resently_product', 20 );
add_filter( 'woo_get_brands'                                    , 'woo_get_brands', 1 );
add_action( 'woocommerce_shipping_init'                         , 'init_ukrposhta_shipping_method' );
add_filter( 'woocommerce_shipping_methods'                      , 'add_ukrposhta_shipping_method' );
add_action( 'init'                                              , 'custom_account_endpoints', 25 );
add_action( 'woocommerce_account_account-data_endpoint'         , 'account_person_data', 25 );
add_action( 'woocommerce_account_account-security_endpoint'     , 'account_security_data', 25 );
add_action( 'wp_ajax_get_product_prices'                        , 'get_product_prices' );
add_action( 'wp_ajax_nopriv_get_product_prices'                 , 'get_product_prices' );
add_action( 'woocommerce_checkout_fields'                       , 'checkout_shipping_fields_settings' );

remove_action( 'woocommerce_checkout_order_review'              , 'woocommerce_checkout_payment', 20 );
add_action( 'woo_pyment'                                        , 'woocommerce_checkout_payment', 20 );

// ===================================================================================================

remove_action( 'woocommerce_after_shop_loop_item'               , 'woocommerce_template_loop_add_to_cart', 10 );
add_filter( 'woocommerce_add_to_cart_fragments'                 , 'cart_count_fragments', 10, 1 );
add_action( 'wp'                                                , 'remove_order_details_on_order_received' );
add_filter( 'woocommerce_account_menu_items'                    , 'custom_account_menu_items' );
add_filter( 'body_class'                                        , 'add_woocommerce_class_to_body' );

function woocommerce_single_product_summary_changes() {
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
    
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_main_data', 5 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_product_box_quantity', 10 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_single_template_wholesale', 20 );
    add_action( 'woocommerce_single_product_summary', 'add_to_cart_box_variations_buttons_template', 30 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 40 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_attributes', 45 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 50 );

    add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_resently_products', 20 );
}

remove_action( 'woocommerce_before_main_content'        , 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_after_shop_loop_item_title' , 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item'       , 'woocommerce_template_loop_add_to_cart', 10 ) ;
remove_action( 'woocommerce_cart_collaterals'           , 'woocommerce_cross_sell_display' );
remove_action( 'woocommerce_before_cart'                , 'woocommerce_output_all_notices', 10 );
remove_action( 'woocommerce_before_checkout_form'       , 'woocommerce_checkout_login_form', 10 );

add_filter( 'woocommerce_get_stock_html'                , '__return_empty_string', 10, 2 );
add_filter( 'woocommerce_sale_flash'                    , '__return_empty_string', 10 );
add_filter( 'woocommerce_new_product_badge'             , '__return_empty_string', 10 );
add_filter( 'gettext'                                   , 'change_woocommerce_text', 20, 3 );
add_filter( 'ngettext'                                  , 'change_woocommerce_text', 20, 3 );
add_filter( 'wpc_filters_label_term_html'               , 'wpc_label', 10, 4 );
add_filter( 'wpc_filters_radio_term_html'               , 'wpc_label', 10, 4 );
add_filter( 'wpc_filters_checkbox_term_html'            , 'wpc_label', 10, 4 );
add_filter( 'woocommerce_catalog_orderby'               , 'custom_woocommerce_catalog_orderby', 20 );
add_filter( 'woocommerce_default_catalog_orderby'       , 'custom_default_catalog_orderby', 20 );
add_filter( 'woocommerce_cart_needs_shipping'           , 'remove_shipping_only_from_cart' );
add_filter( 'woocommerce_checkout_fields'               , 'remove_shipping_address_2' );
add_filter( 'woocommerce_ship_to_different_address_checked', '__return_false' );
add_filter('the_content'                                , 'remove_nbsp_from_content', 99);

add_action( 'woocommerce_after_shop_loop_item'          , 'custom_price_button_wrapper', 10 );
add_action( 'woocommerce_before_single_product_summary' , 'start_single_product_container', 5 );
add_action( 'woocommerce_after_single_product_summary'  , 'end_single_product_container', 5 );
add_action( 'baza_product_before_images'                , 'show_badges_on_product_page', 10 );
add_action( 'woocommerce_before_shop_loop_item_title'   , 'show_badges_in_loop', 9 );
add_action( 'woocommerce_after_cart'                    , 'cross_sell_display' );
add_action( 'woocommerce_before_cart'                   , 'woocommerce_output_all_notices', 5 );
add_action( 'woocommerce_thankyou'                      , 'add_catalog_link_after_order', 10 );
add_action( 'woocommerce_after_checkout_billing_form'   , 'ajax_checkout_login_block', 10 );
add_action( 'wp_ajax_nopriv_ajax_checkout_login'        , 'ajax_login_callback' );
add_action( 'wp_ajax_nopriv_ajax_register'              , 'ajax_register_callback' );

add_action( 'wp_ajax_update_cart'                       , 'handle_update_cart' );
add_action( 'wp_ajax_nopriv_update_cart'                , 'handle_update_cart' );
add_action( 'wp_ajax_get_cart_count'                    , 'get_cart_count' );
add_action( 'wp_ajax_nopriv_get_cart_count'             , 'get_cart_count' );
add_filter( 'woocommerce_pagination_args'               , 'reduce_woocommerce_pagination_items' );
add_filter( 'woocommerce_placeholder_img'               , 'filter_woocommerce_placeholder_img', 10, 3 );

add_action('template_redirect', function() {
    ob_start(function($buffer) {
        return str_replace('&nbsp;', '', $buffer);
    });
});

function remove_nbsp_from_content($content) {
    return str_replace('&nbsp;', ' ', $content);
}

function cart_count_fragments($fragments) {
    $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
    
    $fragments['.cart-count'] = '<span class="cart-count">' . $count . '</span>';
    
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'cart_count_fragments');

function get_cart_count() {
    if (!check_ajax_referer('woocommerce-cart', 'security', false)) {
        wp_send_json_error(array('message' => 'Security check failed.'));
        return;
    }
    
    $count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
    wp_send_json_success(array('count' => $count));
}

function handle_update_cart() {

    if (!check_ajax_referer('woocommerce-cart', 'cart_nonce', false)) {
        error_log('Cart nonce verification failed');
        wp_send_json_error(array('message' => 'Security check failed.'));
        return;
    }
    
    if (!isset($_POST['cart_item_key']) || !isset($_POST['quantity'])) {
        error_log('Missing required parameters');
        wp_send_json_error(array('message' => 'Required parameters missing.'));
        return;
    }
    
    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    $quantity = intval($_POST['quantity']);
    
    if (!isset(WC()->cart->get_cart()[$cart_item_key])) {
        error_log('Cart item not found: ' . $cart_item_key);
        wp_send_json_error(array('message' => 'Cart item not found.'));
        return;
    }
    
    if ($quantity > 0) {
        WC()->cart->set_quantity($cart_item_key, $quantity, true);
        
        WC()->cart->calculate_totals();
        
        wp_send_json_success(array(
            'message' => 'Cart updated successfully.',
            'cart_total' => WC()->cart->get_cart_total()
        ));
    } else {
        wp_send_json_error(array('message' => 'Quantity must be greater than zero.'));
    }
}

function remove_shipping_address_2( $fields ) {
    unset($fields['shipping']['shipping_address_2']);
    return $fields;
}

function add_catalog_link_after_order($order_id) {
    if (!$order_id) return;

    $shop_url = get_permalink(wc_get_page_id('shop'));
    
    echo '
        <div class="catalog-return-link">
            <a href="' . esc_url($shop_url) . '" class="button">' . __('До каталогу'). '</a>
        </div>
    ';
}

function remove_shipping_only_from_cart($needs_shipping) {
    if (is_cart()) {
        return false;
    }
    return $needs_shipping;
}

function custom_woocommerce_catalog_orderby( $sortby ) {
    unset($sortby['rating']);
    unset($sortby['date']);
    
    $sortby['popularity'] = __('Популярні');
    $sortby['price'] = __('Дешевші');
    $sortby['price-desc'] = __('Дорожчі');
    
    return $sortby;
}

function custom_default_catalog_orderby( $default_orderby ) {
    return 'popularity';
}

function cross_sell_display() {
    woocommerce_cross_sell_display(4, 4);
}

function wpc_label( $html, $link_attributes, $term_object, $filter ) {
    $html = $term_object->name;
    return $html;
}

function change_woocommerce_text($translated_text, $text, $domain) {
    if ($domain != 'woocommerce') {
        return $translated_text;
    }
    
    $translations = array(
        'Супутні товари' => 'Ваc може зацікавити',
        'Вас також може зацікавити&hellip;' => 'Додати до замовлення',
        'Вам також може сподобатися&hellip;' => 'Додати до замовлення',
        'Застосувати купон' => 'Застосувати',
        'Позиції' => 'Товарів',
        'Перейти до оформлення' => 'Оформити замовлення',
        'Повернутись в магазин' => 'До каталогу',
        'Платіжні дані' => 'Дані покупця',
        'Оплата та доставка' => 'Дані покупця',
        'Зберегти зміни' => 'Зберегти',
        'Дякуємо. Ваше замовлення було отримано.' => 'Замовлення прийняте',
        'Вже замовляли у нас?' => 'Якщо ви зареєстровані, увійдіть у свій обліковий запис, щоб зберегти дані про покупку.',
    );
    
    if (array_key_exists($translated_text, $translations)) {
        return $translations[$translated_text];
    }
    
    return $translated_text;
}

function product_tags( $product_id ) {
    return wp_get_post_terms( $product_id, 'product_tag' );
}

function display_badges() {
    global $product;
    
    if ( ! $product ) {
        return '';
    }

    $tags = product_tags( $product->get_id() );

    $output = '<div class="product-badges">';

    foreach ( $tags as $tag ) {
        switch ( $tag->name ) {
            case 'hit' :
                $output .= '<span class="product-badge hit"><span>' . __('Хіт') . '</span></span>';
                break;
            case 'new' :
                $output .= '<span class="product-badge new"><span>' . __('Новинка') . '</span></span>';
                break;
        }
    }
    
    if ( $product->is_on_sale() ) {
        $output .= '<span class="product-badge onsale"><span>' . __('Знижка') . '</span></span>';
    }
    
    if ( ! $product->is_in_stock() ) {
        $output .= '<span class="product-badge out-of-stock"><span>' . __('Немає в наявності') . '</span>';
    }
    
    $output .= '</div>';
    
    return $output;
}

function show_badges_on_product_page() {
    echo display_badges();
}

function show_badges_in_loop() {
    echo display_badges();
}

function get_youtube_id_from_url($url) {
    $pattern = 
        '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
    
    if (preg_match($pattern, $url, $match)) {
        return $match[1];
    }
    
    return false;
}

function start_single_product_container() {
    echo '<div class="container product-container">';
}

function end_single_product_container() {
    echo '</div>';
}

function custom_price_button_wrapper() {
    global $product;
    $link = $product->get_permalink();
    
    echo '<div class="price-cart-wrapper">';
    
    echo '<span class="price">' . $product->get_price_html() . '</span>';
    
    echo '
    <a href="' . esc_url( $link ) . '" class="button button-product-view"></a>';
    
    echo '</div>';
}

function woocommerce_template_single_main_data() {
    wc_get_template( 'single-product/main-data.php' );
}

function woocommerce_product_box_quantity() {
    global $product;

    $box_quantity = get_post_meta( $product->get_id(), '_box_quantity', true );

    if ( $box_quantity && '' !== $box_quantity && intval( $box_quantity ) > 0 ):
        echo sprintf( "<div class='product-summary-item product-summary-box'><span class='item-name'>В ящику:</span><span class='item-value'>%s шт.</span></div>", $box_quantity );
    endif;
}

function woocommerce_single_template_wholesale() {
    wc_get_template( 'single-product/wholesale-template.php' );
}

function woocommerce_template_attributes() {
    global $product;

    echo wc_display_product_attributes ( $product );
}

function get_wholesale_prices() {
    return carbon_get_theme_option( 'wholesale_prices' );
}

function add_to_cart_box_variations_buttons_template(){
    wc_get_template( 'single-product/box-variations-buttons-template.php' );
}

// Add description editor
function add_woocommerce_category_description_editor() {
    wp_enqueue_editor();
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            if ($('.term-description-wrap #description').length) {
                wp.editor.initialize('description', {
                    tinymce: {
                        toolbar1: 'bold,italic,underline,strikethrough,alignleft,aligncenter,alignright,link,unlink,code',
                    }
                });
            }
        });
    </script>
    <?php
}

// Add custom product properties
function add_custom_shipping_fields() {
    global $post;
    if ( $post && 'product' === $post->post_type ) {
        echo '<h4>'. __('Box parameters', 'woocommerce') .'</h4>';
        woocommerce_wp_text_input(
            array(
                'id'          => '_box_quantity',
                'label'       => __( 'Quantity in a box', 'woocommerce' ),
                'placeholder' => '',
                'desc_tip'    => 'true',
                'description' => __( 'Specify the number of items in the box.', 'woocommerce' ),
            )
        );
        woocommerce_wp_text_input(
            array(
                'id'          => '_box_height',
                'label'       => __( 'Height of the box (cm)', 'woocommerce' ),
                'placeholder' => '',
                'desc_tip'    => 'true',
                'description' => __( 'Please indicate the height of the box in centimeters.', 'woocommerce' ),
            )
        );
        woocommerce_wp_text_input(
            array(
                'id'          => '_box_width',
                'label'       => __( 'Drawer width (cm)', 'woocommerce' ),
                'placeholder' => '',
                'desc_tip'    => 'true',
                'description' => __( 'Please indicate the width of the box in centimeters.', 'woocommerce' ),
            )
        );
        woocommerce_wp_text_input(
            array(
                'id'          => '_box_length',
                'label'       => __( 'Length of the box (cm)', 'woocommerce' ),
                'placeholder' => '',
                'desc_tip'    => 'true',
                'description' => __( 'Please indicate the length of the box in centimeters.', 'woocommerce' ),
            )
        );
        woocommerce_wp_text_input(
            array(
                'id'          => '_box_weight',
                'label'       => __( 'Weight of the box (kg)', 'woocommerce' ),
                'placeholder' => '',
                'desc_tip'    => 'true',
                'description' => __( 'Please indicate the weight of the box in kilograms.', 'woocommerce' ),
            )
        );
    }
}

// Add per Box prices
function add_custom_box_price_fields() {
    global $post;
    if ( $post && 'product' === $post->post_type ) {
        woocommerce_wp_text_input(
            array(
                'id'          => '_wholesale_prices',
                'label'       => __( 'Wholesale price', 'woocommerce' ),
                'placeholder' => '',
                'desc_tip'    => 'false',
                'type'        => 'price',
                'class'       => 'short wc_input_price',
            )
        );
    }
}

function add_wholesale_price_fields() {
    global $post;

    echo '<div class="options_group"><h4>'.__('Wholesale Prices', 'woocommerce').'</h4>';

    woocommerce_wp_text_input(array(
        'id'        => '_wholesale_prices',
        'label'     => '',
        'desc_tip'  => 'true',
        'type'      => 'hidden',
    ));

    echo '</div>';
}

// Save custom product options
function save_custom_options_fields( $post_id ) {
    if ( isset( $_POST['_box_quantity'] ) ) {
        update_post_meta( $post_id, '_box_quantity', sanitize_text_field( $_POST['_box_quantity'] ) );
    }
    if ( isset( $_POST['_box_height'] ) ) {
        update_post_meta( $post_id, '_box_height', sanitize_text_field( $_POST['_box_height'] ) );
    }
    if ( isset( $_POST['_box_width'] ) ) {
        update_post_meta( $post_id, '_box_width', sanitize_text_field( $_POST['_box_width'] ) );
    }
    if ( isset( $_POST['_box_length'] ) ) {
        update_post_meta( $post_id, '_box_length', sanitize_text_field( $_POST['_box_length'] ) );
    }
    if ( isset( $_POST['_box_weight'] ) ) {
        update_post_meta( $post_id, '_box_weight', sanitize_text_field( $_POST['_box_weight'] ) );
    }
    if ( isset($_POST['_wholesale_prices']) ) {
        $wholesale_prices = $_POST['_wholesale_prices'];
        update_post_meta($post_id, '_wholesale_prices', sanitize_text_field( $wholesale_prices ));
    }
}

// Add SKU before the price
function add_sku_before_price() {
    global $product;
    
    $sku = $product->get_sku();
    if ( $sku ) {
        echo '<p class="product-sku-wrapper">' . __( 'Артикул' ) . ': <span class="product-sku">' . $sku . '</span></p>';
    }
}

// Count single product in cart
function get_cart_product_count( $product_id ) {
    $items = [];
    if( !is_null( WC()->cart ) ) {
        $items = WC()->cart->get_cart();
    }

    $out = 0;

    foreach( $items as $item ) {
        if( $product_id == $item['product_id'] ) {
            $out = $item['quantity'];
        }
    }
    
    return $out;
}

function get_who_price( int $product_id, int $qty ) {
    $product = wc_get_product( $product_id );
    $who_str = get_post_meta( $product_id, '_wholesale_prices', true );
    $out     = 0;

    if ( empty( $who_str ) ) {
        $out = $product->get_price();
        return $out;
    }

    $wholesales = json_decode( $who_str );

    foreach ( $wholesales as $inx => $level ) :
        $lvl_count             = intval( $level->min_product_count );
        $wholesale_lvl_price   = floatval( $level->wh_price );

        if ( $qty >= $lvl_count &&
             array_key_exists( $inx+1, $wholesales ) &&
             $qty < intval( $wholesales[$inx+1]->min_product_count ) ||
             $qty >= $lvl_count &&
             ! array_key_exists( $inx+1, $wholesales )
             )
             {
                $out = floatval( $wholesale_lvl_price );
             };
    endforeach;

    return $out;
}

function dynamic_set_price( $cart ) {
    foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
         $id        = $cart_item['variation_id'] > 0 ? $cart_item['variation_id'] : $cart_item["product_id"];
         $who_price = get_who_price( $id, $cart_item["quantity"] );

        if( 0 < $who_price ) {
            $cart_item['data']->set_price( $who_price );
        }
    }
}

function product_prices( $product_id, $qty = false ) {
    $product    = wc_get_product( $product_id );
    $who_price  = get_who_price( $product_id, $qty );

    if ( ! $qty ) $qty = get_cart_product_count( $product_id );

    return [
        'has_sale'  => intval( $product->get_price() ) < intval( $product->get_regular_price() ) || 0 < $who_price,
        'regular'   => wc_price( $product->get_regular_price() ),
        'price'     => wc_price( $product->get_price() ),
        'who_price' => 0 < $who_price ? wc_price( $who_price ) : $who_price,
    ];
}

function get_product_prices() {
    if ( ! isset( $_POST['prodId'] ) || ! isset( $_POST['prodQty'] ) ) {
        return;
    }

    $result = product_prices( intval( $_POST['prodId'] ) , intval( $_POST['prodQty'] ) );

    wp_send_json( $result );
}

function dynamic_add_to_cart() {
    if ( ! isset( $_POST['prodId'] ) || ! isset( $_POST['prodQuentity'] ) ) {
        wp_send_json_error( array( 'error' => 'Missing product ID or quantity' ) );
        exit;
    }

    $WC_Cart = WC()->cart;

    $product_id          = intval( $_POST['prodId'] );
    $product             = wc_get_product( $product_id );
    $is_variable         = $product->get_parent_id() > 0;
    $item_count          = get_cart_product_count( $product_id );
    $quantity            = intval( $_POST['prodQuentity'] );
    $cart_item_key       = $WC_Cart->generate_cart_id( $product_id );
    $price               = get_who_price( $product_id, $quantity ) > 0 ? get_who_price( $product_id, $quantity ) : $product->get_price();
    $product_permalink   = get_the_permalink( $product_id );
    $item_subtotal       = $quantity * $price;
    $cart_item_html      = "";
    $result              = false;

    if ( $item_count > 0 ) {
        $items = $WC_Cart->get_cart();
        foreach( $items as $item_key => $item ) {
            if( $product_id == $item['product_id'] || $product_id == $item['variation_id'] ) {
                $cart_item_key = $item_key;
            }
        }

        $result = $WC_Cart->set_quantity( $cart_item_key, $quantity );
    } else {
        if( ! $is_variable ) {
            $result = $WC_Cart->add_to_cart( $product_id, $quantity );
        } else {
            $result = $WC_Cart->add_to_cart( $product->get_parent_id(), $quantity, $product_id );
        }
        
    }

    if ( is_wp_error( $result ) ) {
        wp_send_json_error( $result->get_error_message() );
    }

    if ( ! $result ) {
        wp_send_json_error( array( 'error' => 'Failed to add product to cart' ) );
        exit;
    }

    $WC_Cart->calculate_totals();

    
    foreach ( $WC_Cart->get_cart() as $key => $cart_item ) {
        if( $cart_item_key == $key ) {
            $total_price = $cart_item['line_total'];
        }
    }

    $out = [
        'product_count'         => get_cart_product_count( $product_id ),
        // 'all_counts'            => $WC_Cart->get_cart_contents_count(),
        'number_of_positions'   => count( $WC_Cart->get_cart() ),
        'old_price'             => $product->get_regular_price(),
        'price'                 => $price,
        // 'product_total'         => wc_price( $total_price ),
        // 'total'                 => wc_price( WC()->cart->get_displayed_subtotal() ),
        // 'total_sum'             => $WC_Cart->get_displayed_subtotal(),
    ];

    wp_send_json_success( $out );
}

function saved_resently_product() {
    if ( ! is_product() || 0 == get_the_ID() ) {
		return;
	}

    if ( empty( $_COOKIE[ 'woo_recently_viewed' ] ) ) {
		$viewed = array();
	} else {
		$viewed = (array) explode( '||', $_COOKIE[ 'woo_recently_viewed' ] );
	}
 
	if ( ! in_array( get_the_ID(), $viewed ) ) {
		$viewed[] = get_the_ID();
	}
 
	if ( sizeof( $viewed ) > 10 ) {
		array_shift( $viewed );
	}
 
	wc_setcookie( 'woo_recently_viewed', join( '||', $viewed ) );
}

function woocommerce_template_resently_products() {
    wc_get_template( 'single-product/resently_products.php' );
}

function woo_get_brands() {
    return get_terms( array(
        'taxonomy'   => 'product_brand',
        'hide_empty' => false,
    ) );
}

function init_ukrposhta_shipping_method() {
    if ( ! class_exists( 'WC_Shipping_Ukrposhta' ) ) {
        class WC_Shipping_Ukrposhta extends WC_Shipping_Method {
            public function __construct( $instance_id = 0 ) {
                $this->id                 = 'ukrposhta';
                $this->instance_id        = absint( $instance_id );
                $this->method_title       = __( 'Укрпошта', 'woocommerce' );
                $this->method_description = __( 'Доставка Укрпоштою', 'woocommerce' );
                $this->supports           = array(
                    'shipping-zones',
                    'instance-settings',
                    'instance-settings-modal',
                );
                $this->init_form_fields();
                $this->init_settings();

                add_action( 'woocommerce_update_options_shipping_' . $this->id, array( $this, 'process_admin_options' ) );
            }

            public function init_form_fields() {
                $this->instance_form_fields = array(
                    'title' => array(
                        'title'       => __( 'Название', 'woocommerce' ),
                        'type'        => 'text',
                        'description' => __( 'Название метода доставки, отображаемое на странице оформления заказа.', 'woocommerce' ),
                        'default'     => __( 'Укрпошта', 'woocommerce' ),
                    ),
                    'cost' => array(
                        'title'       => __( 'Стоимость', 'woocommerce' ),
                        'type'        => 'price',
                        'description' => __( 'Стоимость доставки.', 'woocommerce' ),
                        'default'     => '0',
                    ),
                );
            }

            public function calculate_shipping( $package = array() ) {
                $cost = $this->get_option( 'cost' );
                $this->add_rate(
                    array(
                        'id'       => $this->id,
                        'label'    => $this->get_option( 'title' ),
                        'cost'     => $cost,
                        'calc_tax' => 'per_item',
                    )
                );
            }
        }
    }
}

function add_ukrposhta_shipping_method( $methods ) {
    $methods['ukrposhta'] = 'WC_Shipping_Ukrposhta';
    return $methods;
}

function checkout_shipping_fields_settings( $fields ) {
    $is_ukposht_spipping = false;
    if ( isset( $_POST['shipping_method'] ) &&
         is_array( $_POST['shipping_method'] ) &&
         strpos( current( $_POST['shipping_method'] ), 'ukrposhta' ) !== false ) {
            $is_ukposht_spipping = true;
         }

    //  Shipping
    unset( $fields['shipping']['shipping_country'] );
    $fields['shipping']['shipping_address_1']['required']   = $is_ukposht_spipping;
    $fields['shipping']['shipping_address_2']['required']   = $is_ukposht_spipping;
    $fields['shipping']['shipping_city']['required']        = $is_ukposht_spipping;
    $fields['shipping']['shipping_state']['required']       = $is_ukposht_spipping;
    $fields['shipping']['shipping_postcode']['required']    = $is_ukposht_spipping;

    // Billing
    unset( $fields['billing']['billing_address_1'] );
    unset( $fields['billing']['billing_address_2'] );
    unset( $fields['billing']['billing_city'] );
    unset( $fields['billing']['billing_state'] );
    unset( $fields['billing']['billing_postcode'] );
    unset( $fields['billing']['shipping_country'] );

    return $fields;
}

// ====================================================================

// Remove tabs
function remove_all_woocommerce_tabs($tabs) {
    return array();
}

// Remove sections from woocommerce thankyou
function remove_order_details_on_order_received() {
    if (is_order_received_page()) {
        remove_action('woocommerce_thankyou', 'woocommerce_order_details_table', 10);
        remove_action('woocommerce_thankyou', 'woocommerce_customer_details', 20);
    }
}

// Account
function custom_account_menu_items( $items ) {
    if (isset($items['downloads'])) {
        unset($items['downloads']);
    }

    if ( isset( $items['dashboard'] ) ) {
        unset( $items['dashboard'] );
    }

    if ( isset( $items['edit-address'] ) ) {
        unset( $items['edit-address'] );
    }

    if ( isset( $items['edit-account'] ) ) {
        unset( $items['edit-account'] );
    }

    if ( isset( $items['customer-logout'] ) ) {
        unset( $items['customer-logout'] );
    }

    $items['account-data'] = __('Дані покупця');

    $items['account-security'] = __('Безпека');

    $items['customer-logout'] = __('Вийти');

    return $items;
}

function custom_account_endpoints() {
    add_rewrite_endpoint( 'account-data', EP_PAGES );
    add_rewrite_endpoint( 'account-security', EP_PAGES );
}

function account_person_data() {    
    wc_get_template( 'myaccount/form-edit-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) );
}

function account_security_data() {
    wc_get_template( 'myaccount/form-edit-login-account.php', array( 'user' => get_user_by( 'id', get_current_user_id() ) ) );
}

function add_custom_account_fields() {
    woocommerce_form_field( 'shipping_phone', array(
        'type'     => 'text',
        'label'    => __( 'Номер телефону' ),
        'required' => false,
    ), get_user_meta( get_current_user_id(), 'shipping_phone', true ) );

    woocommerce_form_field( 'shipping_city', array(
        'type'     => 'text',
        'label'    => __( 'Місто або населений пункт' ),
        'required' => false,
    ), get_user_meta( get_current_user_id(), 'shipping_city', true ) );

    woocommerce_form_field( 'shipping_address_1', array(
        'type'     => 'text',
        'label'    => __( 'Адреса' ),
        'required' => false,
    ), get_user_meta( get_current_user_id(), 'shipping_address_1', true ) );
}

// Add woocommerce class in body (cart)
function add_woocommerce_class_to_body( $classes ) {
    if ( is_cart() ) {
        $classes[] = 'woocommerce';
    }
    return $classes;
}

// Add class in account
function add_woo_account_body_class($classes) {
    if (is_user_logged_in() && is_account_page()) {
        $classes[] = 'woo-logged-in-account';
    }
    return $classes;
}

// Ajax login and registration
function ajax_login_callback() {
    check_ajax_referer('custom-login-nonce', 'security');
    
    $username = isset($_POST['username']) ? sanitize_user($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $remember = isset($_POST['remember']) ? (bool)$_POST['remember'] : false;
    
    $user = wp_signon(
        array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => $remember,
        ),
        is_ssl()
    );
    
    if (is_wp_error($user)) {
        wp_send_json_error(array('message' => $user->get_error_message()));
    } else {
        $fragments = array();
        
        ob_start();
        WC()->cart->calculate_shipping();
        WC()->cart->calculate_totals();
        woocommerce_checkout_payment();
        $fragments['.woocommerce-checkout-payment'] = ob_get_clean();
        
        ob_start();
        woocommerce_order_review();
        $fragments['.woocommerce-checkout-review-order-table'] = ob_get_clean();
        
        ob_start();
        woocommerce_form_field('billing_first_name', array(
            'type'        => 'text',
            'label'       => __('Имя', 'woocommerce'),
            'required'    => true,
            'class'       => array('form-row-first'),
            'default'     => get_user_meta($user->ID, 'billing_first_name', true),
        ));
        $fragments['.woocommerce-billing-fields #billing_first_name_field'] = ob_get_clean();
        
        wp_send_json_success(array(
            'message' => __('Успішна авторизація! Оновлення даних...'),
            'fragments' => $fragments,
            'reload' => false
        ));
    }
    
    wp_die();
}

function ajax_checkout_login_block() {
    if (!is_user_logged_in()) {
    ?>
        <div id="login-form-container" class="login-form-container">
            <div class="woocommerce-form-login-toggle">
                <?php wc_print_notice(apply_filters('woocommerce_checkout_login_message', esc_html__('Returning customer?', 'woocommerce')) . ' <a href="#" class="button showlogin">' . esc_html__('Login', 'woocommerce') . '</a>'); ?>
            </div>
            <div class="woocommerce-ajax-login login">
                <div class="fields">
                    <p class="form-row form-row-first">
                        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="ajax_username" autocomplete="username" placeholder="<?php esc_html_e('Username or email', 'woocommerce'); ?>">
                    </p>
                    <p class="form-row form-row-last">
                        <input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="ajax_password" autocomplete="current-password" placeholder="<?php esc_html_e('Password', 'woocommerce'); ?>">
                    </p>
                    <p class="form-row form-row-submit">
                        <?php wp_nonce_field('custom-login-nonce', 'custom-login-nonce'); ?>
                        <button type="button" class="woocommerce-button button woocommerce-form-login__submit ajax-login-button"><?php esc_html_e('Login', 'woocommerce'); ?></button>
                    </p>
                    <p class="lost_password">
                        <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
                    </p>
                    <div class="ajax-login-message"></div>
                </div>
            </div>
        </div>
        <?php
    }
}

function ajax_register_callback() {
    check_ajax_referer('custom-register-nonce', 'security');
    
    $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    $error = new WP_Error();
    
    if (empty($name)) {
        $error->add('empty_name', __('Будь ласка, введіть ім\'я', 'woocommerce'));
    }
    
    if (empty($email) || !is_email($email)) {
        $error->add('email', __('Будь ласка, введіть коректну електронну пошту', 'woocommerce'));
    }
    
    if (email_exists($email)) {
        $error->add('email_exists', __('Ця електронна пошта вже використовується', 'woocommerce'));
    }
    
    if (empty($password)) {
        $error->add('empty_password', __('Будь ласка, введіть пароль', 'woocommerce'));
    }
    
    if ($error->has_errors()) {
        wp_send_json_error(array('message' => $error->get_error_message()));
        wp_die();
    }
    
    // Extract first and last name
    $name_parts = explode(' ', $name, 2);
    $first_name = $name_parts[0];
    $last_name = isset($name_parts[1]) ? $name_parts[1] : '';
    
    // Create user
    $username = sanitize_user(current(explode('@', $email)), true);
    
    // Ensure username is unique
    $append = 1;
    $o_username = $username;
    while (username_exists($username)) {
        $username = $o_username . $append;
        $append++;
    }
    
    $user_id = wp_create_user($username, $password, $email);
    
    if (is_wp_error($user_id)) {
        wp_send_json_error(array('message' => $user_id->get_error_message()));
        wp_die();
    }
    
    // Update user meta
    update_user_meta($user_id, 'first_name', $first_name);
    update_user_meta($user_id, 'last_name', $last_name);
    update_user_meta($user_id, 'billing_first_name', $first_name);
    update_user_meta($user_id, 'billing_last_name', $last_name);
    update_user_meta($user_id, 'billing_email', $email);
    update_user_meta($user_id, 'billing_phone', $phone);
    
    // Log the user in
    $user = get_user_by('id', $user_id);
    wp_set_current_user($user_id, $user->user_login);
    wp_set_auth_cookie($user_id);
    do_action('wp_login', $user->user_login, $user);
    
    wp_send_json_success(array(
        'message' => __('Реєстрація успішна! Перезавантаження сторінки...'),
        'reload' => true
    ));
    
    wp_die();
}

function header_login_dropdown() {
    if (!is_user_logged_in()) {
        ?>
        <div class="login-container"> 
            <a class="header-login toggle-login-dropdown" href="#">
                <i class="icon-user"></i>
            </a>
            <div id="header-login-form-container" class="login-form-container dropdown-content">
                <div class="tabs-container">
                    <div class="tabs-nav">
                        <a href="#" class="tab-link active" data-tab="login-tab"><?php esc_html_e('Вхід', 'woocommerce'); ?></a>
                        <a href="#" class="tab-link" data-tab="register-tab"><?php esc_html_e('Реєстрація', 'woocommerce'); ?></a>
                    </div>
                    
                    <div id="login-tab" class="tab-content active">
                        <div class="woocommerce-ajax-login">
                            <div class="fields">
                                <p class="form-row form-row-first form-row-username">
                                    <input type="text" class="woocommerce-Input input-text" name="username" id="header_ajax_username" autocomplete="username" placeholder="<?php esc_html_e('Username or email', 'woocommerce'); ?>">
                                </p>
                                <p class="form-row form-row-last form-row-password">
                                    <input class="woocommerce-Input input-text" type="password" name="password" id="header_ajax_password" autocomplete="current-password" placeholder="<?php esc_html_e('Password', 'woocommerce'); ?>">
                                </p>
                                <p class="form-row form-row-submit">
                                    <?php wp_nonce_field('custom-login-nonce', 'custom-login-nonce'); ?>
                                    <button type="button" class="woocommerce-button button woocommerce-form-login__submit header-ajax-login-button"><?php esc_html_e('Вхід', 'woocommerce'); ?></button>
                                </p>
                                <p class="lost_password">
                                    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php esc_html_e('Lost your password?', 'woocommerce'); ?></a>
                                </p>
                                <div class="ajax-login-message"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="register-tab" class="tab-content">
                        <div class="woocommerce-ajax-register">
                            <div class="fields">
                                <p class="form-row form-row-first form-row-username">
                                    <input type="text" class="woocommerce-Input input-text" name="reg_name" id="header_ajax_reg_name" autocomplete="name" placeholder="<?php esc_html_e('Ім\'я та прізвище', 'woocommerce'); ?>">
                                </p>
                                <p class="form-row form-row-email">
                                    <input type="email" class="woocommerce-Input input-text" name="reg_email" id="header_ajax_reg_email" autocomplete="email" placeholder="<?php esc_html_e('Електронна пошта', 'woocommerce'); ?>">
                                </p>
                                <p class="form-row form-row-phone">
                                    <input type="tel" class="woocommerce-Input input-text" name="reg_phone" id="header_ajax_reg_phone" autocomplete="tel" placeholder="<?php esc_html_e('Номер телефону', 'woocommerce'); ?>">
                                </p>
                                <p class="form-row form-row-last form-row-password">
                                    <input class="woocommerce-Input input-text" type="password" name="reg_password" id="header_ajax_reg_password" autocomplete="new-password" placeholder="<?php esc_html_e('Пароль', 'woocommerce'); ?>">
                                </p>
                                <p class="form-row form-row-submit">
                                    <?php wp_nonce_field('custom-register-nonce', 'custom-register-nonce'); ?>
                                    <button type="button" class="woocommerce-button button woocommerce-form-register__submit header-ajax-register-button"><?php esc_html_e('Зареєструватись', 'woocommerce'); ?></button>
                                </p>
                                <div class="ajax-register-message"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        $current_user = wp_get_current_user();
        $first_name = $current_user->first_name;
        $last_name = $current_user->last_name;
        $display_name = !empty($first_name) && !empty($last_name) ? $first_name . ' ' . $last_name : $current_user->display_name;
        ?>
        <div class="login-container">
            <a class="header-login toggle-login-dropdown" href="#">
                <i class="icon-user"></i>
            </a>
            <div class="dropdown-content">
                <p class="welcome-text"><?php echo esc_html($display_name); ?></p>
                <ul class="user-menu">
                    <li class="first"><a href="<?php echo wc_get_account_endpoint_url('orders'); ?>"><?php esc_html_e('Замовлення'); ?></a></li>
                    <li><a href="<?php echo wc_get_account_endpoint_url('account-data'); ?>"><?php esc_html_e('Дані покупця'); ?></a></li>
                    <li class="last"><a href="<?php echo wc_get_account_endpoint_url('account-security'); ?>"><?php esc_html_e('Безпека'); ?></a></li>
                </ul>
                <a class="button button-logout" href="<?php echo wp_logout_url(home_url()); ?>"><?php esc_html_e('Вийти', 'woocommerce'); ?></a>
            </div>
        </div>
        <?php
    }
}

// Reduce the number of page numbers shown
function reduce_woocommerce_pagination_items( $args ) {
    $args['end_size'] = 2; // Default is 3 - show 1 number at the start/end
    $args['mid_size'] = 2; // Default is 3 - show 1 number before/after current page
    
    return $args;
}

// Placeholder img
function filter_woocommerce_placeholder_img( $image_html, $size, $dimensions ) {
    $dimensions = wc_get_image_size( $size );
    
    $default_attr = array(
        'class' => 'woocommerce-placeholder',
        'alt'   => __( 'Placeholder', 'woocommerce' ),
    );
    
    $attr = wp_parse_args( array(), $default_attr );
    
    $theme_url = get_template_directory_uri();
    $image = $theme_url . '/assets/images/placeholder.svg';
    
    $hwstring = image_hwstring( $dimensions['width'], $dimensions['height'] );
    $attributes = array();
    
    foreach ( $attr as $name => $value ) {
        $attributes[] = esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
    }
    
    $image_html = '<img src="' . esc_url( $image ) . '" ' . $hwstring . ' ' . implode( ' ', $attributes ) . '/>';
    
    return $image_html;
}

add_filter('woocommerce_quantity_input_args', 'change_quantity_type_single_product', 999, 2);

function change_quantity_type_single_product($args, $product) {
    if (is_product()) {
        $args['type'] = 'number';
    }
    return $args;
}