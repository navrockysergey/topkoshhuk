	<?php
	$opening_hours = get_theme_mod('opening_hours');
	?>

	<footer class="footer">
		<div class="container">

			<div class="footer-logo">

				<?php
					if ( function_exists( 'the_custom_logo' ) ) {
						the_custom_logo();
					}
				?>

				<a class="call-back" href="#call-back">
					<i class="fa fa-whatsapp" aria-hidden="true"></i>
					<?php echo __('Call-back'); ?>
				</a>

			</div>

			<div class="footer-phone">
				<div class="items">
					<?php if ( get_theme_mod( 'phone' ) ) : ?>
						<div class="footer-phone-link">
							<a href="tel:<?php echo preg_replace('/\D/', '', get_theme_mod( 'phone' ) ); ?>">
								<span>
									<?php 
										$phone = esc_html( get_theme_mod( 'phone' ) );
										$phone = preg_replace('/\(/', '<span>(', $phone, 1);
										$phone = preg_replace('/\)/', ')</span>', $phone, 1);
										echo $phone;
									?>
								</span>
							</a>
						</div>
					<?php endif; ?>
					<?php if ( get_theme_mod( 'phone_2' ) ) : ?>
						<div class="footer-phone-link">
							<a href="tel:<?php echo preg_replace('/\D/', '', get_theme_mod( 'phone_2' ) ); ?>">
								<span>
									<?php 
										$phone = esc_html( get_theme_mod( 'phone' ) );
										$phone = preg_replace('/\(/', '<span>(', $phone, 1);
										$phone = preg_replace('/\)/', ')</span>', $phone, 1);
										echo $phone;
									?>
								</span>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( get_theme_mod( 'email' ) ) : ?>
				<div class="footer-email">
					<a href="mailto:<?php echo esc_html( get_theme_mod( 'email' ) ); ?>"><?php echo esc_html( get_theme_mod( 'email' ) ); ?></a>
				</div>
			<?php endif; ?>

			<div class="footer-social">
				<?php get_template_part('template-parts/block', 'social-icons'); ?>
			</div>

			<div class="footer-menu">
				<div class="footer-block">
					<?php
						wp_nav_menu(
							array(
								'menu' => '17',
							)
						);
					?>
				</div>
			</div>

			<?php if ($opening_hours) : ?>
				<div class="footer-opening-hours">
					<?php echo nl2br(esc_html($opening_hours)); ?>
				</div>
			<?php endif; ?>

		</div>
	</footer>

	<a class="to-top" href="#page"></a>

</div>

<?php wp_footer(); ?>

</body>
</html>
