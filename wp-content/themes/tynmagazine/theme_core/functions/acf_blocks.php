<?php
/**
    * Fichero PHP
    *
    * Funciones para los bloques de ACF - Gutenberg
    *
    * @copyright Copyright (c) 2021 Dandy Agency
*/

function register_acf_block_types() {
    
    $path = 'template-parts/blocks/';

    $blocks = array(
        array(
            'name'              => 'hero-image',
            'title'             => __('Hero Image', THEME_TEXTDOMAIN),
            'render_template'   => $path . 'hero-image_acf-fields.php',
            'icon'              => 'format-image'
        ),
    );
    
    if ($blocks) {
        foreach ($blocks as $block) {
            acf_register_block_type(array(
                'name'              => $block['name'],
                'title'             => $block['title'],
                'render_template'   => $block['render_template'],
                'icon'              => $block['icon'],
                'category'          => 'tyn',
                'mode'              => ($block['mode']) ? $block['mode'] : 'preview'
            ));
        }
    }

}

if( function_exists('acf_register_block_type') ) {
    //add_action('acf/init', 'register_acf_block_types');
}