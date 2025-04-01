<?php 
$post_id = 156; 
$title = carbon_get_post_meta($post_id, 'title'); 
$items = carbon_get_post_meta($post_id, 'pd_items');

if (get_post_status($post_id) === 'publish'):
?>

<section class="section section-discount">
    <?php if ($title): ?>
        <div class="container">
            <div class="section-title"><a href="<?php echo get_permalink(65); ?>"><?php echo esc_html($title); ?></a></div>
        </div>
    <?php endif; ?>
    <?php if (!empty($items)): ?>
        <div class="container">
            <div class="owl-carousel" id="carousel-discount">
                <?php foreach ($items as $item): ?>
                    <?php 
                        $item_image_id = isset($item['pd_image']) ? $item['pd_image'] : ''; 
                        $item_title = isset($item['pd_title']) ? $item['pd_title'] : ''; 
                        $item_text = isset($item['pd_text']) ? $item['pd_text'] : ''; 
                        $item_url = isset($item['pd_url']) ? $item['pd_url'] : '';
                    ?>
                    <div class="item">
                        <?php if ($item_image_id): ?>
                            <?php 
                                $image = wp_get_attachment_image_url($item_image_id, 'medium');
                                $image_alt = get_post_meta($item_image_id, '_wp_attachment_image_alt', true);
                            ?>
                            <div class="image">
                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                            </div>
                        <?php endif; ?>
                        <div class="item-content">
                            <?php if ($item_title): ?>
                                <div class="title"><a href="<?php echo esc_url($item_url); ?>"><?php echo esc_html($item_title); ?></a></div>
                            <?php endif; ?>
                            <?php if ($item_text): ?>
                                <div class="text"><?php echo wp_kses_post($item_text); ?></div>
                            <?php endif; ?>
                            <div class="item-more">
                                <a class="button button-more" href="<?php echo esc_url($item_url); ?>">
                                    <?php echo __('Детальніше'); ?>
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php endif; ?>