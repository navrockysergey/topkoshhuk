<?php
if (is_product()) {
    global $product;
    $related_products = wc_get_related_products($product->get_id(), 99);

    if (!empty($related_products)) { ?>
        <section class="section section-related-products">
            <div class="section-title">
                <?php echo __('We recommend you try it', 'tk'); ?>
                <span><?php echo __('You may also like', 'tk'); ?></span>
            </div>
            <div class="owl-carousel" id="carousel-related-products">
                <?php foreach ($related_products as $related_product_id) : 
                    $related_product = wc_get_product($related_product_id);
                    
                    if (!$related_product || !$related_product->is_visible()) {
                        continue;
                    }

                    $post_object = get_post($related_product_id);
                    setup_postdata($GLOBALS['post'] = $post_object);
                    
                    global $product;
                    $product = $related_product;
                    wc_get_template_part('content', 'product'); 
                endforeach; ?>
            </div>
        </section>
    <?php }
}
?>