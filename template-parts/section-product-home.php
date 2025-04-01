<section class="section woocommerce section-bestsellers">
    <div class="container">
        <div class="section-title">
            <?php echo __('Хіти продаж'); ?>
        </div>
        
        <?php 
        $args = [
            'post_type'      => 'product',
            'orderby'        => 'rand',
            'posts_per_page' => -1,
            'suppress_filters' => false,
        ];
        
        $query = new WP_Query($args);
        
        if ($query->have_posts()) : ?>
            <div class="owl-carousel products product-carousel" id="carousel-bestsellers">
            <?php while ($query->have_posts()) :
                $query->the_post();
                $post_id = get_the_ID();
                $original_id = apply_filters( 'wpml_object_id', $post_id, 'product', true, 'uk' );
                $show_in_home = get_post_meta($original_id, '_product_show_home', true);
        
                if ($show_in_home) {
                    wc_get_template_part('content', 'product');
                }
            endwhile; ?>
           </div>
        <?php endif;

        wp_reset_postdata(); ?>
    </div>
</section>
