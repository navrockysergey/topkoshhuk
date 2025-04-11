jQuery(document).ready(function ($) {
    let body = $('body'),
        thumbnails = $('#product-thumbnails'),
        thumbnailItem = $('.product-thumbnail-item'),
        media = $('#product-gallery'),
        mediaItem = '.product-gallery-item',
        sliderSpeed = 300,
        closeMediaPopup = '.close-media-popup',
        nextPrevButton = '';

    thumbnails.owlCarousel({
        navSpeed: sliderSpeed,
        autoplaySpeed: sliderSpeed,
        dragEndSpeed: sliderSpeed,
        dotsSpeed: sliderSpeed,
        items: 5,
        dots: false,
        nav: false,
        margin: 12,
        loop: false,
        touchDrag: false,
        mouseDrag: false,
        onInitialized: function() {
            thumbnailItem.first().parent().addClass('current');
        }
    });

    let $mediaCarousel = media.owlCarousel({
        items: 1,
        navSpeed: sliderSpeed,
        dragEndSpeed: sliderSpeed,
        dotsSpeed: sliderSpeed,
        nav: true,
        autoHeight: false,
        margin: 0,
        autoplay: false,
        autoplaySpeed: sliderSpeed,
        autoplayTimeout: 6000,
        dots: false,
        loop: false,
        navText: [nextPrevButton, nextPrevButton],
        mouseDrag: false,
        touchDrag: true
    });

    if (thumbnailItem.length > 1) {

        thumbnailItem.on('click', function() {
            let thumbnailId = $(this).data('thumbnail-id');
            $mediaCarousel.trigger('stop.owl.autoplay');
            $mediaCarousel.trigger('to.owl.carousel', [thumbnailId, sliderSpeed]);
            thumbnailItem.removeClass('active current');
            $(this).addClass('active current');
        });

        media.on('changed.owl.carousel', function(event) {
            let currentMediaId = $(event.target).find('.owl-item').eq(event.item.index).find(mediaItem).data('image-id');
            thumbnailItem.removeClass('active current');
            thumbnailItem.filter(`[data-thumbnail-id="${currentMediaId}"]`).addClass('active current');
        });

        $(document).on('click', mediaItem, function(e) {
            e.preventDefault();

            if (body.hasClass('product-media-popup')) {
                return;
            }

            body.addClass('product-media-popup');

            setTimeout(function() {
                $mediaCarousel.trigger('refresh.owl.carousel');
            }, 300);
        });

        $(document).on('click', closeMediaPopup, function(e) {
            e.preventDefault();
        
            body.removeClass('product-media-popup');
        
            setTimeout(function() {
                $mediaCarousel.trigger('refresh.owl.carousel');
            }, 300);
        });

        $(document).on('resize', function() {
            $mediaCarousel.trigger('refresh.owl.carousel');
        });

    }

});
