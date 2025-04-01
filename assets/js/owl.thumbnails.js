jQuery(document).ready(function ($) {
    let thumbnails = $('#thumbnails-list'),
        thumbnailItem = $('.thumbnail-item'),
        images = $('#project-banners-list'),
        imagesItem = '.project-banners-item',
        owlNav = '.owl-nav',
        slideSpeed = 2500;

    thumbnails.owlCarousel({
        items: 5,
        dots: false,
        nav: false,
        margin: 10,
        touchDrag: false,
        mouseDrag: false,
        onInitialized: function() {
            thumbnailItem.first().parent().addClass('current');
        }
    });

    images.owlCarousel({
        items: 1,
        navSpeed: slideSpeed,
        autoplaySpeed: slideSpeed,
        nav: true,
        autoplay: true,
        autoplayTimeout: 6000,
        dots: false,
        loop: true,
        navText: ['', ''],
        mouseDrag: false,
        touchDrag: false
    });

    thumbnailItem.on('click', function() {
        let thumbnailId = $(this).data('thumbnail-id');
        images.trigger('to.owl.carousel', [thumbnailId, slideSpeed]);
        thumbnailItem.parent().removeClass('current');
        $(this).parent().addClass('current');
    });

    images.on('changed.owl.carousel', function(event) {
        let currentImageId = $(event.target).find('.owl-item').eq(event.item.index).find(imagesItem).data('image-id');
        thumbnailItem.parent().removeClass('current');
        thumbnailItem.filter(`[data-thumbnail-id="${currentImageId}"]`).parent().addClass('active current');
    });

    thumbnails.on('mouseenter', function() {
        images.trigger('stop.owl.autoplay');
    });

    thumbnails.on('mouseleave', function() {
        images.trigger('play.owl.autoplay');
    });

    $(document).on('mouseenter', owlNav, function() {
        images.trigger('stop.owl.autoplay');
    });

    $(document).on('mouseleave', owlNav, function() {
        images.trigger('play.owl.autoplay');
    });

});
