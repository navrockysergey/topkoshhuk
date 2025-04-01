<?php
get_header();
$is_home = is_front_page();
?>

<main id="primary" class="site-main<?php if(!$is_home): ?> site-page<?php endif; ?>">

    <?php get_template_part('template-parts/section', 'category'); ?> 

    <?php if(!$is_home): ?>
        <div class="container breadcrumb-container">
            <?php
                if ( function_exists('yoast_breadcrumb') ) {
                    yoast_breadcrumb( '<div id="breadcrumbs">','</div>' );
                }
            ?>
        </div>
    <?php endif; ?>

    <?php if (is_product_category()) : ?>
        <div class="container category-title-container">
            <h1 class="page-title"><?php single_term_title(); ?></h1>
        </div>
    <?php endif; ?>

    <?php if (get_the_content()) : ?>
        <section class="section section-page">
            <div class="container">
                <?php the_content(); ?>
            </div>
        </section>
    <?php endif; ?>

    <div><?php 
            if (is_product_category()) {
                get_template_part('template-parts/section', 'popular-products'); 
                get_template_part('template-parts/section', 'map-delivery'); 
            }
        ?></div>

    <?php do_action( 'main_after' ); ?>

</main>

<?php
get_footer();