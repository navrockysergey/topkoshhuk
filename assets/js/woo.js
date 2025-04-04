jQuery(document).ready(function ($) {

    let sliderSpeed = 1000;
	let nextPrevButton = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.8 11.6C17.0666 11.8 17.0666 12.2 16.8 12.4L9.8 17.8991C9.47038 18.1463 9 17.9111 9 17.4991L9 6.50091C9 6.08888 9.47038 5.85369 9.8 6.10091L16.8 11.6Z" fill="currentColor"></path></svg>';
    
    if ($('.category-header select').length > 0 && $.fn.select2) {
        $('.category-header select').select2({
            minimumResultsForSearch: 10,
            dropdownPosition: 'below'
        });
    }

    function removeNbsp() {
        $('.woocommerce-checkout-review-order td').each(function() {
            $(this).html($(this).html().replace(/&nbsp;/g, ''));
        });
    }

    removeNbsp();

    $(document.body).on('updated_checkout', function() {
        removeNbsp();
    });

	let carouselBestsselers = $('#bestsellers');

	carouselBestsselers.owlCarousel({
		items: 1,
		navSpeed: sliderSpeed,
		autoplaySpeed: sliderSpeed,
		nav: true,
		autoplay: true,
		autoplayTimeout: 6000,
		margin: 0,
		autoplayHoverPause: true,
		dots: false,
		loop: true,
		navText: [nextPrevButton, nextPrevButton],
		mouseDrag: true,
		touchDrag: true,
		dragEndSpeed: sliderSpeed,
		dotsSpeed: sliderSpeed,
		autoHeight: true
	});

	let carouselCategories = $('#main-category-slider');

	carouselCategories.owlCarousel({
		items: 4,
		navSpeed: sliderSpeed,
		autoplaySpeed: sliderSpeed,
		nav: true,
		autoplay: false,
		autoplayTimeout: 6000,
		margin: 24,
		autoplayHoverPause: true,
		dots: false,
		loop: (carouselCategories.find('.item').length > 5),
		navText: [nextPrevButton, nextPrevButton],
		mouseDrag: true,
		touchDrag: true,
		dragEndSpeed: sliderSpeed,
		dotsSpeed: sliderSpeed,
		autoHeight: true,
		autoplayHoverPause: true,
		responsive: {
			0: {
				items: 1,
				loop: (carouselCategories.find('.item').length > 1),
			},
			768: {
				items: 1,
				loop: (carouselCategories.find('.item').length > 1),
			},
			1024: {
				items: 3,
				loop: (carouselCategories.find('.item').length > 3),
			},
			1200: {
				items: 5,
				loop: (carouselCategories.find('.item').length > 5),
			}
		}
	});

	$('#carousel-popular, #carousel-crosssell, #carousel-related-products, #carousel-upsell-products').each(function() {
		let $carousel = $(this);
		let productCount = $carousel.find('.product').length;
	
		$carousel.owlCarousel({
			items: 3,
			navSpeed: sliderSpeed,
			autoplaySpeed: sliderSpeed,
			nav: true,
			autoplay: true,
			autoplayTimeout: 6000,
			margin: 0,
			dots: false,
			loop: (productCount > 3),
			navText: [nextPrevButton, nextPrevButton],
			mouseDrag: true,
			touchDrag: true,
			dragEndSpeed: sliderSpeed,
			dotsSpeed: sliderSpeed,
			autoHeight: true,
			autoplayHoverPause: true,
			responsive: {
				0: {
					items: 1,
					margin: 0,
					autoplay: false,
					nav: true,
					dots: false,
					loop: (productCount > 1),
				},
				768: {
					items: 2,
					autoplay: false,
					nav: true,
					dots: false,
					loop: (productCount > 2),
				},
				1024: {
					items: 2,
					nav: true,
					dots: false,
					loop: (productCount > 2),
				},
				1200: {
					items: 3,
					nav: true,
					dots: false,
					loop: (productCount > 3),
				}
			}
		});
	});	

    // $(document.body).on('change input', '.woocommerce-cart input.qty', function() {
    //     setTimeout(function() {
    //         $('.woocommerce-cart [name=update_cart]').trigger('click');
    //     }, 200);
    // });

	$(document.body).on('click', '.woocommerce-cart .checkout-button.disabled', function(e) {
		e.preventDefault();
	});
});

