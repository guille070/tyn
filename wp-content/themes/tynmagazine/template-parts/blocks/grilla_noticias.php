<?php

/**
 * Grilla de Noticias Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$txt_title = get_field('txt_title');
$num_noticias = get_field('num_noticias');
$range_columnas_tablets_desktop = get_field('range_columnas_tablets_desktop');

$posts_to_exclude = (get_post_meta( $post_id, '_post_ids_from_blocks', true )) ? get_post_meta( $post_id, '_post_ids_from_blocks', true ) : array();
?>

<section class="section-xs bg-white">
    <div class="shell">
        <div class="range">

            <?php if ($txt_title) { ?>
                <div class="cell-xs-12">
                    <div class="section-title">
                        <h3><?php echo $txt_title; ?></h3>
                    </div>
                </div>
            <?php } ?>

            <?php 
            $args = array(
                'post_type'         => 'post',
                'posts_per_page'    => $num_noticias,
                'fields'            => 'ids',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'subseccion',
                        'field' => 'slug',
                        'terms' => array('home'),
                        'operator' => 'IN',
                    )
                )
            );

            if (!empty($posts_to_exclude)) {
                $args['post__not_in'] = $posts_to_exclude;
            }
            
            $latest_posts = get_posts( $args );
            ?>

            <?php if (!empty($latest_posts)) {

                $posts_ids = array();

                if ($range_columnas_tablets_desktop == 2 || $range_columnas_tablets_desktop=='') $col_class = 'cell-sm-6';
                if ($range_columnas_tablets_desktop == 3) $col_class = 'cell-sm-4';
                if ($range_columnas_tablets_desktop == 4) $col_class = 'cell-sm-3';
                if ($range_columnas_tablets_desktop == 5) $col_class = 'cell-sm-1-5';
                ?>

                <div class="range range-center range-30 block-grilla-noticias">

                    <?php foreach ( $latest_posts as $postid ) {

                        $posts_ids[] = $postid;
                        $feat_img = wp_get_attachment_image_src( get_post_thumbnail_id( $postid ), 'feat_big_side' );
                        $title = get_the_title( $postid );
                        $permalink = get_the_permalink( $postid );
                        $categories = get_the_category( $postid );
                        $author_id = get_post_field( 'post_author', $postid );
                        $author_name = get_the_author_meta( 'display_name', $author_id );
                        $author_url = get_author_posts_url( $author_id );
                        $date = get_the_date( '', $postid );
                        ?>

                        <div class="cell-xs-10 <?php echo $col_class; ?>">
                            <div class="post-type-1 post-type-1-mode">
                                <img src="<?php echo esc_url($feat_img[0]); ?>" width="<?php echo $feat_img[1]; ?>" height="<?php echo $feat_img[2]; ?>" alt="" />
                                    
                                <?php echo theme_tag_list( $categories ); ?>

                                <div class="caption">
                                    <h4 class="title"><a href="<?php echo esc_url($permalink); ?>"><?php echo $title; ?></a></h4>
                                    <div class="bottom-block">
                                        <?php echo theme_meta_list( $author_url, $author_name, $date ); ?>
                                        <?php echo theme_share_block( $postid ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } 
                    wp_reset_postdata();

                    if (!empty($posts_ids)) {
                        theme_update_post_ids_from_blocks($post_id, $posts_ids);
                    } ?>

                </div>

            <?php } ?>
        </div>
    </div>
</section>