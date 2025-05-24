<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.3.0
 */

defined( 'ABSPATH' ) || exit;

$product_attributes = $product->get_attributes();

if ( empty( $product_attributes ) ) {
	return;
}

?>
<table class="woocommerce-product-attributes shop_attributes" aria-label="<?php esc_attr_e( 'Product Details', 'woocommerce' ); ?>">
	<?php foreach ( $product_attributes as $product_attribute_key => $product_attribute ) : 
		$attribute = wc_get_attribute( $product_attribute['id'] );

		if ( ! $attribute || ! isset( $attribute->name ) ) {
			continue;
		}
		?>
		<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr( $product_attribute_key ); ?>">
			<th class="woocommerce-product-attributes-item__label" scope="row"><?php echo wp_kses_post( $attribute->name ); ?></th>

			<td class="woocommerce-product-attributes-item__value">
				<?php
					foreach( $product_attribute->get_options() as $term_id ) :
						$term = get_term( $term_id );
						echo wp_kses_post( $term->name ) . ' ';
					endforeach;
					?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
