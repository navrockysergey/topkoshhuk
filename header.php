<?php
	$home_url = home_url();
	$is_home = is_front_page();
	$page_id = get_the_ID();
	$body_class = '';
?>

 <!doctype html>
 <html <?php language_attributes(); ?>>
 <head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-WTTRMJ9F');</script>
	<!-- End Google Tag Manager -->
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WTTRMJ9F"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
 </head>
 
 <body <?php body_class($body_class); ?>>
 <?php wp_body_open(); ?>

 <div id="page" class="site">
	 
	 <header class="site-header">
		 <div class="container">
 
			 <div class="row">

			 	<div class="col col-1 menu-wrapper">
					<div class="menu-inner">
						<div class="menu-header">
							<?php get_template_part( 'template-parts/blocks/block', 'logo' ); ?>
						</div>
						<a href="#" class="button close-menu">
							<i class="icon-close"></i>
						</a>
						<div class="menu-primary">
							<?php
								wp_nav_menu( array(
									'menu' => 32
								) );
							?>
							<div class="menu-phone">
								<?php get_template_part( 'template-parts/blocks/block', 'phone' ); ?>
							</div>
						</div>
						<?php get_template_part( 'template-parts/blocks/block', 'social-links' ); ?>
					</div>
				</div>

				 <div class="col col-2">
					<?php get_template_part( 'template-parts/blocks/block', 'logo' ); ?>
				 </div>

				 <div class="col col-3">

					<div class="header-phone">
						<?php get_template_part( 'template-parts/blocks/block', 'phone' ); ?>
					</div>

					<?php if (function_exists('WC') && !is_cart()) : 
							// $cart_count = WC()->cart->get_cart_contents_count();
							$cart_count = count( WC()->cart->get_cart() );
							$cart_url = wc_get_cart_url(); 
						?>
						<a class="header-cart header-cart-link" href="<?php echo esc_url($cart_url); ?>" data-cart-fragment="true">
							<span class="cart-label">
								<i class="icon-cart"></i>
							</span>
							<span class="cart-count"><?php echo esc_html($cart_count); ?></span>
						</a>

						<script type="text/javascript">
							jQuery(function($) {
								$(document.body).on('added_to_cart removed_from_cart wc_fragments_loaded wc_fragments_refreshed', function() {
									let cartCount = 0;
									
									if (typeof wc_cart_fragments_params !== 'undefined') {
										let fragments = JSON.parse(sessionStorage.getItem(wc_cart_fragments_params.fragment_name));
										if (fragments && fragments['div.widget_shopping_cart_content']) {
											let $temp = $('<div>').html(fragments['div.widget_shopping_cart_content']);
											cartCount = parseInt($temp.find('.cart-count').text()) || 0;
											
											if (isNaN(cartCount) || cartCount < 0) {
												cartCount = 0;
											}
											
											$('.cart-count').text(cartCount);
										}
									}
								});
							});
						</script>
					<?php endif; ?>

					<?php 
						if (function_exists('header_login_dropdown')) {
							header_login_dropdown(); 
						}
					?>

					<a class="menu-toggle">
						<i class="icon-menu"></i>
					</a>
 
				 </div>
			 </div>
 
		 </div>
	 </header>
 