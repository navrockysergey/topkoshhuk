<?php
if (is_cart()) {
    $cart_items = WC()->cart->get_cart();
    $cross_sell_products = array();

    foreach ($cart_items as $cart_item) {
        $product = $cart_item['data'];
        $cross_sell_products = array_merge($cross_sell_products, $product->get_cross_sell_ids());
    }

    $cross_sell_products = array_unique($cross_sell_products);

    if (!empty($cross_sell_products)) {
        $args = array(
            'post_type' => 'product',
            'post__in' => $cross_sell_products,
            'posts_per_page' => -1 
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) { ?>
            <section class="section section-crosssells">
                <div class="section-title">
                    <?php echo __('Popular foods', 'foodmiles'); ?>
                    <span><?php echo __('You may also like', 'foodmiles'); ?></span>
                </div>
                <div class="owl-carousel" id="carousel-crosssell">
                    <?php while ($query->have_posts()) : $query->the_post(); 
                        global $product;
                        
                        if (!$product || !$product->is_visible()) {
                            continue;
                        }
                        wc_get_template_part('content', 'product'); 
                    ?>
                    <?php endwhile; ?>
                </div>
            </section>
        <?php }

        wp_reset_postdata();
    }
}
?>
