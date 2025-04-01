<?php 
$post_id = 161; 
$image_id = carbon_get_post_meta($post_id, 'md_image');
$image_url = wp_get_attachment_url($image_id);
$text = carbon_get_post_meta($post_id, 'md_text');

if (get_post_status($post_id) === 'publish'):
?>

<section class="section section-md" style="background-image: url('<?php echo esc_url($image_url); ?>');">
    <?php if (!empty($text)): ?>
        <div class="container">
            <a class="link-leave-review" href="<?php echo get_permalink(227); ?>"><?php echo __('Залишити відгук'); ?></a>
            <?php echo apply_filters('the_content', $text); ?>
            <a class="link-delivery-map" href="<?php echo get_permalink(141); ?>"><?php echo __('Карта доставки'); ?></a>
        </div>
    <?php endif; ?>
</section>

<?php endif; ?>
