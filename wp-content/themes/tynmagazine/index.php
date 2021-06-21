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


get_footer();
