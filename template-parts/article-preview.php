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
    <div class="article-item-wrapper">
        
        <div class="article-image">
            <a href="<?php echo $article_href ?>" title="<?php echo $article_title?>">
                <img src="<?php echo $post_thumb?>" alt="<?php echo $article_title?>">
            </a>
        </div>

        <div class="article-info">

            <div class="article-title">
                <a href="<?php echo $article_href ?>">
                    <?php echo $article_title?>
                </a>
            </div>
            
            <div class="article-excerpt">
                <?php echo $excerpt?>
            </div>

            <div class="article-footer">
                <div class="article-date">
                    <?php echo $date?>
                </div>

                <div class="article-more">
                    <a href="<?php echo $article_href?>" class="learn-more">
                        <?php echo __( 'Читати далі' )?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>