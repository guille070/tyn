<?php
    $txt_title_footer = get_field('txt_title_footer', 'option');
    $wysiwyg_footer = get_field('wysiwyg_footer', 'option');
    $menu_locations = get_nav_menu_locations();
    $footer_1_menu = wp_get_nav_menu_object( $menu_locations['footer_1'] );
    $footer_2_menu = wp_get_nav_menu_object( $menu_locations['footer_2'] );
    $img_logo = get_field('img_logo', 'option');
    $logo_url = ($img_logo['url']) ? $img_logo['url'] : get_stylesheet_directory_uri() . '/front/images/logo-tynmag-retina.png';
    $txt_newsletter = get_field('txt_titulo_newsletter', 'option');
    $bajada_newsletter = get_field('wysiwyg_bajada_newsletter', 'option');
    $script_newsletter = get_field('txa_script_newsletter', 'option');
    $txt_redes = get_field('txt_titulo_redes_sociales', 'option');
    $bajada_redes = get_field('wysiwyg_bajada_redes_sociales', 'option');
    $rep_redes_sociales = 'rep_redes_sociales';
?>
    
    <footer>
        <div class="shell page-footer-default page-footer-type-1">
            <div class="range range-30 text-left">
                <div class="cell-xs-6 cell-lg-4">
                    <?php if ($txt_title_footer!=='') { ?>
                        <h4 class="footer-title"><?php echo $txt_title_footer; ?></h4>
                    <?php } ?>
                    <?php echo $wysiwyg_footer; ?>
                </div>
                <div class="cell-xs-6 cell-lg-4">
                    <?php if ($footer_1_menu) { ?>
                        <h4 class="footer-title"><?php echo wp_kses_post($footer_1_menu->name); ?></h4>
                    <?php } ?>
                    <?php
                        wp_nav_menu( array(
                            'theme_location'  => 'footer_1',
                            'depth'           => 1, // 1 = no dropdowns, 2 = with dropdowns.
                            'container'       => false,
                            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                            'menu_class'      => 'list',
                        ) );
                    ?>
                </div>
                <div class="cell-xs-12 cell-sm-6 cell-lg-4">
                    <?php if ($footer_2_menu) { ?>
                        <h4 class="footer-title"><?php echo wp_kses_post($footer_2_menu->name); ?></h4>
                    <?php } ?>
                    <?php
                        wp_nav_menu( array(
                            'theme_location'  => 'footer_2',
                            'depth'           => 1, // 1 = no dropdowns, 2 = with dropdowns.
                            'container'       => false,
                            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                            'menu_class'      => 'tag-list-type-1',
                        ) );
                    ?> 
                </div>
                <!-- <div class="cell-xs-12 cell-sm-6 cell-lg-3">
                    <?php if ($txt_newsletter!=='') { ?>
                        <h4 class="footer-title"><?php echo $txt_newsletter; ?></h4>
                    <?php } ?>
                    <?php if ($bajada_newsletter!=='') {
                        echo $bajada_newsletter;
                    } ?>

                    <?php echo $script_newsletter; ?>
                </div> -->
            </div>
            <div class="range range-center range-xs-30 range-sm-0 footer-bottom-section">
                <div class="cell-sm-6 text-sm-left">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <img src="<?php echo $logo_url; ?>" width="266" alt="<?php bloginfo( 'name' ); ?>" />
                    </a>
                    <p class="privacy"><?php bloginfo( 'name' ); ?> &#169; <span id="copyright-year"></span>.</p>
                </div>
                <div class="cell-sm-6 text-sm-right">
                    <?php if ( have_rows($rep_redes_sociales, 'option') ) { ?>
                        <div class="soc-icon">
                            <?php while( have_rows($rep_redes_sociales, 'option') ): the_row();
                                $type = get_sub_field('sel_red_social');
                                $url = get_sub_field('txt_url_red_social');
                                ?>

                                <a class="icon <?php echo $type; ?>" href="<?php echo $url; ?>" target="_blank" rel="nofollow"></a>

                            <?php endwhile; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </footer>

</div> <!-- /Page -->

<?php wp_footer(); ?>

<?php theme_options_scripts_footer(); ?>

</body>

</html>
