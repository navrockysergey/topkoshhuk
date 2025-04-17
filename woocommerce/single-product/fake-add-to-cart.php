<?php
$val       = isset( $args['box_q_val'] ) ? intval( $args['box_q_val'] ) : 0;
$in_box    = isset( $args['in_box'] ) ? intval( $args['in_box'] ) : 0;
$in_cart_q = $args['in_cart_q'];
$product   = $args['product'];

if ( $val > 0 && $in_box > 0 && $val >= $in_box ) {
    $val = $val/$in_box;
}
?>
<div class="qty-container" data-in-box="<?php echo $in_box?>" data-product-id="<?php echo $product->get_id()?>">
    <button class="button button-qty qty-minus">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5.5 11C5.22386 11 5 11.2239 5 11.5V12.5C5 12.7761 5.22386 13 5.5 13H18.5C18.7761 13 19 12.7761 19 12.5V11.5C19 11.2239 18.7761 11 18.5 11H5.5Z" fill="currentColor"/>
        </svg>
    </button>

    <?php
        woocommerce_quantity_input(
            array(
                'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                'input_value' => $in_cart_q,
            )
        );
    ?>

    <input type="text" class="fake-qty" min="1" value="<?php echo $val?>">

    <button class="button button-qty qty-plus">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13 11V5.5C13 5.22386 12.7761 5 12.5 5H11.5C11.2239 5 11 5.22386 11 5.5V11H5.5C5.22386 11 5 11.2239 5 11.5V12.5C5 12.7761 5.22386 13 5.5 13H11V18.5C11 18.7761 11.2239 19 11.5 19H12.5C12.7761 19 13 18.7761 13 18.5V13H18.5C18.7761 13 19 12.7761 19 12.5V11.5C19 11.2239 18.7761 11 18.5 11H13Z" fill="currentColor"/>
        </svg>
    </button>
</div>
