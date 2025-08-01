jQuery(document).ready(function ($) {
	
	let body = $('body');

	body.addClass('ready');

	$('input[name="phone"], [name="billing_phone"], [name="reg_phone"], [name="account_phone"]').inputmask('+38(999)999-99-99');

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

	$(document).on('focus', 'input', function () {
		$(this).parent().addClass('focus');
	});

	$(document).on('blur', 'input', function () {
		$(this).parent().removeClass('focus');
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

	// To top
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

	// Accordion
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

	// Show more
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

    // Sets up number input validation to only allow digits
    function setupNumberInputValidation() {
        $('input[type="number"]:not([readonly])').each(function() {
            const $input = $(this);

            $input.on('input', function() {
                let value = $input.val().replace(/\D/g, '');
                $input.val(value === '' ? '' : value);
            });

            $input.on('focus', function() {
                $input.select();
            });
        });
    }

    setupNumberInputValidation();

	$('span.wpcf7-form-control-wrap').each(function() {
		var fileInput = $(this).find('input[type="file"]');
		if (fileInput.length) {
			let titleText = $(this).data('title');
	
			$(this).append('<span class="file-placeholder"><span class="placeholder-text">' + titleText + '</span></span>');
	
			fileInput.on('change', function() {
				let fileName = $(this).val().split('\\').pop();
				let placeholderElement = $(this).next('.file-placeholder').find('.placeholder-text');
				
				if (fileName) {
					if (fileName.length > 20) {
						let truncatedName = fileName.substring(0, 10) + '...' + fileName.substring(fileName.length - 7);
						placeholderElement.text(truncatedName);
					} else {
						placeholderElement.text(fileName);
					}
					placeholderElement.attr('title', fileName);
				} else {
					placeholderElement.text(titleText);
					placeholderElement.removeAttr('title');
				}
			});
		}
	});

    function initDropdowns() {
        $('.toggle-login-dropdown').off('click').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).siblings('.dropdown-content').toggleClass('active');
        });
 
        $(document).off('click.dropdown').on('click.dropdown', function(e) {
            if (!$(e.target).closest('.login-container').length) {
                $('.dropdown-content').removeClass('active');
            }
        });
    }

	initDropdowns();
});