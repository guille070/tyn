<?php
/**
    * Fichero PHP
    *
    * Funciones para registro de CPT
    *
    * @copyright Copyright (c) 2019 Elegra
*/

/**
* Register post types
*/
function theme_cpt_cpts()
{

    /****************** TAX Subseccion *********************/
    $labels = array(
        'name'              => __('Subsección', THEME_TEXTDOMAIN),
        'singular_name'     => __('Subsección', THEME_TEXTDOMAIN),
        'search_items'      => __('Search Subsección', THEME_TEXTDOMAIN),
        'all_items'         => __('All Subsección', THEME_TEXTDOMAIN),
        'parent_item'       => __('Subsección parent', THEME_TEXTDOMAIN),
        'parent_item_colon' => __('Subsección parent:', THEME_TEXTDOMAIN),
        'edit_item'         => __('Edit Subsección', THEME_TEXTDOMAIN),
        'update_item'       => __('Update Subsección', THEME_TEXTDOMAIN),
        'add_new_item'      => __('Add Subsección', THEME_TEXTDOMAIN),
        'new_item_name'     => __('New Subsección', THEME_TEXTDOMAIN),
        'menu_name'         => __('Subsección', THEME_TEXTDOMAIN),
    );

    register_taxonomy(
        'subseccion',
        array('post'),
        array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'rewrite'           => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'query_var'         => true,
        )
    );
    
}
add_action('init', 'theme_cpt_cpts');
?>