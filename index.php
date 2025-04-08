<?php
get_header();
?>
<div class="header-title">
	<div class="container">
		<h1><?php echo __('Блог компанії'); ?></h1>
	</div>
</div>
<section class="section section-news">
	<div class="container">
		<div class="article-items">
			<?php
			$args = array(
				'posts_per_page' => 9,
				'post_type' => 'post',
				'post_status' => 'publish',
				'orderby' => 'date',
				'order' => 'DESC',
			);
			
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args['paged'] = $paged;

			$query = new WP_Query($args);
			
			if ($query->have_posts()) :
				while ($query->have_posts()) : $query->the_post();
					?>
					<div class="article-item<?php if (is_sticky()) echo ' sticky'; ?>">
						<div class="article-item-wrapper">
							<?php if (has_post_thumbnail()) : ?>
								<div class="article-image">
									<a href="<?php the_permalink(); ?>">
										<img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>">
									</a>
								</div>
							<?php endif; ?>
							<div class="article-info">
								<div class="article-title">
									<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</div>
								<div class="article-excerpt">
									<?php the_excerpt(); ?>
								</div>
								<div class="article-footer">
									<div class="article-date">
										<?php echo get_the_date('d.m.Y'); ?>
									</div>
									<div class="article-more">
										<a href="<?php the_permalink(); ?>"><?php echo __('Читати далі'); ?></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php 
				endwhile;
				wp_reset_postdata();
				?>
		</div>

		<div class="pagination">
			<?php
			$big = 999999999;

			echo paginate_links(array(
				'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
				'format' => '%#%/',
				'current' => max(1, get_query_var('paged')),
				'total' => $query->max_num_pages,
				'prev_text' => '',
				'next_text' => '',
			));
			?>
		</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();