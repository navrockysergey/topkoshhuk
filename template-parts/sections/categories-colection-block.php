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
<div class="container">
    <div class="main-categories">
        <div class="menu-categories owl-carousel" id="menu-categories">
            <?php
            foreach ( $categories as $category ) : 
                $category_link = get_term_link( $category );
                $thumbnail_id  = get_term_meta( $category->term_id, 'thumbnail_id', true );
                $image_url     = wp_get_attachment_url( $thumbnail_id );
                $image_alt     = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
                ?>
                <div class="menu-category menu-category-<?php echo $category->term_id; ?>">
                    <a href="<?php echo esc_url($category_link); ?>">
                        <?php if ( $image_url ) : ?>
                            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
                        <?php endif; ?>

                        <span>
                            <?php echo esc_html( $category->name ); ?>
                        </span>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php
endif;