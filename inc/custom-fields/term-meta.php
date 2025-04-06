<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
add_action( 'carbon_fields_register_fields', 'custom_terms_meta_data' );

function custom_terms_meta_data() {
    Container::make( 'term_meta', __( 'Brand video preveiw' ) )
        ->where( 'term_taxonomy', '=', 'product_brand' )
        ->add_fields( array(
            Field::make( 'image', 'brand_bg_image', __( 'Background Image' ) )
            ->set_value_type('url') 
            ->set_help_text( __( 'Upload an image to be used as the background for this brand.' ) ),   
        ) );
}