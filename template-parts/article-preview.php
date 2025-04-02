<?php
global $post;

$id             = get_the_ID();
$excerpt        = apply_filters( 'get_custom_excerpt', $id );
$post_thumb     = get_the_post_thumbnail_url( $id );
$article_title  = get_the_title();
$article_href   = get_the_permalink();
$date           = get_the_date();
?>
<div class="article-item">
    <div class="article-image">
        <img src="<?php echo $post_thumb?>" alt="<?php echo $article_title?>">
    </div>

    <div class="atticle-excerpt">
        <?php echo $excerpt?>
    </div>

    <div class="article-item-footer">
        <div class="flex">
            <div class="article-date">
                <?php echo $date?>
            </div>
        </div>

        <div class="more-wrap">
            <a href="<?php echo $article_href?>" class="learn-more">
                <?php echo __( 'Читати далі' )?>
            </a>
        </div>
    </div>
</div>