jQuery(document).ready(function($) {
    // Function to create Google Maps iframe without API key
    function createGoogleMapsIframe(lat, lng) {
        return `
        <div class="map-wrapper">
            <iframe 
                width="100%" 
                height="300" 
                frameborder="0" 
                style="border:0" 
                src="https://www.google.com/maps?q=${lat},${lng}&z=15&output=embed" 
                allowfullscreen>
            </iframe>
        </div>
        `;
    }
    
    // Function to load map in appropriate container
    function loadMap() {
        const activeItem = $('.item.active');
        
        if (activeItem.length === 0) return;
        
        const lat = activeItem.data('lat');
        const lng = activeItem.data('lng');
        
        if (!lat || !lng) return;
        
        const iframeHtml = createGoogleMapsIframe(lat, lng);
        
        // Check viewport width and load iframe in appropriate container
        if ($(window).width() > 1024) {
            // Desktop view - load iframe in #map
            $('#map').html(iframeHtml);
            // Clear ALL mobile maps
            $('.item .item-map').empty();
        } else {
            // Mobile view - load iframe in .item-map of active item only
            activeItem.find('.item-map').html(iframeHtml);
            // Clear desktop map
            $('#map').empty();
            // Clear maps from inactive items
            $('.item').not('.active').find('.item-map').empty();
        }
    }
    
    // Handle click on store items
    $(document).on('click', '#stores .item', function(e) {
        // If the click was on the button-map or its children, don't process here
        if ($(e.target).closest('.button-map').length) {
            return;
        }
        
        // If already active in mobile view, do nothing
        if ($(window).width() <= 1024 && $(this).hasClass('active')) {
            return;
        }
        
        // Remove active class from all items
        $('#stores .item').removeClass('active');
        
        // Add active class to clicked item
        $(this).addClass('active');
        
        // Load map with new active item
        loadMap();
    });
    
    // Handle map button click
    $(document).on('click', '.button-map', function(e) {
        // Prevent the click from bubbling up to the .item
        e.stopPropagation();
        
        // Get the parent item
        const parentItem = $(this).closest('.item');
        
        // Remove active class from all items
        $('#stores .item').removeClass('active');
        
        // Add active class to this item
        parentItem.addClass('active');
        
        // Load map with new active item
        loadMap();
        
        // If in mobile view, scroll to the map
        if ($(window).width() <= 1024) {
            // Calculate position of the map within the item
            const mapPosition = parentItem.find('.item-map').offset().top - 20; // 20px offset for spacing
            
            // Scroll to the map
            $('html, body').animate({
                scrollTop: mapPosition
            }, 300);
        }
    });

    $(document).on('click', '#stores .logo-link', function(e) {
        e.stopPropagation();
        e.preventDefault();
    });

    // Handle window resize
    let resizeTimer;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            loadMap();
        }, 250);
    });
    
    // Initial map load
    loadMap();
});