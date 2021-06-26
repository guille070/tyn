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
        'primary' => __( 'Menu Principal', THEME_TEXTDOMAIN ),
        'primary_top_right' => __( 'Menu Principal (top right)', THEME_TEXTDOMAIN ),
        'footer' => __( 'Menu Footer', THEME_TEXTDOMAIN )
    ) );

    // Theme support
    add_theme_support( 'post-thumbnails' );
    //add_theme_support( 'editor-styles' );
    add_theme_support( 'responsive-embeds' );

	// Tamaño de imagenes
    add_image_size('feat_big_slider', 930, 692, true);
    add_image_size('feat_big_side', 450, 330, true);
    add_image_size('filter_category', 330, 220, true);

	// Stylesheet to the visual editor.
    //add_editor_style('editor-style.css');

}
add_action( 'after_setup_theme', 'theme_setup' );

/**
* Theme Scripts
*/
function theme_scripts_styles() 
{
    wp_enqueue_style( 'theme-google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,700', false );
    wp_enqueue_style( 'theme-bootstrap', get_template_directory_uri() . '/front/css/bootstrap.css', array(), THEME_STYLE_VERSION, 'all' );
    wp_enqueue_style( 'theme-style', get_template_directory_uri() . '/front/css/style.css', array(), THEME_STYLE_VERSION, 'all' );
    wp_enqueue_style( 'theme-fonts', get_template_directory_uri() . '/front/css/fonts.css', array(), THEME_STYLE_VERSION, 'all' );

    //Load custom jquery
    wp_deregister_script( 'jquery' ); 
    wp_register_script('jquery-custom', get_template_directory_uri() . '/front/js/jquery-2.2.4.min.js', false, '2.2.4', true);
    wp_enqueue_script('jquery-custom');

    wp_enqueue_script('theme-core', get_template_directory_uri() . '/front/js/core.min.js', array('jquery-custom'), THEME_STYLE_VERSION, true);
    wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/front/js/script.js', array('jquery-custom'), THEME_STYLE_VERSION, true);

    wp_enqueue_style( 'custom-styles', get_template_directory_uri() . '/css/custom-style.css', array(), THEME_STYLE_VERSION, 'all' );
}
add_action('wp_enqueue_scripts', 'theme_scripts_styles'); 

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
                            <?php if (is_front_page()) { ?>
                                <h1>
                            <?php } ?>
                                <a class="brand-name" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/front/images/logo-tynmag-retina.png" width="266"  alt="<?php bloginfo( 'name' ); ?>">
                                </a>
                            <?php if (is_front_page()) { ?>
                                </h1>
                            <?php } ?>
                        </div>
                        <div class="rd-navbar-collapse-toggle" data-rd-navbar-toggle=".rd-navbar-collapse"><span></span></div>
                        
                        <?php if ( has_nav_menu( 'primary_top_right' ) ) { ?>
                            <div class="rd-navbar-top-panel rd-navbar-collapse">
                                <div class="rd-navbar-top-panel-inner">
                                
                                    <?php wp_nav_menu( array(
                                        'theme_location'  => 'primary_top_right',
                                        'depth'           => 1, // 1 = no dropdowns, 2 = with dropdowns.
                                        'container'       => false,
                                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                        'menu_class'      => 'contact-list',
                                    ) ); ?>

                                </div>
                            </div>
                        <?php } ?>
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
                            <form id="searchform" class="rd-search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="GET">
                                <div class="form-wrap">
                                    <label class="form-label form-label" for="rd-navbar-search-form-input"><?php _e( 'Estoy buscando', THEME_TEXTDOMAIN ); ?>...</label>
                                    <input class="rd-navbar-search-form-input form-input" id="rd-navbar-search-form-input" type="text" name="s" autocomplete="off" value="<?php echo get_search_query(); ?>">
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
    $menu = preg_replace('/ current-menu-item /', ' active ', $menu);  
    $menu = preg_replace('/ current-menu-parent /', ' active ', $menu);  
    
    return $menu;  
    
}    
add_filter('wp_nav_menu','theme_submenu_class'); 

/**
* WP Body classes
*/
function theme_change_body_classes( $wp_classes ) {
     
    foreach($wp_classes as $key => $value) {
        if ($value == 'page') unset($wp_classes[$key]); //  Replaces "page" and removes it
    }

    return $wp_classes;
}
add_filter( 'body_class', 'theme_change_body_classes' );

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
* Add Bloques Reutilizables to admin menu
*/
function add_reusable_blocks_admin_menu() {
    add_menu_page( 'Bloques Reutilizables', 'Bloques Reutilizables', 'edit_posts', 'edit.php?post_type=wp_block', '', 'dashicons-editor-table', 22 );
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

/**
* Obtiene el enlace de compartir la pagina actual por Twitter
*
* @param int | WP_Post $post_id: Post ID del que obtener el link
*/
function theme_get_share_link_twitter ($post_id = null)
{
    $url = "";

    $url = "https://twitter.com/intent/tweet?source=webclient&amp;text=" . urlencode(html_entity_decode(get_the_title($post_id). " - ". get_the_permalink($post_id), ENT_COMPAT, 'UTF-8'));

    return $url;
}

/**
* Obtiene el enlace de compartir la pagina actual por Facebook
*
* @param int | WP_Post $post_id: Post ID del que obtener el link
*/
function theme_get_share_link_facebook ($post_id = null)
{
    $url = "";

    $url = "https://www.facebook.com/sharer.php?u=" . get_the_permalink($post_id) . "&amp;t=" . urlencode(html_entity_decode(get_the_title($post_id), ENT_COMPAT, 'UTF-8'));

    return $url;
}

/**
* Obtiene el enlace de compartir la pagina actual por Linkedin
*
* @param int | WP_Post $post_id: Post ID del que obtener el link
*/
function theme_get_share_link_linkedin ($post_id = null)
{
    $url = "";

    $url = "https://www.linkedin.com/shareArticle?mini=true&amp;url=" . get_the_permalink($post_id) . "&amp;title=" . urlencode(html_entity_decode(get_the_title($post_id), ENT_COMPAT, 'UTF-8')) . "&amp;summary=&amp;source=" . urlencode(html_entity_decode(get_bloginfo('name'), ENT_COMPAT, 'UTF-8'));

    return $url;
}

/**
* Obtiene el enlace de compartir la pagina actual por Whatsapp
*
* @param int | WP_Post $post_id: Post ID del que obtener el link
*/
function theme_get_share_link_whatsapp ($post_id = null)
{
    $url = "";

    $wa_domain = ( wp_is_mobile() ? 'whatsapp://' : 'https://web.whatsapp.com/' );

    $url = $wa_domain . "send?text=" . urlencode(get_the_title($post_id)) . " – " . urlencode(html_entity_decode(get_the_permalink($post_id), ENT_COMPAT, 'UTF-8'));

    return $url;
}

/**
 * Share block html
 */
function theme_share_block($post_id) {

    if ( empty($post_id) ) {
        return;
    }

    ?>
    <div class="share-block">
        <div class="soc-icon">
            <a class="icon fa-twitter" href="<?php echo theme_get_share_link_twitter($post_id); ?>" target="_blank" rel="nofollow"></a>
            <a class="icon fa-facebook-square" href="<?php echo theme_get_share_link_facebook($post_id); ?>" target="_blank" rel="nofollow"></a>
            <a class="icon fa-whatsapp" href="<?php echo theme_get_share_link_whatsapp($post_id); ?>" target="_blank" rel="nofollow"></a>
            <a class="icon fa-linkedin" href="<?php echo theme_get_share_link_linkedin($post_id); ?>" target="_blank" rel="nofollow"></a>
        </div>
        <span class="icon fa-share-alt"></span>
    </div>
    <?php
}

/**
 * Tag list html
 */
function theme_tag_list($categories) {

    if ( empty($categories) ) {
        return;
    }

    $i = 0;
    ?>
    <ul class="tag-list">
        <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo esc_url(get_category_link($category)); ?>"><?php echo $category->name; ?></a></li>
        <?php if (++$i == 2) break;
        } ?>
    </ul>
    <?php
}

/**
 * Meta list html
 */
function theme_meta_list($author_url, $author_name, $date) {

    if ( empty($author_url) && empty($author_name) && empty($date) ) {
        return;
    }
    ?>
    <ul class="meta-list">
        <li><a href="<?php echo esc_url($author_url); ?>"><?php echo $author_name; ?></a></li>
        <li><?php echo $date; ?></li>
    </ul>
    <?php
}

/**
 * Get post ids from other blocks
 */
function theme_get_posts_other_blocks($post_content) {

    if ( empty($post_content) ) {
        return;
    }

    $blocks = parse_blocks( $post_content );
    $post_ids = array();
     
    foreach ( $blocks as $block ) {
 
        if ( 'acf/slider-notas-destacadas' === $block['blockName'] ) {

            $rel_notas_slider = $block['attrs']['data']['rel_notas_slider'];
            if ( !empty($rel_notas_slider) ) {
                foreach ( $rel_notas_slider as $post_id ) {
                    $post_ids[] = $post_id;
                }
            }

            $rel_notas_derecho = $block['attrs']['data']['rel_notas_derecho'];
            if ( !empty($rel_notas_derecho) ) {
                foreach ( $rel_notas_derecho as $post_id ) {
                    $post_ids[] = $post_id;
                }
            }
             
        }
         
    }

    return $post_ids;
}

/**
 * WP Columns Block: change html
 */
function theme_columns_block_change_html ($block_content, $block) {
	if ( $block['blockName'] === 'core/columns' && !is_admin() && !wp_is_json_request() ) {
		$html = '';

		$html .= '<section class="bg-white section-bottom-60">' . "\n";
		$html .= '<div class="shell">' . "\n";
		$html .= '<div class="range range-center range-40">' . "\n";

		if (isset($block['innerBlocks'])) {
			foreach ($block['innerBlocks'] as $column) {
                $html .= '<div class="cell- theme-wp-block-fixer" style="flex-basis: '.$column['attrs']['width'].'; max-width: '.$column['attrs']['width'].';">';
                foreach ( $column['innerBlocks'] as $inner_block ) {
                    $html .= render_block( $inner_block ); 
                }
                $html .= '</div>';
			}
		}

		$html .= '</div>' . "\n";
		$html .= '</div>' . "\n";
		$html .= '</section>' . "\n";

		return $html;
	}

	return $block_content;
}

add_filter('render_block', 'theme_columns_block_change_html', null, 2);