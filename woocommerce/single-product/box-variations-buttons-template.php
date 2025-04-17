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
    <button class="box-variation wholesale active">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.499 1.13506C11.8089 0.95563 12.1911 0.955631 12.501 1.13506L21.001 6.05612C21.3099 6.2349 21.5 6.5647 21.5 6.92154V17.0784C21.5 17.4353 21.3099 17.7651 21.001 17.9439L12.501 22.8649C12.1911 23.0443 11.8089 23.0443 11.499 22.8649L2.99896 17.9439C2.69015 17.7651 2.5 17.4353 2.5 17.0784V6.92154C2.5 6.5647 2.69015 6.2349 2.99896 6.05611L11.499 1.13506ZM14.9688 13.6262L18.5312 11.5637V8.06374L13.7812 5.31374L10.2188 7.37624L14.9688 10.1262V13.6262ZM7.25 16.5925V18.655L3.6875 16.5925V14.53L7.25 16.5925Z" fill="currentColor"/>
        </svg>
        <?php _e('Ящики'); ?>
    </button>
    
    <button class="box-variation retail">
        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 9C6.94772 9 6.5 9.44772 6.5 10V20C6.5 20.5523 6.94772 21 7.5 21H17.5C18.0523 21 18.5 20.5523 18.5 20V10C18.5 9.44772 18.0523 9 17.5 9H7.5ZM9 15C8.72386 15 8.5 15.2239 8.5 15.5V18.5C8.5 18.7761 8.72386 19 9 19H16C16.2761 19 16.5 18.7761 16.5 18.5V15.5C16.5 15.2239 16.2761 15 16 15H9Z" fill="currentColor"/>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 3C6.94772 3 6.5 3.44772 6.5 4V7C6.5 7.55228 6.94772 8 7.5 8H17.5C18.0523 8 18.5 7.55228 18.5 7V4C18.5 3.44772 18.0523 3 17.5 3H7.5ZM11.5 5C11.5 4.44772 11.9477 4 12.5 4C13.0523 4 13.5 4.44772 13.5 5H14.5C15.0523 5 15.5 5.44772 15.5 6C15.5 6.55228 15.0523 7 14.5 7H10.5C9.94772 7 9.5 6.55228 9.5 6C9.5 5.44772 9.94772 5 10.5 5H11.5Z" fill="currentColor"/>
            <path d="M9.5 16.5C9.5 16.2239 9.72386 16 10 16H15C15.2761 16 15.5 16.2239 15.5 16.5V17.5C15.5 17.7761 15.2761 18 15 18H10C9.72386 18 9.5 17.7761 9.5 17.5V16.5Z" fill="currentColor"/>
        </svg>
        <?php _e('Штуки'); ?>
    </button>
</div>