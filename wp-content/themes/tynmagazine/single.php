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
$categories = get_the_category();
$signature = theme_get_post_signature( $post->ID );
$author_name = $signature['name'];
$author_url = $signature['url'];
$date = get_the_date();
$tags = get_the_tags();
$next_post = get_next_post();
$prev_post = get_previous_post();
?>

<section class="bg-white section-xs-type-1">
    <div class="shell">
        <div class="range range-center range-50">
            <div class="cell-md-8 cell-lg-8">
                <div class="post-content">
                    <?php echo theme_tag_list( $categories ); ?>

                    <h1 class="heading-2"><?php the_title(); ?></h1>

                    <?php echo theme_meta_list( $author_url, $author_name, $date ); ?>
                    
                    <?php if (!empty($feat_img)) { ?>
                        <img src="<?php echo esc_url($feat_img[0]); ?>" width="<?php echo $feat_img[1]; ?>" height="<?php echo $feat_img[2]; ?>" alt="" />
                    <?php } ?>
                    
                    <?php the_content(); ?>

                    <div class="tag-block bottom-block">
                        <div class="left-block">
                            <?php if (!empty($tags)) { ?>
                                <span class="icon fa-folder-o"></span>
                                <p class="text-italic">Tags: </p>
                                <?php echo theme_tag_list( $tags ); ?>
                            <?php } ?>
                        </div>
                        
                        <?php echo theme_share_block( $post->ID ); ?>
                    </div>
                </div>
                <?php if (!empty($prev_post) || !empty($next_post)) { ?>
                    <div class="post-nav">
                        <?php if (!empty($prev_post)) { ?>
                            <div class="prev-post">
                                <a href="<?php echo get_permalink( $prev_post->ID ); ?>">Artículo anterior</a>

                                <h5><a href="<?php echo get_permalink( $prev_post->ID ); ?>">
                                    <?php echo apply_filters( 'the_title', $prev_post->post_title ); ?>
                                </a></h5>
                            </div>
                        <?php } ?>
                        <?php if (!empty($next_post)) { ?>
                            <div class="next-post">
                                <a href="<?php echo get_permalink( $next_post->ID ); ?>">Artículo siguiente</a>
                                
                                <h5><a href="<?php echo get_permalink( $next_post->ID ); ?>">
                                    <?php echo apply_filters( 'the_title', $next_post->post_title ); ?>
                                </a></h5>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                
                <?php echo theme_related_posts($post->ID); ?>

            </div>

            <?php get_sidebar( 'right' ); ?>

        </div>
    </div>
</section>

<?php
get_footer();