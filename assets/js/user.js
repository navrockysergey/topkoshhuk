jQuery(function ($) {
    function initCheckoutLoginForm() {
        $('#login-form-container .showlogin').off('click').on('click', function (e) {
            e.preventDefault();
            let $loginForm = $('.woocommerce-ajax-login');
            let $container = $('#login-form-container');
 
            $loginForm.slideToggle(400, function () {
                if ($loginForm.is(':visible')) {
                    $loginForm.addClass('active');
                    $container.addClass('active');
                } else {
                    $loginForm.removeClass('active');
                    $container.removeClass('active');
                }
            });
        });
 
        $('#login-form-container .ajax-login-button').off('click').on('click', function (e) {
            e.preventDefault();
 
            let $container = $(this).closest('.woocommerce-ajax-login');
            let $message = $container.find('.ajax-login-message');
            let nonce = $('#custom-login-nonce').val();
 
            if (!nonce) {
                $message.html('<p class="woocommerce-error">Security token missing. Please refresh the page.</p>');
                return;
            }
 
            $container.addClass('loading');
 
            $message.html('<p>' + login_params.login_process_text + '</p>');
 
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: login_params.ajax_url,
                data: {
                    'action': 'ajax_checkout_login',
                    'username': $('#ajax_username').val(),
                    'password': $('#ajax_password').val(),
                    'remember': $('#ajax_rememberme').is(':checked') ? 1 : 0,
                    'security': nonce
                },
                success: function (response) {
                    $container.removeClass('loading');
 
                    if (response.success) {
                        $message.html('<p class="woocommerce-message">' + response.data.message + '</p>');
 
                        if (response.data.fragments) {
                            $.each(response.data.fragments, function (key, value) {
                                $(key).replaceWith(value);
                            });
                        }
 
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    } else {
                        $message.html('<p class="woocommerce-error">' + response.data.message + '</p>');
                    }
                },
                error: function (xhr, status, error) {
                    $container.removeClass('loading');
                    console.error("AJAX error: " + status + " - " + error);
                    console.error("Response: ", xhr.responseText);
                    $message.html('<p class="woocommerce-error">' + login_params.error_text + ' (' + status + ')</p>');
                }
            });
        });
    }
 
    function initHeaderTabs() {
        $('.tab-link').off('click').on('click', function (e) {
            e.preventDefault();
            let tabId = $(this).data('tab');
            $('.tab-link').removeClass('active');
            $(this).addClass('active');
            $('.tab-content').removeClass('active');
            $('#' + tabId).addClass('active');
        });
    }
 
    function initHeaderLogin() {
        $('.header-ajax-login-button').off('click').on('click', function (e) {
            e.preventDefault();
 
            let $container = $(this).closest('.woocommerce-ajax-login');
            let $message = $container.find('.ajax-login-message');
            let nonce = $container.find('input[name="custom-login-nonce"]').val();
 
            if (!nonce) {
                $message.html('<p class="woocommerce-error">Security token missing. Please refresh the page.</p>');
                return;
            }
 
            $container.addClass('loading');
            $message.html('<p class="processing">' + login_params.login_process_text + '</p>');
 
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: login_params.ajax_url,
                data: {
                    'action': 'ajax_checkout_login',
                    'username': $('#header_ajax_username').val(),
                    'password': $('#header_ajax_password').val(),
                    'remember': $('#header_ajax_rememberme').is(':checked') ? 1 : 0,
                    'security': nonce
                },
                success: function (response) {
                    $container.removeClass('loading');
 
                    if (response.success) {
                        $message.html('<p class="woocommerce-message">' + response.data.message + '</p>');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    } else {
                        $message.html('<p class="woocommerce-error">' + response.data.message + '</p>');
                    }
                },
                error: function (xhr, status, error) {
                    $container.removeClass('loading');
                    console.error("AJAX error: " + status + " - " + error);
                    console.error("Response: ", xhr.responseText);
                    $message.html('<p class="woocommerce-error">' + login_params.error_text + ' (' + status + ')</p>');
                }
            });
        });
    }
 
    function initHeaderRegister() {
        $('.header-ajax-register-button').off('click').on('click', function (e) {
            e.preventDefault();
 
            let $container = $(this).closest('.woocommerce-ajax-register');
            let $message = $container.find('.ajax-register-message');
            let nonce = $('#custom-register-nonce').val();
 
            if (!nonce) {
                $message.html('<p class="woocommerce-error">Security token missing. Please refresh the page.</p>');
                return;
            }
 
            $container.addClass('loading');
 
            if (typeof login_params.register_process_text !== 'undefined') {
                $message.html('<p class="processing">' + login_params.register_process_text + '</p>');
            } else {
                $message.html('<p class="processing">Реєстрація...</p>');
            }
 
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: login_params.ajax_url,
                data: {
                    'action': 'ajax_register',
                    'name': $('#header_ajax_reg_name').val(),
                    'email': $('#header_ajax_reg_email').val(),
                    'phone': $('#header_ajax_reg_phone').val(),
                    'password': $('#header_ajax_reg_password').val(),
                    'security': nonce
                },
                success: function (response) {
                    $container.removeClass('loading');
 
                    if (response.success) {
                        $message.html('<p class="woocommerce-message">' + response.data.message + '</p>');
                        setTimeout(function () {
                            window.location.reload();
                        }, 1500);
                    } else {
                        $message.html('<p class="woocommerce-error">' + response.data.message + '</p>');
                    }
                },
                error: function (xhr, status, error) {
                    $container.removeClass('loading');
                    console.error("AJAX error: " + status + " - " + error);
                    console.error("Response: ", xhr.responseText);
                    $message.html('<p class="woocommerce-error">' + login_params.error_text + ' (' + status + ')</p>');
                }
            });
        });
    }
 
    function initKeyboardHandlers() {
        $(document).on('keypress', '#header_ajax_username, #header_ajax_password', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                $('.header-ajax-login-button').trigger('click');
            }
        });
 
        $(document).on('keypress', '#header_ajax_reg_name, #header_ajax_reg_email, #header_ajax_reg_phone, #header_ajax_reg_password', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                $('.header-ajax-register-button').trigger('click');
            }
        });
 
        $(document).on('keypress', '#ajax_username, #ajax_password', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                $('.ajax-login-button').trigger('click');
            }
        });
    }
 
    function initAll() {
        initCheckoutLoginForm();
        
        if ($('.tab-link').length > 0) {
            initHeaderTabs();
            initHeaderLogin();
            initHeaderRegister();
        }
    }
 
    initAll();
    initKeyboardHandlers();
    
    $(document.body).on('updated_checkout', function () {
        initAll();
    });
 });