<?php

class td_module_2 extends td_module {

    function __construct($post) {
        //run the parrent constructor
        parent::__construct($post);
    }
	
    function render($nombre_influencer, $url_influencer) {
	    $nombre_influencer = $nombre_influencer;
	    $url_influencer = $url_influencer;
	    
        ob_start();
        ?>

        <div class="<?php echo $this->get_module_classes();?>">
            <div class="td-module-image">
                <?php echo $this->get_image('td_300x160');?>
                
                <?php if (!is_singular('influencers') && !is_singular('partner-zone')) { ?>
	                <?php if (td_util::get_option('tds_category_module_2') == 'yes') { 
		                echo $this->get_category(); }
		            ?>
	            <?php } ?>
            </div>
            <?php echo $this->get_title();?>
            
            <?php if (!is_post_type_archive('influencers') && !is_singular('influencers') && !is_singular('partner-zone')) { ?>
	            <div class="meta-info">
	                <?php echo $this->get_author();?>
	                <?php echo $this->get_date();?>
	                <?php echo $this->get_comments();?>
	            </div>
            <?php } else if (is_singular('influencers')) { ?>
            	<div class="meta-info">
	            	<div class="td-post-author-name">
		            	<a href="<?php echo $url_influencer;?>"><?php echo $nombre_influencer;?></a> <span>-</span> 
		            </div>
	                <?php echo $this->get_date();?>
	            </div>
            <?php } ?>

            <div class="td-excerpt">
                <?php echo $this->get_excerpt();?>
            </div>
            
            <?php if (is_post_type_archive('influencers')) { ?>
            	
            	<a class="verPerfInf" href="<?php the_permalink(); ?>">Ver Perfil</a>
            	
	            <?php if (get_field('influencer_facebook') || get_field('influencer_twitter') || get_field('influencer_linkedin')) { ?>
		            <div class="social-links">
						<span class="hidden-xs">Seguir en:</span>
						<?php if (get_field('influencer_facebook')) { ?><a href="<?php the_field('influencer_facebook') ?>" target="_blank"><i class="fa fa-facebook fa--circle"></i></a><?php } ?>
						<?php if (get_field('influencer_twitter')) { ?><a href="<?php the_field('influencer_twitter') ?>" target="_blank"><i class="fa fa-twitter fa--circle"></i></a><?php } ?>
						<?php if (get_field('influencer_linkedin')) { ?><a href="<?php the_field('influencer_linkedin') ?>" target="_blank"><i class="fa fa-linkedin fa--circle"></i></a><?php } ?>
		            </div>
	            <?php }
            } ?>

            <?php echo $this->get_quotes_on_blocks(); ?>

        </div>

        <?php return ob_get_clean();
    }
}