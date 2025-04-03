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

<section class="section section-articles">
    <div class="container">
        <div class="section-title">
            <?php echo esc_html( $latest_articles_section_title )?>
        </div>

        <div class="article-items-wrapper">
            <div class="article-items">
                <?php
                while( $posts->have_posts() ) :
                    $posts->the_post();

                    include __THEME_DIR__ . '/template-parts/article-preview.php';
                endwhile;
                ?>
            </div>
        </div>

        <div class="section-footer">
            <a href="<?php echo esc_url( $latest_article_section_button_href )?>" class="button button-secondary">
                <span><?php echo esc_html( $latest_article_section_button_text )?></span>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.8 11.6C17.0666 11.8 17.0666 12.2 16.8 12.4L9.8 17.8991C9.47038 18.1463 9 17.9111 9 17.4991L9 6.50091C9 6.08888 9.47038 5.85369 9.8 6.10091L16.8 11.6Z" fill="currentColor"/>
                </svg>
            </a>
        </div>
    </div>
</section>