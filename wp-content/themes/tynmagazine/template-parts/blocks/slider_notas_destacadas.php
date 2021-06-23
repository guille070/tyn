<?php

/**
 * Slider y Notas destacadas Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$rel_notas_slider = get_field('rel_notas_slider');
$rel_notas_derecho = get_field('rel_notas_derecho');

?>

<section class="section-xs bg-white">
    <div class="shell">
        <div class="range range-center range-30">
            <?php if ($rel_notas_slider) { ?>
                <div class="cell-lg-8">
                    <!-- Swiper-->
                    <div class="swiper-container swiper-slider swiper-slider-type-1" data-loop="false" data-autoplay="false" data-simulate-touch="false">
                        <div class="swiper-wrapper">
                            <?php foreach ($rel_notas_slider as $post_id) {
                                $feat_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'feat_big_slider' );
                                $link = get_permalink( $post_id );
                                $title = get_the_title( $post_id );
                                $categories = get_the_category( $post_id );
                                $author_id = get_post_field( 'post_author', $post_id );
                                $author_name = get_the_author_meta( 'display_name', $author_id );
                                $author_url = get_author_posts_url( $author_id );
                                $date = get_the_date( '', $post_id );
                                ?>

                                <div class="swiper-slide">
                                    <div class="swiper-slide-caption">
                                        <div class="post-type-1 post-type-1-mode">
                                            <img src="<?php echo esc_url($feat_img[0]); ?>" width="<?php echo $feat_img[1]; ?>" height="<?php echo $feat_img[2]; ?>" alt="" />
                                            <?php if ($categories) {
                                                $i = 0; ?>
                                                <ul class="tag-list">
                                                    <?php foreach ($categories as $category) { ?>
                                                        <li><a href="<?php echo esc_url(get_category_link($category)); ?>"><?php echo $category->name; ?></a></li>
                                                    <?php if (++$i == 2) break;
                                                    } ?>
                                                </ul>
                                            <?php } ?>
                                            <div class="caption">
                                                <h2 class="title"><a href="<?php echo esc_url($link); ?>"><?php echo $title; ?></a></h2>
                                                <ul class="meta-list">
                                                    <li><a href="<?php echo esc_url($author_url); ?>"><?php echo $author_name; ?></a></li>
                                                    <li><?php echo $date; ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <?php if (count($rel_notas_slider) > 1) { ?>
                            <!-- Swiper Pagination-->
                            <div class="swiper-pagination"></div>
                            <!-- Swiper Navigation-->
                            <div class="swiper-button-prev fa-arrow-left"></div>
                            <div class="swiper-button-next fa-arrow-right"></div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>

            <?php if ($rel_notas_derecho) { ?>
                <div class="cell-lg-4">
                    <div class="range range-center range-30">
                        <?php foreach ($rel_notas_derecho as $post_id) {
                            $feat_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'feat_big_side' );
                            $link = get_permalink( $post_id );
                            $title = get_the_title( $post_id );
                            $categories = get_the_category( $post_id );
                            $author_id = get_post_field( 'post_author', $post_id );
                            $author_name = get_the_author_meta( 'display_name', $author_id );
                            $author_url = get_author_posts_url( $author_id );
                            $date = get_the_date( '', $post_id );
                            ?>
                            <div class="cell-xs-6 cell-sm-6 cell-lg-12">
                                <div class="post-type-1">
                                    <img src="<?php echo esc_url($feat_img[0]); ?>" width="<?php echo $feat_img[1]; ?>" height="<?php echo $feat_img[2]; ?>" alt="" />
                                    <?php if ($categories) {
                                        $i = 0; ?>
                                        <ul class="tag-list">
                                            <?php foreach ($categories as $category) { ?>
                                                <li><a href="<?php echo esc_url(get_category_link($category)); ?>"><?php echo $category->name; ?></a></li>
                                            <?php if (++$i == 2) break;
                                            } ?>
                                        </ul>
                                    <?php } ?>
                                    <div class="caption">
                                        <h4 class="title"><a href="<?php echo esc_url($link); ?>"><?php echo $title; ?></a></h4>
                                        <div class="bottom-block">
                                            <ul class="meta-list">
                                                <li><a href="<?php echo esc_url($author_url); ?>"><?php echo $author_name; ?></a></li>
                                                <li><?php echo $date; ?></li>
                                            </ul>
                                            <?php echo theme_share_block($post_id); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>