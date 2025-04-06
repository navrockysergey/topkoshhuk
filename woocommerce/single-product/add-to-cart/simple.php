<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}
$product_id       = $product->get_id();
$count_in_box     = get_post_meta( $product_id, '_box_quantity', true );
$quentity_in_cart = apply_filters( 'get_cart_product_count', $product_id );
$quentity_value   = $product->get_min_purchase_quantity();

if ( $count_in_box > 0 ) {
	$quentity_value = $quentity_in_cart;
} elseif ( isset( $_POST['quantity'] ) ) {
	$quentity_value = wc_stock_amount( wp_unslash( $_POST['quantity'] ) );
};

echo wc_get_stock_html( $product );

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart"
		  action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>"
		  method="post"
		  data-in-box="<?php echo $count_in_box?>"
		  enctype='multipart/form-data'>
		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<?php
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		wc_get_template( 'single-product/price.php' );

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
				'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
				'input_value' => $quentity_value,
			)
		);

		wc_get_template( 'single-product/fake-add-to-cart.php', ['input_val' => $quentity_value, 'in_box' => $count_in_box] );

		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>

		<a class="button button-catalog" href="<?php echo get_permalink( wc_get_page_id( 'shop' ) ) ?>">
			<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M11.3592 4.85355L10.6521 4.14645C10.4569 3.95118 10.1403 3.95118 9.94502 4.14645L7.6484 6.44307C7.45314 6.63833 7.45314 6.95491 7.6484 7.15017L8.35551 7.85728C8.55077 8.05254 8.86735 8.05254 9.06261 7.85728L11.3592 5.56066C11.5545 5.3654 11.5545 5.04882 11.3592 4.85355Z" fill="currentColor"/>
				<path d="M13.6485 4.85355L14.3556 4.14645C14.5508 3.95118 14.8674 3.95118 15.0627 4.14645L17.3593 6.44307C17.5546 6.63833 17.5546 6.95491 17.3593 7.15017L16.6522 7.85728C16.4569 8.05254 16.1403 8.05254 15.9451 7.85728L13.6485 5.56066C13.4532 5.3654 13.4532 5.04882 13.6485 4.85355Z" fill="currentColor"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M6.50317 9C4.58393 9 3.15827 10.7773 3.57461 12.6508L4.68572 17.6508C4.99075 19.0234 6.20819 20 7.61428 20H17.3856C18.7917 20 20.0091 19.0234 20.3142 17.6508L21.4253 12.6508C21.8416 10.7773 20.416 9 18.4967 9H6.50317ZM8.17777 13.2289L9.15396 13.012C9.42353 12.9521 9.69062 13.1221 9.75052 13.3916L10.228 15.5405C10.2879 15.81 10.118 16.0771 9.84841 16.137L8.87222 16.3539C8.60265 16.4138 8.33556 16.2439 8.27566 15.9743L7.79815 13.8255C7.73824 13.5559 7.90821 13.2888 8.17777 13.2289ZM16.8221 13.2289L15.8459 13.012C15.5763 12.9521 15.3093 13.1221 15.2493 13.3916L14.7718 15.5405C14.7119 15.81 14.8819 16.0771 15.1515 16.137L16.1276 16.3539C16.3972 16.4138 16.6643 16.2439 16.7242 15.9743L17.2017 13.8255C17.2616 13.5559 17.0917 13.2888 16.8221 13.2289ZM13.002 13L12.002 13C11.7258 13 11.502 13.2239 11.502 13.5L11.502 15.5C11.502 15.7761 11.7258 16 12.002 16H13.002C13.2781 16 13.502 15.7761 13.502 15.5L13.502 13.5C13.502 13.2239 13.2781 13 13.002 13Z" fill="currentColor"/>
			</svg>
			<?php _e( 'Продовжити покупки' ); ?>
		</a>

		<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>">
			<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M11.3592 4.85355L10.6521 4.14645C10.4569 3.95118 10.1403 3.95118 9.94502 4.14645L7.6484 6.44307C7.45314 6.63833 7.45314 6.95491 7.6484 7.15017L8.35551 7.85728C8.55077 8.05254 8.86735 8.05254 9.06261 7.85728L11.3592 5.56066C11.5545 5.3654 11.5545 5.04882 11.3592 4.85355Z" fill="currentColor"/>
				<path d="M13.6485 4.85355L14.3556 4.14645C14.5508 3.95118 14.8674 3.95118 15.0627 4.14645L17.3593 6.44307C17.5546 6.63833 17.5546 6.95491 17.3593 7.15017L16.6522 7.85728C16.4569 8.05254 16.1403 8.05254 15.9451 7.85728L13.6485 5.56066C13.4532 5.3654 13.4532 5.04882 13.6485 4.85355Z" fill="currentColor"/>
				<path fill-rule="evenodd" clip-rule="evenodd" d="M6.50317 9C4.58393 9 3.15827 10.7773 3.57461 12.6508L4.68572 17.6508C4.99075 19.0234 6.20819 20 7.61428 20H17.3856C18.7917 20 20.0091 19.0234 20.3142 17.6508L21.4253 12.6508C21.8416 10.7773 20.416 9 18.4967 9H6.50317ZM8.17777 13.2289L9.15396 13.012C9.42353 12.9521 9.69062 13.1221 9.75052 13.3916L10.228 15.5405C10.2879 15.81 10.118 16.0771 9.84841 16.137L8.87222 16.3539C8.60265 16.4138 8.33556 16.2439 8.27566 15.9743L7.79815 13.8255C7.73824 13.5559 7.90821 13.2888 8.17777 13.2289ZM16.8221 13.2289L15.8459 13.012C15.5763 12.9521 15.3093 13.1221 15.2493 13.3916L14.7718 15.5405C14.7119 15.81 14.8819 16.0771 15.1515 16.137L16.1276 16.3539C16.3972 16.4138 16.6643 16.2439 16.7242 15.9743L17.2017 13.8255C17.2616 13.5559 17.0917 13.2888 16.8221 13.2289ZM13.002 13L12.002 13C11.7258 13 11.502 13.2239 11.502 13.5L11.502 15.5C11.502 15.7761 11.7258 16 12.002 16H13.002C13.2781 16 13.502 15.7761 13.502 15.5L13.502 13.5C13.502 13.2239 13.2781 13 13.002 13Z" fill="currentColor"/>
			</svg>
			<?php echo esc_html( $product->single_add_to_cart_text() ); ?>
		</button>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
