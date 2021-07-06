<?php

/**
 * Espacio Patrocinado Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$txt_title = get_field('txt_title');
$term = get_field('sel_term_notas_patrocinadas');
$term_img = get_field('img_patrocinador', $term);
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

            <?php if ($term_img) { ?>
                <div class="cell-lg-3 text-left">
                    <img src="<?php echo $term_img['sizes']['medium']; ?>" alt="" />
                </div>
            <?php } ?>

            <?php 
            $args = array(
                'post_type'         => 'post',
                'posts_per_page'    => 6,
                'tax_query' => array(
                    array(
                        'taxonomy' => $term->taxonomy,
                        'field'    => 'slug',
                        'terms'    => $term->slug,
                    ),
                )
            );
            
            $latest_posts = get_posts( $args );
            ?>

            <?php if (!empty($latest_posts)) { ?>

                <div class="range range-20">

                    <?php foreach ( $latest_posts as $post ) {
                        setup_postdata( $post );

                        $title = get_the_title( $post->ID );
                        $permalink = get_the_permalink( $post->ID );
                        $signature = theme_get_post_signature( $post->ID );
                        $author_name = $signature['name'];
                        $author_url = $signature['url'];
                        $date = get_the_date( '', $post->ID );
                        ?>

                        <div class="cell-xs-6 cell-sm-12 cell-lg-6">
                            <div class="post-type-3">
                                <div class="unit unit-vertical unit-sm-horizontal">
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

                    <?php } 
                    wp_reset_postdata();
                    ?>

                </div>

            <?php } ?>

        </div>
    </div>
</section>