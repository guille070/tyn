<?php

/**
 * Filtro Categorias Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$txt_title = get_field('txt_title');
$rel_categorias = get_field('rel_categorias');

?>

<section class="section-sm bg-white">
    <div class="shell">
        <div class="range">
            <div class="cell-xs-12">
                <div class="section-title">
                    <?php if ($txt_title) { ?>
                        <h3><?php echo $txt_title; ?></h3>
                    <?php } ?>

                    <?php if ($rel_categorias) {
                        $i = 0;
                        ?>
                        <div class="isotope-filters isotope-filters-horizontal">
                            <button class="isotope-filters-toggle isotope-filters-toggle-1 button" data-custom-toggle="#isotope-filters" data-custom-toggle-disable-on-blur="true">Filtro<span class="caret"></span></button>

                            <ul class="isotope-filters-list" id="isotope-filters">
                                <?php foreach ($rel_categorias as $category_id) {
                                    $category_obj = get_category($category_id);
                                    ?>

                                    <li>
                                        <a <?php echo ($i==0) ? 'class="active"' : ''; ?> data-isotope-filter="<?php echo $category_obj->slug; ?>" data-isotope-group="gallery" href="#"><?php echo $category_obj->name; ?></a>
                                    </li>
                                    
                                <?php 
                                    $i++;
                                } ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <?php if ($rel_categorias) { ?>
                <div class="cell-xs-12">   
                    <div class="row">
                        <div class="isotope" data-isotope-layout="fitRows" data-isotope-group="gallery">
                            <div class="row">
                                <?php foreach ($rel_categorias as $category_id) {
                                    $category_obj = get_category($category_id);

                                    $args = array(
                                        'numberposts'   => 4,
                                        'category'      => $category_id,
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => 'subseccion',
                                                'field' => 'slug',
                                                'terms' => array('home'),
                                                'operator' => 'IN',
                                            )
                                        )
                                    );
                                    
                                    $latest_posts = get_posts( $args );
                                    ?>

                                    <?php if ($latest_posts) {
                                        foreach ( $latest_posts as $post ) {
                                            setup_postdata( $post );

                                            $feat_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'filter_category' );
                                            $title = get_the_title( $post->ID );
                                            $permalink = get_the_permalink( $post->ID );
                                            $categories = get_the_category( $post->ID );
                                            $author_id = get_post_field( 'post_author', $post->ID );
                                            $author_name = get_the_author_meta( 'display_name', $author_id );
                                            $author_url = get_author_posts_url( $author_id );
                                            $date = get_the_date( '', $post->ID );
                                            ?>

                                            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 isotope-item" data-filter="<?php echo $category_obj->slug; ?>">
                                                <div class="post-type-2">
                                                    <div class="img-block">
                                                        <a href="<?php echo esc_url($permalink); ?>">
                                                            <img src="<?php echo esc_url($feat_img[0]); ?>" width="<?php echo $feat_img[1]; ?>" height="<?php echo $feat_img[2]; ?>" alt="" />
                                                        </a>
                                                        
                                                        <?php echo theme_tag_list( $categories ); ?>
                                                    </div>
                                                    <div class="caption">
                                                        <h5><a href="<?php echo esc_url($permalink); ?>"><?php echo $title; ?></a></h5>
                                                        <p><?php echo wp_trim_words( get_the_content($post->ID), 25, '...' ); ?></p>
                                                        <div class="bottom-block">
                                                            <?php echo theme_meta_list( $author_url, $author_name, $date ); ?>
                                                            <?php echo theme_share_block( $post->ID ); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php }
                                    wp_reset_postdata();
                                    } ?>
                                    
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>