<?php
/**
 * WooCommerce Product Image Template
 * This template is used to display the product images and video on the product page.
 */

defined( 'ABSPATH' ) || exit;

global $product;

$youtube_url = carbon_get_post_meta($product->get_id(), 'product_video');
$video_id = get_youtube_id_from_url($youtube_url);

$attachment_ids = $product->get_gallery_image_ids();
$main_image_id = get_post_thumbnail_id($product->get_id());
?>

<div class="product-media">
    <?php do_action( 'baza_product_before_images' ); ?>

    <a class="button button-secondary close-media-popup">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.8553 7.55871C18.0506 7.36345 18.0506 7.04686 17.8553 6.8516L17.1482 6.14449C16.953 5.94923 16.6364 5.94923 16.4411 6.14449L11.9999 10.5857L7.55872 6.14449C7.36346 5.94923 7.04688 5.94923 6.85162 6.14449L6.14451 6.8516C5.94925 7.04686 5.94925 7.36345 6.14451 7.55871L10.5857 11.9999L6.14449 16.4411C5.94923 16.6364 5.94923 16.953 6.14449 17.1482L6.8516 17.8553C7.04686 18.0506 7.36344 18.0506 7.55871 17.8553L11.9999 13.4141L16.4411 17.8553C16.6364 18.0506 16.953 18.0506 17.1482 17.8553L17.8553 17.1482C18.0506 16.953 18.0506 16.6364 17.8553 16.4411L13.4141 11.9999L17.8553 7.55871Z" fill="white"/>
        </svg>
    </a>

    <div class="product-gallery-wrapper">
        <div class="product-gallery owl-carousel" id="product-gallery">
            <?php
                echo '<div class="product-gallery-item" data-image-id="0">';
                echo wp_get_attachment_image($main_image_id, 'full');
                echo '</div>';

                $index = 1;
                foreach ($attachment_ids as $attachment_id) :
                    echo '<div class="product-gallery-item" data-image-id="' . $index . '">';
                    echo wp_get_attachment_image($attachment_id, 'full');
                    echo '</div>';
                    $index++;
                endforeach;

                if (!empty($video_id)) : 
                    $video_iframe = '<div class="product-gallery-item product-gallery-video" data-image-id="9999">';
                    $video_iframe .= '<iframe id="youtube-iframe" width="560" height="315" src="https://www.youtube.com/embed/' . esc_attr($video_id) . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>';
                    $video_iframe .= '</div>';
                    echo $video_iframe;
                endif;
            ?>
        </div>
    </div>

    <div class="product-thumbnails-wrapper">
        <div class="product-thumbnails">
            <?php
                echo '<div class="product-thumbnail-item active current" data-thumbnail-id="0">';
                echo wp_get_attachment_image($main_image_id, 'thumbnail');
                echo '</div>';

                $index = 1;
                foreach ($attachment_ids as $attachment_id) :
                    echo '<div class="product-thumbnail-item" data-thumbnail-id="' . $index . '">';
                    echo wp_get_attachment_image($attachment_id, 'thumbnail');
                    echo '</div>';
                    $index++;
                endforeach;

                if (!empty($video_id)) : 
                    $video_iframe = '
                    <div class="product-thumbnail-item product-thumbnail-video" data-thumbnail-id="9999">
                        <svg width="48" height="34" viewBox="0 0 48 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M42.7533 1.48509C44.8185 2.02725 46.445 3.62469 46.997 5.653C48 9.32943 48 17 48 17C48 17 48 24.6706 46.997 28.347C46.445 30.3753 44.8185 31.9727 42.7533 32.5149C39.01 33.5 24 33.5 24 33.5C24 33.5 8.98999 33.5 5.24671 32.5149C3.18152 31.9727 1.55504 30.3753 1.00302 28.347C0 24.6706 0 17 0 17C0 17 0 9.32943 1.00302 5.653C1.55504 3.62469 3.18152 2.02725 5.24671 1.48509C8.98999 0.5 24 0.5 24 0.5C24 0.5 39.01 0.5 42.7533 1.48509ZM31.6363 17.0001L19.0909 23.9642V10.0356L31.6363 17.0001Z" fill="#EF3E33"/>
                        </svg>
                    </div>';
                    echo $video_iframe;
                endif;
            ?>
        </div>
    </div>

    <?php do_action( 'baza_product_after_images' ); ?>
</div>