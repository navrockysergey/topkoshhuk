jQuery(document).ready(function ($) {

    function hideElementsAfterNthElement(container, elementSelector, count) {
        const $container = $(container);
        const $targetElement = $container.find(elementSelector).eq(count - 1);
        const $elementsToHide = $targetElement.nextAll();
        const $hiddenContainer = $('<div class="hidden-content" style="display:none;"></div>');

        $elementsToHide.detach().appendTo($hiddenContainer);

        const $showMoreBtn = $('<a class="show-more-button">' + showMoreVars.readMoreText + '</a>');

        $targetElement.after($hiddenContainer);
        $targetElement.append($showMoreBtn);

        $showMoreBtn.on('click', function () {
            $hiddenContainer.show();
            $(this).remove();
        });
    }
    
    hideElementsAfterNthElement('.showmore', 'p', 2);

});