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
        'footer_1' => __( 'Menu Footer 1', THEME_TEXTDOMAIN ),
        'footer_2' => __( 'Menu Footer 2', THEME_TEXTDOMAIN )
    ) );

    // Theme support
    add_theme_support( 'post-thumbnails' );
    //add_theme_support( 'editor-styles' );
    add_theme_support( 'responsive-embeds' );

	// Tamaño de imagenes
    add_image_size('feat_big_slider', 930, 692, true);
    add_image_size('feat_big_side', 450, 330, true);
    add_image_size('filter_category', 330, 220, true);
    add_image_size('grid_small', 158, 158, true);
    add_image_size('feat_post', 930, 99999, false);

	// Stylesheet to the visual editor.
    //add_editor_style('editor-style.css');

}
add_action( 'after_setup_theme', 'theme_setup' );

/**
* Add classic editor en posts
*/
function theme_gutenberg_post_template() {
    $post_type_object = get_post_type_object( 'post' );
    $post_type_object->template = array(
        array( 'core/freeform' ),
    );
}
add_action( 'init', 'theme_gutenberg_post_template' );

/**
* Google fonts
*/
function theme_google_fonts() { ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
<?php }
add_action('wp_head', 'theme_google_fonts', 0);

/**
* Theme Scripts
*/
function theme_scripts_styles() 
{
    wp_enqueue_style( 'theme-bootstrap', get_template_directory_uri() . '/front/css/bootstrap.css', array(), THEME_STYLE_VERSION, 'all' );
    wp_enqueue_style( 'theme-style', get_template_directory_uri() . '/front/css/style.css', array(), THEME_STYLE_VERSION, 'all' );
    wp_enqueue_style( 'theme-fonts', get_template_directory_uri() . '/front/css/fonts.css', array(), THEME_STYLE_VERSION, 'all' );

    //Load custom jquery
    //wp_deregister_script( 'jquery' ); 
    wp_register_script('jquery-custom', get_template_directory_uri() . '/front/js/jquery-2.2.4.min.js', false, '2.2.4', true);
    wp_enqueue_script('jquery-custom');

    wp_enqueue_script('theme-core', get_template_directory_uri() . '/front/js/core.min.js', array('jquery-custom'), THEME_STYLE_VERSION, true);
    wp_enqueue_script('theme-scripts', get_template_directory_uri() . '/front/js/script.js', array('jquery-custom'), THEME_STYLE_VERSION, true);

    wp_enqueue_style( 'custom-styles', get_template_directory_uri() . '/css/custom-style.css', array(), THEME_STYLE_VERSION, 'all' );
}
add_action('wp_enqueue_scripts', 'theme_scripts_styles'); 

/**
* Gutenberg: deny list blocks
*/
function theme_deny_list_blocks() {
    wp_enqueue_script( 'theme-deny-list-blocks', get_template_directory_uri() . '/js/theme.js', array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ), THEME_STYLE_VERSION );
}
add_action( 'enqueue_block_editor_assets', 'theme_deny_list_blocks' );

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
 * ACF Relationship jquery
 */
add_filter('acf/fields/relationship/query', 'theme_acf_fields_relationship_query', 10, 3);
function theme_acf_fields_relationship_query( $args, $field, $post_id ) {

    $args['post_status'] = array('publish', 'future');

    return $args;
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
function theme_get_header() {
    $img_logo = get_field('img_logo', 'option');
    $logo_url = ($img_logo['url']) ? $img_logo['url'] : get_stylesheet_directory_uri() . '/front/images/logo-tynmag-retina.png';
    $header_banner_desktop = do_shortcode( "[banner group='header-728x90']" );
    $header_banner_movil = do_shortcode( "[banner group='header-300x90']" );
    ?>

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
                                    <img src="<?php echo $logo_url; ?>" width="266"  alt="<?php bloginfo( 'name' ); ?>">
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
    
    <?php if ($header_banner_desktop!=='' || $header_banner_movil!=='') { ?>
        <section class="section-xs header-banner">
            <div class="shell">
                <div class="range range-center">
                    <div class="cell-sm-12">
                        <div class="hidden-xs">
                            <?php echo $header_banner_desktop; ?>
                        </div>
                        <div class="visible-xs">
                            <?php echo $header_banner_movil; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>

<?php
}

/**
* Change classes to WP Submenu 
*/
function theme_submenu_class($menu) {
    
    $menu = preg_replace('/ class="sub-menu"/', '/ class="rd-navbar-dropdown" /', $menu);  
    $menu = preg_replace('/ current-menu-item /', ' active ', $menu);  
    //$menu = preg_replace('/ current-menu-parent /', ' active ', $menu);  
    
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
* Obtiene el enlace de compartir la pagina actual por Telegram
*
* @param int | WP_Post $post_id: Post ID del que obtener el link
*/
function theme_get_share_link_telegram ($post_id = null)
{
    $url = "";

    $url = "https://t.me/share/url?url=" . get_the_permalink($post_id) . "&amp;text=" . urlencode(html_entity_decode(get_the_title($post_id), ENT_COMPAT, 'UTF-8'));

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
            <a class="icon fa-facebook-square" href="<?php echo theme_get_share_link_facebook($post_id); ?>" target="_blank" rel="nofollow" title="Facebook"></a>
            <a class="icon fa-twitter" href="<?php echo theme_get_share_link_twitter($post_id); ?>" target="_blank" rel="nofollow" title="Twitter"></a>
            <a class="icon fa-whatsapp" href="<?php echo theme_get_share_link_whatsapp($post_id); ?>" target="_blank" rel="nofollow" title="Whatsapp"></a>
            <a class="icon fa-linkedin" href="<?php echo theme_get_share_link_linkedin($post_id); ?>" target="_blank" rel="nofollow" title="Linkedin"></a>
            <a class="icon fa-telegram" href="<?php echo theme_get_share_link_telegram($post_id); ?>" target="_blank" rel="nofollow" title="Telegram"></a>
        </div>
        <span class="icon fa-share-alt"></span>
    </div>
    <?php
}

/**
 * Get post Signature meta
 */
function theme_get_post_signature( $post_id ) {
    if ( empty($post_id) ) {
        return;
    }

    $author_data = array();
    $post_signature = get_post_meta($post_id, 'post_signature', true );

    if ($post_signature == 0) {
        $author_id = (get_field('post_user_default', 'option')['ID']) ? get_field('post_user_default', 'option')['ID'] : 42;
    } else {
        $author_id = get_post_field( 'post_author', $post_id );
    }

    $author_data['name'] = get_the_author_meta( 'display_name', $author_id );
    $author_data['url'] = get_author_posts_url( $author_id );

    return $author_data;
}

/**
 * Tag list html
 */
function theme_tag_list($categories, $class_name = 'tag-list') {

    if ( empty($categories) ) {
        return;
    }

    $i = 0;
    ?>

    <ul class="<?php echo $class_name; ?>">
        <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo esc_url(get_category_link($category)); ?>"><?php echo $category->name; ?></a></li>
        <?php if (!is_single() && ++$i == 2) break;
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

    $pre_txt = (is_single()) ? 'Por' : '';
    ?>

    <ul class="meta-list">
        <li><?php echo $pre_txt . ' '; ?><a href="<?php echo esc_url($author_url); ?>"><?php echo $author_name; ?></a></li>
        <li><?php echo $date; ?></li>
    </ul>
    <?php
}

/**
 * Newsletter html
 */
function theme_newsletter_html() {
    $txt_newsletter = get_field('txt_titulo_newsletter', 'option');
    $bajada_newsletter = get_field('wysiwyg_bajada_newsletter', 'option');
    $script_newsletter = get_field('txa_script_newsletter', 'option');
    ?>
    
    <div class="block-form-newsletter">
        <?php 
        if ($txt_newsletter!=='') echo '<h3>' . $txt_newsletter . '</h3>';
        if ($bajada_newsletter!=='') echo $bajada_newsletter;
        
        echo $script_newsletter;
        ?>
    </div>

    <?php
}

/**
 * Redes sociales html
 */
function theme_redessociales_html() {
    $txt_redes = get_field('txt_titulo_redes_sociales', 'option');
    $bajada_redes = get_field('wysiwyg_bajada_redes_sociales', 'option');
    $rep_redes_sociales = 'rep_redes_sociales';
    ?>

    <div class="section-subscribe">

        <?php 
        if ($txt_redes!=='') echo '<h3>' . $txt_redes . '</h3>';
        if ($bajada_redes!=='') echo $bajada_redes;
        
        if ( have_rows($rep_redes_sociales, 'option') ) { ?>
            <div class="soc-icon">
                <?php while( have_rows($rep_redes_sociales, 'option') ): the_row();
                    $type = get_sub_field('sel_red_social');
                    $url = get_sub_field('txt_url_red_social');
                    ?>

                    <a class="icon <?php echo $type; ?>" href="<?php echo $url; ?>" target="_blank" rel="nofollow"></a>

                <?php endwhile; ?>
            </div>
        <?php } ?>

    </div>

    <?php
}

/**
 * Update post ids from blocks
 */
function theme_update_post_ids_from_blocks($post_id, $posts_ids_block) {
    if ( empty($posts_ids_block) ) {
        return;
    }
    
    if ( ! add_post_meta( $post_id, '_post_ids_from_blocks', $posts_ids_block, true ) ) { 
        $existing_ids = get_post_meta( $post_id, '_post_ids_from_blocks', true );
        $diff = array_diff($posts_ids_block, $existing_ids);
        
        if (!empty($existing_ids) && !empty($diff)) {
            $posts_ids_block = array_merge($existing_ids, $posts_ids_block);
        }

        update_post_meta ( $post_id, '_post_ids_from_blocks', $posts_ids_block );
    }
}

/**
 * Get post ids from blocks
 */
function theme_get_post_ids_from_blocks($post_id) {
    if ( empty($post_id) ) {
        return;
    }

    $meta = (get_post_meta( $post_id, '_post_ids_from_blocks', true )) ? get_post_meta( $post_id, '_post_ids_from_blocks', true ) : array();

    return $meta;
}

/**
 * WP Columns Block: change html
 */
function theme_columns_block_change_html ($block_content, $block) {
	if ( $block['blockName'] === 'core/columns' && !is_admin() && !wp_is_json_request() ) {
		
        $html = '<section class="bg-white">' . "\n";
		$html .= '<div class="shell">' . "\n";
        $html .= $block_content;
		$html .= '</div>' . "\n";
		$html .= '</section>' . "\n";

		return $html;
	}

	return $block_content;
}
add_filter('render_block', 'theme_columns_block_change_html', 10, 2);

/**
 * Related posts
 */
function theme_related_posts($post_id) {
    $related_posts = get_posts( 
        array( 
            'category__in' => wp_get_post_categories($post_id), 
            'numberposts' => 3, 
            'post__not_in' => array($post_id) 
        )
    );

    if( $related_posts ) { ?>

        <div class="range rel-posts">
            <div class="cell-xs-12">
                <div class="section-title">
                    <h3>Notas Relacionadas</h3>
                </div>
            </div>

            <?php foreach( $related_posts as $post ) {
                setup_postdata($post);

                $feat_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'filter_category' );
                $categories = get_the_category($post->ID);
                $title = get_the_title($post->ID);
                $permalink = get_the_permalink($post->ID);
                ?>
                
                <div class="cell-xs-10 cell-sm-4 elem-item">
                    <div class="post-type-2">
                        <div class="img-block">
                            <a href="<?php echo esc_url($permalink); ?>">
                                <img src="<?php echo esc_url($feat_img[0]); ?>" width="<?php echo $feat_img[1]; ?>" height="<?php echo $feat_img[2]; ?>" alt="" />
                            </a>
                            
                            <?php echo theme_tag_list( $categories ); ?>
                        </div>
                        <div class="caption">
                            <h5><a href="<?php echo esc_url($permalink); ?>"><?php echo $title; ?></a></h5>
                        </div>
                    </div>
                </div>

            <?php }
            wp_reset_postdata(); ?>
        </div>
    <?php }
}

/**
 * Get Breadcrumbs (Yoast SEO)
 */
function theme_add_breadcrumbs() {
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb();
    }
}

/**
 * Yoast Breadcrumbs: Output wrapper
 */
add_filter( 'wpseo_breadcrumb_output_wrapper', 'theme_breadcrumb_output_wrapper', 10, 1 );
function theme_breadcrumb_output_wrapper( $wrapper ) {
    $wrapper = 'ul';
    return $wrapper;
}

/**
 * Yoast Breadcrumbs: Output class
 */
add_filter( 'wpseo_breadcrumb_output_class', 'theme_breadcrumb_output_class', 10, 1 );
function theme_breadcrumb_output_class( $class ) {
    $class = 'breadcrumb-custom-type-1';
    return $class;
}

/**
 * Yoast Breadcrumbs: Single link wrapper
 */
add_filter( 'wpseo_breadcrumb_single_link_wrapper', 'theme_breadcrumb_single_link_wrapper', 10, 1 );
function theme_breadcrumb_single_link_wrapper( $element ) {
    $element = 'li';
    return $element;
}

/**
 * Pagination
 */
function theme_pagination() {
    $args = array(
        'type'      => 'list',
        'mid_size'  => 2,
    );

    $pagination = get_the_posts_pagination( $args );
    $pagination = str_replace( "<ul class='page-numbers'>", '<ul class="pagination-custom">', $pagination );

    $html = '<div class="section-xs text-left">';
    $html .= $pagination;
    $html .= '</div>';

    return $html;
}

/**
 * Latest posts
 */
function theme_latest_posts() {
    $latest_posts = get_posts( 
        array( 
            'numberposts' => 6
        )
    );

    if( $latest_posts ) { ?>

        <div class="section-xs bg-white">
            <div class="range range-20">
                <div class="cell-xs-12">
                    <div class="section-title">
                        <h4>Mira nuestras últimas noticias</h4>
                    </div>
                </div>

                <?php foreach( $latest_posts as $post ) {
                    setup_postdata($post);

                    $feat_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'grid_small' );
                    $categories = get_the_category( $post->ID );
                    $title = get_the_title($post->ID);
                    $permalink = get_the_permalink($post->ID);
                    $signature = theme_get_post_signature( $post->ID );
                    $author_name = $signature['name'];
                    $author_url = $signature['url'];
                    $date = get_the_date( '', $post->ID );
                    ?>
                    
                    <div class="cell-xs-6 cell-md-12 cell-lg-6">
                        <div class="post-type-3">
                            <div class="unit unit-vertical unit-sm-horizontal">
                                <div class="unit__left">
                                    <div class="img-block">
                                        <a href="<?php echo $permalink; ?>"><img src="<?php echo esc_url($feat_img[0]); ?>" width="<?php echo $feat_img[1]; ?>" height="<?php echo $feat_img[2]; ?>" alt="" /></a>
                                        <?php echo theme_tag_list( $categories ); ?>
                                    </div>
                                </div>
                                <div class="unit__body">
                                    <h5 class="title"><a href="<?php echo $permalink; ?>"><?php echo $title; ?></a></h5>
                                    <div class="bottom-block">
                                        <?php echo theme_meta_list( $author_url, $author_name, $date ); ?>
                                        <?php echo theme_share_block( $post->ID ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php }
                wp_reset_postdata(); ?>
            </div>
        </div>

    <?php }
}

/**
 * Allowed blocks
 */
function theme_allowed_blocks($allowed_block_types, $post) {

    $template = get_page_template_slug($post);

    if ($template == 'pag_tyn-newsletter3.php') {
        return [
            'acf/newsletter-configurador'
        ];
    }

    return $allowed_block_types;

}
add_filter('allowed_block_types', 'theme_allowed_blocks', 10, 2);

/**
 * Newsletter HTML
 */
function theme_print_newsletter_html( $post_id ) {

    if (empty($post_id)) return;

    $title = get_the_title( $post_id );
    $url = get_permalink( $post_id );
    $post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), array(450,315) );
    ?>

    <div style="width: 320px; display: inline-block; vertical-align: top; margin-top: 3px;">
        <table width="310" height="300" bgcolor="#f6f6f6" valign="top">
            <tr>
                <td height="95" valign="top" style="padding: 5px 5px 0 5px; width: 294px;">
                <h1 id="Titulo1" style="color: #c9000a; text-align: left; font-size: 22px; font-family: Arial; font-weight: bold; line-height: 120%; margin: 0"><a style="color: #c9000a" href="<?php echo $url;?>"><?php echo $title;?></a></h1>
                </td>
            </tr>
            <tr>
                <td id="Imagen1" height="200px" valign="top" style="padding: 2px 5px 5px 5px;"><a style="color: #c9000a" href="<?php echo $url;?>"><img src="<?php echo $post_image[0];?>" width="297" height="208"/></a>
                </td>
            </tr>
        </table>
    </div>

    <?php
}

/**
 * Newsletter Banners
 */
function theme_print_newsletter_banner( $banner_id ) {

    if (empty($banner_id)) return;

    $shortcode = do_shortcode( '[banner id='.$banner_id.']' );
    $shortcode = preg_replace('/ custom-banners-theme-standard-white" /', ' custom-banners-theme-standard-white" style="border: 0; position: relative; width: 100%;" ', $shortcode);  
    $shortcode = preg_replace('/ class="custom_banners_big_link" /', ' class="custom_banners_big_link" style="position: absolute; top: 0; right: 0; bottom: 0; left: 0; z-index: 999;" ', $shortcode);  
    ?>

    <div style="width: 320px; display: inline-block; vertical-align: top; margin-top: 3px;">
        <table width="100%">
            <tr>
                <td style="text-align: center;">
                    <?php echo $shortcode; ?>
                </td>
            </tr>
        </table>
    </div>

    <?php
}