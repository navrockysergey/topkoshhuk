<?php
$val       = isset( $args['box_q_val'] ) ? intval( $args['box_q_val'] ) : 0;
$in_box    = isset( $args['in_box'] ) ? intval( $args['in_box'] ) : 0;
$in_cart_q = $args['in_cart_q'];
$product   = $args['product'];

if ( $val > 0 && $in_box > 0 && $val >= $in_box ) {
    $val = round( $val/$in_box, 2 );
}

$retail_step = apply_filters( 'woocommerce_quantity_input_step', 1, $product );

if ( $in_cart_q > $in_box ) {
   $retail_step = $in_box;
}

?>
<div class="qty-container" data-in-box="<?php echo $in_box?>" data-product-id="<?php echo $product->get_id()?>">
    <button class="button button-qty qty-minus">
        <i class="icon-minus-24"></i>
    </button>

    <?php
        woocommerce_quantity_input(
            array(
                'min_value'   => '0',
                'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                'input_value' => $in_cart_q,
                'step'        => $retail_step,
            )
        );
    ?>
    
    <input type="number" class="fake-qty" min="0" value="<?php echo $val?>" data-suffix="<?php _e('ящ.'); ?>">

    <div class="qty-suffix">
        <span id="qty-suffix"><?php _e('ящ.'); ?></span>
    </div>

    <button class="button button-qty qty-plus">
        <i class="icon-plus-24"></i>
    </button>
</div>
