<?php
// your-theme/woocommerce/cart/cart.php
defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <?php do_action('woocommerce_before_cart_table'); ?>

    <div class="cart-items">
        <?php do_action('woocommerce_before_cart_contents'); ?>

        <?php
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                ?>
                <div class="cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                    
                    <div class="product-remove">
                        <?php
                        echo apply_filters(
                            'woocommerce_cart_item_remove_link',
                            sprintf(
                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.8553 7.55871C18.0506 7.36345 18.0506 7.04686 17.8553 6.8516L17.1482 6.14449C16.953 5.94923 16.6364 5.94923 16.4411 6.14449L11.9999 10.5857L7.55872 6.14449C7.36346 5.94923 7.04688 5.94923 6.85162 6.14449L6.14451 6.8516C5.94925 7.04686 5.94925 7.36345 6.14451 7.55871L10.5857 11.9999L6.14449 16.4411C5.94923 16.6364 5.94923 16.953 6.14449 17.1482L6.8516 17.8553C7.04686 18.0506 7.36344 18.0506 7.55871 17.8553L11.9999 13.4141L16.4411 17.8553C16.6364 18.0506 16.953 18.0506 17.1482 17.8553L17.8553 17.1482C18.0506 16.953 18.0506 16.6364 17.8553 16.4411L13.4141 11.9999L17.8553 7.55871Z" fill="currentColor"/></svg></a>',
                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                esc_html__('Remove this item', 'woocommerce'),
                                esc_attr($product_id),
                                esc_attr($_product->get_sku())
                            ),
                            $cart_item_key
                        );
                        ?>
                    </div>

                    <div class="product-thumbnail">
                        <?php
                        $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                        if (!$product_permalink) {
                            echo $thumbnail;
                        } else {
                            printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail);
                        }
                        ?>
                    </div>

                    <div class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                        <?php
                        if (!$product_permalink) {
                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                        } else {
                            echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                        }

                        do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                        // Meta data
                        echo wc_get_formatted_cart_item_data($cart_item);

                        // Backorder notification
                        if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                            echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                        }
                        ?>
                    </div>

                    <div class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                        <?php
                        echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                        ?>
                    </div>

                    <div class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                        <?php
                        if ($_product->is_sold_individually()) {
                            $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                        } else {
                            $product_quantity = woocommerce_quantity_input(
                                array(
                                    'input_name'   => "cart[{$cart_item_key}][qty]",
                                    'input_value'  => $cart_item['quantity'],
                                    'max_value'    => $_product->get_max_purchase_quantity(),
                                    'min_value'    => '0',
                                    'product_name' => $_product->get_name(),
                                ),
                                $_product,
                                false
                            );
                        }

                        echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                        ?>
                    </div>

                    <div class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                        <?php
                        echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                        ?>
                    </div>
                </div>
                <?php
            }
        }
        ?>

        <?php do_action('woocommerce_cart_contents'); ?>

        <div class="actions">
            <?php if (wc_coupons_enabled()) { ?>
                <div class="coupon">
                    <label for="coupon_code"><?php esc_html_e('Coupon:', 'woocommerce'); ?></label>
                    <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
                    <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_attr_e('Apply coupon', 'woocommerce'); ?></button>
                    <?php do_action('woocommerce_cart_coupon'); ?>
                </div>
            <?php } ?>

            <button type="submit" class="button update-cart" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

            <?php do_action('woocommerce_cart_actions'); ?>

            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
        </div>

        <?php do_action('woocommerce_after_cart_contents'); ?>
    </div>

    <?php do_action('woocommerce_after_cart_table'); ?>
</form>

<?php do_action('woocommerce_before_cart_collaterals'); ?>

<div class="cart-collaterals">
    <?php
    /**
     * Cart collaterals hook.
     * @hooked woocommerce_cross_sell_display - 10
     * @hooked woocommerce_cart_totals - 10
     */
    do_action('woocommerce_cart_collaterals');
    ?>
</div>

<?php do_action('woocommerce_after_cart'); ?>