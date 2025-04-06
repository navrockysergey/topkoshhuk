<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$current_post_id = get_the_ID();

if( empty( $_COOKIE[ 'woo_recently_viewed' ] ) ) {
	$viewed = array();
} else {
	$viewed = (array) explode( '|', $_COOKIE[ 'woo_recently_viewed' ] );
}

if ( empty( $viewed ) ) {
	return;
}

$viewed_products = array_reverse( array_map( 'absint', $viewed ) );

if ( $viewed_products ) : ?>

	<section class="section-resently">
		<div class="container">
			<?php
			$heading = apply_filters( 'woocommerce_product_upsells_products_heading', __( 'Ви переглядали', 'woocommerce' ) );

			if ( $heading ) :
				?>
				<h2><?php echo esc_html( $heading ); ?></h2>
			<?php endif; ?>

			<ul class="products owl-carousel" id="carousel-resently-products">

				<?php foreach ( $viewed_products as $viewed_product ) : ?>

					<?php
					if ( 0 == $viewed_product || $current_post_id == $viewed_product ) {
						continue;
					}
					$post_object = get_post( $viewed_product );

					setup_postdata( $GLOBALS['post'] = $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

					wc_get_template_part( 'content', 'product' );
					?>

				<?php endforeach; ?>

			</ul>
		</div>
	</section>

	<?php
endif;

wp_reset_postdata();
