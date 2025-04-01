<?php 
$post_id = 147; 
$title = carbon_get_post_meta($post_id, 'title'); 
$items = carbon_get_post_meta($post_id, 'items');

if (get_post_status($post_id) === 'publish'):
?>


<?php if ($title): ?>
    <div class="container">
        <div class="section-fd-title"><?php echo esc_html($title); ?></div>
    </div>
<?php endif; ?>

<section class="section section-fd">
    <?php if (!empty($items)): ?>
        <div class="container">
            <ul>
                <?php foreach ($items as $item): ?>
                    <?php 
                    $icon = isset($item['icon']) ? $item['icon'] : ''; 
                    $item_title = isset($item['title']) ? $item['title'] : ''; 
                    $url = isset($item['url']) ? $item['url'] : '';
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