<?php
/*
Template Name: 404
*/
?>

<?php get_header(); ?>

<main id="main" class="site-main page-404">
    <section class="section section-content section-404">
        <div class="container container-404">
        <div class="container">
            <div class="block-404">
                <h2><?php _e('Помилка'); ?></h2>
                <p><?php _e('Сторінку не знайдено'); ?></p>
            </div>
            <div class="block-404-footer">
                <p><?php _e('Неправильно набрано адресу або такої сторінки на сайті більше не існує.'); ?></p>
                <div class="return-to">
                    <a class="button wc-backward<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
                        <?php
                            /**
                             * Filter "Return To Shop" text.
                             *
                             * @since 4.6.0
                             * @param string $default_text Default text.
                             */
                            echo esc_html( apply_filters( 'woocommerce_return_to_shop_text', __( 'Return to shop', 'woocommerce' ) ) );
                        ?>
                    </a>
                    <a class="button go-home" href="<?php echo esc_url(home_url()); ?>">
                        <?php _e('На головну'); ?>
                    </a>
                </div>
            </div>
        </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>
