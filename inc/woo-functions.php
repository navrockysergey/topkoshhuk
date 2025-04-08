<?php
add_filter( 'woocommerce_product_tabs'                          , 'remove_all_woocommerce_tabs', 100 );
add_action( 'wp_loaded'                                         , 'woocommerce_single_product_summary_changes' );
add_filter( 'get_wholesale_prices'                              , 'get_wholesale_prices' );
add_action( 'admin_head'                                        , 'add_woocommerce_category_description_editor' );
add_action( 'woocommerce_product_options_shipping'              , 'add_custom_shipping_fields' );
add_action( 'woocommerce_product_options_general_product_data'  , 'add_wholesale_price_fields');
add_action( 'woocommerce_process_product_meta'                  , 'save_custom_options_fields' );
add_action( 'woocommerce_after_shop_loop_item'                  , 'add_sku_before_price', 9 );
add_action( 'get_cart_product_count'                            , 'get_cart_product_count', 10, 1 );
add_action( 'woocommerce_before_calculate_totals'               , 'dinamyc_set_price', 10, 1 );
add_action( 'template_redirect'                                 , 'saved_resently_product', 20 );
add_filter( 'woo_get_brands'                                    , 'woo_get_brands', 1 );
add_action( 'woocommerce_shipping_init'                         , 'init_ukrposhta_shipping_method' );
add_filter( 'woocommerce_shipping_methods'                      , 'add_ukrposhta_shipping_method' );
add_action( 'init'                                              , 'custom_account_endpoints', 25 );
add_action( 'woocommerce_account_account-data_endpoint'         , 'account_person_data', 25 );
add_action( 'woocommerce_account_account-security_endpoint'     , 'account_security_data', 25 );
add_action( 'wp_ajax_get_product_prices'                        , 'get_product_prices' );
add_action( 'wp_ajax_nopriv_get_product_prices'                 , 'get_product_prices' );

// ===================================================================================================

remove_action( 'woocommerce_after_shop_loop_item'               , 'woocommerce_template_loop_add_to_cart', 10 );

add_action( 'wp_ajax_get_cart_count'                            , 'get_cart_count_ajax' );
add_action( 'wp_ajax_nopriv_get_cart_count'                     , 'get_cart_count_ajax' );
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

add_action( 'woocommerce_after_shop_loop_item'          , 'custom_price_button_wrapper', 10 );
add_action( 'woocommerce_before_single_product_summary' , 'start_single_product_container', 5 );
add_action( 'woocommerce_after_single_product_summary'  , 'end_single_product_container', 5 );
add_action( 'baza_product_before_images'                , 'show_badges_on_product_page', 10 );
add_action( 'woocommerce_before_shop_loop_item_title'   , 'show_badges_in_loop', 9 );
add_action( 'woocommerce_after_cart'                    , 'cross_sell_display' );
add_action( 'woocommerce_before_cart'                   , 'woocommerce_output_all_notices', 5 );

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

function dinamyc_set_price( $cart ) {
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

    $items['account-data'] = __('Платіжні дані');

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