jQuery(document).ready(function($) {

    function updateShippingAddressVisibility() {
        let isLocalPickupSelected = $('.shipping_method:checked[value*=local_pickup]').length > 0;
        let isNovaPoshtaSelected = $('.shipping_method:checked[value*=nova_poshta]').length > 0;
        let $shippingAddress = $('.woocommerce-shipping-fields');
        
        if (isLocalPickupSelected) {

            $shippingAddress.hide();
        } else if (isNovaPoshtaSelected) {

            $shippingAddress.show();
            let isShipToDifferent = $('#ship-to-different-address-checkbox').is(':checked');
            
            if (isShipToDifferent) {
                $('.shipping_address').show();
            } else {
                $('.shipping_address').hide();
            }
        } else {
            $shippingAddress.show();
            $('.shipping_address').show();
        }
    }
      
    $('.shipping_method').change(function () {
        updateShippingAddressVisibility();
    });

    updateShippingAddressVisibility();

    function processCheckboxLabels() {
        $('.woocommerce-checkout .form-row input[type="checkbox"], .woocommerce-checkout .wc-urk-shipping-form-group input[type="checkbox"]').each(function() {
            let $checkbox = $(this);
            let $label = $checkbox.closest('label');
            
            if ($label.length) {

                if ($label.data('processed')) {
                    return;
                }
                
                $label.data('processed', true);
                
                $label.find('.checkbox-text').remove();
                
                $label.find('.optional').remove();
                
                let labelText = '';
                $label.contents().filter(function() {
                    return this.nodeType === 3;
                }).each(function() {
                    labelText += this.textContent;
                });
                
                $label.contents().filter(function() {
                    return this.nodeType === 3;
                }).remove();
                
                if (labelText.trim() !== '') {
                    $checkbox.after($('<span class="checkbox-text"></span>').text(labelText.trim()));
                }
            }
        });
    }

    processCheckboxLabels();

    function moveCallbackField() {
        let $callbackField = $('#shipping_call_back_field');
        let $customerDetails = $('#customer_details');
        
        if ($callbackField.length && $customerDetails.length) {
            $customerDetails.append($callbackField);
        }
    }
    
    moveCallbackField();

    $(document.body).on('updated_checkout', function () {
        updateShippingAddressVisibility();
        processCheckboxLabels();
        moveCallbackField();
    });
});

