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
 </head>
 
 <body <?php body_class($body_class); ?>>
 <?php wp_body_open(); ?>

 <div id="page" class="site">
	 
	 <!-- <header class="site-header">
		 <div class="container">
 
			 <div class="row">
				 <div class="col-1">
 
					 <div class="site-branding">
						 <?php
							if ( function_exists( 'the_custom_logo' ) ) {
								the_custom_logo();
							}
						?>
					 </div>
 
				 </div>

				 <div class="col-2">
					col-2
				 </div>

				 <div class="col-3">

					<?php if ( !is_user_logged_in() ) : ?>
						<a class="header-login" href="<?php echo get_permalink(10); ?>"><?php echo __('Логін'); ?></a>
					<?php else:?>
						<a class="header-login" href="<?php echo get_permalink(10); ?>"><?php echo __('Мій акаунт'); ?></a>
					<?php endif;?>

					<?php if (function_exists('WC') && !is_cart()) : 
						$cart_count = WC()->cart->get_cart_contents_count(); 
						$cart_url = wc_get_cart_url(); 
						?>
						<a class="header-cart header-cart-link" href="<?php echo esc_url($cart_url); ?>">
							<span class="cart-label"><?php echo __('Cart', 'woocommerce'); ?></span>
							<span class="cart-count"><?php echo esc_html($cart_count); ?></span>
						</a>
					<?php endif; ?>
 
					 <div class="header-navigation">
						 <a class="menu-toggle">
							 <?php echo __('Меню'); ?>
						 </a>
						 <div class="menu-wrapper">
						 	<div class="menu-inner">

							 	<a href="#" class="close-menu"></a>

								<div class="menu-primary">
									<?php get_template_part('template-parts/category', 'menu'); ?> 
								</div>

								<div class="menu-footer">
									
									<?php
										wp_nav_menu(
											array(
												'menu' => '16',
											)
										);
									?>

								</div>

							</div>
						 </div>
					 </div>
 
				 </div>
			 </div>
 
		 </div>
	 </header> -->
 