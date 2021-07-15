<?php
/**
 * Fichero PHP
 *
 * Define el template de la pagina principal
 *
 * @copyright Copyright (c) 2020 Dandy Agency
*/

get_header();

$feat_img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'feat_post' );
$signature = theme_get_post_signature( $post->ID );
$author_name = $signature['name'];
$author_url = $signature['url'];
$date = get_the_date();
?>

<section class="bg-white section-xs-type-1">
    <div class="shell">
        <div class="range range-center range-50">
            <div class="cell-md-8 cell-lg-8">
                <?php echo theme_add_breadcrumbs(); ?>
                
                <div class="post-content">

                    <h1 class="heading-2"><?php the_title(); ?></h1>

                    <?php echo theme_meta_list( $author_url, $author_name, $date ); ?>
                    
                    <?php if (!empty($feat_img)) { ?>
                        <img src="<?php echo esc_url($feat_img[0]); ?>" width="<?php echo $feat_img[1]; ?>" height="<?php echo $feat_img[2]; ?>" alt="" />
                    <?php } ?>
                    
                    <?php the_content(); ?>

                    <div class="tag-block bottom-block">
                        <div class="left-block">
                        </div>
                        
                        <?php echo theme_share_block( $post->ID ); ?>
                    </div>
                </div>

            </div>

            <?php get_sidebar( 'right' ); ?>

        </div>
    </div>
</section>

<?php
get_footer();