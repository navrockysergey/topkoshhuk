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
    wp_enqueue_script( 'baza-notiny-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/notiny.min.js', array('jquery'), false);
	wp_enqueue_script( 'baza-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/jq.js', array('jquery'), false);

    if (is_page(195)) {
        wp_enqueue_script( 'baza-map-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/map.js', array('jquery'), false);
    }

    if (is_product()) {
        wp_enqueue_script( 'baza-product-gallery-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/product-gallery.js', array('jquery'), false);
        wp_enqueue_script( 'baza-qty-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/qty.js', array('jquery'), false);

         wp_localize_script( 'baza-qty-js', 'dataObj', [
            'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
            'cartUpdated'  => __('Cart updated.', 'woocommerce'),
            'errorMessage' => __('Something went wrong.', 'woocommerce'),
        ] );
    }

    if (is_checkout()) {
        wp_enqueue_script('baza-checkout-js', trailingslashit(get_stylesheet_directory_uri()) . 'assets/js/checkout.js', array('jquery'), false);
        wp_enqueue_script( 'baza-nova-poshta-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/nova-poshta.js', array('jquery'), false);
    }

    if ( is_cart() || is_checkout() ) {
        wp_enqueue_script( 'baza-qty-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/cart-qty.js', array('jquery'), false);

        wp_localize_script( 'baza-qty-js', 'dataObj', [
            'ajaxUrl' => admin_url( 'admin-ajax.php' ),
            'nonce' => wp_create_nonce( 'woocommerce-cart' ),
        ] );
    }

    if (!is_user_logged_in()) {
 
        wp_register_script('baza-user-js', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/user.js', array('jquery'), false, true);
        wp_localize_script('baza-user-js', 'login_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'login_process_text' => __('Авторизація...'),
            'register_process_text' => __('Реєстрація...'),
            'error_text' => __('Сталася помилка. Будь ласка, спробуйте ще раз.'),
            'success_text' => __('Успішна авторизація! Перезавантаження сторінки...')
        ));
        
        wp_enqueue_script('baza-user-js');
    }

    // CSS

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
    wp_deregister_style( 'wqpmb_internal' );
    wp_dequeue_style( 'woocommerce-layout' );
    wp_deregister_style( 'woocommerce-layout' );
    wp_dequeue_style( 'filter-everything-inline' );
    wp_deregister_style( 'filter-everything-inline' );
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

/**
 * Add all favicon and app icon related tags to the site header
 */
function add_complete_favicons() {
    $img_path = trailingslashit(get_stylesheet_directory_uri()) . 'assets/images/';
    
    // SVG favicon (modern browsers)
    echo '<link rel="icon" href="' . $img_path . 'favicon.svg" type="image/svg+xml" />' . "\n";
    
    // Traditional favicon
    echo '<link rel="shortcut icon" href="' . $img_path . 'favicon.ico" />' . "\n";
    
    // Various sizes for different devices
    echo '<link rel="icon" type="image/png" sizes="96x96" href="' . $img_path . 'favicon-96x96.png" />' . "\n";
    
    // Apple Touch Icons
    echo '<link rel="apple-touch-icon" href="' . $img_path . 'apple-touch-icon.png" />' . "\n";
    
    // Web App Manifest for PWA
    echo '<link rel="manifest" href="' . $img_path . 'site.webmanifest" />' . "\n";
}
add_action('wp_head', 'add_complete_favicons');

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

remove_filter( 'the_content', 'wpautop' );
add_filter( 'wpcf7_autop_or_not', '__return_false' );

function category_container_before() {
    register_sidebar(
        array(
            'name'          => 'Category Container Before',
            'id'            => 'category_container_before',
            'before_widget' => '<div class="item">',
            'after_widget'  => '</div>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        )
    );
}
add_action('widgets_init', 'category_container_before');

// ====================================================================================================

add_action( 'init' , 'create_posts_types' );
function create_posts_types() {
    register_post_type( 'vacancie', [
        'label'  => null,
        'labels' => [
            'name'               => __( 'Vacancies' ),
            'singular_name'      => __( 'Vacancies' ),
            'add_new'            => __( 'Add Vacancie' ),
            'add_new_item'       => __( 'Add Vacancie' ),
            'edit_item'          => __( 'Edit Vacancie' ),
            'new_item'           => __( 'Add Vacancie' ),
            'view_item'          => __( 'View Vacancie' ),
            'search_items'       => __( 'Add Vacancies' ),
            'not_found'          => __( 'Not found' ),
            'not_found_in_trash' => __( 'Not found' ),
            'menu_name'          => __( 'Vacancies' ),
        ],
        'description'         => '',
        'public'              => true,
        'has_archive'         => false,
        'publicly_queryable'  => true,
        'show_in_menu'        => true,
        'show_in_rest'        => false,
        'menu_icon'           => 'dashicons-groups',
        'hierarchical'        => false,
        'supports'            => [ 'title', 'editor', 'excerpt' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );

    register_post_type( 'branch', [
        'label'  => null,
        'labels' => [
            'name'               => __( 'Branches' ),
            'singular_name'      => __( 'Branche' ),
            'add_new'            => __( 'Add Branche' ),
            'add_new_item'       => __( 'Add Branche' ),
            'edit_item'          => __( 'Edit Branche' ),
            'new_item'           => __( 'Add Branche' ),
            'view_item'          => __( 'View Branche' ),
            'search_items'       => __( 'Add Branches' ),
            'not_found'          => __( 'Not found' ),
            'not_found_in_trash' => __( 'Not found' ),
            'menu_name'          => __( 'Branches' ),
        ],
        'description'         => '',
        'public'              => true,
        'has_archive'         => false,
        'publicly_queryable'  => false,
        'show_in_menu'        => true,
        'show_in_rest'        => false,
        'menu_icon'           => 'dashicons-admin-multisite',
        'hierarchical'        => false,
        'supports'            => [ 'title', 'editor', 'excerpt', 'thumbnail' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );
}

add_action( 'init' , 'create_taxonomies' );
function create_taxonomies() {
    register_taxonomy( 'department', ['vacancie'], [
        'labels'                => [
                'name'              => 'Departments',
                'singular_name'     => 'Department',
                'search_items'      => 'Search Departments',
                'all_items'         => 'All Departments',
                'view_item '        => 'View Department',
                'edit_item'         => 'Edit Department',
                'update_item'       => 'Update Department',
                'add_new_item'      => 'Add New Department',
                'new_item_name'     => 'New Department Name',
                'menu_name'         => 'Departments',
                'back_to_items'     => '← Back to Department',
            ],
        'public'                => true,
        'hierarchical'          => true,
        'rewrite'               => true,
        'show_in_rest'          => true,
    ] );
}

add_filter( 'get_vacancies', 'get_vacancies' );
function get_vacancies( $category = false ) {
    $vacancies_args = [
        'post_type'   => 'vacancie',
        'post_status' => 'publish',
    ];

    if ( $category ) {
        $vacancies_args['tax_query'] = [
            'taxonomy' => 'department',
            'field'    => 'slug',
            'terms'    =>  $category,
        ];
    }

    $vacanсies = new WP_Query( $vacancies_args );

    wp_reset_postdata();

    return $vacanсies;
}

add_filter( 'get_stores', 'get_stores' );
function get_stores( $region = false ) {
    $stores_args = [
        'post_type'   => 'branch',
        'post_status' => 'publish',
        'orderby' => 'menu_order',
        'order' => 'DESC',
        'posts_per_page' => -1,
    ];

    if ( $region ) {
        $stores_args['meta_query'] = [
            'key'      => 'branch_addres_region',
            'compare'  => '=',
            'value'    =>  $region,
        ];
    }

    $result = new WP_Query( $stores_args );

    wp_reset_postdata();

    return $result;
}

add_filter( 'wpcf7_form_elements', 'imp_wpcf7_form_elements' );
function imp_wpcf7_form_elements( $content ) {
    $str_pos = strpos( $content, 'name="your-file"' );
    if ( $str_pos !== false ) {
        $content = substr_replace( $content, 'title="' . __('Додайте файл резюме') . '"', $str_pos, 0 );
    }
    return $content;
}

add_filter('block_categories_all', function($categories, $post) {
    $exists = false;
    foreach ($categories as $key => $category) {
        if ($category['slug'] === 'top-koshik') {
            unset($categories[$key]);
            $exists = true;
            break;
        }
    }
    
    if ($exists) {
        array_unshift($categories, [
            'slug' => 'top-koshik',
            'title' => __('Top Koshik'),
            'icon' => 'smiley'
        ]);
    } else {
        array_unshift($categories, [
            'slug' => 'top-koshik',
            'title' => __('Top Koshik'),
            'icon' => 'smiley'
        ]);
    }
    
    return $categories;
}, 10, 2);

// Cusom color

function custom_gutenberg_colors() {
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('White'),
            'slug'  => 'section-light',
            'color' => '#ffffff',
        ),
        array(
            'name'  => __('Primary'),
            'slug'  => 'section-dark',
            'color' => '#EF3E33',
        ),
        array(
            'name'  => __('Black'),
            'slug'  => 'section-dark',
            'color' => '#020202',
        ),
    ));
    remove_theme_support('editor-font-sizes');
}
add_action('after_setup_theme', 'custom_gutenberg_colors');
