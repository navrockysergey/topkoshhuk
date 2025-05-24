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
        <i class="icon-minus-24"></i>
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

    <div class="qty-suffix">
        <input type="text" class="fake-qty" min="0" value="<?php echo $val?>" data-suffix="<?php _e('ящ.'); ?>">
        <span id="qty-suffix"><?php _e('ящ.'); ?></span>
    </div>

    <button class="button button-qty qty-plus">
        <i class="icon-plus-24"></i>
    </button>
</div>
