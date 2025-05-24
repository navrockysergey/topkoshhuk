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

$total_media_count = 1 + count($attachment_ids) + (!empty($video_id) ? 1 : 0);
?>

<div class="product-media<?php if ($total_media_count == 1) : ?> product-media-one<?php endif; ?>">
    <?php do_action( 'baza_product_before_images' ); ?>

    <a class="button button-secondary close-media-popup">
        <i class="icon-close"></i>
    </a>

    <div class="product-gallery-wrapper">
        <div class="product-gallery owl-carousel" id="product-gallery">
            <?php
                
                echo '<div class="product-gallery-item" data-image-id="0">';
                
                if ($main_image_id) {
                    echo wp_get_attachment_image($main_image_id, 'large');
                } else {
                    echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.svg">';
                }

                echo '</div>';

                $index = 1;
                foreach ($attachment_ids as $attachment_id) :
                    echo '<div class="product-gallery-item" data-image-id="' . $index . '">';
                    echo wp_get_attachment_image($attachment_id, 'large');
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
    
    <?php if ($total_media_count > 1) : ?>
        <div class="product-thumbnails-wrapper">
            <div class="product-thumbnails">
                <?php
                    echo '<div class="product-thumbnail-item active current" data-thumbnail-id="0">';

                    if ($main_image_id) {
                        echo wp_get_attachment_image($main_image_id, 'thumbnail');
                    } else {
                        echo '<img src="' . get_template_directory_uri() . '/assets/images/placeholder.svg">';
                    }

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
    <?php endif; ?>

    <?php do_action( 'baza_product_after_images' ); ?>
</div>