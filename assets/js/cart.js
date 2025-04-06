jQuery(document).ready(function($) {

    let timer;
    
    $(document).on('click', '.qty-plus', function(e) {
        e.preventDefault();
        
        const $input = $(this).siblings('.quantity').find('.qty');
        const currentVal = parseFloat($input.val()) || 0;
        const max = parseFloat($input.attr('max'));
        
        if (!max || currentVal < max) {
            $input.val(currentVal + 1);
            ajaxUpdateCart($input);
        }
    });

    $(document).on('click', '.qty-minus', function(e) {
        e.preventDefault();
        
        const $input = $(this).siblings('.quantity').find('.qty');
        const currentVal = parseFloat($input.val()) || 0;
        const min = parseFloat($input.attr('min')) || 0;
        
        if (currentVal > min) {
            $input.val(currentVal - 1);
            ajaxUpdateCart($input);
        }
    });

    $(document).on('change', '.qty', function() {
        ajaxUpdateCart($(this));
    });

    $(document).on('input', '.qty', function() {
        clearTimeout(timer);
        const $input = $(this);
        
        timer = setTimeout(function() {
            ajaxUpdateCart($input);
        }, 500);
    });

    function ajaxUpdateCart($input) {
        
    }
});