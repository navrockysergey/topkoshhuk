<?php
/**
 * baza Theme Customizer
 *
 * @package baza
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function baza_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'baza_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'baza_customize_partial_blogdescription',
			)
		);
	}

	// Add new section Site Info
    $wp_customize->add_section('site_info', array(
        'title'    => __('Site Info'),
        'priority' => 30,
    ));

    // Add new section Woo
    $wp_customize->add_section('woo', array(
        'title'    => __('Woo'),
        'priority' => 29,
    ));

    // Check minimum order amount
    $wp_customize->add_setting('min_order_amount', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('min_order_amount', array(
        'label'   => __('Minimum order amount'),
        'section' => 'woo',
        'type'    => 'text',
    ));

    // Add Coordinates
    $wp_customize->add_setting('coordinates', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('coordinates', array(
        'label'   => __('Coordinates'),
        'section' => 'site_info',
        'type'    => 'text',
    ));

	// Opening hours

	$wp_customize->add_setting('opening_hours', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('opening_hours', array(
        'label'   => __('Opening hours'),
        'section' => 'site_info',
        'type'    => 'textarea',
    ));

	// Add Phone setting and control
    $wp_customize->add_setting('phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('phone', array(
        'label'   => __('Phone'),
        'section' => 'site_info',
        'type'    => 'text',
    ));

    // Add Phone setting and control 2
    $wp_customize->add_setting('phone_2', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('phone_2', array(
        'label'   => __('Phone'),
        'section' => 'site_info',
        'type'    => 'text',
    ));

    // Add Email setting and control
    $wp_customize->add_setting('email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('email', array(
        'label'   => __('Email'),
        'section' => 'site_info',
        'type'    => 'email',
    ));

    // Facebook setting and control
    $wp_customize->add_setting('facebook', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('facebook', array(
        'label'   => __('Facebook'),
        'section' => 'site_info',
        'type'    => 'url',
    ));

    // Instagram setting and control
    $wp_customize->add_setting('instagram', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('instagram', array(
        'label'   => __('Instagram'),
        'section' => 'site_info',
        'type'    => 'url',
    ));

    // TikTok setting and control
    $wp_customize->add_setting('tiktok', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('tiktok', array(
        'label'   => __('TikTok'),
        'section' => 'site_info',
        'type'    => 'url',
    ));

    // YouTube setting and control
    $wp_customize->add_setting('youtube', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('youtube', array(
        'label'   => __('YouTube'),
        'section' => 'site_info',
        'type'    => 'url',
    ));

	// Add Copyright
	$wp_customize->add_setting('copyright', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ));

    $wp_customize->add_control('copyright', array(
        'label'   => __('Copyright'),
        'section' => 'site_info',
        'type'    => 'textarea',
    ));

}
add_action( 'customize_register', 'baza_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function baza_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function baza_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function baza_customize_preview_js() {
	wp_enqueue_script( 'baza-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), _S_VERSION, true );
}
add_action( 'customize_preview_init', 'baza_customize_preview_js' );
