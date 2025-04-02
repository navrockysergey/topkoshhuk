	<?php
	$opening_hours = get_theme_mod('opening_hours');
	?>

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
						<?php get_template_part( 'template-parts/blocks/block', 'phone' ); ?>
					</div>
				</div>

				<div class="col col-2 footer-menu-container">
					<div class="footer-menu">
						<?php
							wp_nav_menu(
								array(
									'menu' => '33',
								)
							);
						?>
					</div>
					<div class="footer-menu">
						<?php
							wp_nav_menu(
								array(
									'menu' => '34',
								)
							);
						?>
					</div>
					<div class="footer-menu">
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
