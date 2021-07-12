<?php
    $shortcode_banners = do_shortcode( "[banner group='notas-300x250']" );
?>

<div class="cell-md-4">
    <div class="section-left-sidebar section-left-sidebar-type-1">
        <div class="range range-50">
            <div class="cell-sm-6 cell-md-12">
                <div class="sidebar-form-block">
                    <?php 
                        echo theme_newsletter_html();
                        echo theme_redessociales_html();
                    ?>
                </div>
            </div>
            <?php if ( $shortcode_banners!=='' ) { ?>
                <div class="cell-sm-6 cell-md-12">
                    <?php echo $shortcode_banners; ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>