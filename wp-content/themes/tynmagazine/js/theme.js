wp.domReady( function () {
    var unregister_blocks = [
        'core/latest-posts', 
        'core/latest-comments', 
        'core/rss', 
        'core/calendar', 
        'core/social-link', 
        'core/social-links', 
        'core/categories', 
        'custom-banners/banner-list',
        'custom-banners/rotating-banner',
        'custom-banners/single-banner'
    ];

    if (unregister_blocks) {
        unregister_blocks.forEach(element => {
            wp.blocks.unregisterBlockType( element );
        });
    }
} );