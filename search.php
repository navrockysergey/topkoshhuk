<?php
get_header();
?>

<main id="primary" class="site-main">

	<?php 
		get_template_part( 'template-parts/section', 'category' ); 
	?>

	<?php if ( ! is_home() ) : ?>
		<div class="container breadcrumb-container">
			<?php
				if ( function_exists( 'yoast_breadcrumb' ) ) {
					yoast_breadcrumb( '<div id="breadcrumbs">', '</div>' );
				}
			?>
		</div>
	<?php endif; ?>

	<section class="section section-search">
		<div class="container">

			<?php if ( have_posts() ) : ?>
				<h1 class="page-title">
					<?php
						printf( esc_html__( 'Результати пошуку: %s', 'kelner' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>

				<div class="woocommerce">
					<ul class="products">
						<?php
						while ( have_posts() ) : the_post();
							?>
							<li class="product">
								<a href="<?php the_permalink(); ?>" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">
									<?php
										do_action( 'woocommerce_before_shop_loop_item_title' );
										do_action( 'woocommerce_shop_loop_item_title' );
										do_action( 'woocommerce_after_shop_loop_item_title' );
									?>
								</a>
								<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</section>

</main>

<?php
get_footer();
?>
