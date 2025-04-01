<?php 
$post_id = 159; 
$title = carbon_get_post_meta($post_id, 'title'); 
$items = carbon_get_post_meta($post_id, 'yt_items');

if (get_post_status($post_id) === 'publish'):
?>

<section class="section section-video">
    <div class="container">
        <div class="section-title">
            <?php echo __('Food Miles на'); ?> <i class="fa fa-youtube-play" aria-hidden="true"></i> <?php echo __('YouTube'); ?>
        </div>
    </div>
    <?php if (!empty($items)): ?>
        <div class="container">
            <div class="owl-carousel" id="carousel-video">
                <?php foreach ($items as $item): ?>
                    <?php 
                        $item_url = isset($item['yt_url']) ? $item['yt_url'] : '';
                        $video_id = ''; 

                        if (preg_match('/(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|\S+v=|(?:\/v\/|\S+\/v\/)|\/e\/\S+\/|\S+\/v\/|\S+\/(?:[\S]+\?)?v=|youtu\.be\/))([\w\-]{11})/', $item_url, $matches)) {
                            $video_id = $matches[1];
                        }
                    ?>
                    <?php if ($video_id): ?>
                        <div class="item">
                            <iframe width="1200" height="675" src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php endif; ?>