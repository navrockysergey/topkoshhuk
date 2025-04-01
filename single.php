<?php
get_header();
$hero_show = carbon_get_post_meta($page_id, 'hero_show');
?>

	<main id="primary" class="site-main">

		<?php get_template_part('template-parts/section', 'category'); ?> 

		<div class="container breadcrumb-container">
            <?php
                if ( function_exists('yoast_breadcrumb') ) {
                    yoast_breadcrumb( '<div id="breadcrumbs">','</div>' );
                }
            ?>
        </div>

		<?php if (get_the_content()) : ?>
			<section class="section section-single">
				<div class="container">
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				</div>
			</section>
		<?php endif; ?>
		
	</main>

<?php
get_footer();
