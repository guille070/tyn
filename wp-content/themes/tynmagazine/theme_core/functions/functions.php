<?php
/**
    * Fichero PHP
    *
    * Funciones generales del tema
    *
    * @copyright Copyright (c) 2020 Dandy Agency
*/

/**
* Basic theme set up
*/
function theme_setup()
{
    
    // Localización de traducciones
    load_theme_textdomain( THEME_TEXTDOMAIN, get_stylesheet_directory() . '/languages' );

    // Menús
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', THEME_TEXTDOMAIN ),
        'primary_top_right' => __( 'Primary Menu (top right)', THEME_TEXTDOMAIN ),
        'footer' => __( 'Footer Menu', THEME_TEXTDOMAIN )
    ) );

    // Theme support
    add_theme_support( 'post-thumbnails' );
    //add_theme_support( 'editor-styles' );
    add_theme_support( 'responsive-embeds' );

	// Tamaño de imagenes
    add_image_size('hero_image', 1440, 900, true);

	// Stylesheet to the visual editor.
    //add_editor_style('editor-style.css');

}
add_action( 'after_setup_theme', 'theme_setup' );

/**
* Load custom Jquery
*/
function theme_load_custom_jquery() {
    wp_enqueue_style( 'theme-google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700', false );
    wp_enqueue_style( 'theme-bootstrap', get_template_directory_uri() . '/front/css/bootstrap.css', array(), THEME_STYLE_VERSION, 'all' );
    wp_enqueue_style( 'theme-style', get_template_directory_uri() . '/front/css/style.css', array(), THEME_STYLE_VERSION, 'all' );
    wp_enqueue_style( 'theme-fonts', get_template_directory_uri() . '/front/css/fonts.css', array(), THEME_STYLE_VERSION, 'all' );

    wp_deregister_script( 'jquery' ); 
    wp_register_script('jquery-custom', get_template_directory_uri() . '/front/js/jquery-2.2.4.min.js', false, '2.2.4', true);
    wp_enqueue_script('jquery-custom'); 

    wp_enqueue_script('theme-core', get_template_directory_uri() . '/front/js/core.min.js', array('jquery-custom'), THEME_STYLE_VERSION, true);
    wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/front/js/script.js', array('jquery-custom'), THEME_STYLE_VERSION, true);

    wp_enqueue_style( 'custom-styles', get_template_directory_uri() . '/css/custom-style.css', array(), THEME_STYLE_VERSION, 'all' );
}
add_action('wp_enqueue_scripts', 'theme_load_custom_jquery'); 

/**
* Theme Scripts
*/
function theme_scripts_styles()
{
    

    
}
add_action( 'enqueue_block_assets', 'theme_scripts_styles' );

/**
* Admin Scripts
*/
function theme_admin_scripts()
{
    wp_enqueue_style( 'editor-css', get_stylesheet_directory_uri() . '/editor-style.css', array(), THEME_STYLE_VERSION, 'all' );
    wp_enqueue_script( 'editor-js', get_stylesheet_directory_uri() . '/editor-admin.js', array('jquery'), THEME_STYLE_VERSION, true );
}
//add_action('enqueue_block_editor_assets', 'theme_admin_scripts');

/**
* ACF JSON - Save
*/
add_filter('acf/settings/save_json', 'theme_acf_json_save_point');
function theme_acf_json_save_point( $path ) {
    
    // update path
    $path = get_stylesheet_directory() . '/acf-json';
    
    // return
    return $path;
    
}

/**
* ACF JSON - Load
*/
add_filter('acf/settings/load_json', 'theme_acf_json_load_point');
function theme_acf_json_load_point( $paths ) {
    
    // remove original path (optional)
    unset($paths[0]);
    
    // append path
    $paths[] = get_stylesheet_directory() . '/acf-json';
    
    // return
    return $paths;
    
}

/**
* Theme options scripts in head
*/
function theme_options_scripts_head(){
    $scripts_head = get_field('scripts_head', 'option');

    echo ($scripts_head) ? $scripts_head : '';
};

/**
* Theme options scripts in footer
*/
function theme_options_scripts_footer(){
    $scripts_end_body = get_field('scripts_end_body', 'option');

    echo ($scripts_end_body) ? $scripts_end_body : '';
};


/**
* Theme Header
*/
function theme_get_header() 
{ ?>

    <header class="page-header header-home-1">
        <!-- RD Navbar-->
        <div class="rd-navbar-wrap">
            <nav class="rd-navbar rd-navbar-default" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-fullwidth" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-fullwidth" data-xl-device-layout="rd-navbar-fullwidth" data-xxl-layout="rd-navbar-fullwidth" data-xxl-device-layout="rd-navbar-fullwidth" data-md-stick-up-offset="180px" data-lg-stick-up-offset="180px" data-xl-stick-up-offset="180px" data-xxl-stick-up-offset="180px" data-stick-up="true" data-sm-stick-up="true" data-md-stick-up="true" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
                <div class="rd-navbar-inner">
                    <!-- RD Navbar Panel-->
                    <div class="rd-navbar-panel">
                        <!-- RD Navbar Toggle-->
                        <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                        <!-- RD Navbar Brand-->
                        <div class="rd-navbar-brand">
                            <a class="brand-name" href="<?php echo home_url(); ?>">
                                <img src="<?php echo get_stylesheet_directory_uri() ?>/front/images/logo-tynmag-retina.png" width="266"  alt="<?php bloginfo( 'name' ); ?>">
                            </a>
                        </div>
                        <div class="rd-navbar-collapse-toggle" data-rd-navbar-toggle=".rd-navbar-collapse"><span></span></div>
                        <div class="rd-navbar-top-panel rd-navbar-collapse">
                            <div class="rd-navbar-top-panel-inner">
                                <ul class="contact-list">
                                    <li><a href="#">Subscribe Now</a></li>
                                    <li><a data-toggle="modal" href="#myModal">Sign In</a></li>
                                    <li><a href="contacts.html">Contacts</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="rd-navbar-aside-right">
                        <div class="rd-navbar-nav-wrap">

                            <?php
                                wp_nav_menu( array(
                                    'theme_location'  => 'primary',
                                    'depth'           => 2, // 1 = no dropdowns, 2 = with dropdowns.
                                    'container'       => false,
                                    'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                    'menu_class'      => 'rd-navbar-nav',
                                ) );
                            ?>
                        </div>
                        <!--RD Navbar Search-->
                        <div class="rd-navbar-search">
                            <a class="rd-navbar-search-toggle" data-rd-navbar-toggle=".rd-navbar-search" href="#"><span></span></a>
                            <form class="rd-search" action="search-results.html" data-search-live="rd-search-results-live" method="GET">
                                <div class="form-wrap">
                                    <label class="form-label form-label" for="rd-navbar-search-form-input">I`m looking for...</label>
                                    <input class="rd-navbar-search-form-input form-input" id="rd-navbar-search-form-input" type="text" name="s" autocomplete="off">
                                    <div class="rd-search-results-live" id="rd-search-results-live"></div>
                                </div>
                                <button class="rd-search-form-submit fa-search"></button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>

<?php
}

/**
* Change classes to WP Submenu 
*/
function theme_submenu_class($menu) {
    
    $menu = preg_replace('/ class="sub-menu"/', '/ class="rd-navbar-dropdown" /', $menu);  
    
    return $menu;  
    
}    
add_filter('wp_nav_menu','theme_submenu_class'); 

/**
* Add Mime Types
*/
function theme_custom_mime_types( $mimes ) {
 
    // New allowed mime types.
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
     
    return $mimes;
}
add_filter( 'upload_mimes', 'theme_custom_mime_types' );

/**
 * Disable Automatic Updates
 */
add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );

/**
* Gutenberg: adding custom block categories
*/
function theme_block_categories( $categories, $post ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'tyn',
                'title' => __( 'Tyn Magazine', THEME_TEXTDOMAIN ),
                'icon'  => 'wordpress',
            ),
        )
    );
}
add_filter( 'block_categories', 'theme_block_categories', 10, 2 );

/**
* Gutenberg: disabled editor default styles
*/
add_filter('block_editor_settings', function ($editor_settings) {
    unset($editor_settings['styles'][0]);

    return $editor_settings;
});

/**
* Add Reusable Blocks to admin menu
*/
function add_reusable_blocks_admin_menu() {
    add_menu_page( 'Reusable Blocks', 'Reusable Blocks', 'edit_posts', 'edit.php?post_type=wp_block', '', 'dashicons-editor-table', 22 );
}
add_action( 'admin_menu', 'add_reusable_blocks_admin_menu' );


/**
 * Add unfiltered html cap to Administrator
 */
function theme_add_unfiltered_html_cap_to_users( $caps, $cap, $user_id ) {
    if ( 'unfiltered_html' === $cap && user_can( $user_id, 'administrator' ) ) {
   
        $caps = array( 'unfiltered_html' );
   
    }
   
    return $caps;
}
add_filter( 'map_meta_cap', 'theme_add_unfiltered_html_cap_to_users', 1, 3 );



