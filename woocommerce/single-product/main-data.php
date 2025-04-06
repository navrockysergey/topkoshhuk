<?php

defined( 'ABSPATH' ) || exit;

global $product;

$product_ID     = $product->get_id();
$brands         = wc_get_product_terms( $product_ID, 'product_brand',  );
$product_sku    = $product->get_sku();
$barcode        = get_post_meta( $product_ID, '_global_unique_id', true );

if ( ! empty( $brands ) ):
    $brand_name = $brands[0]->name;
    $brand_id   = $brands[0]->term_id;
    $brand_lnk  = get_term_link( $brand_id, 'product_brand' );
    ?>
    <div class="product-summary-item">
        <span class="item-name">
            <strong><?php echo __( 'Brand', 'woocommerce' )?>:</strong>
        </span>

        <span class="item-value">
            <a href="<?php echo $brand_lnk?>">
                <?php echo $brand_name?>
            </a>
        </span>
    </div>
    <?php
endif;

if ( $product_sku && '' !== $product_sku ):
?>
    <div class="product-summary-item">
        <span class="item-name">
            <strong><?php echo __( 'Код товару')?>:</strong>
        </span>

        <span class="item-value">
            <?php echo $product_sku?>
        </span>
    </div>
<?php
endif;

if ( $barcode && '' !== $barcode ) :
    ?>
    <div class="product-summary-item">
        <span class="item-name">
            <strong><?php echo __( 'Штрихкод')?>:</strong>
        </span>

        <span class="item-value">
            <?php echo $barcode?>
        </span>
    </div>
<?php
endif;
