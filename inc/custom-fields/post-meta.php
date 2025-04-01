<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
add_action( 'carbon_fields_register_fields', 'custom_posts_meta_data' );

function custom_posts_meta_data() {
    Container::make( 'post_meta', __('Product banner') )
    ->where( 'post_type', '=', 'product' )
    ->set_context( 'side' )
    ->add_fields( array(
        Field::make( 'image', 'product_banner', __('Set banner image') ),
    ) );
}