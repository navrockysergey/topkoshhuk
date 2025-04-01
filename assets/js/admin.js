jQuery(document).ready(function($) {
    var container = $('<div class="wholesale-prices-container"></div>');

    $('#_wholesale_prices').after(container);

    $('#add_wholesale_price').click(function() {
        var wholesale_prices = JSON.parse($('#_wholesale_prices').val() || '[]');

        wholesale_prices.push({
            min_product_count: '',
            wh_price: ''
        });

        $('#_wholesale_prices').val(JSON.stringify(wholesale_prices));

        display_wholesale_prices();

        return false;
    });

    function display_wholesale_prices() {
        var wholesale_prices = JSON.parse($('#_wholesale_prices').val() || '[]');

        var html = '<div class="wholesale-prices-items">';

        for (var i = 0; i < wholesale_prices.length; i++) {
            html += '<p>';
            html += '<label for="wholesale_prices-' + i + '-min_product_count">Min Product Count: </label>\
                    <input type="text" class="min_product_count" id="wholesale_prices-' + i + '-min_product_count" name="wholesale_prices[' + i + '][min_product_count]" value="' + wholesale_prices[i].min_product_count + '">';
            html += '<label for="wholesale_prices-' + i + '-wh_price">Wholesale Price: </label>\
                    <input type="text" class="wh_price" id="wholesale_prices-' + i + '-wh_price" name="wholesale_prices[' + i + '][wh_price]" value="' + wholesale_prices[i].wh_price + '">';
            html += '<button class="remove-wholesale-price" data-index="' + i + '">Remove</button>';
            html += '</p>';
        }

        html += '</div>';

        $('.wholesale-prices-container').html(html);

        $('.wholesale-prices-container').append('<button id="add_wholesale_price_item">Add Item</button>');

        $('.remove-wholesale-price').click(function() {
            var index = $(this).data('index');
            wholesale_prices.splice(index, 1);
            $('#_wholesale_prices').val(JSON.stringify(wholesale_prices));
            display_wholesale_prices();
        });

        $('.min_product_count, .wh_price').change(function() {
            var index = $(this).closest('p').find('.remove-wholesale-price').data('index');
            wholesale_prices[index].min_product_count = $(this).closest('p').find('.min_product_count').val();
            wholesale_prices[index].wh_price = $(this).closest('p').find('.wh_price').val();
            $('#_wholesale_prices').val(JSON.stringify(wholesale_prices));
        });

        $('#add_wholesale_price_item').click(function() {
            wholesale_prices.push({
                min_product_count: '',
                wh_price: ''
            });
            $('#_wholesale_prices').val(JSON.stringify(wholesale_prices));
            display_wholesale_prices();
        });
    }

    display_wholesale_prices();
});