<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'theme_options_fields' );

function theme_options_fields(){
    // $currensy_simbol = get_option('woocommerce_currency');

    Container::make( 'theme_options', __( 'Global vars' ) )
        ->add_fields( array(
            Field::make( 'separator', 'adwsep',__( 'Advantages' ) ),
            Field::make( 'complex', 'advantages_list', __( 'Advantages list' ) )
                ->set_collapsed( true )
                ->add_fields( array(
                    Field::make( 'radio', 'adv_icon_type', __( 'Icon type' ) )
                        ->set_width( 25 )
                        ->add_options( array(
                            'image' => __( 'Image' ),
                            'code'  => __( 'Code' ),
                        ) ),
                    Field::make( 'image', 'adv_icon_image', __( 'Icon image' ) )
                        ->set_width( 75 )
                        ->set_value_type( 'url' )
                        ->set_conditional_logic( array(
                            array(
                                'field'   => 'adv_icon_type',
                                'value'   => 'image',
                                'compare' => '=',
                            )
                        ) ),
                    Field::make( 'textarea', 'adv_icon_code', __( 'Icon code' ) )
                        ->set_width( 75 )
                        ->set_conditional_logic( array(
                            array(
                                'field'   => 'adv_icon_type',
                                'value'   => 'code',
                                'compare' => '=',
                            )
                        ) ),
                    Field::make( 'text', 'adw_title', __( 'Title' ) )
                        ->set_width( 50 ),
                    Field::make( 'rich_text', 'adw_desc_text', __( 'Description text' ) )
                        ->set_width( 50 ),
                ) )
                ->set_header_template( '
                    <% if (adw_title) { %>
                        <%- adw_title %>
                    <% } %>
                ' ),
            ) );
};