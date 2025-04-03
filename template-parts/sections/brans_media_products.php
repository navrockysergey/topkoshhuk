<?php

if ( empty( $brans_media_products_terms ) ) {
    return;
}

?>
<section class="section brands-video-previews">
    <div class="container">
        <?php
        foreach( $brans_media_products_terms as $brand ) :
            $brand_id = $brand['id'];
            $brand_thumbnail_id         = get_term_meta( $brand_id, 'thumbnail_id', true );
            $brand_media_preview_src    = get_attachment_link( $brand_thumbnail_id );
            $term_link                  = get_term_link( $brand_id );

            if ( ! $brand_media_preview_src ) {
                continue;
            }

            $prod_args = [
                'post_type'      => 'product',
                'post_status'    => 'publish',
                'posts_per_page' => intval( $brans_video_products_per_page ),
            ];

            $products = new WP_Query( $prod_args );
        ?>
            <div class="brand-products">
                <div class="products">
                    <li class="product">
                        <a href="<?php echo $term_link?>">
                            <img src="<?php echo $brand_media_preview_src?>" alt="Brand">
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
