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
$range_columnas_tablets_desktop_img_small = get_field('range_columnas_tablets_desktop_img_small');
$rad_diseno = get_field('rad_diseno');

$posts_to_exclude = (get_post_meta( $post_id, '_post_ids_from_blocks', true )) ? get_post_meta( $post_id, '_post_ids_from_blocks', true ) : array();
?>

<section class="section-xs">
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
                $col_class = '6'; // 2 cols & default
                
                if ($rad_diseno == 'img_back') {
                    if ($range_columnas_tablets_desktop == 1) $col_class = '12';
                    if ($range_columnas_tablets_desktop == 3) $col_class = '4';
                    if ($range_columnas_tablets_desktop == 4) $col_class = '3';
                    if ($range_columnas_tablets_desktop == 5) $col_class = '1-5';

                    $html_range_classes = 'range-center range-30';
                } else {
                    if ($range_columnas_tablets_desktop_img_small == 1) $col_class = '12';
                    if ($range_columnas_tablets_desktop_img_small == 3) $col_class = '4';

                    $html_range_classes = 'range-20';
                }
                ?>

                <div class="range <?php echo $html_range_classes; ?> block-grilla-noticias">

                    <?php foreach ( $latest_posts as $post ) {
                        setup_postdata( $post );

                        $posts_ids[] = $post->ID;
                        $size_img = ($rad_diseno == 'img_back') ? 'feat_big_side' : 'grid_small';
                        $feat_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $size_img );
                        $title = get_the_title( $post->ID );
                        $permalink = get_the_permalink( $post->ID );
                        $categories = get_the_category( $post->ID );
                        $author_id = get_post_field( 'post_author', $post->ID );
                        $author_name = get_the_author_meta( 'display_name', $author_id );
                        $author_url = get_author_posts_url( $author_id );
                        $date = get_the_date( '', $post->ID );
                        ?>

                        <?php if ($rad_diseno == 'img_back') { ?>

                            <div class="cell-xs-10 cell-sm-<?php echo $col_class; ?>">
                                <div class="post-type-1 post-type-1-mode">
                                    <img src="<?php echo esc_url($feat_img[0]); ?>" width="<?php echo $feat_img[1]; ?>" height="<?php echo $feat_img[2]; ?>" alt="" />
                                        
                                    <?php echo theme_tag_list( $categories ); ?>

                                    <div class="caption">
                                        <h4 class="title"><a href="<?php echo esc_url($permalink); ?>"><?php echo $title; ?></a></h4>
                                        <div class="bottom-block">
                                            <?php echo theme_meta_list( $author_url, $author_name, $date ); ?>
                                            <?php echo theme_share_block( $post->ID ); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } else { ?>

                            <div class="cell-xs-<?php echo $col_class; ?> cell-sm-12 cell-lg-<?php echo $col_class; ?>">
                                <div class="post-type-3">
                                    <div class="unit unit-vertical unit-sm-horizontal">
                                        <div class="unit__left">
                                            <div class="img-block">
                                                <a href="<?php echo esc_url($permalink); ?>"><img src="<?php echo esc_url($feat_img[0]); ?>" width="<?php echo $feat_img[1]; ?>" height="<?php echo $feat_img[2]; ?>" alt="" /></a>

                                                <?php echo theme_tag_list( $categories ); ?>
                                            </div>
                                        </div>
                                        <div class="unit__body">
                                            <h5 class="title"><a href="<?php echo esc_url($permalink); ?>"><?php echo $title; ?></a></h5>
                                            <div class="bottom-block">
                                                <?php echo theme_meta_list( $author_url, $author_name, $date ); ?>
                                                <?php echo theme_share_block( $post->ID ); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>

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