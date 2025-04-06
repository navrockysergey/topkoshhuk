<?php
defined('ABSPATH') || exit;
?>
<div class="cart-totals cart_totals<?php echo (WC()->customer->has_calculated_shipping()) ? ' calculated_shipping' : ''; ?>">

    <?php do_action('woocommerce_before_cart_totals'); ?>

    <div class="cart-totals-wrapper">

        <div class="cart-items-count">
            <div class="label"><?php esc_html_e('Items', 'woocommerce'); ?>:</div>
            <div class="value">
                <?php 
                $item_count = WC()->cart->get_cart_contents_count();
                echo esc_html($item_count); 
                ?>
            </div>
        </div>

        <?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
            <div class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
                <div class="label"><?php wc_cart_totals_coupon_label($coupon); ?>:</div>
                <div class="value"><?php wc_cart_totals_coupon_html($coupon); ?></div>
            </div>
        <?php endforeach; ?>

        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
            <div class="shipping-wrapper">
                <?php do_action('woocommerce_cart_totals_before_shipping'); ?>
                <?php wc_cart_totals_shipping_html(); ?>
                <?php do_action('woocommerce_cart_totals_after_shipping'); ?>
            </div>
        <?php elseif (WC()->cart->needs_shipping() && 'yes' === get_option('woocommerce_enable_shipping_calc')) : ?>
            <div class="shipping-wrapper">
                <div class="label"><?php esc_html_e('Shipping', 'woocommerce'); ?>:</div>
                <div class="value"><?php woocommerce_shipping_calculator(); ?></div>
            </div>
        <?php endif; ?>

        <?php foreach (WC()->cart->get_fees() as $fee) : ?>
            <div class="fee">
                <div class="label"><?php echo esc_html($fee->name); ?>:</div>
                <div class="value"><?php wc_cart_totals_fee_html($fee); ?></div>
            </div>
        <?php endforeach; ?>

        <div class="order-subtotal">
            <div class="label"><?php esc_html_e('Total', 'woocommerce'); ?>:</div>
            <div class="value"><?php wc_cart_totals_order_total_html(); ?></div>
        </div>

        <?php
        if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) {
            $taxable_address = WC()->customer->get_taxable_address();
            $estimated_text  = '';

            if (WC()->customer->is_customer_outside_base() && !WC()->customer->has_calculated_shipping()) {
                /* translators: %s location. */
                $estimated_text = sprintf(' <small>' . esc_html__('(estimated for %s)', 'woocommerce') . '</small>', WC()->countries->estimated_for_prefix($taxable_address[0]) . WC()->countries->countries[$taxable_address[0]]);
            }

            if ('itemized' === get_option('woocommerce_tax_total_display')) {
                foreach (WC()->cart->get_tax_totals() as $code => $tax) {
                    ?>
                    <div class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?>">
                        <div class="label"><?php echo esc_html($tax->label) . $estimated_text; ?>:</div>
                        <div class="value"><?php echo wp_kses_post($tax->formatted_amount); ?></div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="tax-total">
                    <div class="label"><?php echo esc_html(WC()->countries->tax_or_vat()) . $estimated_text; ?>:</div>
                    <div class="value"><?php wc_cart_totals_taxes_total_html(); ?></div>
                </div>
                <?php
            }
        }
        ?>

        <?php do_action('woocommerce_cart_totals_before_order_total'); ?>

        <?php
        // Calculate discount amount if any
        $regular_price_total = 0;
        $actual_price_total = WC()->cart->get_cart_contents_total();
        
        foreach (WC()->cart->get_cart() as $cart_item) {
            $_product = $cart_item['data'];
            $regular_price = $_product->get_regular_price();
            $regular_price_total += $regular_price * $cart_item['quantity'];
        }
        
        $discount_amount = $regular_price_total - $actual_price_total;
        ?>

        <?php if ($discount_amount > 0) : ?>
        <div class="discount-total">
            <div class="label"><?php esc_html_e('Знижка', 'woocommerce'); ?>:</div>
            <div class="value"><?php echo wc_price($discount_amount); ?></div>
        </div>
        <?php endif; ?>

        <div class="order-total">
            <div class="value"><?php wc_cart_totals_order_total_html(); ?></div>
        </div>

        <?php do_action('woocommerce_cart_totals_after_order_total'); ?>
    </div>

    <div class="wc-proceed-to-checkout">
        <?php do_action('woocommerce_proceed_to_checkout'); ?>
    </div>

    <?php do_action('woocommerce_after_cart_totals'); ?>

</div>