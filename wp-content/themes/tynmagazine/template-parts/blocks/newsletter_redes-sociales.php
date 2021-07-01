<?php

/**
 * Newsletter + Redes Sociales Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$mostrar_form_newsletter = get_field('bool_mostrar_form_newsletter');
$mostrar_redes_sociales = get_field('bool_mostrar_redes_sociales');

?>

<div class="section-left-sidebar">
    <div class="range range-50">
        <div class="cell-sm-12">
            <div class="sidebar-form-block">
                <div class="block-form-newsletter">
                    <?php if ($mostrar_form_newsletter) {
                        $txt_newsletter = get_field('txt_titulo_newsletter', 'option');
                        $bajada_newsletter = get_field('wysiwyg_bajada_newsletter', 'option');
                        ?> 

                        <?php if ($txt_newsletter!=='') { ?>
                            <h3><?php echo $txt_newsletter; ?></h3>
                        <?php } ?>
                        <?php if ($bajada_newsletter!=='') {
                            echo $bajada_newsletter;
                        } ?>

                        <script type="text/javascript" src="https://v3.envialosimple.com/form/renderwidget/format/widget/AdministratorID/52552/FormID/4/Lang/es"></script>
                    <?php } ?>
                </div>
                
                <?php if ($mostrar_redes_sociales) {
                    $txt_redes = get_field('txt_titulo_redes_sociales', 'option');
                    $bajada_redes = get_field('wysiwyg_bajada_redes_sociales', 'option');
                    $rep_redes_sociales = 'rep_redes_sociales';
                    ?>

                    <div class="section-subscribe">

                        <?php if ($txt_redes!=='') { ?>
                            <h3><?php echo $txt_redes; ?></h3>
                        <?php } ?>
                        <?php if ($bajada_redes!=='') {
                            echo $bajada_redes;
                        } ?>
                        
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

                <?php } ?>
            </div>
        </div>
    </div>
</div>