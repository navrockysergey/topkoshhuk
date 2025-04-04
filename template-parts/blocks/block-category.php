<?php
$categories_args = array(
    'taxonomy'     => 'product_cat',
    'orderby'      => 'name',
    'order'        => 'ASC',
    'hide_empty'   => false,
    'exclude'      => array( 15 ),
    'parent'       => 0,
);

$categories = get_terms( $categories_args );

if ( ! empty( $categories ) ) :
?>
<div class="main-category">
    <div class="main-category-slider owl-carousel" id="main-category-slider">
        <?php
        foreach ( $categories as $category ) : 
            $category_link = get_term_link( $category );
            $thumbnail_id  = get_term_meta( $category->term_id, 'thumbnail_id', true );
            $image_url     = wp_get_attachment_url( $thumbnail_id );
            $image_alt     = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
            $is_active     = is_tax( 'product_cat', $category->term_id ) ? ' active' : '';
            ?>
            <a class="item item-item-<?php echo $category->term_id . $is_active; ?>" href="<?php echo esc_url($category_link); ?>">
                <?php if ( $image_url ) : ?>
                    <span class="item-image"><img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>"></span>
                <?php endif; ?>
                <span class="item-name">
                    <?php echo esc_html( $category->name ); ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php
endif;