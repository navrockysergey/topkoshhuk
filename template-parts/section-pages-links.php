<?php 
$post_id = 160; 
$items = carbon_get_post_meta($post_id, 'pl_items');

if (get_post_status($post_id) === 'publish'):
?>

<section class="section section-pl">
    <?php if (!empty($items)): ?>
        <div class="container">
            <ul>
                <?php foreach ($items as $item): ?>
                    <?php 
                    $icon = isset($item['pl_icon']) ? $item['pl_icon'] : ''; 
                    $item_title = isset($item['pl_title']) ? $item['pl_title'] : ''; 
                    $url = isset($item['pl_url']) ? $item['pl_url'] : '';
                    ?>
                    <li>
                        <a href="<?php echo esc_url($url); ?>">
                            <?php if ($icon): ?>
                                <span class="icon"><?php echo wp_kses_post($icon); ?></span>
                            <?php endif; ?>
                            <?php if ($item_title): ?>
                                <span><?php echo esc_html($item_title); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</section>

<?php endif; ?>
