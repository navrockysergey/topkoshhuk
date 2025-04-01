<?php

if ( empty( $brans_video_products_terms ) ) {
    return;
}

?>
<section class="brands-video-previews">
    <div class="container">
        <?php
        foreach( $brans_video_products_terms as $brand ) :
            $brand_id = $brand['id'];
            $brand_media_type_preview    = carbon_get_term_meta( $brand_id, 'brand_video_type' );
            $brand_media_preview_file_id = carbon_get_term_meta( $brand_id, 'brand_video_file' );
            $brand_media_preview_src     = 'file' == $brand_media_type_preview ? get_attachment_link( $brand_media_preview_file_id ) : carbon_get_term_meta( $brand_id, 'brand_video_link' ) ;

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
                <video controls
                       src="<?php echo $brand_media_preview_src?>"
                       class="video-preview-item"
                       width="300"
                       >
                </video>

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
        <?php
            wp_reset_postdata();
        endforeach;
        ?>
    </div>
</section>
