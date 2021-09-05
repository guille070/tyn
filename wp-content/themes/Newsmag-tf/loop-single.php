<?php
/**
 * The single post loop Default template
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
            
            <?php if(! is_singular('influencers')) { ?>
	            <?php echo td_page_generator::get_single_breadcrumbs($td_mod_single->title); ?>

				<?php echo $td_mod_single->get_category(); ?>
            <?php } ?>

            <header>
                <?php echo $td_mod_single->get_title();?>


                <?php if (!empty($td_mod_single->td_post_theme_settings['td_subtitle'])) { ?>
                    <p class="td-post-sub-title"><?php echo $td_mod_single->td_post_theme_settings['td_subtitle'];?></p>
                <?php } ?>

				
				<?php if(! is_singular('influencers')) { ?>
	                <div class="meta-info">
						<?php echo $td_mod_single->get_author();?>
	                    <?php echo $td_mod_single->get_date(false);?>
	                    <?php echo $td_mod_single->get_views();?>
	                    <?php echo $td_mod_single->get_comments();?>
	                </div>
                <?php } ?>
            </header>


        </div>
		
		<?php if(! is_singular('influencers')) { ?>
	        <?php echo $td_mod_single->get_social_sharing_top();?>
        <?php } ?>


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
        
        <?php if (is_singular('influencers')) { ?>
            <?php if (get_field('influencer_facebook') || get_field('influencer_twitter') || get_field('influencer_linkedin')) { ?>
	            <div class="social-links">
					<span class="hidden-xs">Seguir en:</span>
					<?php if (get_field('influencer_facebook')) { ?><a href="<?php the_field('influencer_facebook') ?>" target="_blank"><i class="fa fa-facebook fa--circle"></i></a><?php } ?>
					<?php if (get_field('influencer_twitter')) { ?><a href="<?php the_field('influencer_twitter') ?>" target="_blank"><i class="fa fa-twitter fa--circle"></i></a><?php } ?>
					<?php if (get_field('influencer_linkedin')) { ?><a href="<?php the_field('influencer_linkedin') ?>" target="_blank"><i class="fa fa-linkedin fa--circle"></i></a><?php } ?>
	            </div>
            <?php }
        } ?>
        
        </div>
		
		
		<?php if (is_singular('influencers')) { ?>
        	<?php
	        	$nombre_influencer = get_the_title();
	        	$url_influencer = get_the_permalink();
	        	
	        	$posts = get_posts(array(
					'post_type' => 'post',
					'meta_query' => array(
						array(
							'key' => 'influencer_posts', // name of custom field
							'value' => '"' . get_the_ID() . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
							'compare' => 'LIKE'
						)
					)
				));
			?>
			<?php if( $posts ): ?>
				<div class="postsInflu">
					<?php foreach( $posts as $post ): setup_postdata( $post ); ?>
						
						<?php
							echo $td_template_layout->layout_open_element();
							
							$td_mod = new $td_module_class($post);
				            echo $td_mod->render($nombre_influencer, $url_influencer);
				            
				            echo $td_template_layout->layout_close_element();
							$td_template_layout->layout_next();
						?>
						
					<?php endforeach; ?>
				</div>
			<?php endif; wp_reset_query(); ?>
        <?php } ?>
		
		
		<?php if (! is_singular('influencers')) { ?>
	        <footer>
	            <?php echo $td_mod_single->get_post_pagination();?>
	            <?php echo $td_mod_single->get_review();?>
	
	            <div class="td-post-source-tags td-pb-padding-side">
	                <?php echo $td_mod_single->get_source_and_via();?>
	                <?php echo $td_mod_single->get_the_tags();?>
	            </div>
	
	            <?php echo $td_mod_single->get_social_sharing_bottom();?>
	            <?php echo $td_mod_single->get_next_prev_posts();?>
	            <?php echo $td_mod_single->get_author_box();?>
		        <?php echo $td_mod_single->get_item_scope_meta();?>
	        </footer>
        <?php } ?>

    </article> <!-- /.post -->
	
	<?php if (! is_singular('influencers')) { ?>
	    <?php echo $td_mod_single->related_posts();?>
    <?php } ?>

<?php
} else {
    //no posts
    echo td_page_generator::no_posts();
}