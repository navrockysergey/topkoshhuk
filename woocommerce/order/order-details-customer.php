<?php
/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.7.0
 */

defined( 'ABSPATH' ) || exit;
$order_data           = $order->get_data();
$shipping_data        = $order->get_shipping_methods();
$shipping_method_id   = 'nova_poshta_shipping';
$shipping_method_name = $order->get_shipping_method();

$shipping_first_name = $order->get_shipping_first_name();
$shipping_last_name  = $order->get_shipping_last_name();

$billing_first_name = $order->get_billing_first_name();
$billing_last_name  = $order->get_billing_last_name();

$customer_first_name  = ! empty( $shipping_first_name ) ? $shipping_first_name : $billing_first_name;
$customer_last_name   = ! empty( $shipping_last_name ) ? $shipping_last_name : $billing_last_name;

$payment_method 	  = $order->get_payment_method();
$payment_method_title = $order->get_payment_method_title();

foreach ( $shipping_data as $id => $shipping ) {
	$shipping_method_id = $shipping->get_method_id();
}

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<div class="woocommerce-customer-details">
	<div class="order-data-item shipping-method">
		<i class="icon-<?php echo esc_attr( $shipping_method_id )?>"></i>

		<span class="content">
			<?php
			echo esc_html( $shipping_method_name );
			?>
		</span>
	</div>

	<?php 
		if ( $show_shipping ) :
		?>
		<div class="order-data-item shipping">
			<i class="icon-map-24"></i>

			<address class="content">
				<?php
					if ( ! empty( $order_data["shipping"]["city"] ) ) {
						echo esc_html( $order_data["shipping"]["city"] ) . ' ';
					};

					if ( ! empty( $order_data["shipping"]["address_1"] ) ) {
						echo esc_html( $order_data["shipping"]["address_1"] ) . ' ';
					};

					if ( ! empty( $order_data["shipping"]["address_2"] ) ) {
						echo esc_html( $order_data["shipping"]["address_2"] ) . ' ';
					}
				?>
			</address>
		</div>
		<?php
		else :
			?>
			<div class="order-data-item billing">
				<i class="icon-wallet-24"></i>

				<address class="content">
				<?php
					if ( ! empty( $order_data["billing"]["city"] ) ) {
						echo esc_html( $order_data["billing"]["city"] ) . ' ';
					};

					if ( ! empty( $order_data["billing"]["address_1"] ) ) {
						echo esc_html( $order_data["billing"]["address_1"] ) . ' ';
					};

					if ( ! empty( $order_data["billing"]["address_2"] ) ) {
						echo esc_html( $order_data["billing"]["address_2"] ) . ' ';
					}
				?>
				</address>
			</div>
			<?php
		endif; 
	?>

	<div class="order-data-item customer">
		<span class="icon-user"></span>

		<span class="content">
			<?php
			echo esc_html( $customer_first_name ) . ' ' . esc_html( $customer_last_name );
			?>
		</span>
	</div>

	<?php
	if ( ! empty( $payment_method ) ) :
		?>
		<div class="order-data-item order-pyment">
			<i class="icon-wallet-24 <?php echo esc_attr( $payment_method )?>"></i>

			<div class="content">
				<?php echo esc_attr( $payment_method_title )?>
			</div>
		</div>
		<?php
	endif;
	?>
</div>
