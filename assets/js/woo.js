jQuery(document).ready(function ($) {

    let sliderSpeed = 300;
	let nextPrevButton = '';

	$('.form-row').each(function () {
		const $row = $(this);
		const $label = $row.find('label');
		const $field = $row.find('input, textarea, select').first();
	
		if ($field.length && $label.length) {
			const labelClone = $label.clone();
			labelClone.find('*').remove();
			const pureText = $.trim(labelClone.text());
	
			if ($field.attr('placeholder')) {
				$label.hide();
			} else if (pureText) {
				$field.attr('placeholder', pureText);
				$label.hide();
			}
		}
	});
	
    
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
					nav: false,
					dots: false,
					margin: 12,
					stagePadding: 34,
					loop: true,
				},
				1024: {
					items: 2,
					nav: false,
					dots: false,
					margin: 12,
					stagePadding: 48,
					loop: true,
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

