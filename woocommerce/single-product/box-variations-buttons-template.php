<?php
defined( 'ABSPATH' ) || exit;

global $product;
$product_id       = $product->get_id();
$in_box    = intval( get_post_meta( $product_id, '_box_quantity', true ) );
$in_cart   = intval( apply_filters( 'get_cart_product_count', $product_id ) );

$retail_active    = $in_cart < $in_box ? 'active' : '';
$wholesale_active = $in_cart > $in_box ? 'active' : '';
?>
<div class="box-variations">
    <button class="box-variation wholesale <?php echo $wholesale_active?>">
        Ящики
    </button>
    
    <button class="box-variation retail <?php echo $retail_active?>">
        Штуки
    </button>
</div>