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
	 
	 <header class="site-header">
		 <div class="container">
 
			 <div class="row">

			 	<div class="col col-1 menu-wrapper">
					<div class="menu-inner">
						<div class="menu-header">
							<?php get_template_part( 'template-parts/blocks/block', 'logo' ); ?>
						</div>
						<a href="#" class="button close-menu">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M17.8553 7.55877C18.0506 7.36351 18.0506 7.04692 17.8553 6.85166L17.1482 6.14455C16.953 5.94929 16.6364 5.94929 16.4411 6.14455L11.9999 10.5858L7.55872 6.14455C7.36346 5.94929 7.04688 5.94929 6.85162 6.14455L6.14451 6.85166C5.94925 7.04692 5.94925 7.36351 6.14451 7.55877L10.5857 12L6.14449 16.4412C5.94923 16.6364 5.94923 16.953 6.14449 17.1483L6.8516 17.8554C7.04686 18.0506 7.36344 18.0507 7.55871 17.8554L11.9999 13.4142L16.4411 17.8554C16.6364 18.0507 16.953 18.0507 17.1482 17.8554L17.8553 17.1483C18.0506 16.953 18.0506 16.6364 17.8553 16.4412L13.4141 12L17.8553 7.55877Z" fill="currentColor"/>
							</svg>
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
						$cart_count = WC()->cart->get_cart_contents_count(); 
						$cart_url = wc_get_cart_url(); 
						?>
						<a class="header-cart header-cart-link" href="<?php echo esc_url($cart_url); ?>">
							<span class="cart-label">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M10.8594 4.85355L10.1523 4.14645C9.95699 3.95118 9.64041 3.95118 9.44514 4.14645L7.14852 6.44307C6.95326 6.63833 6.95326 6.95491 7.14852 7.15017L7.85563 7.85728C8.05089 8.05254 8.36747 8.05254 8.56274 7.85728L10.8594 5.56066C11.0546 5.3654 11.0546 5.04882 10.8594 4.85355Z" fill="currentColor"/>
									<path d="M13.1486 4.85355L13.8557 4.14645C14.0509 3.95118 14.3675 3.95118 14.5628 4.14645L16.8594 6.44307C17.0547 6.63833 17.0547 6.95491 16.8594 7.15017L16.1523 7.85728C15.957 8.05254 15.6405 8.05254 15.4452 7.85728L13.1486 5.56066C12.9533 5.3654 12.9533 5.04882 13.1486 4.85355Z" fill="currentColor"/>
									<path fill-rule="evenodd" clip-rule="evenodd" d="M6.00329 9C4.08405 9 2.65839 10.7773 3.07473 12.6508L4.18584 17.6508C4.49087 19.0234 5.70831 20 7.1144 20H16.8857C18.2918 20 19.5093 19.0234 19.8143 17.6508L20.9254 12.6508C21.3417 10.7773 19.9161 9 17.9968 9H6.00329ZM7.6779 13.2289L8.65408 13.012C8.92365 12.9521 9.19074 13.1221 9.25064 13.3916L9.72816 15.5405C9.78806 15.81 9.61809 16.0771 9.34853 16.137L8.37234 16.3539C8.10277 16.4138 7.83569 16.2439 7.77578 15.9743L7.29827 13.8255C7.23836 13.5559 7.40833 13.2888 7.6779 13.2289ZM16.3222 13.2289L15.346 13.012C15.0765 12.9521 14.8094 13.1221 14.7495 13.3916L14.272 15.5405C14.2121 15.81 14.382 16.0771 14.6516 16.137L15.6278 16.3539C15.8973 16.4138 16.1644 16.2439 16.2243 15.9743L16.7018 13.8255C16.7617 13.5559 16.5918 13.2888 16.3222 13.2289ZM12.5021 13L11.5021 13C11.2259 13 11.0021 13.2239 11.0021 13.5L11.0021 15.5C11.0021 15.7761 11.2259 16 11.5021 16H12.5021C12.7782 16 13.0021 15.7761 13.0021 15.5L13.0021 13.5C13.0021 13.2239 12.7782 13 12.5021 13Z" fill="currentColor"/>
								</svg>
							</span>
							<span class="cart-count"><?php echo esc_html($cart_count); ?></span>
						</a>
					<?php endif; ?>

					<a class="header-login" href="<?php echo get_permalink(14); ?>">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path fill-rule="evenodd" clip-rule="evenodd" d="M12 11.9985C13.6569 11.9985 15 10.6554 15 8.99854C15 7.34168 13.6569 5.99854 12 5.99854C10.3431 5.99854 9 7.34168 9 8.99854C9 10.6554 10.3431 11.9985 12 11.9985ZM12 13.9985C14.7614 13.9985 17 11.76 17 8.99854C17 6.23711 14.7614 3.99854 12 3.99854C9.23858 3.99854 7 6.23711 7 8.99854C7 11.76 9.23858 13.9985 12 13.9985Z" fill="currentColor"/>
							<path d="M7.82994 15.9985H16.1701C16.9661 15.9985 17.7294 16.3148 18.2922 16.8779L19.8537 18.4398C20.0489 18.6351 20.0489 18.9515 19.8537 19.1468L19.1459 19.8548C18.9507 20.0501 18.634 20.0501 18.4387 19.8548L16.8775 18.2931C16.6899 18.1054 16.4355 18 16.1701 18H7.82994C7.56463 18 7.31018 18.1054 7.12258 18.2931L5.56136 19.8548C5.36609 20.0501 5.04941 20.0501 4.85413 19.8548L4.14638 19.1468C3.95121 18.9515 3.95121 18.6351 4.14638 18.4398L5.70785 16.8779C6.27067 16.3148 7.034 15.9985 7.82994 15.9985Z" fill="currentColor"/>
						</svg>
					</a>

					<a class="menu-toggle">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M4 11C4 10.4477 4.44772 10 5 10L7 10C7.55228 10 8 10.4477 8 11V13C8 13.5523 7.55228 14 7 14H5C4.44772 14 4 13.5523 4 13V11Z" fill="white"/>
							<path d="M10 11C10 10.4477 10.4477 10 11 10L13 10C13.5523 10 14 10.4477 14 11V13C14 13.5523 13.5523 14 13 14H11C10.4477 14 10 13.5523 10 13V11Z" fill="white"/>
							<path d="M16 11C16 10.4477 16.4477 10 17 10L19 10C19.5523 10 20 10.4477 20 11V13C20 13.5523 19.5523 14 19 14H17C16.4477 14 16 13.5523 16 13V11Z" fill="white"/>
						</svg>
					</a>
 
				 </div>
			 </div>
 
		 </div>
	 </header>
 