<?php //include 'intersitial.php';?>

<?php

$nota_patrocinada_titulo = get_field('nota_patrocinada_titulo', 'option');
$nota_patrocinada_descripcion = get_field('nota_patrocinada_descripcion', 'option');
$nota_patrocinada_link = get_field('nota_patrocinada_link', 'option');

if ($nota_patrocinada_titulo || $nota_patrocinada_descripcion || $nota_patrocinada_link) { ?>

<div class="td-container">
    <div class="vc_row wpb_row td-pb-row">
        <div class="wpb_column vc_column_container td-pb-span12" style="padding-bottom: 0; margin-bottom: 0 !important; padding-top: 30px; border-top: 1px solid #eee; ">
            <div class="wpb_wrapper">
                <div class="wpb_wrapper">
                    <div class="td-block-row">

                        <div class="td-block-span12">

                            <div class="td_module_2 td_module_wrap td-animation-stack">
                                <h3 class="entry-title td-module-title">
                                    <?php echo $nota_patrocinada_titulo; ?>
                                </h3>            
                                                
                                <div class="td-excerpt"><?php echo $nota_patrocinada_descripcion; ?></div>
                            </div>
                            
                        </div> <!-- ./td-block-span2 -->
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php } ?>

<!-- Footer -->
<?php
    if (td_util::get_option('tds_footer') != 'no') {
        td_api_footer_template::_helper_show_footer();
    }
?>

<!-- Sub Footer -->
<?php if (td_util::get_option('tds_sub_footer') != 'no') { ?>
    <div class="td-sub-footer-container td-container td-container-border <?php if (td_util::get_option('tds_footer') == 'no' && td_util::get_option('tds_footer_bottom_color') == '' ) { echo "td-add-border";} ?>">
        <div class="td-pb-row">
            <div class="td-pb-span4 td-sub-footer-copy">
                <div class="td-pb-padding-side">
                    <?php
                    $tds_footer_copyright = td_util::get_option('tds_footer_copyright');
                    $tds_footer_copy_symbol = td_util::get_option('tds_footer_copy_symbol');

                    //show copyright symbol
                    if ($tds_footer_copy_symbol == '') {
                        echo '&copy; ';
                    }

                    echo $tds_footer_copyright;
                    ?>
                </div>
            </div>

            <div class="td-pb-span8 td-sub-footer-menu">
                <div class="td-pb-padding-side">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-menu',
                        'menu_class'=> '',
                        'fallback_cb' => 'td_wp_footer_menu'
                    ));

                    //if no menu
                    function td_wp_footer_menu() {
                        //do nothing?
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
    </div><!--close content div-->
</div><!--close td-outer-wrap-->

<?php wp_footer(); ?>

</body>
</html>