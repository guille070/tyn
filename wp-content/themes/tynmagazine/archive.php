<?php
/**
 * Fichero PHP
 *
 * Define el template de la pagina principal
 *
 * @copyright Copyright (c) 2020 Dandy Agency
*/

get_header();

$i=1;
?>

<section class="bg-white section-xs-type-1">
    <div class="shell">
        <div class="range range-center range-50">
            <div class="cell-md-8 cell-lg-8">
                <?php echo theme_add_breadcrumbs(); ?>

                <?php if ( have_posts() ) : ?>
                    
                    <div class="range range-center range-30">

                        <?php while ( have_posts() ) : the_post();

                            $feat_img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'feat_big_side' );
                            $categories = get_the_category();
                            $signature = theme_get_post_signature( $post->ID );
                            $author_name = $signature['name'];
                            $author_url = $signature['url'];
                            $date = get_the_date();

                            if ( $i==1 || $i<=4 ) {
                            ?>

                            <div class="cell-xs-9 cell-sm-6">
                                <div class="post-type-1 post-type-1-mode-1">
                                    <img src="<?php echo esc_url($feat_img[0]); ?>" width="<?php echo $feat_img[1]; ?>" height="<?php echo $feat_img[2]; ?>" alt="" />
                                    <?php echo theme_tag_list( $categories ); ?>

                                    <div class="caption">
                                        <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <div class="bottom-block">
                                            <?php echo theme_meta_list( $author_url, $author_name, $date ); ?>
                                            <?php echo theme_share_block( $post->ID ); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php }

                        if ($i==4) {
                            $i++;
                            break;
                        } 

                        $i++;
                        endwhile; ?>
                        
                    </div>
                    

                    <div class="section-xs bg-white">
                        <div class="range range-20">

                        <?php while ( have_posts() ) : the_post();

                            $feat_img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'grid_small' );
                            $categories = get_the_category();
                            $signature = theme_get_post_signature( $post->ID );
                            $author_name = $signature['name'];
                            $author_url = $signature['url'];
                            $date = get_the_date();

                            if ( $i>=5 && $i<=10 ) {
                            ?>

                            <div class="cell-xs-6 cell-md-12 cell-lg-6">
                                <div class="post-type-3">
                                    <div class="unit unit-vertical unit-sm-horizontal">
                                        <div class="unit__left">
                                            <div class="img-block">
                                                <a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url($feat_img[0]); ?>" width="<?php echo $feat_img[1]; ?>" height="<?php echo $feat_img[2]; ?>" alt="" /></a>
                                                <?php echo theme_tag_list( $categories ); ?>
                                            </div>
                                        </div>
                                        <div class="unit__body">
                                            <h5 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                            <div class="bottom-block">
                                                <?php echo theme_meta_list( $author_url, $author_name, $date ); ?>
                                                <?php echo theme_share_block( $post->ID ); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php }

                            if ($i==10) {
                                $i++;
                                break;
                            } 

                            $i++;
                            endwhile; ?>
                            
                        </div>
                    </div>


                    <div class="section-xs bg-white">
                        <?php while ( have_posts() ) : the_post();

                            $feat_img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'grid_small' );
                            $categories = get_the_category();
                            $signature = theme_get_post_signature( $post->ID );
                            $author_name = $signature['name'];
                            $author_url = $signature['url'];
                            $date = get_the_date();

                            if ( $i>=11 && $i<=13 ) {
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

                        <?php }

                            $i++;
                            endwhile; ?>
                    </div>

                <?php endif;

                echo theme_pagination();

                ?>

            </div>

            <?php get_sidebar( 'right' ); ?>

        </div>
    </div>
</section>

<?php
get_footer();