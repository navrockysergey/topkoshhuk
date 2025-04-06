jQuery(document).ready(function ($) {
    /**
     * Rounds a number to the nearest multiple of another number
     * @param {number} multiplier - The multiple to round to
     * @param {number} value - The value to round
     * @return {number} - The rounded value
     */
    function roundToNearestMultiple(multiplier, value) {
        const remainder = value % multiplier;
        if (remainder === 0) {
            return value;
        }

        const lowerValue = value - remainder;
        const upperValue = value + (multiplier - remainder);

        if (value - lowerValue <= upperValue - value) {
            return lowerValue;
        } else {
            return upperValue;
        }
    }

    /**
     * Updates the quantity and UI based on the action (increase/decrease)
     * @param {Object} $button - jQuery object of the clicked button
     */
    function updateQuantity($button) {
        const $form = $button.closest('form');
        const itemsPerBox = parseInt($form.data('in-box'));
        const $quantityInput = $form.find('input[name="quantity"]');
        const $fakeQuantityInput = $form.find('input.fake-qty');
        const minQuantity = parseInt($quantityInput.attr('min')) || 1;
        const currentQuantity = parseInt($quantityInput.val()) || minQuantity;
        const isIncreasing = $button.hasClass('qty-plus');
        const isDecreasing = $button.hasClass('qty-minus');
        
        let step, newQuantity, displayQuantity, isWholesale;

        // Process quantity increase
        if (isIncreasing) {
            // Проверяем, достигнем ли мы значения itemsPerBox после увеличения
            if (currentQuantity + 1 === itemsPerBox) {
                // Если после увеличения на 1 мы ровно достигаем itemsPerBox
                step = 1;
                newQuantity = currentQuantity + step;
                displayQuantity = newQuantity;
                isWholesale = false; // Все еще розница, пока не превысили itemsPerBox
            } else if (currentQuantity + 1 > itemsPerBox) {
                // Если после увеличения мы превышаем itemsPerBox
                step = 1;
                
                // Если текущее значение = itemsPerBox, то следующее будет itemsPerBox + 1
                if (currentQuantity === itemsPerBox) {
                    newQuantity = itemsPerBox + 1;
                    // Fix: Use Math.floor to get whole number of boxes
                    displayQuantity = Math.floor((newQuantity / itemsPerBox) * 1000) / 1000;
                    isWholesale = true; // Теперь это оптовая продажа
                } else {
                    // Если уже в оптовом режиме, увеличиваем на itemsPerBox
                    step = itemsPerBox;
                    newQuantity = roundToNearestMultiple(itemsPerBox, currentQuantity + step);
                    // Fix: Use Math.floor to get whole number of boxes with proper rounding
                    displayQuantity = Math.floor((newQuantity / itemsPerBox) * 1000) / 1000;
                    isWholesale = true;
                }
            } else {
                // Обычное увеличение на 1 в розничном режиме
                step = 1;
                newQuantity = currentQuantity + step;
                displayQuantity = newQuantity;
                isWholesale = false;
            }
        } 
        // Process quantity decrease
        else if (isDecreasing) {
            if (currentQuantity > itemsPerBox) {
                // Если мы выше itemsPerBox и уменьшаем
                step = itemsPerBox;
                newQuantity = roundToNearestMultiple(itemsPerBox, currentQuantity - step);
                
                // Проверяем, не опустились ли мы ниже или равно itemsPerBox
                if (newQuantity <= itemsPerBox) {
                    // Если после уменьшения мы на границе или ниже
                    displayQuantity = newQuantity;
                    isWholesale = false; // Переходим на розницу
                } else {
                    // Остаемся в оптовом режиме
                    // Fix: Use Math.floor to get whole number of boxes with proper rounding
                    displayQuantity = Math.floor((newQuantity / itemsPerBox) * 1000) / 1000;
                    isWholesale = true;
                }
            } else {
                // Обычное уменьшение в розничном режиме
                step = 1;
                newQuantity = Math.max(minQuantity, currentQuantity - step); // Fix: Use minQuantity here
                displayQuantity = newQuantity;
                isWholesale = false;
            }
        }

        // Update input values
        $quantityInput.val(newQuantity);
        $fakeQuantityInput.val(isWholesale ? displayQuantity : newQuantity);
        
        // Update wholesale UI
        updateWholesaleUI(isWholesale, newQuantity);
    }

    /**
     * Updates the wholesale UI elements based on quantity
     * @param {boolean} isWholesale - Whether the quantity is wholesale
     * @param {number} quantity - The new quantity value
     */
    function updateWholesaleUI(isWholesale, quantity) {
        const $wholesaleItems = $('.product-wholesales').find('.wholesale-item');
        
        if (isWholesale) {
            $('.box-variation.wholesale').addClass('active');
            $('.box-variation.retail').removeClass('active');

            $wholesaleItems.each(function(index, element) {
                const $element = $(element);
                const currentThreshold = parseInt($element.data('pr-count'));
                let nextThreshold = false;

                if ($wholesaleItems.length > index + 1) {
                    nextThreshold = $($wholesaleItems[index + 1]).data('pr-count');
                }

                const isActive = 
                    (nextThreshold && 
                     currentThreshold <= quantity && 
                     nextThreshold > quantity) || 
                    (!nextThreshold && currentThreshold <= quantity);

                if (isActive) {
                    $('.product-wholesales').find('.wholesale-item.active').removeClass('active');
                    $element.addClass('active');
                }
            });
        } else {
            $('.product-wholesales').find('.wholesale-item.active').removeClass('active');
            $('.box-variation.retail').addClass('active');
            $('.box-variation.wholesale').removeClass('active');
        }
    }

    /**
     * Handles real-time input in both quantity fields
     */
    function handleQuantityInputChange() {
        // Handle changes to the main quantity input
        $('form input[name="quantity"]').on('input', function() {
            const $quantityInput = $(this);
            const $form = $quantityInput.closest('form');
            const itemsPerBox = parseInt($form.data('in-box'));
            const $fakeQuantityInput = $form.find('input.fake-qty');
            const minQuantity = parseInt($quantityInput.attr('min')) || 1; // Fix: Get min attribute
            
            // Get the current input value and ensure it's a number (at least minQuantity)
            let currentQuantity = $quantityInput.val().replace(/\D/g, '');
            currentQuantity = currentQuantity === '' ? minQuantity : parseInt(currentQuantity);
            
            // Ensure minimum value is respected
            const validQuantity = Math.max(minQuantity, currentQuantity);
            
            // Determine if wholesale - только если СТРОГО больше itemsPerBox
            const isWholesale = validQuantity > itemsPerBox;
            // Fix: Use proper division with rounding for wholesale display
            const displayQuantity = isWholesale ? 
                Math.floor((validQuantity / itemsPerBox) * 1000) / 1000 : 
                validQuantity;
            
            // Update both inputs
            $quantityInput.val(validQuantity);
            $fakeQuantityInput.val(displayQuantity);
            
            // Update wholesale UI
            updateWholesaleUI(isWholesale, validQuantity);
        });

        // Handle changes to the fake quantity input
        $('form input.fake-qty').on('input', function() {
            const $fakeQuantityInput = $(this);
            const $form = $fakeQuantityInput.closest('form');
            const itemsPerBox = parseInt($form.data('in-box'));
            const $quantityInput = $form.find('input[name="quantity"]');
            const minQuantity = parseInt($quantityInput.attr('min')) || 1; // Fix: Get min attribute
            
            // Get the current input value and ensure it's a number (at least 1)
            let fakeQuantity = $fakeQuantityInput.val().replace(/\D/g, '');
            fakeQuantity = fakeQuantity === '' ? 1 : parseInt(fakeQuantity);
            
            // Ensure minimum value is 1
            const validFakeQuantity = Math.max(1, fakeQuantity);
            
            // Determine if wholesale
            const isWholesale = $form.find('.box-variation.wholesale').hasClass('active');
            
            // Calculate the real quantity based on wholesale status
            let realQuantity;
            if (isWholesale) {
                realQuantity = validFakeQuantity * itemsPerBox;
            } else {
                realQuantity = validFakeQuantity;
            }
            
            // Ensure minimum quantity is respected
            realQuantity = Math.max(minQuantity, realQuantity);
            
            // Update the real quantity input
            $quantityInput.val(realQuantity);
            
            // Update wholesale UI
            updateWholesaleUI(isWholesale, realQuantity);
        });
    }

    /**
     * Инициализация начального состояния
     */
    function initializeQuantityState() {
        $('form[data-in-box]').each(function() {
            const $form = $(this);
            const itemsPerBox = parseInt($form.data('in-box'));
            const $quantityInput = $form.find('input[name="quantity"]');
            const $fakeQuantityInput = $form.find('input.fake-qty');
            const minQuantity = parseInt($quantityInput.attr('min')) || 1; // Fix: Get min attribute
            const currentQuantity = parseInt($quantityInput.val()) || minQuantity;
            
            // Проверить нужно ли активировать оптовые цены при загрузке
            const isWholesale = currentQuantity > itemsPerBox;
            
            // Update fake quantity input if in wholesale mode
            if (isWholesale) {
                // Fix: Use proper division with rounding
                const displayQuantity = Math.floor((currentQuantity / itemsPerBox) * 1000) / 1000;
                $fakeQuantityInput.val(displayQuantity);
            }
            
            // Обновить UI соответственно
            updateWholesaleUI(isWholesale, currentQuantity);
        });
    }

    // Event listener for quantity buttons
    $(document).on('click', '.button-qty', function(e) {
        e.preventDefault();
        updateQuantity($(this));
    });
    
    // Set up quantity input change handlers
    handleQuantityInputChange();
    
    // Initialize quantity state on page load
    initializeQuantityState();
});