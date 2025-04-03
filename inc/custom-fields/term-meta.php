<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
add_action( 'carbon_fields_register_fields', 'custom_terms_meta_data' );

function custom_terms_meta_data() {
    Container::make( 'term_meta', __( 'Brand video preveiw' ) )
        ->where( 'term_taxonomy', '=', 'product_brand' )
        ->add_fields( array(
            // Field::make( 'radio', 'brand_video_type', __( 'Choice type' ) )
            //     ->add_options( array(
            //         'file'      => __( 'File' ),
            //         'link_href' => __( 'Link href' ),
            //     ) ),
            // Field::make( 'file', 'brand_video_file', __( 'Load video' ) )
            //     ->set_type( array( 'video' ) )
            //     ->set_conditional_logic( array(
            //         array(
            //             'field'   => 'brand_video_type',
            //             'value'   => 'file',
            //             'compare' => '=',
            //         )
            //     ) ),
            // Field::make( 'text', 'brand_video_link', __( 'Link href' ) )
            //     ->set_conditional_logic( array(
            //         array(
            //             'field'   => 'brand_video_type',
            //             'value'   => 'link_href',
            //             'compare' => '=',
            //         )
            //     ) ),    
        ) );
}