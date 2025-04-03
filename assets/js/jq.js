jQuery(document).ready(function ($) {
	
	let baseUrl = window.location.protocol + '//' + window.location.hostname,
		body = $('body'),
		sliderSpeed = 1000;

	body.addClass('ready');

	$('input[name="phone"]').inputmask('+38(999)999-99-99');

	$(document).on('click', '.menu-toggle', function() {
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			body.removeClass('nav-active');
			body.removeClass('nav-active-after');
		} else {
			body.addClass('nav-active');
			$(this).addClass('active');
			setTimeout(function() {
				body.addClass('nav-active-after');
			}, 500);
		}
	});

	$(document).on('click', '.close-menu', function(e) {
		e.preventDefault();
		$('.menu-toggle').removeClass('active');
		body.removeClass('nav-active');
		body.removeClass('nav-active-after');
	});
	
	$(document).on('click', function(event) {
		if (!$(event.target).closest('.menu-wrapper').length && !$(event.target).closest('.menu-toggle').length && !$(event.target).closest('#MagiCSS-bookmarklet').length) {
			$('.menu-toggle').removeClass('active');
			body.removeClass('nav-active');
			body.removeClass('nav-active-after');
		}
	});

	$(document).on('click', 'header .menu .current-menu-item a[aria-current="page"], .logo-link[href="#"]', function(e) {
		e.preventDefault();
		e.stopPropagation();
	});

    $('.category').hover(function() {
		let category = $(this);
		setTimeout(function() {
			category.addClass('active');
		}, 300);
		
	}, function() {
		let category = $(this);
		setTimeout(function() {
			category.removeClass('active');
		}, 300);
	});

	let carouselDiscount = $('#carousel-discount');

	carouselDiscount.owlCarousel({
		items: 4,
		navSpeed: sliderSpeed,
		autoplaySpeed: sliderSpeed,
		nav: true,
		autoplay: true,
		autoplayTimeout: 6000,
		margin: 30,
		dots: true,
		loop: (carouselDiscount.find('.item').length > 3),
		navText: ['<i class="fa fa-arrow-left" aria-hidden="true"></i>', '<i class="fa fa-arrow-right" aria-hidden="true"></i>'],
		mouseDrag: true,
		touchDrag: true,
		dragEndSpeed: sliderSpeed,
		dotsSpeed: sliderSpeed,
		autoHeight: true,
		autoplayHoverPause: true,
		responsive: {
			0: {
				items: 1,
				nav: false,
				autoplay: false,
				loop: (carouselDiscount.find('.item').length > 1),
			},
			768: {
				items: 2,
				autoplay: false,
				loop: (carouselDiscount.find('.item').length > 2),
			},
			1024: {
				items: 3,
				loop: (carouselDiscount.find('.item').length > 3),
			},
			1200: {
				items: 4,
				loop: (carouselDiscount.find('.item').length > 4),
			}
		}
	});

	let $toTop = $('.to-top'),
        offset = 300;

    $(window).scroll(function() {
        if ($(this).scrollTop() < offset) {
            $toTop.css('transform', 'translateY(150px)');
        } else {
            $toTop.css('transform', 'translateY(0)');
        }
    });

	$('.to-top').click(function () {
		$('html, body').animate({
			scrollTop: 0
		}, 500);
	});

	$('.accordion-header').click(function () {
		let item = $(this).closest('.accordion-item');
		let text = item.find('.accordion-content');
	
		if (item.hasClass('active')) {
			item.removeClass('active');
			text.slideUp(300);
		} else {
			$('.accordion-item').removeClass('active');
			$('.accordion-content').slideUp(300);
			item.addClass('active');
			text.slideToggle(300);
		}
	});

	$('.show-more').each(function() {
		const $container = $(this);
		const buttonText = $container.data('button-text');
		const rowCount = parseInt($container.data('row'));
		
		$container.parent().addClass('has-show-more');
		
		const $allElements = $container.children();
		
		if ($allElements.length > rowCount) {
			const $hiddenContainer = $('<div class="hidden-content" style="display:none;"></div>');
			
			$allElements.slice(rowCount).detach().appendTo($hiddenContainer);
			$container.append($hiddenContainer);
			const $showMoreBtn = $('<div class="show-more-button"><a href="javascript:void(0);">' + buttonText + '</a></div>');

			$container.after($showMoreBtn);
			
			$showMoreBtn.on('click', function(e) {
				e.preventDefault();
				$hiddenContainer.show();
				$container.parent().removeClass('has-show-more');
				$(this).remove();
			});
		}
	});

});

