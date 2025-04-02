<?php

$current_product_id = get_the_ID();

$args = array(
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'orderby'        => 'rand',
    'post__not_in'   => array($current_product_id),
    'posts_per_page' => -1,
    'suppress_filters' => false,
);

$query = new WP_Query($args);
        
if ($query->have_posts()) : ?>

    <section class="section section-popular">
        <div class="section-title">
            <?php echo __('Popular foods', 'tk'); ?>
            <span><?php echo __('You may also like', 'tk'); ?></span>
        </div>
        <div class="owl-carousel" id="carousel-popular">
            <?php while ($query->have_posts()) :
                $query->the_post();
                $post_id = get_the_ID();
                $original_id = apply_filters( 'wpml_object_id', $post_id, 'product', true, 'uk' );
                $show_in_home = get_post_meta($original_id, '_show_popular', true);
        
                if ($show_in_home) {
                    wc_get_template_part('content', 'product');
                }
            endwhile; ?>
        </div>
    </section>

<?php
    wp_reset_postdata();
endif;
?>
