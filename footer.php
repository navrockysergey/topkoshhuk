	<?php
	$current_language = apply_filters('wpml_current_language', NULL);

	if ($current_language === 'uk') {
		$opening_hours = get_theme_mod('opening_hours_uk', '');
	} else {
		$opening_hours = get_theme_mod('opening_hours_ru', '');
	}
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
				<i class="fa fa-phone" aria-hidden="true"></i>
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
					<?php if ( get_theme_mod( 'phone_3' ) ) : ?>
						<div class="footer-phone-link">
							<a href="tel:<?php echo preg_replace('/\D/', '', get_theme_mod( 'phone_3' ) ); ?>">
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

	<a class="call-back mobile-call-back" href="#call-back">
		<span><?php echo __('CallBack'); ?></span>
	</a>

	<?php if (function_exists('WC') && !is_cart()) : 
		$cart_count = WC()->cart->get_cart_contents_count(); 
		$cart_url = wc_get_cart_url(); 
		?>
		<a class="mobile-cart" href="<?php echo esc_url($cart_url); ?>">
			<span>
				<span class="cart-icon"><span class="cart-count"><?php echo esc_html($cart_count); ?></span></span>
				<span class="cart-label"><?php echo __('Cart', 'woocommerce'); ?></span>
			</span>
		</a>
	<?php endif; ?>

</div>

<?php wp_footer(); ?>

</body>
</html>
