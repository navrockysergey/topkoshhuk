<section class="section woocommerce section-bestsellers">
    <div class="container">
        <div class="section-title">
            <?php echo __('Хіти продаж'); ?>
        </div>
        
        <?php 
        $args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'orderby'        => 'rand',
            'meta_query'     => array(
                'relation' => 'AND',
                array(
                    'key'   => '_stock_status',
                    'value' => 'instock',
                ),
                array(
                    'key'   => 'product_badge_top_sales',
                    'value' => 'yes',
                    'compare' => '=',
                ),
            ),
        );
            
        $products = new WP_Query($args);
        
        if ($products->have_posts()) : ?>
            <div class="owl-carousel products product-carousel" id="carousel-bestsellers">
                <?php while ($products->have_posts()) {
                    $translated_post_id = apply_filters( 'wpml_object_id', get_the_ID(), 'product', false, 'uk' );

                    if ($translated_post_id) {
                        $post = get_post($translated_post_id);
                        setup_postdata($post);
                        wc_get_template_part('content', 'product');
                    } else {
                        wc_get_template_part('content', 'product');
                    }
                    
                } ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php wp_reset_postdata(); ?>
