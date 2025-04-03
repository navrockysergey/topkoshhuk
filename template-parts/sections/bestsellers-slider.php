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
    'meta_query' => array(
        array(
            'key'     => '_product_banner',
            'compare' => '!=',
            'value'   => ''
        )
    )
];

$products = get_posts( $products_query_arguments );

if ( empty( $products ) ) {
    return;
}
?>

<section class="section section-bestsellers">
    <div class="container">
        
        <div class="section-title">
            <?php echo esc_html( $bestsellers_section_title )?>
        </div>

        <div class="bestsellers owl-carousel" id="bestsellers">
            <?php
            foreach( $products as $item ) :
                $product                            = wc_get_product( $item->ID );
                $product_banner_id                  = get_post_meta( $item->ID, '_product_banner', true );
                $product_banner_sourse_full_size    = wp_get_attachment_url( $product_banner_id, $item->ID, 'full' );
                $product_permalink                  = get_the_permalink( $item->ID );
                ?>
                <div class="item">
                    <span class="badge badge-hit"><?php _e('Хіт'); ?></span>
                    <div class="item-image">
                        <img src="<?php echo esc_url( $product_banner_sourse_full_size )?>" alt="<?php echo esc_attr( $item->post_title )?>">
                    </div>
                    <div class="item-content">
                        <span class="item-title">
                            <a href="<?php echo esc_url( $product_permalink )?>">
                                <?php echo esc_html( $item->post_title )?>
                            </a>
                        </span>
                        <div class="item-footer">
                            <a href="<?php echo esc_url( $product_permalink )?>" class="button button-product-view">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.8 11.6C17.0666 11.8 17.0666 12.2 16.8 12.4L9.8 17.8991C9.47038 18.1463 9 17.9111 9 17.4991L9 6.50091C9 6.08888 9.47038 5.85369 9.8 6.10091L16.8 11.6Z" fill="currentColor"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            endforeach;
            ?>
        </div>
    </div>
</section>