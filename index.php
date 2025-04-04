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

		<section class="section section-posts">
			<div class="container">

				<h1 class="page-title"><?php echo __('Блог'); ?></h1>
				
				<?php
					while ( have_posts() ) : the_post();
						?>
							<article <?php post_class(); ?>>
								<h3 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
								<div class="entry-summary">
									<?php the_excerpt(); ?>
								</div>
							</article>
						<?php
					endwhile;
				?>

				<div class="pagination">
					<?php
						the_posts_pagination();
					?>
				</div>
			</div>
		</section>
		
	</main>

<?php
get_footer();
