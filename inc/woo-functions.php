<?php
// remove_action( 'woocommerce_before_shop_loop_item_title'    , 'woocommerce_template_loop_product_thumbnail', 10 );
// remove_action( 'woocommerce_shop_loop_item_title'           , 'woocommerce_template_loop_product_title', 10 );
// remove_action( 'woocommerce_before_shop_loop_item_title'    , 'woocommerce_show_product_loop_sale_flash', 10 );
// remove_action( 'woocommerce_before_single_product_summary'  , 'woocommerce_show_product_sale_flash', 10 );
// remove_action( 'woocommerce_before_shop_loop'               , 'woocommerce_result_count', 20 );
// remove_action( 'woocommerce_before_shop_loop'               , 'woocommerce_catalog_ordering', 30 );
// remove_action( 'woocommerce_after_single_product_summary'   , 'woocommerce_output_related_products', 20 );
// remove_action( 'woocommerce_before_main_content'            , 'woocommerce_breadcrumb', 20 );
// add_filter( 'script_loader_src'                             , 'remove_version_query_string' );
// add_filter( 'style_loader_src'                              , 'remove_version_query_string' );
// add_filter( 'woocommerce_product_tabs'                      , 'remove_all_woocommerce_tabs', 100 );
// add_filter( 'woocommerce_variable_product_contents'         , '__return_false', 100 );
// add_filter( 'woocommerce_cart_ready_to_calc_shipping'       , 'disable_shipping_calc_on_cart', 99 );
// add_filter( 'woocommerce_cart_item_remove_link'             , 'custom_remove_cart_item_button', 10, 2 );
// add_action( 'wp'                                            , 'remove_cart_cross_sells' );
add_action( 'wp_loaded'                                         , 'woocommerce_single_product_summary_changes' );
add_filter( 'get_wholesale_prices'                              , 'get_wholesale_prices' );

// add_action( 'init'                                              , 'create_ingredients_taxonomy' );
// add_filter( 'woocommerce_cart_needs_payment', 'woocommerce_disabled_payment' );
// function woocommerce_disabled_payment() {
// 	return false;
// }
add_action( 'admin_head'                                        , 'add_woocommerce_category_description_editor' );
add_action( 'woocommerce_product_options_shipping'              , 'add_custom_shipping_fields' );
add_action( 'woocommerce_product_options_general_product_data'  , 'add_wholesale_price_fields');
add_action( 'woocommerce_process_product_meta'                  , 'save_custom_options_fields' );
// add_action( 'woocommerce_single_product_summary'                , 'display_custom_box_price_fields', 11 );
add_action( 'woocommerce_after_shop_loop_item'                  , 'add_sku_before_price', 9 );
// add_action( 'woocommerce_before_shop_loop_item_title'           , 'custom_product_image_title_wrapper', 10 );
add_action( 'get_cart_product_count'                            , 'get_cart_product_count', 10, 1 );
add_action( 'woocommerce_before_calculate_totals'               , 'dinamyc_set_price', 10, 1 );
add_action( 'template_redirect'                                 , 'saved_resently_product', 20 );
add_filter( 'woo_get_brands'                                    , 'woo_get_brands', 1 );
add_action( 'woocommerce_shipping_init'                         , 'init_ukrposhta_shipping_method' );
add_filter( 'woocommerce_shipping_methods'                      , 'add_ukrposhta_shipping_method' );
add_action( 'init'                                              , 'custom_account_endpoints', 25 );
add_action( 'woocommerce_account_account-data_endpoint'         , 'account_person_data', 25 );
add_action( 'template_redirect'                                 , 'redirect_my_account_to_orders' );

// ===================================================================================================
remove_action( 'woocommerce_after_shop_loop_item'               , 'woocommerce_template_loop_add_to_cart', 10 );

add_action( 'wp_ajax_get_cart_count'                            , 'get_cart_count_ajax' );
add_action( 'wp_ajax_nopriv_get_cart_count'                     , 'get_cart_count_ajax' );
add_action( 'wp_enqueue_scripts'                                , 'add_wc_ajax_params' );
add_filter( 'woocommerce_add_to_cart_fragments'                 , 'cart_count_fragments', 10, 1 );
// add_action( 'woocommerce_before_shop_loop'                      , 'add_content_woocommerce_before_shop_loop', 15 );
add_action( 'woocommerce_before_cart'                           , 'order_steps', 1 );
add_action( 'woocommerce_before_checkout_form'                  , 'order_steps', 1 );
add_action( 'woocommerce_thankyou'                              , 'order_steps', 1 );
add_action( 'woocommerce_account_content'                       , 'add_h1_to_my_account_page', 5 );
add_filter( 'woocommerce_cart_item_name'                        , 'checkoout_item_display', 10, 3 );
add_action( 'wp'                                                , 'remove_order_details_on_order_received' );

// add_filter( 'woocommerce_account_menu_items'                    , 'remove_downloads_from_my_account_menu' );
add_filter( 'woocommerce_account_menu_items'                    , 'custom_account_menu_items' );

add_action( 'woocommerce_proceed_to_checkout'                   , 'replace_proceed_to_checkout', 10 );
add_action( 'woocommerce_before_cart_totals'                    , 'minimum_order_message' );
add_action( 'main_after'                                        , 'load_crosssell_products_after_cart', 20 );
add_filter( 'body_class'                                        , 'add_woocommerce_class_to_body' );

function woocommerce_single_product_summary_changes() {
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
    // remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_main_data', 5 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_product_box_quantity', 10 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_single_template_wholesale', 20 );
    add_action( 'woocommerce_single_product_summary', 'add_to_cart_box_variations_buttons_template', 30 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 40 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_attributes', 45 );
    add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 50 );

    add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_resently_products', 20 );
}

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item'      , 'woocommerce_template_loop_add_to_cart', 10) ;
add_action( 'woocommerce_after_shop_loop_item'         , 'custom_price_button_wrapper', 10 );
add_filter( 'woocommerce_get_price_html'               , 'custom_price_html', 100, 2 );
add_filter( 'wpc_auto_scroll_offset'                    , 'wpc_change_auto_scroll_offset' );

function wpc_change_auto_scroll_offset( $offset ){
    return 200;
}

function custom_price_html( $price, $product ) {
    $price = str_replace( '&nbsp;', ' ', $price );

    $price_prefix = '<span class="price-prefix">' . __('від', 'your-text-domain') . '</span>';
    $price_suffix = '<span class="price-suffix">' . __('за шт.', 'your-text-domain') . '</span>';
    $price_wrapper = '<span class="price-wrapper">' . $price . '</span>';

    return $price_prefix . $price_wrapper . $price_suffix;
}

function custom_price_button_wrapper() {
    global $product;
    $link = $product->get_permalink();
    
    echo '<div class="price-cart-wrapper">';
    
    echo '<span class="price">' . $product->get_price_html() . '</span>';
    
    echo '
    <a href="' . esc_url( $link ) . '" class="button button-product-view">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M16.8 11.6C17.0666 11.8 17.0666 12.2 16.8 12.4L9.8 17.8991C9.47038 18.1463 9 17.9111 9 17.4991L9 6.50091C9 6.08888 9.47038 5.85369 9.8 6.10091L16.8 11.6Z" fill="currentColor"/>
        </svg>
    </a>';
    
    echo '</div>';
}

function woocommerce_template_single_main_data() {
    wc_get_template( 'single-product/main-data.php' );
}

function woocommerce_product_box_quantity() {
    global $product;

    $box_quantity = get_post_meta( $product->get_id(), '_box_quantity', true );

    if ( $box_quantity && '' !== $box_quantity && intval( $box_quantity ) > 0 ):
        echo sprintf( "<span class='box_quantity'>В ящику: %s шт.</span>", $box_quantity );
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

// Register the "Ingredients" taxonomy for WooCommerce products
function create_ingredients_taxonomy() {

    $labels = array(
        'name'              => 'Ingredients',
        'singular_name'     => 'Ingredient',
        'search_items'      => 'Search Ingredients',
        'all_items'         => 'All Ingredients',
        'parent_item'       => 'Parent Ingredient',
        'parent_item_colon' => 'Parent Ingredient:',
        'edit_item'         => 'Edit Ingredient',
        'update_item'       => 'Update Ingredient',
        'add_new_item'      => 'Add New Ingredient',
        'new_item_name'     => 'New Ingredient Name',
        'menu_name'         => 'Ingredients',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => false,
        'query_var'         => true,
        'rewrite'           => false,
    );

    register_taxonomy('ingredient', 'product', $args);
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
        'id' => '_wholesale_prices',
        'label' => '',
        'desc_tip' => 'true',
        'type' => 'hidden',
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

// Remove the version number from the scripts and styles
function remove_version_query_string($src) {
    if ( strpos( $src, 'ver=' ) ) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}

// Add SKU before the price
function add_sku_before_price() {
    global $product;
    
    $sku = $product->get_sku();
    if ($sku) {
        echo '<p class="product-sku-wrapper">Артикул: <span class="product-sku">' . $sku . '</span></p>';
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
    $out = 0;

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

function dinamyc_set_price( $cart ) {
    foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
         $id = $cart_item['variation_id'] > 0 ? $cart_item['variation_id'] : $cart_item["product_id"];

         $price = get_who_price( $id, $cart_item["quantity"] );

        $cart_item['data']->set_price( $price );
    }
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

// ===============================================================

// Add AJAX handler for getting cart count
function get_cart_count_ajax() {
    echo WC()->cart->get_cart_contents_count();
    wp_die();
}

// Make sure WC AJAX parameters are available
function add_wc_ajax_params() {
    if (function_exists('is_woocommerce') && !is_admin()) {
        wp_enqueue_script('wc-cart-fragments');
    }
}

function cart_count_fragments($fragments) {
    $fragments['.cart-count'] = '<span class="cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
    return $fragments;
}

// Category header
function add_content_woocommerce_before_shop_loop() {
    echo '<div class="category-header">';
    
    // echo do_shortcode('[fe_widget]');
    
    woocommerce_result_count();
    
    woocommerce_catalog_ordering();
    
    echo '</div>';
}

// Remove tabs
function remove_all_woocommerce_tabs($tabs) {
    return array();
}

// Remove link in cart
function custom_remove_cart_item_button( $remove_link, $cart_item_key ) {
    $remove_link = '<a href="' . esc_url( wc_get_cart_remove_url( $cart_item_key ) ) . '" class="remove">
                      <i class="fa fa-times"></i>
                    </a>';
    return $remove_link;
}


// Remove shipping in cart
function disable_shipping_calc_on_cart( $show_shipping ) {
    if( is_cart() ) {
        return false;
    }
    return $show_shipping;
}

// Add title in account 
function add_h1_to_my_account_page() {
    if (is_account_page()) {
        echo '<h1>' . __('Мій акаунт') . '</h1>';
    }
}

// Checkoout item display
function checkoout_item_display($name, $cart_item, $cart_item_key) {
    if (!is_checkout()) {
        return $name;
    }
    
    $product = $cart_item['data'];
    $quantity = $cart_item['quantity'];
    $thumbnail = $product->get_image(array(100, 100));
    $title = $product->get_title();
    
    $variation_html = '';
    if (!empty($cart_item['variation'])) {
        $variation_html = '<div class="product-variation">';
        foreach ($cart_item['variation'] as $attribute => $value) {
            $attribute_name = str_replace('attribute_', '', $attribute);
            $attribute_label = wc_attribute_label($attribute_name);
            $variation_html .= '<div class="variation-item">' . $attribute_label . ': <span>' . $value . '</span></div>';
        }
        $variation_html .= '</div>';
    }

    $output = '<div class="checkout-product-wrapper">';
    $output .= '<div class="product-image">' . $thumbnail . '</div>';
    $output .= '<div class="product-details">';
    $output .= '<div class="product-title">' . $title . '</div>';
    $output .= '<div class="product-quantity">' . __('Quantity', 'woocommerce') . ': <span>' . $quantity . '</span></div>';
    $output .= $variation_html;
    $output .= '</div>';
    $output .= '</div>';
    
    return $output;
}

// Remove sections from woocommerce thankyou
function remove_order_details_on_order_received() {
    if (is_order_received_page()) {
        remove_action('woocommerce_thankyou', 'woocommerce_order_details_table', 10);
        remove_action('woocommerce_thankyou', 'woocommerce_customer_details', 20);
    }
}

// Remove download section from woocommerce my account
// function remove_downloads_from_my_account_menu($items) {
//     if (isset($items['downloads'])) {
//         unset($items['downloads']);
//     }
//     return $items;
// }

function redirect_my_account_to_orders() {
    // if ( is_account_page() && !is_wc_endpoint_url('orders') ) {
    //     wp_redirect( wc_get_account_endpoint_url( 'orders' ) );
    //     exit;
    // }
}

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

    $items['account-data'] = __('Платіжні дані');

    $items['account-security'] = __('Безпека');

    $items['customer-logout'] = __('Вийти');

    return $items;
}

function custom_account_endpoints() {
    add_rewrite_endpoint( 'account-data', EP_PAGES );
}

function account_person_data() {
 
	echo 'Accout Data';
 
}

// Check minimum order amount on checkout page
function get_minimum_order_amount() {
    $minimum_amount = get_theme_mod('min_order_amount', '');
    return esc_html(get_theme_mod('minimum_order_amount', $minimum_amount));
}

function is_below_minimum_order() {
    $minimum_amount = get_minimum_order_amount();
    return WC()->cart && WC()->cart->get_cart_contents_total() < $minimum_amount;
}

function get_current_language() {
    if (function_exists('apply_filters') && has_filter('wpml_current_language')) {
        return apply_filters('wpml_current_language', NULL);
    }
    else if (function_exists('pll_current_language')) {
        return pll_current_language();
    }
    return get_locale();
}

function get_continue_shopping_text() {
    $current_language = get_current_language();
    
    $texts = array(
        'uk' => 'Продовжити покупки',
        'ru' => 'Продолжить покупки',
        'default' => 'Continue shopping'
    );
    
    return isset($texts[$current_language]) ? $texts[$current_language] : $texts['default'];
}

function get_checkout_text() {
    $current_language = get_current_language();
    
    $texts = array(
        'uk' => 'Оформити замовлення',
        'ru' => 'Оформить заказ',
        'default' => 'Checkout'
    );
    
    return isset($texts[$current_language]) ? $texts[$current_language] : $texts['default'];
}

function replace_proceed_to_checkout() {
    if (is_below_minimum_order()) {
        remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
        $shop_page_url = get_permalink(wc_get_page_id('shop'));
        echo '
            <a href="' . esc_url($shop_page_url) . '" class="button continue-shopping">' . 
            get_continue_shopping_text() . '</a>
            <a href="#" class="checkout-button button alt disabled">' . 
            get_checkout_text() . '</a>
        ';
    }
}


// Add minimum order message
function minimum_order_message() {

    $minimum_amount = get_theme_mod('min_order_amount', '');

    if ( ! $minimum_amount ) {
        return;
    }

    $cart_total = WC()->cart->get_total('edit');
    $cart_total_float = floatval(preg_replace('/[^\d.]/', '', $cart_total));

    if ( $cart_total_float < $minimum_amount ) {
        $difference = $minimum_amount - $cart_total_float;

        $messages = array(
            'uk' => 'Мінімальна сума замовлення - %s грн. Додайте ще товарів на %s грн, щоб оформити доставку.',
            'ru' => 'Минимальная сумма для оформления заказа - %s грн. Пожалуйста, добавьте еще товаров на %s грн, чтобы оформить доставку.',
            'default' => 'Minimum order amount is %s UAH. Please add more items worth %s UAH to complete your order.'
        );

        $current_language = get_locale();

        if (isset($messages[$current_language])) {
            $message = $messages[$current_language];
        } else {
            $message = $messages['uk'];
        }

        $formatted_message = sprintf($message, number_format($minimum_amount, 0, ',', ' '), number_format($difference, 0, ',', ' '));

        echo '<div class="minimum-order-message">' . esc_html($formatted_message) . '</div>';
    }
}


// Crosssell in cart
function load_crosssell_products_after_cart() {
    if ( is_cart() ) {
        get_template_part( 'template-parts/section', 'crosssell-products' );
    }
}

// Add woocommerce class in body (cart)
function add_woocommerce_class_to_body( $classes ) {
    if ( is_cart() ) {
        $classes[] = 'woocommerce';
    }
    return $classes;
}

// Remove crosssells from cart page
function remove_cart_cross_sells() {
    remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
}

// Add woocommerce class in account
function add_woo_account_body_class($classes) {
    if (is_user_logged_in() && is_account_page()) {
        $classes[] = 'woo-logged-in-account';
    }
    return $classes;
}