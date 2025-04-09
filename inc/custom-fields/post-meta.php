<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
add_action( 'carbon_fields_register_fields', 'custom_posts_meta_data' );

function custom_posts_meta_data() {
    $hourses_opt = [];

    for ( $i = 0; $i <= 24 ; ++$i ) {
        $hourses_opt[$i] = str_pad ($i, 2, '0', STR_PAD_LEFT ) . ':00';
    }

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
        ->add_fields( array(
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
        ) );

    Container::make( 'post_meta', __( 'Details' ) )
        ->where( 'post_type', '=', 'branch' )
        ->add_fields( array(
            Field::make( 'text', 'branch_addres_city', __( 'City' ) )
                ->set_width( 50 ),
            Field::make( 'text', 'branch_addres_region', __( 'Region' ) )
                ->set_width( 50 ),
            Field::make( 'textarea', 'branch_addres_string', __( 'Addres' ) ),
            Field::make( 'text', 'branch_geo_latitude', __( 'latitude' ) )
                ->set_width( 50 ),
            Field::make( 'text', 'branch_geo_longitude', __( 'longitude' ) )
                ->set_width( 50 ),
            Field::make( 'text', 'branch_shedule_before_string', __( 'Shedule notice' ) )
                ->set_width( 33 ),
            Field::make( 'select', 'branch_time_work_start', __( 'Work start time' ) )
                ->set_width( 33 )
                ->add_options( $hourses_opt )
                ->set_default_value( '9' ),
            Field::make( 'select', 'branch_time_work_end', __( 'Work end time' ) )
                ->set_width( 33 )
                ->add_options( $hourses_opt )
                ->set_default_value( '21' ),
            Field::make( 'complex', 'branch_phones', __( 'Phones' ) )
                ->add_fields( array(
                    Field::make( 'text', 'contact_number', __( 'Phone number' ) ),
                ) )
                ->set_collapsed( true )
                ->set_header_template( '
                    <% if (contact_number) { %>
                        <%- contact_number %>
                    <% } %>
                ' ) 
        ) );
}