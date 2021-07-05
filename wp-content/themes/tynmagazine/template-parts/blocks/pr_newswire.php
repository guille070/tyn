<?php

/**
 * PR Newswire Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

$txa_script_prnewswire = get_field('txa_script_prnewswire', 'option');
?>

<section class="section-xs">
    <div class="shell">
        <div class="range text-left">
            <div class="cell-xs-12">
                <?php echo $txa_script_prnewswire; ?>
            </div>
        </div>
    </div>
</section>