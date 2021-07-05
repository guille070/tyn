<?php

/**
 * Listado de Noticias Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$txt_title = get_field('txt_title');
$num_noticias = get_field('num_noticias');
$rad_feed = get_field('rad_feed');
$rel_noticias = get_field('rel_noticias');

$posts_to_exclude = (get_post_meta( $post_id, '_post_ids_from_blocks', true )) ? get_post_meta( $post_id, '_post_ids_from_blocks', true ) : array();
?>

<section class="section-xs">
    <div class="shell">
        <div class="range range-50">
            <div class="cell-sm-12">
                <?php if ($txt_title) { ?>
                    <div class="section-title">
                        <h3><?php echo $txt_title; ?></h3>
                    </div>
                <?php } ?>

                <?php if ($rad_feed == 'auto') {
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

                    if (!empty($latest_posts)) {

                        $posts_feed = $latest_posts;

                    }
                } else {
                    if (!empty($rel_noticias)) {

                        $posts_feed = $rel_noticias;

                    }
                }
                
                if (!empty($posts_feed)) {

                    $posts_ids = array();
                    $posts_data = array();

                    foreach ( $posts_feed as $post ) {

                        if ($rad_feed == 'auto') setup_postdata( $post );

                        $posts_ids[] = $post->ID;
                        $posts_data[] = array(
                            'title' => get_the_title( $post->ID ),
                            'permalink' => get_the_permalink( $post->ID )
                        );
                    } 

                    if ($rad_feed == 'auto') wp_reset_postdata();
                }

                if (!empty($posts_ids)) {
                    theme_update_post_ids_from_blocks($post_id, $posts_ids);
                }
                ?>

                <?php if (!empty($posts_data)) { ?>
                    <ul class="post-list">
                        <?php foreach ( $posts_data as $post ) { ?>
                            <li><a href="<?php echo $post['permalink']; ?>"><?php echo $post['title']; ?></a></li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </div>
</section>