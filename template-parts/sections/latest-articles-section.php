<?php
$posts_arge = [
    'post_type'   => 'post',
    'post_status' => 'publish',
    'order_by'    => 'date',
    'order'       => 'DESC'
];

$posts = new WP_Query( $posts_arge );

wp_reset_postdata();

if ( ! $posts->have_posts() ) {
    return;
}
?>

<section class="articles-wrap">
    <div class="container">
        <h2 class="setion-title">
            <?php echo esc_html( $latest_articles_section_title )?>
        </h2>

        <div class="flex">
            <?php
            while( $posts->have_posts() ) :
                $posts->the_post();

                include __THEME_DIR__ . '/template-parts/article-preview.php';
            endwhile;
            ?>
        </div>

        <a href="<?php echo esc_url( $latest_article_section_button_href )?>" class="button">
            <?php echo esc_html( $latest_article_section_button_text )?>
        </a>
    </div>
</section>