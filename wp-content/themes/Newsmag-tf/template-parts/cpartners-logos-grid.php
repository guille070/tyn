<?php if( have_rows('cpartners_repeater', 'option') ): ?>

    <div class="cpartners-logos-grid">

    <?php while( have_rows('cpartners_repeater', 'option') ): the_row(); 

    	$cpartner_logo = get_sub_field('cpartner_logo'); 
    	$cpartner_link = get_sub_field('cpartner_link');
    	?>

        <div class="item">
        	<a href="<?php echo $cpartner_link; ?>" target="_blank"><img src="<?php echo $cpartner_logo; ?>" alt="" /></a>
        </div>

    <?php endwhile; ?>

    </div>

<?php endif; ?>