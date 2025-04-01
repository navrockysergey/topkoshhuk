<?php
if (is_product()) {
    global $product;
    $upsell_products = $product->get_upsell_ids();

    if (!empty($upsell_products)) { ?>
        <section class="section section-upsell-products">
            <div class="section-title">
                <?php echo __('We recommend you', 'foodmiles'); ?>
                <span><?php echo __('You may also like', 'foodmiles'); ?></span>
            </div>
            <div class="owl-carousel" id="carousel-upsell-products">
                <?php foreach ($upsell_products as $upsell_product_id) : 
                    $upsell_product = wc_get_product($upsell_product_id);
                    
                    if (!$upsell_product || !$upsell_product->is_visible()) {
                        continue;
                    }

                    $post_object = get_post($upsell_product_id);
                    setup_postdata($GLOBALS['post'] = $post_object);
                    
                    global $product;
                    $product = $upsell_product;
                    wc_get_template_part('content', 'product'); 
                endforeach; ?>
            </div>
        </section>
    <?php }
}
?>
