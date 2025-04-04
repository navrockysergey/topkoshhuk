<?php
get_header();
$is_home = is_front_page();
$is_category = is_product_category();
?>

<main id="primary" class="site-main<?php if(!$is_home): ?> site-page<?php endif; ?>">

    <?php if(!$is_home && !$is_category): ?>
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

    <?php if ($is_category) : ?>
        <section class="section section-category-hero">
            <div class="container">
                <?php get_template_part('template-parts/blocks/block', 'search'); ?>
                <?php get_template_part('template-parts/blocks/block', 'category'); ?>
            </div>
        </section>
        <div class="container category-container">
            <div class="category-side">
                <?php get_template_part('template-parts/blocks/block', 'filter'); ?>
            </div>
            <div class="category-main">
                <?php the_content(); ?>
            </div>
        </div>
        <?php else: ?>
            <?php if (get_the_content()) : ?>
                <div class="containner">
                    <?php the_content(); ?>
                </div>
        <?php endif; ?>

    <?php endif; ?>

</main>

<?php
get_footer();