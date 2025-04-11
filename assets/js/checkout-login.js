jQuery(function($) {

    function initLoginForm() {
        $('#login-form-container .showlogin').off('click').on('click', function(e) {
            e.preventDefault();
            let $loginForm = $('.woocommerce-ajax-login');
            let $container = $('#login-form-container');
            
            $loginForm.slideToggle(400, function() {
                if ($loginForm.is(':visible')) {
                    $loginForm.addClass('active');
                    $container.addClass('active');
                } else {
                    $loginForm.removeClass('active');
                    $container.removeClass('active');
                }
            });
        });
        
        $('#login-form-container .ajax-login-button').off('click').on('click', function(e) {
            e.preventDefault();
            
            let $container = $(this).closest('.woocommerce-ajax-login');
            let $message = $container.find('.ajax-login-message');

            $container.addClass('loading');
            
            $message.html('<p>' + checkout_login_params.login_process_text + '</p>');
            
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: checkout_login_params.ajax_url,
                data: {
                    'action': 'ajax_checkout_login',
                    'username': $('#ajax_username').val(),
                    'password': $('#ajax_password').val(),
                    'remember': $('#ajax_rememberme').is(':checked'),
                    'security': $('#custom-login-nonce').val()
                },
                success: function(response) {
                    $container.removeClass('loading');

                    if (response.success) {
                        $message.html('<p class="woocommerce-message">' + response.data.message + '</p>');
                        
                        if (response.data.fragments) {
                            $.each(response.data.fragments, function(key, value) {
                                $(key).replaceWith(value);
                            });
                            
                            window.location.reload();
                        }
                    } else {
                        $message.html('<p class="woocommerce-error">' + response.data.message + '</p>');
                    }
                },
                error: function() {
                    $container.removeClass('loading');

                    $message.html('<p class="woocommerce-error">' + checkout_login_params.error_text + '</p>');
                }
            });
        });
    }

    initLoginForm();
    
    $(document.body).on('updated_checkout', function() {
        initLoginForm();
    });
});