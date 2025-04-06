<?php
get_header();
$is_home = is_front_page();
$is_category = is_product_category();
$is_shop = is_shop();
$is_page_shop = wc_get_page_permalink( 'shop' );
$is_account = wc_get_page_permalink( 'myaccount' );
$is_orders = wc_get_account_endpoint_url( 'orders' ); // Orders page
?>

<main id="primary" class="site-main<?php if(!$is_home): ?> site-page<?php endif; ?>">

    <?php if(!$is_home && !$is_category && !$is_page_shop && !$is_account): ?>
        <div class="breadcrumb-container">
            <div class="container">
                <?php
                    if ( function_exists('yoast_breadcrumb') ) {
                        yoast_breadcrumb( '<div id="breadcrumbs">','</div>' );
                    }
                ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($is_category || $is_shop) : ?>
        <section class="section section-category-hero">
            <div class="container">
                <?php get_template_part('template-parts/blocks/block', 'search'); ?>
                <?php get_template_part('template-parts/blocks/block', 'category'); ?>
            </div>
        </section>
        <div class="container category-container">

            <?php if (is_active_sidebar('category_container_before')) : ?>
                <div class="category-before">
                    <?php dynamic_sidebar('category_container_before'); ?>
                </div>
            <?php endif; ?>

            <div class="category-side">
                <?php get_template_part('template-parts/blocks/block', 'filter'); ?>
            </div>

            <div class="category-main">
                <?php the_content(); ?>
            </div>
        </div>

        <?php else: ?>

        <div class="header-title">
            <div class="container">
                <h1><?php the_title(); ?></h1>
            </div>
        </div>
        
        <?php if (get_the_content()) : ?>
            <?php the_content(); ?>
        <?php endif; ?>

    <?php endif; ?>

</main>

<?php
get_footer();