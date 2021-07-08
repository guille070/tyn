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

<section class="section-xs">
    <div class="shell">
        <div class="range range-50">
            <div class="cell-sm-12">
                <div class="sidebar-form-block">
                    <?php if ($mostrar_form_newsletter) {
                        echo theme_newsletter_html();
                    } ?>
                    
                    <?php if ($mostrar_redes_sociales) {
                        echo theme_redessociales_html();
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>