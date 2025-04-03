<?php
if ( ! $seo_text ) {
    return;
}
?>
<section class="section section-text">
    <div class="container">
        <div class="content">
            <div class="show-more" data-button-text="<?php _e( 'Читати повністю' ); ?>" data-row="<?php echo esc_html( $text_row ); ?>">
                <?php echo wp_kses_post( $seo_text ); ?>
            </div>
        </div>
    </div>
</section>