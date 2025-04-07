jQuery(document).ready(function($) {
    let timer;
    let isAdjusting = false;
    let delay = 500
    
    $(document).on('click', '.qty-plus, .qty-minus', function(e) {
        e.preventDefault();
        
        clearTimeout(timer);
        
        const $input = $(this).siblings('.quantity').find('.qty');
        const currentVal = parseFloat($input.val()) || 0;
        
        if ($(this).hasClass('qty-plus')) {
            const max = parseFloat($input.attr('max'));
            if (!max || currentVal < max) {
                $input.val(currentVal + 1);
            }
        } else {
            const min = parseFloat($input.attr('min')) || 0;
            if (currentVal > min) {
                $input.val(currentVal - 1);
            }
        }
        
        isAdjusting = true;
        
        timer = setTimeout(function() {
            isAdjusting = false;
            ajaxUpdateCart($input);
        }, delay);
        
        $('button[name="update_cart"]').prop('disabled', false);
    });

    $(document).on('input', '.qty', function() {
        clearTimeout(timer);
        const $input = $(this);
        
        timer = setTimeout(function() {
            ajaxUpdateCart($input);
        }, delay);
    });

    function ajaxUpdateCart($input) {

        if (!isAdjusting) {
            $('button[name="update_cart"]').trigger('click');
        }
    }
});

