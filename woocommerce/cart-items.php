<div class="cart woocommerce-cart-form__contents">
    <div class="cart-items">
        <?php do_action('woocommerce_before_cart_contents'); ?>

        <?php
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
            $in_box     = intval( get_post_meta( $product_id, '_box_quantity', true ) );

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                ?>
                <div class="cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>" data-key="<?php echo esc_attr($cart_item_key); ?>">
                    
                    <div class="product-remove">
                        <?php
                        echo apply_filters(
                            'woocommerce_cart_item_remove_link',
                            sprintf(
                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>',
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

                        <div class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                            <?php
                            echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                            ?>
                        </div>
                    </div>

                    <div class="product-content-footer">

                        <div class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                            <?php
                            echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                            ?>
                        </div>

                        <div class="qty-container" data-in-box="<?php echo $in_box?>" data-product-id="<?php echo $product_id?>">
                            <button class="button button-qty qty-minus">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.5 11C5.22386 11 5 11.2239 5 11.5V12.5C5 12.7761 5.22386 13 5.5 13H18.5C18.7761 13 19 12.7761 19 12.5V11.5C19 11.2239 18.7761 11 18.5 11H5.5Z" fill="currentColor"></path>
                                </svg>
                            </button>
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
                            <button class="button button-qty qty-plus">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13 11V5.5C13 5.22386 12.7761 5 12.5 5H11.5C11.2239 5 11 5.22386 11 5.5V11H5.5C5.22386 11 5 11.2239 5 11.5V12.5C5 12.7761 5.22386 13 5.5 13H11V18.5C11 18.7761 11.2239 19 11.5 19H12.5C12.7761 19 13 18.7761 13 18.5V13H18.5C18.7761 13 19 12.7761 19 12.5V11.5C19 11.2239 18.7761 11 18.5 11H13Z" fill="currentColor"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                            <?php
                            echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                            ?>
                        </div>

                    </div>
                        
                </div>
                <?php
            }
        }
        ?>

        <?php do_action('woocommerce_cart_contents'); ?>

        <?php do_action('woocommerce_after_cart_contents'); ?>
    </div>

    <div class="actions">
        <?php if (wc_coupons_enabled()) { ?>
            <div class="coupon">
                <label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply coupon', 'woocommerce' ); ?></button>
                <?php do_action( 'woocommerce_cart_coupon' ); ?>
            </div>
        <?php } ?>

        <button type="submit" class="button update-cart" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>

        <?php do_action('woocommerce_cart_actions'); ?>

        <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
    </div>
</div>