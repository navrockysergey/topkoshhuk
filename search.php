<?php
get_header();
?>

<main id="primary" class="site-main">

	<div class="breadcrumb-container">
		<div class="container">
			<?php
				if ( function_exists('yoast_breadcrumb') ) {
					yoast_breadcrumb( '<div id="breadcrumbs">','</div>' );
				}
			?>
		</div>
	</div>

	<section class="section section-category-hero">
		<div class="container">
			<?php get_template_part('template-parts/blocks/block', 'search'); ?>
			<?php get_template_part('template-parts/blocks/block', 'category'); ?>
		</div>
	</section>
	
	<div class="container category-container search-container<?php if ( !have_posts() ) : ?> no-results<?php endif; ?>">

		<?php if ( have_posts() ) : ?>
			<div class="category-side">
				<?php get_template_part('template-parts/blocks/block', 'filter'); ?>
			</div>
		<?php endif; ?>

		<div class="category-main">
			<?php if ( have_posts() ) : ?>
				<div class="search-result-info">
					<?php
						printf( esc_html__( 'Результати пошуку: %s' ), '<span>' . get_search_query() . '</span>' );
					?>
				</div>

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
			<?php else : ?>
				<div class="container no-results-container">
					<div class="no-results-message">
						<h1><?php echo esc_html__( 'Нічого не знайдено'); ?></h1>
						<p><?php echo esc_html__( 'На жаль, за вашим запитом нічого не знайдено. Спробуйте змінити пошуковий запит.'); ?></p>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>

</main>

<?php
get_footer();