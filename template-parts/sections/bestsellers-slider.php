<?php
$products_query_arguments = [
    'post_type'      => 'product',
    'post_status'    => 'publish',
    'posts_per_page' => $bestseller_per_page,
    'tax_query'      => [
        [
            'taxonomy' => 'product_tag',
            'field'    => 'slug',
            'terms'    => 'hit',
        ],
    ],
];

$products = get_posts( $products_query_arguments );

if ( empty( $products ) ) {
    return;
}
?>

<section id="bestsselers-carusel">
    <h2>
        <?php echo esc_html( $bestsellers_section_title )?>
    </h2>

    <div class="bestsselers-carusel-wrap">
        <?php
        foreach( $products as $item ) :
            $product                            = wc_get_product( $item->ID );
            $product_thumbnail_id               = get_post_meta( $item->ID, '_product_banner', true );
            $product_thumbnail_sourse_full_size = wp_get_attachment_url( $product_thumbnail_id, $item->ID, 'full' );
            $product_permalink                  = get_the_permalink( $item->ID );
            ?>
            <div class="best-product-slide">
                <h3 class="product-title">
                    <?php echo esc_html( $item->post_title )?>
                </h3>

                <div class="product-banner">
                    <img src="<?php echo esc_url( $product_thumbnail_sourse_full_size )?>" alt="<?php echo esc_attr( $item->post_title )?>">
                </div>

                <div class="slide-footer">
                    <div class="inputs">
                        <a href="<?php echo esc_url( $product_permalink )?>" class="button">
                            <?php echo __( 'Перейти до товару' )?>
                        </a>
                    </div>
                </div>
            </div>
            <?php
        endforeach;
        ?>
    </div>
</section>