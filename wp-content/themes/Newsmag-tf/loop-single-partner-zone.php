<?php
/**
 * The single post loop Partner Zone. Copy of loop-single.php
 **/

global $loop_module_id, $loop_sidebar_position, $global_flag_to_hide_no_post_to_display;

$loop_module_id = 2;
$td_template_layout = new td_template_layout($loop_sidebar_position);
$td_module_class = td_api_module::_helper_get_module_class_from_loop_id($loop_module_id);

if (have_posts()) {
    the_post();

    $td_mod_single = new td_module_single($post);

    ?>


    <article id="post-<?php echo $td_mod_single->post->ID;?>" class="<?php echo join(' ', get_post_class());?>" <?php echo $td_mod_single->get_item_scope();?>>
        <div class="td-post-header td-pb-padding-side">
            
            <header>
                <?php echo $td_mod_single->get_title();?>


                <?php if (!empty($td_mod_single->td_post_theme_settings['td_subtitle'])) { ?>
                    <p class="td-post-sub-title"><?php echo $td_mod_single->td_post_theme_settings['td_subtitle'];?></p>
                <?php } ?>
				
            </header>

        </div>
		
		<?php //echo $td_mod_single->get_social_sharing_top();?>

        <div class="td-post-content td-pb-padding-side">

        <?php
        // override the default featured image by the templates (single.php and home.php/index.php - blog loop)
        if (!empty(td_global::$load_featured_img_from_template)) {
            echo $td_mod_single->get_image(td_global::$load_featured_img_from_template);
        } else {
            echo $td_mod_single->get_image('td_640x0');
        }
        ?>

        <?php echo $td_mod_single->get_content();?>
        
        </div>
        
        <?php
	        $menuItems = array();
	        
	        if( have_rows('pzone_videos') ) { $pzone_videos = 'pzone_videos'; array_push($menuItems, 'Videos'); };
	        if( have_rows('pzone_whitepapers') ) { $pzone_whitepapers = 'pzone_whitepapers'; array_push($menuItems, 'Whitepapers'); };
	        if( have_rows('pzone_webinars') ) { $pzone_webinars = 'pzone_webinars'; array_push($menuItems, 'Webinars'); };
	        if( have_rows('pzone_cexito') ) { $pzone_cexito = 'pzone_cexito'; array_push($menuItems, 'Casos de éxito'); };
	        if( get_field('pzone_articulos') ) { $pzone_articulos = get_field('pzone_articulos'); array_push($menuItems, 'Artículos'); }
	        
	        if ( !empty($menuItems) ) { ?>
	        	<h3 class="titMenu">Menú</h3>
	        	<ul class="menuPZone">
		        	<?php foreach ($menuItems as $val) { ?>
					    <li><a href="#<?php echo $val; ?>"><?php echo $val; ?></a></li>
					<?php } ?>
	        	</ul>
		    <?php
	        }
        ?>
        
        <?php if( have_rows($pzone_videos) ): ?>
			<h2 class="titSubsec" name="Videos">Videos</h2>
			<div class="td-block-row">
			    <?php while( have_rows($pzone_videos) ): the_row();
			 
			        $pzone_link_video = get_sub_field('pzone_link_video'); 
			        $pzone_tit_video = get_sub_field('pzone_tit_video'); 
			        $pzone_desc_video = get_sub_field('pzone_desc_video'); 
			        ?>
			        
			        <div class="td-block-span6">
				        <div class="td_module_2 td_module_wrap td-animation-stack">
					        <div class="td-module-image">
								<div class="td-module-thumb">
									<?php echo $pzone_link_video; ?>
								</div>                
							</div>
							<h3 class="entry-title td-module-title"><?php echo $pzone_tit_video; ?></h3>
							<div class="td-excerpt"><?php echo $pzone_desc_video; ?></div>
				        </div>
			        </div>
			        
			    <?php endwhile; ?>
			</div>
		<?php endif; ?>
		
		<?php if( have_rows($pzone_whitepapers) ): ?>
			<h2 class="titSubsec" name="Whitepapers">Whitepapers</h2>
			<div class="td-block-row">
			    <?php while( have_rows($pzone_whitepapers) ): the_row();
			 
			        $pzone_link_whitepaper = get_sub_field('pzone_link_whitepaper'); 
			        $pzone_img_whitepaper = get_sub_field('pzone_img_whitepaper'); 
			        $pzone_tit_whitepaper = get_sub_field('pzone_tit_whitepaper'); 
			        $pzone_desc_whitepaper = get_sub_field('pzone_desc_whitepaper'); 
			        ?>
			        
			        <div class="td-block-span6">
				        <div class="td_module_2 td_module_wrap td-animation-stack">
					        <div class="td-module-image">
								<div class="td-module-thumb">
									<img src="<?php echo $pzone_img_whitepaper; ?>" alt="" />
								</div>                
							</div>
							<h3 class="entry-title td-module-title"><?php echo $pzone_tit_whitepaper; ?></h3>
							<div class="td-excerpt"><?php echo $pzone_desc_whitepaper; ?></div>
							<a href="<?php echo $pzone_link_whitepaper; ?>" target="_blank">Descargar whitepaper</a>
				        </div>
			        </div>
			        
			    <?php endwhile; ?>
			</div>
		<?php endif; ?>
		
		<?php if( have_rows($pzone_webinars) ): ?>
			<h2 class="titSubsec" name="Webinars">Webinars</h2>
			<div class="td-block-row">
			    <?php while( have_rows($pzone_webinars) ): the_row();
			 
			        $pzone_link_video = get_sub_field('pzone_link_webinar'); 
			        $pzone_tit_video = get_sub_field('pzone_tit_webinar'); 
			        ?>
			        
			        <div class="td-block-span6">
				        <div class="td_module_2 td_module_wrap td-animation-stack">
					        <div class="td-module-image">
								<div class="td-module-thumb">
									<?php echo $pzone_link_video; ?>
								</div>                
							</div>
							<h3 class="entry-title td-module-title"><?php echo $pzone_tit_video; ?></h3>
				        </div>
			        </div>
			        
			    <?php endwhile; ?>
			</div>
		<?php endif; ?>
		
		<?php if( have_rows($pzone_cexito) ): ?>
			<h2 class="titSubsec" name="Casos de éxito">Casos de éxito</h2>
			<div class="td-block-row">
			    <?php while( have_rows($pzone_cexito) ): the_row();
			 
			        $pzone_link_whitepaper = get_sub_field('pzone_link_cexito'); 
			        $pzone_img_whitepaper = get_sub_field('pzone_img_cexito'); 
			        $pzone_tit_whitepaper = get_sub_field('pzone_tit_cexito'); 
			        $pzone_desc_whitepaper = get_sub_field('pzone_desc_cexito'); 
			        ?>
			        
			        <div class="td-block-span6">
				        <div class="td_module_2 td_module_wrap td-animation-stack">
					        <div class="td-module-image">
								<div class="td-module-thumb">
									<img src="<?php echo $pzone_img_whitepaper; ?>" alt="" />
								</div>                
							</div>
							<h3 class="entry-title td-module-title"><?php echo $pzone_tit_whitepaper; ?></h3>
							<div class="td-excerpt"><?php echo $pzone_desc_whitepaper; ?></div>
							<a href="<?php echo $pzone_link_whitepaper; ?>" target="_blank">Descargar infografía</a>
				        </div>
			        </div>
			        
			    <?php endwhile; ?>
			</div>
		<?php endif; ?>
		
		<?php
			if( $pzone_articulos ): ?>
			    <h2 class="titSubsec" name="Artículos">Artículos</h2>
			    
			    <?php foreach( $pzone_articulos as $post):
			        setup_postdata($post);
			        
					echo $td_template_layout->layout_open_element();
					
					$td_mod = new $td_module_class($post);
		            echo $td_mod->render();
		            
		            echo $td_template_layout->layout_close_element();
					$td_template_layout->layout_next();
			        
			    endforeach;
			    
			    wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly
			endif;
		?>
		
        <footer>
            <?php echo $td_mod_single->get_post_pagination();?>
            <?php echo $td_mod_single->get_review();?>

            <div class="td-post-source-tags td-pb-padding-side">
                <?php echo $td_mod_single->get_source_and_via();?>
                <?php echo $td_mod_single->get_the_tags();?>
            </div>

            <?php //echo $td_mod_single->get_social_sharing_bottom();?>
            <?php echo $td_mod_single->get_next_prev_posts();?>
            <?php echo $td_mod_single->get_author_box();?>
	        <?php echo $td_mod_single->get_item_scope_meta();?>
        </footer>

    </article> <!-- /.post -->
	
	<?php echo $td_mod_single->related_posts();?>

<?php
} else {
    //no posts
    echo td_page_generator::no_posts();
}