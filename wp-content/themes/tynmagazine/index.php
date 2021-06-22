<?php
/**
 * Fichero PHP
 *
 * Define el template de la pagina principal
 *
 * @copyright Copyright (c) 2020 Dandy Agency
*/

get_header();

    while(have_posts()) { the_post();
        the_content();
    }
    
     
    $blocks = parse_blocks( $post->post_content );
     
    foreach ( $blocks as $block ) {
 
        if ( 'acf/featured-big' === $block['blockName'] ) {
             
            //var_dump($block);
             
        }
         
    }


get_footer();