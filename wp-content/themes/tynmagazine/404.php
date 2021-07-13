<?php
/**
 * Fichero PHP
 *
 * Define el template de la pagina principal
 *
 * @copyright Copyright (c) 2020 Dandy Agency
*/

get_header();
?>

<section class="bg-white section-xs-type-1">
    <div class="shell">
        <div class="range range-center range-50">
            <div class="cell-md-8 cell-lg-8">
                <?php echo theme_add_breadcrumbs(); ?>
                
                <div class="section-xs bg-white">

                    <div class="section-title">
                        <h3>Página no encontrada</h3>
                    </div>

                    <div class="txt-noresults">
                        <p>Lo sentimos, pero la página que estás buscando no existe.</p>
                        <p class="gohome">Ir a la <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></p>
                    </div>

                    <?php echo theme_latest_posts(); ?>

                </div>

            </div>

            <?php get_sidebar( 'right' ); ?>

        </div>
    </div>
</section>

<?php
get_footer();