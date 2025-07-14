<?php
defined( 'ABSPATH' ) || exit;

global $product;
$product_id       = $product->get_id();
$in_box      = intval( get_post_meta( $product_id, '_box_quantity', true ) );
$in_cart     = intval( apply_filters( 'get_cart_product_count', $product_id ) );
$is_in_stock = $product->is_in_stock();

$retail_active    = 0 < $in_cart && $in_cart < $in_box ? 'active' : '';
$wholesale_active = 'active' !== $retail_active ? 'active' : '';

?>
<?php if ( $is_in_stock ) : ?>
    <div class="box-variations">
        <button class="box-variation wholesale <?php echo $wholesale_active?>" data-qty-suffix="<?php _e('ящ.'); ?>">
            <i class="icon-box-24"></i>
            <?php _e('Ящики'); ?>
        </button>
        
        <button class="box-variation retail <?php echo $retail_active?>" data-qty-suffix="<?php _e('шт.'); ?>">
            <i class="icon-item-24"></i>
            <?php _e('Штуки'); ?>
        </button>
    </div>
<?php endif; ?>