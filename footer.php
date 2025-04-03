<?php
	$opening_hours = get_theme_mod('opening_hours');
	$copyright = get_theme_mod('copyright', '');
?>

	<section class="section section-subscribe">
		<div class="container">
			<div class="section-title">
				<?php _e('Підпишіться на розсилку'); ?>
			</div>

			<?php echo do_shortcode( '[contact-form-7 id="6424b04"]' ); ?>

			<div class="text">
				<?php _e('Лише корисна інформація. Без нав’язливого спаму.'); ?>
			</div>
		</div>
	</section>

	<footer class="footer">
		<div class="container">

			<div class="row">

				<div class="col col-1 footer-info-container">
					<?php if ($opening_hours) : ?>
						<div class="footer-opening-hours">
							<?php echo nl2br(esc_html($opening_hours)); ?>
						</div>
					<?php endif; ?>

					<div class="footer-phone">
						<?php get_template_part( 'template-parts/blocks/block', 'phone' ); ?>
					</div>

					<div class="footer-social">
						<?php get_template_part( 'template-parts/blocks/block', 'social-links' ); ?>
					</div>

					<?php if ($opening_hours) : ?>
						<div class="footer-copyright">
							<?php echo do_shortcode(nl2br(esc_html($copyright))); ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="col col-2 footer-menu-container">
					<div class="footer-menu">
						<div class="label"><?php _e('Продукція')?></div>
						<?php
							wp_nav_menu(
								array(
									'menu' => '33',
								)
							);
						?>
					</div>
					<div class="footer-menu">
						<div class="label"><?php _e('Компанія')?></div>
						<?php
							wp_nav_menu(
								array(
									'menu' => '34',
								)
							);
						?>
					</div>
					<div class="footer-menu">
						<div class="label"><?php _e('Інформація')?></div>
						<?php
							wp_nav_menu(
								array(
									'menu' => '35',
								)
							);
						?>
					</div>
				</div>

			</div>
		</div>
	</footer>

	<a class="to-top" href="#page"></a>
</div>

<?php wp_footer(); ?>

</body>
</html>
