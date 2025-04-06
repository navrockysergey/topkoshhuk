jQuery(document).ready(function($) {
    // Настройки Notiny
    $.notiny.addTheme('success', {
        background: '#68b828',
        position: 'right-top'
    });
    
    $.notiny.addTheme('error', {
        background: '#d5080f',
        position: 'right-top'
    });
    
    $.notiny.addTheme('info', {
        background: '#40bbea',
        position: 'right-top'
    });
    
    $.notiny.addTheme('warning', {
        background: '#f7d227',
        position: 'right-top'
    });
    
    // Основные настройки для всех уведомлений
    $.notiny.setBaseTheme({
        image: '',
        position: 'right-top',
        theme: 'default',
        template: '<div class="notiny-base"><div class="notiny-theme"><span class="notiny-text" data-notiny-text></span></div></div>',
        width: '300px',
        background: '#303641',
        typeClass: {
            error: 'notiny-theme-error',
            success: 'notiny-theme-success',
            warning: 'notiny-theme-warning',
            info: 'notiny-theme-info'
        }
    });
    
    // Обработка AJAX-запросов WooCommerce
    $(document.body).on('added_to_cart removed_from_cart updated_cart_totals applied_coupon removed_coupon updated_shipping_method updated_checkout', function() {
        // Задержка для получения обновленных сообщений
        setTimeout(function() {
            displayNotifications();
        }, 100);
    });
    
    // Функция для отображения уведомлений
    function displayNotifications() {
        // Проверяем, есть ли уведомления от PHP
        if (typeof wooNotifications !== 'undefined' && wooNotifications.notices) {
            // Проходим по всем сообщениям
            wooNotifications.notices.forEach(function(notice) {
                var theme = 'default';
                
                // Определяем тему в зависимости от типа сообщения
                switch(notice.type) {
                    case 'success':
                        theme = 'success';
                        break;
                    case 'error':
                        theme = 'error';
                        break;
                    case 'notice':
                    case 'info':
                        theme = 'info';
                        break;
                    case 'warning':
                        theme = 'warning';
                        break;
                }
                
                // Показываем уведомление
                $.notiny({
                    text: notice.message,
                    theme: theme,
                    hideTime: 5000, // 5 секунд
                    showTime: 250,
                    hideEffect: 'slide',
                    showEffect: 'slide',
                    closeButton: true
                });
            });
        }
        
        // Ищем стандартные элементы WooCommerce и создаем уведомления на их основе
        $('.woocommerce-message, .woocommerce-info, .woocommerce-error, .woocommerce-notice').each(function() {
            var message = $(this).text().trim();
            var theme = 'default';
            
            if ($(this).hasClass('woocommerce-message')) {
                theme = 'success';
            } else if ($(this).hasClass('woocommerce-error')) {
                theme = 'error';
            } else if ($(this).hasClass('woocommerce-info')) {
                theme = 'info';
            } else if ($(this).hasClass('woocommerce-notice')) {
                theme = 'info';
            }
            
            // Показываем уведомление
            if (message) {
                $.notiny({
                    text: message,
                    theme: theme,
                    hideTime: 5000, // 5 секунд
                    showTime: 250,
                    hideEffect: 'slide',
                    showEffect: 'slide',
                    closeButton: true
                });
                
                // Скрываем оригинальное сообщение
                $(this).hide();
            }
        });
    }
    
    // Запускаем отображение уведомлений при загрузке страницы
    displayNotifications();
});