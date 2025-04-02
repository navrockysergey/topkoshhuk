<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package baza
 */

// Scripts and css

function baza_dev_scripts_and_styles() {

    // JS

	wp_enqueue_script( 'baza-owl-carousel-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/owl.carousel.min.js', array('jquery'), false);
	wp_enqueue_script( 'baza-inputmask-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/jquery.inputmask.min.js', array('jquery'), false);
    wp_enqueue_script( 'baza-woo-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/woo.js', array('jquery'), false);
	wp_enqueue_script( 'baza-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/jq.js', array('jquery'), false);
    wp_enqueue_script( 'baza-show-more', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/show-more.js', array('jquery'), null, true); 
    wp_localize_script( 'baza-show-more', 'showMoreVars', array('readMoreText' => __('Read more', 'woocommerce'))); 

    // CSS

    //wp_enqueue_style( 'baza-aos', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/aos.css', array(), false );
	wp_enqueue_style( 'baza-owl-carousel', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/owl.carousel.min.css', array(), false );
	wp_enqueue_style( 'baza-photoswipe', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/photoswipe.css', array(), false );
    wp_enqueue_style( 'baza-woo-styles', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/woo.css', array(), false );
	wp_enqueue_style( 'baza-styles', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/style.css', array(), false );
}

add_action( 'wp_enqueue_scripts', 'baza_dev_scripts_and_styles' , 999 );

// Admin css

function my_custom_admin_styles() {
    wp_enqueue_style( 'baza-admin-styles', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/css/admin.css', array(), false );
}
add_action('admin_enqueue_scripts', 'my_custom_admin_styles');

 // Remove styles

function baza_dev_dequeue_styles() {
    wp_dequeue_style( 'wooac-frontend' );
    wp_dequeue_style( 'contact-form-7' );
    wp_dequeue_style( 'trp-language-switcher-style' );
    wp_dequeue_style( 'wqpmb-style' );
    wp_dequeue_style( 'woocommerce-general' );
    wp_deregister_style( 'woocommerce-general' );
    wp_dequeue_style( 'wpc-filter-everything' );
    wp_deregister_style('wpc-filter-everything');
    wp_dequeue_style( 'woocommerce-smallscreen' );
    wp_deregister_style('wqpmb_internal');
}
add_action( 'wp_enqueue_scripts', 'baza_dev_dequeue_styles', 9999999 );

// Remove styles by site URL

function remove_style_by_site_url( $src ) {

    $select2_css = get_site_url() . '/wp-content/plugins/woocommerce/assets/css/select2.css';
    if ( strpos( $src, $select2_css ) !== false ) {
        return '';
    }
    
    return $src;
}

add_filter( 'style_loader_src', 'remove_style_by_site_url', 10, 1 );

// Allow SVG uploads

function allow_svg_uploads($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

// favicon

function add_svg_favicon() {
    $favicon_url = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/images/favicon.png';
    echo '<link rel="icon" href="' . $favicon_url . '" type="image/svg+xml" />';
}
add_action('wp_head', 'add_svg_favicon');

// Sanitize SVG content

function sanitize_svg($svg_content) {
    $svg_content = preg_replace('/<script.*?>.*?<\/script>/is', '', $svg_content);
    $svg_content = preg_replace('/<style.*?>.*?<\/style>/is', '', $svg_content);
    $svg_content = preg_replace('/\s+xmlns=["\'][^"\']*["\']/', '', $svg_content);
    return $svg_content;
}

// remove jQuery migrate

add_action('wp_default_scripts', function ($scripts) {
    if (!empty($scripts->registered['jquery'])) {
        $scripts->registered['jquery']->deps = array_diff($scripts->registered['jquery']->deps, ['jquery-migrate']);
    }
});

remove_action('wp_head', 'wp_generator');

// Shortcodes

function current_year_shortcode() {
    return date('Y');
}
add_shortcode('Y', 'current_year_shortcode');

// Photoswipe

function generate_photoswipe_lightbox_script($gallery_selector, $item_selector) {
    ob_start();
    ?>
    <script type="module">
        import PhotoSwipeLightbox from '<?php echo esc_url(get_stylesheet_directory_uri()) ?>/assets/js/photoswipe-lightbox.esm.min.js';
        const lightbox = new PhotoSwipeLightbox({
            gallerySelector: '<?php echo esc_js($gallery_selector); ?>',
            arrowPrevSVG: '',
            arrowNextSVG: '',
            childSelector: '<?php echo esc_js($item_selector); ?>',
            escKey: false,
            pswpModule: () => import('<?php echo esc_url(get_stylesheet_directory_uri()) ?>/assets/js/photoswipe.esm.min.js')
        });
        lightbox.init();
    </script>
    <?php
    return ob_get_clean();
}

function get_custom_excerpt( $post_id, $excerpt_length = 200 ) {
    $post = get_post( $post_id );

    if ( ! empty( $post->post_excerpt ) ) {
        return $post->post_excerpt;
    }

    $content = strip_tags( strip_shortcodes( $post->post_content ) );
    $content = mb_substr( $content, 0, $excerpt_length );
    $content = mb_substr( $content, 0, mb_strrpos( $content, ' ') );
    $content .= '...';

    return $content;
}
add_filter( 'get_custom_excerpt', 'get_custom_excerpt', 10 );
