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

    Container::make( 'post_meta', __('Product video') )
        ->where( 'post_type', '=', 'product' )
        ->add_fields( array(
            Field::make( 'radio', 'product_video_preview_type', __('Set banner image') )
                ->set_width( 33 )
                ->add_options( array(
                    'url'  => __( 'By url' ),
                    'file' => __( 'Load file' ),
                ) ),
            Field::make( 'text', 'product_video_preview_url', __( 'Video url' ) )
                ->set_width( 66 )
                ->set_conditional_logic( array(
                    array(
                        'field'   => 'product_video_preview_type',
                        'value'   => 'url',
                        'compare' => '=',
                    ),
                ) ),
            Field::make( 'file', 'product_video_preview_file', __( 'Load video' ) )
                ->set_width( 66 )
                ->set_type( 'video' )
                ->set_conditional_logic( array(
                    array(
                        'field'   => 'product_video_preview_type',
                        'value'   => 'file',
                        'compare' => '=',
                    ),
                ) )
        ) );    
}