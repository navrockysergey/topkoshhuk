<?php
get_header();
$hero_show = carbon_get_post_meta($page_id, 'hero_show');
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

		<?php if (get_the_content()) : ?>
			<section class="section section-single">
				<div class="container">
					<?php the_content(); ?>
				</div>
			</section>
		<?php endif; ?>
		
	</main>

<?php
get_footer();
