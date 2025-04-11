jQuery(function ($) {
    const npAreaSelector = '#wcus_np_billing_area';
    const npCitySelector = '#wcus_np_billing_city';
    const npWarehouseSelector = '#wcus_np_billing_warehouse';
    const npDisabledClass = 'np-disabled';

    function refreshFields() {
        const $area = $(npAreaSelector);
        const $city = $(npCitySelector);
        const $warehouse = $(npWarehouseSelector);

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

        $(document).on('change', npAreaSelector, function () {
            refreshFields();
        });

        $(document).on('change', npCitySelector, function () {
            refreshFields();
        });

        setInterval(refreshFields, 500);
        refreshFields();
    }

    function checkFieldsAndInit() {
        if ($(npAreaSelector).length && $(npCitySelector).length) {
            init();
        } else {
            setTimeout(checkFieldsAndInit, 300);
        }
    }

    checkFieldsAndInit();

    $(document).on('updated_checkout', function () {
        setTimeout(refreshFields, 500);
    });
});