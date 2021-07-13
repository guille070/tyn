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

                    <?php if ( have_posts() ) { ?>
                        <div class="section-title">
                            <h3>Resultados de búsqueda</h3>
                        </div>

                        <?php while ( have_posts() ) : the_post();

                            $feat_img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'grid_small' );
                            $categories = get_the_category();
                            $signature = theme_get_post_signature( $post->ID );
                            $author_name = $signature['name'];
                            $author_url = $signature['url'];
                            $date = get_the_date();
                            ?>

                            <div class="post-type-3 post-type-3-modern">
                                <div class="unit unit-vertical unit-xs-horizontal">
                                    <div class="unit__left">
                                        <div class="img-block">
                                            <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($feat_img[0]); ?>" width="<?php echo $feat_img[1]; ?>" height="<?php echo $feat_img[2]; ?>" alt="" /></a>
                                        </div>
                                    </div>
                                    <div class="unit__body">
                                        <h5 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                        <p><?php echo wp_trim_words( get_the_content($post->ID), 25, '...' ); ?></p>
                                        <div class="bottom-block">
                                            <?php echo theme_meta_list( $author_url, $author_name, $date ); ?>
                                            <?php echo theme_tag_list( $categories, 'tag-list-type-1' ); ?>
                                            <?php echo theme_share_block( $post->ID ); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endwhile;
                    
                        echo theme_pagination();

                    } else { ?>

                        <div class="section-title">
                            <h3>No hay resultados para su búsqueda</h3>
                        </div>

                        <div class="txt-noresults">
                            <p>En este momento no se encontraron resultados para su búsqueda. Por favor, intente realizar una nueva búsqueda.</p>
                            <p class="gohome">Ir a la <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></p>
                        </div>

                        <?php echo theme_latest_posts(); ?>

                    <?php }; ?>

                </div>

            </div>

            <?php get_sidebar( 'right' ); ?>

        </div>
    </div>
</section>

<?php
get_footer();