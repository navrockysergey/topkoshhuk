<?php
$val    = isset( $args['input_val'] ) ? intval( $args['input_val'] ) : 0;
$in_box = isset( $args['in_box'] ) ? intval( $args['in_box'] ) : 0;

if ( $val > 0 && $in_box > 0 && $val >= $in_box ) {
    $val = $val/$in_box;
}
?>
<div class="qty-container">
    <button class="button button-qty qty-minus">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5.5 11C5.22386 11 5 11.2239 5 11.5V12.5C5 12.7761 5.22386 13 5.5 13H18.5C18.7761 13 19 12.7761 19 12.5V11.5C19 11.2239 18.7761 11 18.5 11H5.5Z" fill="#020202"/>
        </svg>
    </button>

    <input type="text" class="fake-qty" min="1" value="<?php echo $val?>">

    <button class="button button-qty qty-plus">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13 11V5.5C13 5.22386 12.7761 5 12.5 5H11.5C11.2239 5 11 5.22386 11 5.5V11H5.5C5.22386 11 5 11.2239 5 11.5V12.5C5 12.7761 5.22386 13 5.5 13H11V18.5C11 18.7761 11.2239 19 11.5 19H12.5C12.7761 19 13 18.7761 13 18.5V13H18.5C18.7761 13 19 12.7761 19 12.5V11.5C19 11.2239 18.7761 11 18.5 11H13Z" fill="#020202"/>
        </svg>
    </button>
</div>
