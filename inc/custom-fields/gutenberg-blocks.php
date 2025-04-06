<?php
use Carbon_Fields\Block;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'custom_posts_gutenberg_blocks' );

function custom_posts_gutenberg_blocks() {
    $def_per_page  = get_option( 'posts_per_page' );
    $home_url      = home_url();
    $shop_page     = get_option( 'woocommerce_shop_page_id' );
    $blog_page     = get_option( 'page_for_posts' );
    $shop_page_url = ! is_null( $shop_page ) && ! empty( $shop_page ) ? get_the_permalink( $shop_page ) : $home_url;
    $blog_page_url = ! is_null( $blog_page ) && ! empty( $blog_page ) ? get_the_permalink( $blog_page ) : $home_url;

    // ==== Main top Variative
    Block::make( 'main_top_variative',  __( 'Main top Variative' ) )
        ->add_fields( array (
            Field::make( 'separator', 'main_top_variative_sep', __( 'Main top Variative' ) ),
            Field::make( 'radio', 'main_top_heading_type', __( 'Heading type' ) )
                ->set_options( array(
                    'text'  => __( 'Text' ),
                    'media' => __( 'Media' ),
                ) ),
            Field::make( 'text', 'main_top_heading_text', __( 'Hending text' ) )
                ->set_conditional_logic( array(
                    array(
                        'field' => 'main_top_heading_type',
                        'value' => 'text',
                        'compare' => '=',
                    )
                ) ),
            Field::make( 'file', 'main_top_heading_media', __( 'Hending media' ) )
                ->set_type( 
                    array( 'video', 'image' )
                )
                ->set_conditional_logic( array(
                    array(
                        'field' => 'main_top_heading_type',
                        'value' => 'media',
                        'compare' => '=',
                    )
                ) ),
            Field::make( 'textarea', 'main_bottom_text', __( 'Bootom ( first ) text' ) ),
            Field::make( 'textarea', 'main_bottom_second_text', __( 'Bootom ( second ) text' ) ),
            Field::make( 'text', 'main_bottom_button_text', __( 'Button text' ) )
                ->set_width( 50 ),
            Field::make( 'text', 'main_bottom_button_link', __( 'Button link' ) )
                ->set_default_value( $shop_page_url )        
                ->set_width( 50 ),
        ) )
        ->set_inner_blocks( true )
        ->set_description( __( 'This a block for inner in Hero section page' ) )
        ->set_icon( 'cover-image' )
        ->set_category( 'top-koshik', __( 'Top Koshik' ), 'smiley' )
        ->set_mode( 'both' )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );
    
            include_once __THEME_DIR__ . '/template-parts/sections/hero-section.php';
        } );

    // ==== Bestsellers carusel
    Block::make( 'bestsellers_carusel', __( 'Bestsellers carusel' ) )
        ->add_fields( array(
            Field::make( 'separator', 'bestsellers_carusel_sep', __( 'Bestsellers carusel' ) ),
            Field::make( 'text', 'bestsellers_section_title', __( 'Section title' ) )
                ->set_default_value( 'НАЙКРАЩІ ПРОПОЗИЦІЇ' ),
            Field::make( 'text', 'bestseller_per_page', __( 'Products count' ) )
                ->set_default_value( $def_per_page )
                ->set_attribute( 'type', 'number' ),
         ) )
        ->set_category( 'top-koshik' )
        ->set_mode( 'both' )
        ->set_icon( 'slides' )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );

            include_once __THEME_DIR__ . '/template-parts/sections/bestsellers-slider.php';
        } );

    // ==== Simple products previews
    Block::make( 'simple_products_previews', __( 'Simple products previews' ) )
        ->add_fields( array(
            Field::make( 'separator', 'simple_previews_sep', __('Simple products previews') ),
            Field::make( 'text', 'simple_previews_title', __( 'Title' ) ),
            Field::make( 'text', 'simple_previews_products_count', __( 'Products count' ) )
                ->set_default_value( $def_per_page )
                ->set_attribute( 'type', 'number' ),
            Field::make( 'set', 'simple_previews_tags', __( 'Tags' ) )
                ->add_options( array(
                    ''    => __( 'All' ),
                    'hit' => __( 'HIT' ),
                    'new' => __( 'NEW' ),
                ) ),
            Field::make( 'text', 'simple_previews_buttom_text', _( 'Buttom text' ) )
                ->set_default_value( 'Перейти до каталогу' )
                ->set_width( 50 ),
            Field::make( 'text', 'simple_previews_button_lnk', _( 'Button URL' ) )
                ->set_default_value( $shop_page_url )  
                ->set_width( 50 ),
        ) )
        ->set_category( 'top-koshik' )
        ->set_mode( 'both' )
        ->set_icon( 'grid-view' )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );

            include_once __THEME_DIR__ . '/template-parts/sections/simple-products-preview.php';
        } );

    // ==== Categories colection
    Block::make( 'categories_colection', __( 'Categories colection' ) )
        ->add_fields( array(
            Field::make( 'separator', 'categories_colection_sep', __( 'Categories colection' ) ),
        ) )
        ->set_category( 'top-koshik' )
        ->set_mode( 'both' )
        ->set_icon( 'images-alt2' )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            include_once __THEME_DIR__ . '/template-parts/blocks/block-category.php';
        } );

    // ==== Advantages
    Block::make( 'advantages_colection', __( 'Advantages colection' ) )
        ->add_fields( array(
            Field::make( 'separator', 'advantages_colection_sep', __( 'Advantages colection' ) ),
        ) )
        ->set_category( 'top-koshik' )
        ->set_mode( 'both' )
        ->set_icon( 'saved' )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            include_once __THEME_DIR__ . '/template-parts/sections/advantages-section.php';
        } );

    // ==== Brands video + products block
    Block::make( 'brands_products_preview', __( 'Brands && products preview block' ) )
        ->add_fields( array(
            Field::make( 'separator', 'brans_media_products_sep', __( 'Brands && products preview block' ) ),
            Field::make( 'association', 'brans_media_products_terms', __( 'Brands' ) )
            ->set_types( array(
                array(
                    'type'     => 'term',
                    'taxonomy' => 'product_brand',
                )
            ) ),
            Field::make( 'text', 'brans_media_products_per_page', __( 'Products count in sungle brand' ) )
                ->set_default_value( '2' )
                ->set_attribute( 'type', 'number' ),
        ) )
        ->set_category( 'top-koshik' )
        ->set_mode( 'both' )
        ->set_icon( 'video-alt3' )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );
            include_once __THEME_DIR__ . '/template-parts/sections/brands-media-products.php';
        } );

    // Latest articles
    Block::make( 'l_articles', __( 'Latest articles' ) )
        ->add_fields( array(
            Field::make( 'separator', 'l_articles_sep', __( 'Latest articles' ) ),
            Field::make( 'text', 'latest_articles_per_page', __( 'Articles per page' ) )
                ->set_default_value( $def_per_page )
                ->set_attribute( 'type', 'number' ),
            Field::make( 'text', 'latest_articles_section_title', __( 'Title' ) )
                ->set_default_value( 'НОВИНИ З БЛОГУ' ),
            Field::make( 'text', 'latest_article_section_button_text', __( 'Button text' ) )
                ->set_default_value( 'Більше новин з блогу' )
                ->set_width( 50 ),
            Field::make( 'text', 'latest_article_section_button_href', __( 'Button href' ) )
                ->set_default_value( $blog_page_url )
                ->set_width( 50 ),
        ) )
        ->set_category( 'top-koshik' )
        ->set_mode( 'both' )
        ->set_icon( 'admin-post' )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );
            include_once __THEME_DIR__ . '/template-parts/sections/latest-articles-section.php';
        } );

    // Text
    Block::make( 'seo_text', __( 'SEO Text' ) )
        ->add_fields( array(
            Field::make( 'text', 'text_row', __( 'Visible rows' ) )->set_width( 20 ),
            Field::make( 'rich_text', 'seo_text', __( 'SEO Text' ) )->set_width( 100 ),
        ) )
        ->set_category( 'top-koshik' )
        ->set_mode( 'both' )
        ->set_icon( 'admin-post' )
        ->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
            extract( $fields );
            include_once __THEME_DIR__ . '/template-parts/sections/text-section.php';
        } );
}
