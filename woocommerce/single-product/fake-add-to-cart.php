<?php
$val    = isset( $args['input_val'] ) ? intval( $args['input_val'] ) : 0;
$in_box = isset( $args['in_box'] ) ? intval( $args['in_box'] ) : 0;

if ( $val > 0 && $in_box > 0 && $val >= $in_box ) {
    $val = $val/$in_box;
}
?>
<div class="qty-inputs">
    <button class="set-quantity manus">-</button>

    <input type="text" class="fake-qty" value="<?php echo $val?>">

    <button class="set-quantity plus">+</button>
</div>
