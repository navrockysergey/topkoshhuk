<?php

if ( empty( $brans_media_products_terms ) ) {
    return;
}

?>
<section class="section brands-video-previews">
    <div class="container">
        <?php
        foreach( $brans_media_products_terms as $brand ) :
            $term = get_term_by( 'term_id', $brand['id'], 'product_brand' );

            if ( ! $term ) {
                continue;
            };
            
            $brand_id = $brand['id'];
            $brand_bg_image             = get_term_meta( $brand_id, '_brand_bg_image', true );
            $brand_thumbnail_id         = get_term_meta( $brand_id, 'thumbnail_id', true );
            $brand_media_preview_src    = get_attachment_link( $brand_thumbnail_id );
            $term_link                  = get_term_link( $brand_id );

            if ( ! $brand_media_preview_src ) {
                continue;
            }

            $prod_args = [
                'post_type'      => 'product',
                'post_status'    => 'publish',
                'orderby'        => 'rand',
                'posts_per_page' => intval( $brans_media_products_per_page ),
                'tax_query'      => [
                    [
                        'taxonomy' => 'product_brand',
                        'field'    => 'term_id',
                        'terms'    => $brand_id,
                    ],
                ],
            ];

            $products = new WP_Query( $prod_args );

            if ( ! $products->have_posts() ) {
                wp_reset_postdata();
                continue;
            }
        ?>
            <div class="brand-products">
                <div class="products brands-products">
                    <li class="product product-brand">
                        <a class="product-brand-link" href="<?php echo $term_link?>" style="background-image: url(<?php echo esc_url($brand_bg_image)?>)">
                            <img src="<?php echo esc_url($brand_media_preview_src)?>" alt="<?php _e('Виробник')?>">
                        </a>
                        <a class="button button-secondary button-product-brand" href="<?php echo $term_link?>">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.8 11.6C17.0666 11.8 17.0666 12.2 16.8 12.4L9.8 17.8991C9.47038 18.1463 9 17.9111 9 17.4991L9 6.50091C9 6.08888 9.47038 5.85369 9.8 6.10091L16.8 11.6Z" fill="currentColor"></path>
                            </svg>
                        </a>
                    </li>
                    <?php
                    while( $products->have_posts() ):
                        $products->the_post();

                        $product = wc_get_product( get_the_ID() );

                        if ( $product ) {
                            wc_get_template_part( 'content', 'product' );
                        }
                    endwhile;
                    ?>
                </div>
            </div>
        <?php
            wp_reset_postdata();
        endforeach;
        ?>
    </div>
</section>