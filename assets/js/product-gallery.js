jQuery(document).ready(function ($) {
    let body = $('body'),
        thumbnails = $('#product-thumbnails'),
        thumbnailItem = $('.product-thumbnail-item'),
        media = $('#product-gallery'),
        mediaItem = '.product-gallery-item',
        owlNav = '.owl-nav',
        sliderSpeed = 300,
        closeMediaPopup = '.close-media-popup',
        nextPrevButton = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.8 11.6C17.0666 11.8 17.0666 12.2 16.8 12.4L9.8 17.8991C9.47038 18.1463 9 17.9111 9 17.4991L9 6.50091C9 6.08888 9.47038 5.85369 9.8 6.10091L16.8 11.6Z" fill="currentColor"></path></svg>';

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

});
