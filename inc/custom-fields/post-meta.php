<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
add_action( 'carbon_fields_register_fields', 'custom_posts_meta_data' );

function custom_posts_meta_data() {
    Container::make( 'post_meta', __( 'Badges' ) )
        ->where( 'post_type', '=', 'product' )
        ->set_context( 'side' )
        ->add_fields( array(
            Field::make( 'checkbox', 'product_badge_new', __( 'New' ) )
                    ->set_default_value( false ),
        ) );

    Container::make( 'post_meta', __( 'Product banner' ) )
        ->where( 'post_type', '=', 'product' )
        ->set_context( 'side' )
        ->add_fields( array(
            Field::make( 'image', 'product_banner', __( 'Set banner image' ) ),
        ) );
    
    Container::make( 'post_meta', __( 'Product video' ) )
        ->where( 'post_type', '=', 'product' )
        ->add_fields( array(
            Field::make( 'text', 'product_video', __( 'YouTube URL' ) ),
        ) );

    Container::make( 'post_meta', __( 'Details' ) )
        ->where( 'post_type', '=', 'vacancie' )
        ->add_fields(array(
            Field::make( 'text', 'vacancie_localization', __( 'Localization' ) ),
            Field::make( 'text', 'vacancie_workplace', __( 'Workplace' ) )
                ->set_width( 60 ),
            Field::make( 'text', 'vacancie_work_days_count', __('Work day count') )
                ->set_width( 40 )
                ->set_attribute( 'type', 'number' )
                ->set_default_value( 5 ),
            Field::make( 'checkbox', 'negotiated_salary', __('Договірна ЗП') )
                ->set_width( 33 ),
            Field::make( 'text', 'min_salary', __( 'Min salary' ) )
                ->set_width( 33 )
                ->set_attribute( 'type', 'number' )
                ->set_conditional_logic( array(
                    array(
                        'field'   => 'negotiated_salary',
                        'value'   => '',
                        'compare' => '=',
                    )
                ) ),
            Field::make( 'text', 'max_salary', __( 'Max salary' ) )
                ->set_width( 33 )
                ->set_attribute( 'type', 'number' )
                ->set_conditional_logic( array(
                    array(
                        'field'   => 'negotiated_salary',
                        'value'   => '',
                        'compare' => '=',
                    )
                ) )    
        ));
}