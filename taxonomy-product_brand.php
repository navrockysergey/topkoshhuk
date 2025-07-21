<?php
get_header();
?>

<main id="primary" class="site-main">
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
            <?php echo do_shortcode('[products limit="18" columns="3" orderby="date" order="DESC" paginate=true]'); ?>
        </div>
    </div>
</main>

<?php
get_footer();