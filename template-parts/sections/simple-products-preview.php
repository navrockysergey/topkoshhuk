<?php
$products_query_arguments = [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => intval( $simple_previews_products_count ),
];

if ( ! empty( $simple_previews_tags ) ) {
    $products_query_arguments['tax_query'] = [
        [
            'taxonomy' => 'product_tag',
            'field'    => 'slug',
            'terms'    => implode( $simple_previews_tags ),
        ],
    ];
}

$products = new WP_Query( $products_query_arguments );

if ( ! $products->have_posts() ) {
    return;
}
?> 
<section class="section products-colection">
    <div class="container">
        <div class="section-title">
            <?php
                echo esc_html( $simple_previews_title )
            ?>
        </div>

        <div class="products new-products">
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

        <div class="section-footer">
            <a href="<?php echo esc_url( $simple_previews_button_lnk )?>" class="button">
                <?php echo esc_html( $simple_previews_buttom_text )?>
            </a>
        </div>
    </div>
</section>
<?php

wp_reset_postdata();