<?php

/**
 * Banners Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$sel_banner_group = get_field('sel_banner_group');
$range_banners = get_field('range_banners');
$banner_group_term_slug = get_term($sel_banner_group)->slug;
$shortcode = do_shortcode( "[banner group='.$banner_group_term_slug.' count=$range_banners]" );

if ( $shortcode!== '' ) {
?>

    <section class="section-xs">
        <div class="shell">
            <div class="range">

                <?php
                    $dom = new DOMDocument();
                    $internal_errors = libxml_use_internal_errors(true);
                    $dom->loadHTML($shortcode);
                    libxml_use_internal_errors($internal_errors);
                    $divs = $dom->getElementsByTagName('div');
                    $class_name_plugin = 'banner_wrapper';
                    $xpath = new DOMXpath($dom);
                    $banner_wrapper_elements = $xpath->query("*/div[@class='$class_name_plugin']");
                    $banner_wrapper_length = ($banner_wrapper_elements->length) ? $banner_wrapper_elements->length : 0;
                    
                    if ( $banner_wrapper_length ) {
                        $cols = array();
            
                        for ($i=0; $i<$banner_wrapper_length; $i++) {
                            if ( $banner_wrapper_length <= 4 ) {
                                $cols[$i] = 12 / $banner_wrapper_length; // 12 cols grid
                            } else if ( $banner_wrapper_length == 5 ) {
                                $cols[$i] = ($i<=2) ? 4 : 6;
                            } else if ( $banner_wrapper_length == 6 ) {
                                $cols[$i] = 4;
                            } else if ( $banner_wrapper_length == 7 ) {
                                $cols[$i] = ($i<=3) ? 3 : 4;
                            } else if ( $banner_wrapper_length == 8 ) {
                                $cols[$i] = 3;
                            } else {
                                $cols[$i] = 4;
                            }
                        }
                    }
            
                    if ( !is_null($divs) ) {
                        $i=0;
            
                        foreach ($divs as $div) {
                            $div_class = $div->getAttribute('class');
            
                            if ( $div_class == $class_name_plugin ) {
                                $div->setAttribute('class', 'banner_wrapper cell-sm-'.$cols[$i].'');
                                $i++;
                            }
                        }
                    }

                    $html = $dom->saveHTML();
                    echo $html;
                ?>

            </div>
        </div>
    </section>
<?php } ?>