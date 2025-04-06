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
        $('.woocommerce-checkout-review-order td, .amount').each(function() {
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
		nav: true,
		margin: 0,
		dots: false,
		loop: true,
		navText: [nextPrevButton, nextPrevButton],
		mouseDrag: true,
		touchDrag: true,
		dragEndSpeed: sliderSpeed,
		dotsSpeed: sliderSpeed,
		autoHeight: true,
		autoplay: true,
		autoplaySpeed: sliderSpeed,
		autoplayTimeout: 6000,
		autoplayHoverPause: true,
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
		loop: true,
		navText: [nextPrevButton, nextPrevButton],
		mouseDrag: true,
		touchDrag: true,
		dragEndSpeed: sliderSpeed,
		dotsSpeed: sliderSpeed,
		autoHeight: true,
		autoplayHoverPause: true,
		responsive: {
			0: {
				items: 1
			},
			768: {
				items: 1
			},
			1024: {
				items: 3
			},
			1200: {
				items: 5
			}
		}
	});

	$('.products.owl-carousel').each(function() {
		let $carousel = $(this);
	
		$carousel.owlCarousel({
			stagePadding: 23,
			items: 3,
			navSpeed: sliderSpeed,
			dragEndSpeed: sliderSpeed,
			dotsSpeed: sliderSpeed,
			nav: true,
			margin: 24,
			dots: false,
			loop: true,
			navText: [nextPrevButton, nextPrevButton],
			mouseDrag: true,
			touchDrag: true,
			autoHeight: true,
			autoplay: false,
			autoplayHoverPause: true,
			autoplaySpeed: sliderSpeed,
			autoplayTimeout: 6000,
			responsive: {
				0: {
					items: 1,
					nav: false,
					dots: false,
					margin: 12,
					stagePadding: 34,
					loop: true,
				},
				768: {
					items: 2,
					nav: true,
					dots: false,
					margin: 12,
					stagePadding: 34,
					loop: true,
				},
				1024: {
					items: 2,
					nav: true,
					dots: false,
					margin: 24,
					stagePadding: 0,
					loop: false,
				},
				1200: {
					items: 3,
					nav: true,
					dots: false,
					margin: 24,
					loop: false,
					stagePadding: 0,
				}
			}
		});
	});

	$(document.body).on('click', '.woocommerce-cart .checkout-button.disabled', function(e) {
		e.preventDefault();
	});

	function categoryOrderby() {
		const $select = $('select.orderby, select.wpc-orderby-select');
		if (!$select.length) return;
		
		const $ulWrapper = $('<ul>', { class: 'select-wrapper' });
		const $li = $('<li>');
		const $selected = $('<a>', { class: 'selected', href: '#' });
		const $ulDropdown = $('<ul>', { class: 'select-list' });
		
		$select.find('option').each(function() {
			const value = $(this).val();
			const text = $(this).text();
			const isActive = value === $select.val();
			
			const $option = $('<li>', { 
				'data-value': value, 
				text: text,
				class: isActive ? 'active' : ''
			});
			
			$ulDropdown.append($option);
			if (isActive) $selected.text(text);
		});
		
		$li.append($selected, $ulDropdown);
		$ulWrapper.append($li);
		$select.after($ulWrapper).hide();

		$(document).on('click', function(e) {
			if (!$(e.target).closest('.select-wrapper').length) {
				$ulDropdown.removeClass('active');
			}
		});
		
		$selected.on('click', function(e) {
			e.preventDefault();
			$ulDropdown.toggleClass('active');
		});
		
		$ulDropdown.on('click', 'li:not(.active)', function() {
			const value = $(this).data('value');
			const text = $(this).text();
			$ulDropdown.find('li').removeClass('active');
			$(this).addClass('active');
			$selected.text(text);
			$select.val(value).change();
			$ulDropdown.removeClass('active');
		});
	}	

	categoryOrderby();

	$(document).on('ready', function(e){
		categoryOrderby();
		removeNbsp();
	});
});

