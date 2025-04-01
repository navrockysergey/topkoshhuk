<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );

global $post;

$product_id = get_the_ID();
$product = wc_get_product($product_id);

$product_image_url = wp_get_attachment_url($product->get_image_id());

$primary_category_id = get_post_meta($product_id, '_yoast_wpseo_primary_product_cat', true);

if (!$primary_category_id) {
    $product_categories = get_the_terms($product_id, 'product_cat');
    if ($product_categories && !is_wp_error($product_categories)) {
        $primary_category_id = $product_categories[0]->term_id;
    }
}

if ($primary_category_id) {
    $primary_category = get_term_by('id', $primary_category_id, 'product_cat');
    
    if ($primary_category && !is_wp_error($primary_category)) {
        $category_name = $primary_category->name;
        $category_url = get_term_link($primary_category);

        if ($primary_category->parent > 0) {
            $parent_category = get_term_by('id', $primary_category->parent, 'product_cat');
            
            if ($parent_category && !is_wp_error($parent_category)) {
                $parent_category_name = $parent_category->name;
                $parent_category_url = get_term_link($parent_category);
            }
        }
    }
}

$product_type = $product ? $product->get_type() : '';

$original_post_id = function_exists( 'icl_object_id' ) ? icl_object_id( $product_id, 'product', true, 'uk' ) : $product_id; // WPML original post id
$current_language = apply_filters('wpml_current_language', NULL); // WPML current language

$calories      = get_post_meta($original_post_id, '_calories', true);
$protein       = get_post_meta($original_post_id, '_protein', true);
$fat           = get_post_meta($original_post_id, '_fat', true);
$carbohydrates = get_post_meta($original_post_id, '_carbohydrates', true);

$translations = array(
    'ingredients_title' => array(
        'ru' => __('Ингредиенты', 'foodmiles'),
        'uk' => __('Інгредієнти', 'foodmiles'),
    ),
    'nutritional_title' => array(
        'ru' => __('Пищевая ценность', 'foodmiles'),
        'uk' => __('Поживна цінність', 'foodmiles'),
    ),
    'calories' => array(
        'ru' => __('Калории (ккал)', 'foodmiles'),
        'uk' => __('Калорії (kcal)', 'foodmiles'),
    ),
    'protein' => array(
        'ru' => __('Белки (г/100г)', 'foodmiles'),
        'uk' => __('Білки (г/100г) год.', 'foodmiles'),
    ),
    'fat' => array(
        'ru' => __('Жиры (г/100г)', 'foodmiles'),
        'uk' => __('Жири (г/100г)', 'foodmiles'),
    ),
    'carbohydrates' => array(
        'ru' => __('Углеводы (г/100г)', 'foodmiles'),
        'uk' => __('Вуглеводи (г/100г)', 'foodmiles'),
    ),
);

$availability = $product->get_availability();

$prev_product = get_previous_post(true, '', 'product_cat');
$next_product = get_next_post(true, '', 'product_cat');

if (!$prev_product) {
    $prev_products = get_posts([
        'posts_per_page' => 1,
        'post_type' => 'product',
        'orderby' => 'date',
        'order' => 'DESC',
        'post__not_in' => [$product_id],
        'tax_query' => [
            [
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => wp_get_post_terms($product_id, 'product_cat', ['fields' => 'ids']),
                'operator' => 'IN',
            ]
        ]
    ]);

    if (!empty($prev_products)) {
        $prev_product = $prev_products[0];
    }
}

if (!$next_product) {
    $next_products = get_posts([
        'posts_per_page' => 1,
        'post_type' => 'product',
        'orderby' => 'date',
        'order' => 'ASC',
        'post__not_in' => [$product_id],
        'tax_query' => [
            [
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => wp_get_post_terms($product_id, 'product_cat', ['fields' => 'ids']),
                'operator' => 'IN',
            ]
        ]
    ]);

    if (!empty($next_products)) {
        $next_product = $next_products[0];
    }
}


?>

<main id="main-content" class="site-main product product-type-<?php echo esc_attr($product_type); ?>" <?php wc_product_class('', get_the_ID()); ?>>

    <?php get_template_part('template-parts/section', 'category'); ?>

    <div class="container breadcrumb-container">
        <?php
            if ( function_exists('yoast_breadcrumb') ) {
                yoast_breadcrumb( '<div id="breadcrumbs">','</div>' );
            }
        ?>
    </div>

    <?php if ($product->get_gallery_image_ids()) : ?>
        <div class="product-gallery">
            <a class="product-back" href="<?php echo $category_url; ?>"></a>

            <div class="product-navigation">
                <?php 
                    if ( $prev_product ) : 
                    $prev_product_id = $prev_product->ID;
                ?>
                    <a class="prev-product" href="<?php echo get_permalink($prev_product_id); ?>" title="<?php echo get_the_title($prev_product_id); ?>"></a>
                <?php endif; ?>

                <?php 
                    if ( $next_product ) : 
                        $next_product_id = $next_product->ID;
                ?>
                    <a class="next-product" href="<?php echo get_permalink($next_product_id); ?>" title="<?php echo get_the_title($next_product_id); ?>"></a>
                <?php endif; ?>
            </div>

            <div class="owl-carousel" id="product-gallery-carousel">
                <?php 
                $attachment_ids = $product->get_gallery_image_ids();
                foreach ($attachment_ids as $attachment_id) : 
                    $image_url = wp_get_attachment_url($attachment_id);
                    $image_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
                    $image = wp_get_attachment_image_src($attachment_id, 'full');
                ?>
                    <div class="item">
                        <img src="<?php echo esc_url($image[0]); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="container product product-info-container">

        <div class="product-info">

            <h1 class="product-title"><?php echo get_the_title($product_id); ?></h1>
            
            <?php if ( $product->get_description() ) : ?>
                <div class="product-description">
                    <?php echo apply_filters('the_content', get_post_field('post_content', $product_id)); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="product-side">

            <?php 
                $weight = 0;

                if ($product->is_type('variable')) {
                    $variations = $product->get_available_variations();

                    foreach ($variations as $variation) {
                        if (!empty($variation['weight']) && $variation['weight'] > 0) {
                            $weight = $variation['weight'];
                            break;
                        }
                    }
                } else {
                    if ($product->get_weight()) {
                        $weight = $product->get_weight();
                    }
                }

                if ($weight > 0) : ?>
                <div class="product-weight-wrapper">
                    <span class="product-weight-label"><?php echo __('Вага порції'); ?></span> 
                    <span class="product-variation-name"></span> - 
                    <span class="product-weight"><?php echo $weight; ?></span> г.
                </div>
            <?php endif; ?>

            <?php if ( $product->is_in_stock() ) : ?>

                <div class="product-price">
                    <?php echo $product->get_price_html(); ?>
                </div>

                <?php if ($product->get_sku()) : ?>
                    <div class="product-sku-wrapper">
                        <p><?php echo __('SKU', 'woocommerce'); ?>: <span class="product-sku"><?php echo $product->get_sku(); ?></span></p>
                    </div>
                <?php endif; ?>

                <?php 
                    if ( $product->is_purchasable() ) {
                        woocommerce_template_single_add_to_cart();
                    }
                ?>

            <?php else: ?>

                <div class="product-price">
                    <?php echo $product->get_price_html(); ?>
                </div>

                <?php if ($product->get_sku()) : ?>
                    <div class="product-sku-wrapper">
                        <p><?php echo __('SKU', 'woocommerce'); ?>: <span class="product-sku"><?php echo $product->get_sku(); ?></span></p>
                    </div>
                <?php endif; ?>

                <p class="stock out-of-stock"><?php echo __('Out of stock', 'woocommerce'); ?></p>

            <?php endif; ?>
        </div>

    </div>

    <div>
        <?php 
            //get_template_part('template-parts/section', 'related-products');
            get_template_part('template-parts/section', 'upsell-products');
            get_template_part('template-parts/section', 'popular-products'); 
            get_template_part('template-parts/section', 'map-delivery'); 
        ?>
    </div>

</main>

<script type="text/javascript">
    jQuery(function($) {
        $('.single_add_to_cart_button').attr('data-product_image', '<?php echo esc_url($product_image_url); ?>');
    });
</script>

<?php get_footer('shop'); ?>