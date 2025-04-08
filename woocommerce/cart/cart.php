<?php

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<div class="container">

    <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
        <?php do_action('woocommerce_before_cart_table'); ?>
        
        <div class="cart-container">

            <?php wc_get_template('cart-items.php'); ?>

            <div class="cart-side">
                <div class="cart-side-block">
                    <?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

                    <div class="cart-collaterals">
                        <?php
                            /**
                             * Cart collaterals hook.
                             *
                             * @hooked woocommerce_cross_sell_display
                             * @hooked woocommerce_cart_totals - 10
                             */
                            do_action( 'woocommerce_cart_collaterals' );
                        ?>
                    </div>
                </div>
            </div>

        </div>

        <?php do_action('woocommerce_after_cart_table'); ?>
    </form>

</div>

<?php do_action('woocommerce_after_cart'); ?>