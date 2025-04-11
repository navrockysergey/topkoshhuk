jQuery(function ($) {
    const selectors = {
        billing: {
            area: '#wcus_np_billing_area',
            city: '#wcus_np_billing_city',
            warehouse: '#wcus_np_billing_warehouse'
        },
        shipping: {
            area: '#wcus_np_shipping_area',
            city: '#wcus_np_shipping_city',
            warehouse: '#wcus_np_shipping_warehouse'
        }
    };
    
    const npDisabledClass = 'np-disabled';

    function refreshFields() {
        refreshFieldSet(selectors.billing);
        refreshFieldSet(selectors.shipping);
    }
    
    function refreshFieldSet(fieldSet) {
        const $area = $(fieldSet.area);
        const $city = $(fieldSet.city);
        const $warehouse = $(fieldSet.warehouse);
        
        if (!$area.length || !$city.length || !$warehouse.length) {
            return;
        }

        if (!$area.val()) {
            $city.addClass(npDisabledClass);
            $warehouse.addClass(npDisabledClass);
            return;
        }

        const cityOptions = $city.find('option').length;

        if (cityOptions > 1) {
            $city.removeClass(npDisabledClass);
        } else {
            $city.addClass(npDisabledClass);
        }

        if (!$city.val()) {
            $warehouse.addClass(npDisabledClass);
            return;
        }

        const warehouseOptions = $warehouse.find('option').length;
        if (warehouseOptions > 1) {
            $warehouse.removeClass(npDisabledClass);
        } else {
            $warehouse.addClass(npDisabledClass);
        }
    }

    function init() {
        $(document).on('mousedown mouseup click focus', 
            '.' + npDisabledClass + ', ' + 
            '.' + npDisabledClass + ' + .select2-container, ' +
            '.' + npDisabledClass + ' + .select2-container .select2-selection, ' +
            '.' + npDisabledClass + ' + .select2-container .select2-selection--single, ' +
            '.' + npDisabledClass + ' + .select2-container .select2-selection__rendered, ' +
            '.' + npDisabledClass + ' + .select2-container .select2-selection__arrow', 
            function (e) {
                e.preventDefault();
                e.stopPropagation();
                return false;
            }
        );

        $(document).on('select2:opening', '.' + npDisabledClass, function (e) {
            e.preventDefault();
            return false;
        });

        $(document).on('change', selectors.billing.area, function () {
            refreshFields();
        });

        $(document).on('change', selectors.billing.city, function () {
            refreshFields();
        });
        
        $(document).on('change', selectors.shipping.area, function () {
            refreshFields();
        });

        $(document).on('change', selectors.shipping.city, function () {
            refreshFields();
        });

        setInterval(refreshFields, 500);
        refreshFields();
    }

    function checkFieldsAndInit() {
        const billingFieldsExist = $(selectors.billing.area).length && $(selectors.billing.city).length;
        const shippingFieldsExist = $(selectors.shipping.area).length && $(selectors.shipping.city).length;
        
        if (billingFieldsExist || shippingFieldsExist) {
            init();
        } else {
            setTimeout(checkFieldsAndInit, 300);
        }
    }

    checkFieldsAndInit();

    $(document).on('updated_checkout', function () {
        setTimeout(refreshFields, 500);
    });
    
    $(document).on('change', '#ship-to-different-address-checkbox', function() {
        setTimeout(refreshFields, 300);
    });
});