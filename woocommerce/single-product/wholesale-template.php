<?php
defined( 'ABSPATH' ) || exit;

global $product;
$product_id       = $product->get_id();
$wholesales_str   = get_post_meta( $product_id, '_wholesale_prices', true );

if ( empty( $wholesales_str ) ) {
    return;
};

$wholesales_start = [
    'min_product_count' => 0,
    'wh_price'          => $product->get_regular_price(),
];

$wholesales_array = json_decode( $wholesales_str, true, 512, JSON_THROW_ON_ERROR );

$wholesales = array(
    $wholesales_start,
);

foreach ( $wholesales_array as $wholesale ) {
    if ( ! is_array( $wholesale ) || ! array_key_exists( 'min_product_count', $wholesale ) || ! array_key_exists( 'wh_price', $wholesale ) ) {
        continue;
    }

    // Ensure that the min_product_count is an integer and wh_price is a float
    $wholesale['min_product_count'] = intval( $wholesale['min_product_count'] );
    $wholesale['wh_price']          = floatval( $wholesale['wh_price'] );

    // Add the wholesale level to the array
    array_push( $wholesales, $wholesale );
}

$currency         = get_woocommerce_currency_symbol();
// $price            = $product->get_price();
$quentity_in_box  = intval( get_post_meta( $product_id, '_box_quantity', true ) );
$quentity_in_cart = intval( apply_filters( 'get_cart_product_count', $product_id ) );
?>
<div class="product-summary-item product-wholesales">
    <?php
    foreach ( $wholesales as $inx => $level ) :
        $active                = '';
        $lvl_count             = intval( $level['min_product_count'] );
        $wholesale_lvl_price   = floatval( $level['wh_price'] );

        if ( -1 < ( $quentity_in_cart <=> $lvl_count ) &&
                array_key_exists( $inx+1, $wholesales ) &&
                -1 == ( $quentity_in_cart <=> intval( $wholesales[$inx+1]['min_product_count'] ) ) ||
                -1 < ( $quentity_in_cart <=> $lvl_count ) &&
                ! array_key_exists( $inx+1, $wholesales )
            )
            {
                $active = 'active';
            }
        ?>
        <span class="wholesale-item <?php echo $active?>" data-pr-count="<?php echo $lvl_count?>">
            <?php
            echo number_format( round( $wholesale_lvl_price, 2), 2, ',', '' ) . " " . $currency . " від " . $lvl_count . "шт.";
            ?>
        </span>
        <?php
    endforeach;
    ?>
</div>