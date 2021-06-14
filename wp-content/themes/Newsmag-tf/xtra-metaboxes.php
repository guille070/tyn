<?php
	
//Disable all the updates notifications regarding plugins, themes & WordPress completely
function remove_core_updates(){
	global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates');
add_filter('pre_site_transient_update_plugins','remove_core_updates');
add_filter('pre_site_transient_update_themes','remove_core_updates');

function taxotyn_subseccion() {
 register_taxonomy('subseccion', 'post', array(
  'hierarchical' => true, 'label' => 'Subsecci&oacute;n',
  'query_var' => true, 'rewrite' => true));
  
}
add_action('init', 'taxotyn_subseccion', 0);

add_action('init', 'taxotyn_agregator', 0);
function taxotyn_agregator() {
 register_taxonomy('agregador', 'post', array(
  'hierarchical' => true, 'label' => 'Agregador', 'public' => true,
  'query_var' => true, 'rewrite' => true));
  
}

// Little function to return a custom field value
function wpshed_get_custom_field( $value ) {
	global $post;

    $custom_field = get_post_meta( $post->ID, $value, true );
    if ( !empty( $custom_field ) )
	    return is_array( $custom_field ) ? stripslashes_deep( $custom_field ) : stripslashes( wp_kses_decode_entities( $custom_field ) );

    return false;
}

// Register the Metabox
function wpshed_add_custom_meta_box() {
	add_meta_box( 'wpshed-meta-box', __( 'Opciones de post', 'textdomain' ), 'wpshed_meta_box_output', 'post', 'normal', 'high' );
	add_meta_box( 'wpshed-meta-box', __( 'Opciones de post', 'textdomain' ), 'wpshed_meta_box_output', 'page', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'wpshed_add_custom_meta_box' );

// Output the Metabox
function wpshed_meta_box_output( $post ) {
	// create a nonce field
	wp_nonce_field( 'my_wpshed_meta_box_nonce', 'wpshed_meta_box_nonce' ); ?>
	
	<p>
		<label for="post_signature"><?php _e( 'Firma: </br>', 'textdomain' ); ?></label>
		<?php if (intval(wpshed_get_custom_field( 'post_signature')) > 0) {
		echo '<input type="radio" name="post_signature" id="post_signature" value="0" />Sin firma<br /><input type="radio" name="post_signature" id="post_signature" value="1" checked />Con firma';
		} else {
		echo '<input type="radio" name="post_signature" id="post_signature" value="0" checked />Sin firma<br /><input type="radio" name="post_signature" id="post_signature" value="1" />Con firma';
		}?>
	</p>
	<p>
		<label for="post_gallery"><?php _e( 'Galería de imágenes', 'textdomain' ); ?>:</label><br />
		<?php if (intval(wpshed_get_custom_field( 'post_gallery')) > 0) {
		echo '<input type="radio" name="post_gallery" id="post_gallery" value="0" />Integrada<br /><input type="radio" name="post_gallery" id="post_gallery" value="1" checked />Dehabilitada';
		} else {
		echo '<input type="radio" name="post_gallery" id="post_gallery" value="0" checked />Integrada<br /><input type="radio" name="post_gallery" id="post_gallery" value="1" />Dehabilitada';
		}?>
    </p>
	<h1>Opciones para posts de Video</h1>
	<p>
		<label for="post_video"><?php _e( 'Video ID (https://www.youtube.com/watch?v=<span style="color: red">jNQXAC9IVRw</span>): </br>', 'textdomain' ); ?></label>
		<input type="text" name="post_video" id="post_video" value="<?php echo wpshed_get_custom_field('post_video');?>" />
	</p>
	<h1>Opciones para reviews</h1>
	<p>
		<label for="post_product">Nombre completo del producto</label>
		<input type="text" name="post_product" id="post_product" value="<?php echo wpshed_get_custom_field('post_product');?>" />
	</p>
	<p>
		<label for="post_pro_1">Pro #1</label>
		<input type="text" name="post_pro_1" id="post_pro_1" value="<?php echo wpshed_get_custom_field('post_pro_1');?>" />
	</p>
	<p>
		<label for="post_pro_2">Pro #2</label>
		<input type="text" name="post_pro_2" id="post_pro_2" value="<?php echo wpshed_get_custom_field('post_pro_2');?>" />
	</p>
	<p>
		<label for="post_pro_3">Pro #3</label>
		<input type="text" name="post_pro_3" id="post_pro_3" value="<?php echo wpshed_get_custom_field('post_pro_3');?>" />
	</p>
	<p>
		<label for="post_con_1">Con #1</label>
		<input type="text" name="post_con_1" id="post_con_1" value="<?php echo wpshed_get_custom_field('post_con_1');?>" />
	</p>
	<p>
		<label for="post_con_2">Con #2</label>
		<input type="text" name="post_con_2" id="post_con_2" value="<?php echo wpshed_get_custom_field('post_con_2');?>" />
	</p>
	<p>
		<label for="post_con_3">Con #3</label>
		<input type="text" name="post_con_3" id="post_con_3" value="<?php echo wpshed_get_custom_field('post_con_3');?>" />
	</p>
	<p>
		<label for="post_con_3">Puntaje (de 1 a 100)</label>
		<input type="text" name="post_score" id="post_con_3" value="<?php echo wpshed_get_custom_field('post_score');?>" />
	</p>
    
	<?php
}

// Save the Metabox values
function wpshed_meta_box_save( $post_id ) {
	// Stop the script when doing autosave
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// Verify the nonce. If insn't there, stop the script
	if( !isset( $_POST['wpshed_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['wpshed_meta_box_nonce'], 'my_wpshed_meta_box_nonce' ) ) return;

	// Stop the script if the user does not have edit permissions
	if( !current_user_can( 'edit_post' ) ) return;

	if( isset( $_POST['post_signature'] ) )
		update_post_meta( $post_id, 'post_signature', esc_attr( $_POST['post_signature'] ) );

	if( isset( $_POST['post_gallery'] ) )
		update_post_meta( $post_id, 'post_gallery', esc_attr( $_POST['post_gallery'] ) );
		
	if( isset( $_POST['post_video'] ) )
		update_post_meta( $post_id, 'post_video', esc_attr( $_POST['post_video'] ) );
	
	if( isset( $_POST['post_product'] ) )
		update_post_meta( $post_id, 'post_product', esc_attr( $_POST['post_product'] ) );
	
	if( isset( $_POST['post_score'] ) )
		update_post_meta( $post_id, 'post_score', esc_attr( $_POST['post_score'] ) );
			
	if( isset( $_POST['post_pro_1'] ) )
		update_post_meta( $post_id, 'post_pro_1', esc_attr( $_POST['post_pro_1'] ) );
	
	if( isset( $_POST['post_pro_2'] ) )
		update_post_meta( $post_id, 'post_pro_2', esc_attr( $_POST['post_pro_2'] ) );
	
	if( isset( $_POST['post_pro_3'] ) )
		update_post_meta( $post_id, 'post_pro_3', esc_attr( $_POST['post_pro_3'] ) );
	
	if( isset( $_POST['post_con_1'] ) )
		update_post_meta( $post_id, 'post_con_1', esc_attr( $_POST['post_con_1'] ) );
	
	if( isset( $_POST['post_con_2'] ) )
		update_post_meta( $post_id, 'post_con_2', esc_attr( $_POST['post_con_2'] ) );
	
	if( isset( $_POST['post_con_3'] ) )
		update_post_meta( $post_id, 'post_con_3', esc_attr( $_POST['post_con_3'] ) );
}
add_action( 'save_post', 'wpshed_meta_box_save' );


// Place the metabox in the post edit page below the editor before other metaboxes (like the Excerpt)
// add_meta_box( 'wpshed-meta-box', __( 'Opciones de post', 'textdomain' ), 'wpshed_meta_box_output', 'post', 'normal', 'high' );
// Place the metabox in the post edit page below the editor at the end of other metaboxes
// add_meta_box( 'wpshed-meta-box', __( 'Opciones de post', 'textdomain' ), 'wpshed_meta_box_output', 'post', 'normal', '' );
// Place the metabox in the post edit page in the right column before other metaboxes (like the Publish)
// add_meta_box( 'wpshed-meta-box', __( 'Opciones de post', 'textdomain' ), 'wpshed_meta_box_output', 'post', 'side', 'high' );
// Place the metabox in the post edit page in the right column at the end of other metaboxes
// add_meta_box( 'wpshed-meta-box', __( 'Opciones de post', 'textdomain' ), 'wpshed_meta_box_output', 'post', 'side', '' );

//[foobar]
function tyn_big_grid_4_function( $atts ){
global $wpdb;
$idsitio=get_sitio();
$table_name = $wpdb->prefix . "tynhome";
$variable = $wpdb->get_row("SELECT * FROM $table_name WHERE sitio = '" . $idsitio . "'");

$fea_art = $variable->feature_1 .','. $variable->feature_2 .','.$variable->feature_3 .','. $variable->feature_4.','.$variable->feature_5;
//$output = tyn_header_ads();
$output = do_shortcode('[td_block_big_grid_4 td_grid_style="td-grid-style-7" post_ids="'.$fea_art.'"]');
return $output;
}
add_shortcode( 'tyn_big_grid_4', 'tyn_big_grid_4_function' );

function tyn_notas_globenewswire() {
	$html = '';
	$limit_post = 6;
	$term = get_term_by('slug', 'globenewswire', 'subseccion');
	$term_img = get_field('img_patrocinador', $term);
	$term_name = ($term->name) ? $term->name : '';

	$args = array(			
		'tax_query' => array(
			array(
				'taxonomy' => 'subseccion',
				'field'    => 'slug',
				'terms'    => 'globenewswire',
			),
		),
		'numberposts' => $limit_post,			
	);
				
	$myposts = get_posts( $args );
	if ($myposts){
		$post_ids = array();

		foreach( $myposts as $post ) :	setup_postdata($post);
			array_push($post_ids, $post->ID);
		endforeach;

		if (!empty($post_ids)) {
			$html = '<div class="block-patrocinados"><div class="enc"><img src="'.$term_img['sizes']['medium'].'" alt="'.$term_img['alt'].'" /></div>[td_block_9 limit="'.$limit_post.'" post_ids="'.implode(",", $post_ids).'"]</div>';
		}
	}

	return $html;
}

function tyn_home_function( $atts ){
global $wpdb;
$idsitio=get_sitio();
$table_name = $wpdb->prefix . "tynhome";
$variable = $wpdb->get_row("SELECT * FROM $table_name WHERE sitio = '" . $idsitio . "'");
$exclude_array = array($variable->feature_1,$variable->feature_2,$variable->feature_3,$variable->feature_4,$variable->feature_5);


//SEGUNDO BIG GRID
$args = array(			
			'post__not_in' => $exclude_array,
			'category__not_in' => array( 29443, 31748, 57507, 57508 ),
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'subseccion',
					'field'    => 'slug',
					'terms'    => array( 'globenewswire' ),
					'operator' => 'NOT IN',
				),
				array (
					'relation' => 'OR',
					array(
						'taxonomy' => 'subseccion',
						'field'    => 'slug',
						'terms'    => array( 'feature' ),
					),
				),
			),
			'numberposts' => 5,			
		);
			
$myposts = get_posts( $args );
$fea2_art='';
$i = 0;
foreach( $myposts as $post ) :	setup_postdata($post);
$fea2_art.=$post->ID;
$exclude_array[]=$post->ID;
$i=$i+1;
if ($i<5) {
		$fea2_art.=',';
	}
endforeach;


//COMPLETAR SÁBANA $exclude_post = $fea_array + $fea2_array;
$args = array(			
			'post__not_in' => $exclude_array,
			'category__not_in' => array( 29443, 31748, 57507, 57508 ),
			'tax_query' => array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'subseccion',
					'field'    => 'slug',
					'terms'    => array( 'globenewswire' ),
					'operator' => 'NOT IN',
				),
				array(
					'relation' => 'OR',
					array(
						'taxonomy' => 'subseccion',
						'field'    => 'slug',
						'terms'    => array( 'feature' ),
					),
					array(
						'taxonomy' => 'subseccion',
						'field'    => 'slug',
						'terms'    => array( 'home' ),
					),
				),
			),
			'numberposts' => 44,			
		);		

$myposts = get_posts( $args );
$i = 0;
$tabloid=array();
foreach( $myposts as $post ) :	setup_postdata($post);
$tabloid[$i] = $post->ID;
$i=$i+1;

endforeach;

if ( wp_is_mobile() ) {
$ads0='<div><div style="display: inline; margin: 10px auto 10px auto; max-width: 728px; min-width: 320px"><center><iframe id="a4b3b792" name="a4b3b792" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=154&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="90"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a7933d35&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=154&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a7933d35" border="0" alt="" /></a></iframe></center></div></div>';
}else{
$ads0='<div><div style="display: inline; margin: 10px auto 10px auto; max-width: 728px; min-width: 320px"><center><iframe id="a8c8a42d" name="a8c8a42d" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=153&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="728" height="90"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=af8a7656&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=153&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=af8a7656" border="0" alt="" /></a></iframe>
</center></div></div>';
}

$ads1='<div class="vc_row wpb_row td-pb-row vc_custom_1464907557877" style="border-top: 1px solid #E6E6E6; ">
<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="acebf068" name="acebf068" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=20&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a31ec27b&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=20&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a31ec27b" border="0" alt="" /></a></iframe></center></div></div></div></div>
<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="aea8be4d" name="aea8be4d" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=259&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a319a131&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=259&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a319a131" border="0" alt="" /></a></iframe></center></div></div></div></div>
<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="aeb3f298" name="aeb3f298" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=5&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a5ba8ccd&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=5&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a5ba8ccd" border="0" alt="" /></a></iframe></center></div></div></div></div>
</div>
<div class="vc_row wpb_row td-pb-row vc_custom_1464907557877" style="border-top: 1px solid #E6E6E6">
<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="a9806ea8" name="a9806ea8" src="http://104.131.142.242/adserver/www/delivery/afr.php?refresh=600&amp;zoneid=6&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=aa223dcf&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=6&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=aa223dcf" border="0" alt="" /></a></iframe></center></div></div></div></div>
<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="aaa15e7a" name="aaa15e7a" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=7&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=aef1d0a9&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=7&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=aef1d0a9" border="0" alt="" /></a></iframe></center></div></div></div></div>
<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="a8297b69" name="a8297b69" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=8&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=ad32576e&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=8&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=ad32576e" border="0" alt="" /></a></iframe></center></div></div></div></div>
</div>';

$ads1_bis='<div class="vc_row wpb_row td-pb-row vc_custom_1464907557877" style="border-top: 1px solid #E6E6E6">
<div class="wpb_column vc_column_container td-pb-span6"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="a6947d0c" name="a6947d0c" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=260&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a256a978&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=260&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a256a978" border="0" alt="" /></a></iframe></center></div></div></div></div>
<!--<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="abb2b6c5" name="abb2b6c5" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=261&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=aa451c4e&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=261&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=aa451c4e" border="0" alt="" /></a></iframe></center></div></div></div></div>-->
<div class="wpb_column vc_column_container td-pb-span6"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="a434a91e" name="a434a91e" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=262&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a063595a&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=262&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a063595a" border="0" alt="" /></a></iframe></center></div></div></div></div>
</div>
<!--<div class="vc_row wpb_row td-pb-row vc_custom_1464907557877" style="border-top: 1px solid #E6E6E6">
<div class="wpb_column vc_column_container td-pb-span12"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="a279b52b" name="a279b52b" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=267&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="645" height="105"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=ae2a9a1e&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=267&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=ae2a9a1e" border="0" alt="" /></a></iframe></center></div></div></div></div>-->
</div>';

$ads2='<div class="vc_row wpb_row td-pb-row vc_custom_1464907557877" style="border-top: 1px solid #E6E6E6">
<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="a885a950" name="a885a950" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=258&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a711d106&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=258&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a711d106" border="0" alt="" /></a></iframe></center></div></div></div></div>
<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="a9cc0ed1" name="a9cc0ed1" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=257&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=aca65985&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=257&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=aca65985" border="0" alt="" /></a></iframe></center></div></div></div></div>
<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="a2d336ea" name="a2d336ea" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=4&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a70fc7b2&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=4&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a70fc7b2" border="0" alt="" /></a></iframe></center></div></div></div></div>
</div>
<div class="vc_row wpb_row td-pb-row vc_custom_1464907557877" style="border-top: 1px solid #E6E6E6">
<div class="wpb_column vc_column_container td-pb-span6"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="a8bc6a33" name="a8bc6a33" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=3&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a2e60646&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=3&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a2e60646" border="0" alt="" /></a></iframe></center></div></div></div></div>
<div class="wpb_column vc_column_container td-pb-span6"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="a9bf84a4" name="a9bf84a4" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=19&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a2b7c7fe&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=19&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a2b7c7fe" border="0" alt="" /></a></iframe></center></div></div></div></div>
<!--<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="ab33f845" name="ab33f845" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=2&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a07fa993&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=2&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a07fa993" border="0" alt="" /></a></iframe></center></div></div></div></div>-->
</div>';


$ads3='<div class="vc_row wpb_row td-pb-row vc_custom_1464907557877" style="border-top: 1px solid #E6E6E6">
<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="ab732bfb" name="ab732bfb" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=254&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a00a4a5b&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=254&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a00a4a5b" border="0" alt="" /></a></iframe></center></div></div></div></div>
<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="a47d8c77" name="a47d8c77" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=255&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=abe70122&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=255&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=abe70122" border="0" alt="" /></a></iframe></center></div></div></div></div>
<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="af7be3e4" name="af7be3e4" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=256&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a20933e6&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=256&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a20933e6" border="0" alt="" /></a></iframe></center></div></div></div></div>
</div>';


$ads4='<div class="vc_row wpb_row td-pb-row vc_custom_1464907557877" style="border-top: 1px solid #E6E6E6; border-bottom: 1px solid #E6E6E6">
<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="a54d69db" name="a54d69db" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=263&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a6c9fad5&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=263&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a6c9fad5" border="0" alt="" /></a></iframe></center></div></div></div></div>
<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="a5bd8579" name="a5bd8579" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=264&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a1e16cc5&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=264&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a1e16cc5" border="0" alt="" /></a></iframe></center></div></div></div></div>
<div class="wpb_column vc_column_container td-pb-span4"><div class="wpb_wrapper"><div class="wpb_raw_code wpb_content_element wpb_raw_html"><div class="wpb_wrapper"><center><iframe id="a0b6a2a5" name="a0b6a2a5" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=266&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="250"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=aec453d1&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=266&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=aec453d1" border="0" alt="" /></a></iframe></center></div></div></div></div>
</div>';

$home_shortcode= '';
$home_shortcode= $ads1;
$home_shortcode.='[vc_row][vc_column][td_block_4 custom_title="" limit="6" post_ids="'. $tabloid[0].','.$tabloid[1].','.$tabloid[2].','.$tabloid[3].','.$tabloid[4].','.$tabloid[5].'"][/vc_column][/vc_row]';

//$home_shortcode.= $ads1_bis;

$home_shortcode.='[vc_row][vc_column width="2/3"][td_block_4 custom_title="" limit="2" post_ids="'.$tabloid[7].','.$tabloid[6].'"]'.tyn_notas_globenewswire().'[/vc_column][vc_column width="1/3"]<div class="wpb_wrapper"><div class="td_block_wrap td-pb-border-top"><h4 class="block-title"><span>Síganos</span></h4><div style="margin-left: 15px; margin-bottom: 10px;">[aps-counter]</div></div><!-- ./block --></div>[tyn_newsletter_box][/vc_column]';
$home_shortcode.='[vc_row][vc_column][td_block_4 custom_title="" limit="6" post_ids="'.$tabloid[8].','.$tabloid[9].','.$tabloid[10].','.$tabloid[11].','.$tabloid[12].','.$tabloid[13].'"][/vc_column][/vc_row]';
$home_shortcode.='[vc_row][vc_column][td_block_big_grid td_grid_style="td-grid-style-7" post_ids='.$fea2_art.'][/vc_column][/vc_row]';
$home_shortcode.= $ads2;

$home_shortcode.='[vc_row][vc_column][td_block_16 custom_title="" limit="10" post_ids="'.$tabloid[14].','.$tabloid[15].','.$tabloid[16].','.$tabloid[17].','.$tabloid[18].','.$tabloid[19].','.$tabloid[20].','.$tabloid[21].','.$tabloid[22].','.$tabloid[23].'"][/vc_column][/vc_row]';
//$home_shortcode.='[vc_row][vc_column]<h3 style="padding-left: 15px; margin-top: 0;" class="vc_custom_heading"><b>Content Partners</b></h3>[cpartners_logos_slide] [/vc_column][/vc_row]';
$home_shortcode.='[vc_row][vc_column][td_block_16 custom_title="" limit="10" post_ids="'.$tabloid[24].','.$tabloid[25].','.$tabloid[26].','.$tabloid[27].','.$tabloid[28].','.$tabloid[29].','.$tabloid[30].','.$tabloid[31].','.$tabloid[32].','.$tabloid[33].'"][/vc_column][/vc_row]';

//$home_shortcode.=$ads3;

$home_shortcode.='[vc_row][vc_column][td_block_16 custom_title="" limit="10" post_ids="'.$tabloid[34].','.$tabloid[35].','.$tabloid[36].','.$tabloid[37].','.$tabloid[38].','.$tabloid[39].','.$tabloid[40].','.$tabloid[41].','.$tabloid[42].','.$tabloid[43].'"][/vc_column][/vc_row]';

//$home_shortcode.=$ads4;

$output = do_shortcode($home_shortcode);


return $output;
}
add_shortcode( 'tyn_home_gen', 'tyn_home_function' );

function tyn_notas_publicitadas_function($atts){	
	global $wpdb;
	$idsitio=get_sitio();
	$table_name = $wpdb->prefix . "tynhome";
	$variable = $wpdb->get_row("SELECT * FROM $table_name WHERE sitio = '" . $idsitio . "'");
	$exclude_array = array($variable->feature_1,$variable->feature_2,$variable->feature_3,$variable->feature_4,$variable->feature_5);
	
	$args = array(			
		'post__not_in' => $exclude_array,
		'tax_query' => array(
			array(
				'taxonomy' => 'subseccion',
				'field'    => 'slug',
				'terms'    => 'notas-patrocinadas',
			),
		),
		'numberposts' => 3,			
	);
				
	$myposts = get_posts( $args );
	if ($myposts){
		$fea2_art='';
		$i = 0;
		foreach( $myposts as $post ) :	setup_postdata($post);
			$fea2_art.=$post->ID;
			$exclude_array[]=$post->ID;
			$i=$i+1;
			if ($i<3) {
				$fea2_art.=',';
			}
		endforeach;
		
		$home_shortcode = '[vc_row][vc_column][td_block_4 custom_title="Notas Patrocinadas" limit="3" post_ids="'.$fea2_art.'"][/vc_column][/vc_row]';
		$output = do_shortcode($home_shortcode);
	
		return $output;
	}
}
add_shortcode( 'tyn_notas_publicitadas', 'tyn_notas_publicitadas_function' );


function get_sitio(){
$blogid = get_current_blog_id();
$output = str_replace('/', '', get_blog_details($blogid)->path);
return $output;
}



/** IMAGE CREDIT **/

/**
 * Add Photographer Name and URL fields to media uploader
 *
 * @param $form_fields array, fields to include in attachment form
 * @param $post object, attachment record in database
 * @return $form_fields, modified form fields
 */
 
function be_attachment_field_credit( $form_fields, $post ) {
	$form_fields['be-photographer-name'] = array(
		'label' => 'Nombre del fotógrafo',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'be_photographer_name', true ),
		'helps' => 'Ingrese el nombre del fotógrafo',
	);

	$form_fields['be-photographer-url'] = array(
		'label' => 'URL del fotógrafo URL',
		'input' => 'text',
		'value' => get_post_meta( $post->ID, 'be_photographer_url', true ),
		'helps' => 'Ingrese la url del fotógrafo',
	);

	return $form_fields;
}

add_filter( 'attachment_fields_to_edit', 'be_attachment_field_credit', 10, 2 );

/**
 * Save values of Photographer Name and URL in media uploader
 *
 * @param $post array, the post data for database
 * @param $attachment array, attachment fields from $_POST form
 * @return $post array, modified post data
 */

function be_attachment_field_credit_save( $post, $attachment ) {
	if( isset( $attachment['be-photographer-name'] ) )
		update_post_meta( $post['ID'], 'be_photographer_name', $attachment['be-photographer-name'] );

	if( isset( $attachment['be-photographer-url'] ) )
update_post_meta( $post['ID'], 'be_photographer_url', esc_url( $attachment['be-photographer-url'] ) );

	return $post;
}

add_filter( 'attachment_fields_to_save', 'be_attachment_field_credit_save', 10, 2 );

function tyn_header_ads() {
if ( wp_is_mobile() ) {
$output='<div style="display: block; margin: 10px 0 0;"><center><iframe id="a4b3b792" name="a4b3b792" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=154&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="300" height="90"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=a7933d35&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=154&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=a7933d35" border="0" alt="" /></a></iframe></center></div>';
}else{
$output='
<!--<div style="display: block; margin: 10px 0 0;"><center><iframe id="a8c8a42d" name="a8c8a42d" src="http://www.tynmagazine.com/_banner-movistar/728x90/index.html" frameborder="0" scrolling="no" width="728" height="90"><a href="http://www.movistar.com.ar/" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=153&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=af8a7656" border="0" alt="" /></a></iframe></center></div>-->

<div style="display: block; margin: 10px 0 0;"><center><iframe id="a8c8a42d" name="a8c8a42d" src="http://104.131.142.242/adserver/www/delivery/afr.php?zoneid=153&amp;cb=INSERT_RANDOM_NUMBER_HERE" frameborder="0" scrolling="no" width="728" height="90"><a href="http://104.131.142.242/adserver/www/delivery/ck.php?n=af8a7656&amp;cb=INSERT_RANDOM_NUMBER_HERE" target="_blank"><img src="http://104.131.142.242/adserver/www/delivery/avw.php?zoneid=153&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;n=af8a7656" border="0" alt="" /></a></iframe></center></div>';
}

return $output;

}

function tyn_newsletter_box_function(){
$output='<div class="wpb_wrapper"><div class="td_block_wrap td-pb-border-top"><h4 class="block-title"><span>Suscríbase al newsletter</span></h4><center><script type="text/javascript" src="https://app.envialosimple.com/form/show/AdministratorID/52552/FormID/2/format/widget"></script></center></div><!-- ./block --></div>';
return $output;
}
add_shortcode( 'tyn_newsletter_box', 'tyn_newsletter_box_function' );



// SHORTCODE PARA INFLUENCERS
function insertar_influencers( $atts , $content = null ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'author' => '',
			'twitter' => '',
						'mail' => '',

			'linkedin' => '',
			'align' => '',
			'img' => '',
		), $atts );


if ($atts['align'] == 'right') {
	$align = 'right';
	} else {
	$align = 'left';
}

$output = '<aside style="width: 320px; float: left; margin: 5px 2% 2%; padding: 0 0 1%; display: inline; border-top: 3px #c9000a solid; border-bottom: 1px #cccccc solid">';
$output .= '<h1 style="font-size: 20px">El autor: '. $atts['author'] .'</h1>';
$output .= '<div style="width: 100%; display: block; margin: 0 0 2% 0; float: left;">';
if (strlen($atts['img'])>0) {
	$output .= '<img style="width: 30%; heigth: auto; float: left; margin: 0 2%;" src ="'. $atts['img'] .'" />';
	}
$output .= $content . '</div>';
if (strlen($atts['twitter'])>0) {
	$output .= '<input class="submitButton" name="influencer-twitter" type="submit" onclick="location.href=\''.$atts['twitter'].'\';" value="Twitter" style= "margin: 0 1% 0;"/>';
	}
if (strlen($atts['mail'])>0) {
	$output .= '<input class="submitButton" name="influencer-mail" type="submit" onclick="location.href=mailto\''.$atts['mail'].'\';" value="e-mail" />';
	}
if (strlen($atts['linkedin'])>0) {
	$output .= '<input class="submitButton" name="influencer-linkedin" type="submit" onclick="location.href=\''.$atts['linkedin'].'\';" value="LinkedIn" />';
	}
$output .= '</aside>';

return $output;
}

add_shortcode( 'influencers', 'insertar_influencers' );



function autoset_featured() {
          global $post;
          $already_has_thumb = has_post_thumbnail($post->ID);
              if (!$already_has_thumb)  {
              $attached_image = get_children( "post_parent=$post->ID&post_type=attachment&post_mime_type=image&numberposts=1" );
                          if ($attached_image) {
                                foreach ($attached_image as $attachment_id => $attachment) {
                                set_post_thumbnail($post->ID, $attachment_id);
                                }
                           }
                        }
      }
add_action('the_post', 'autoset_featured');
add_action('save_post', 'autoset_featured');
add_action('draft_to_publish', 'autoset_featured');
add_action('new_to_publish', 'autoset_featured');
add_action('pending_to_publish', 'autoset_featured');
add_action('future_to_publish', 'autoset_featured');





/**
 * Child Theme Path
 */
function theme_path(){
	return get_stylesheet_directory_uri();
}


/**
 * Child Theme JS Path
 */
function js_path(){
	return theme_path() . "/js/";
}


/**
 * Child Theme CSS Path
 */
function css_path(){
	return theme_path() . "/css/";
}


/**
 * Child Theme Vendor Path
 */
function vendor_path(){
	return theme_path() . "/static/vendor/";
}


/**
 * Child Theme Images Path
 */
function images_path(){
	return theme_path() . "/images/";
}


/**
 * Custom Scripts
 */
add_action( 'wp_enqueue_scripts', 'load_custom_scripts' );
function load_custom_scripts() {
	
	if ( ! is_admin() ) {
		// global $wp_query;

		/**
		 * Scripts
		 */

		wp_register_script( 'owl-carousel', vendor_path() . 'owl.carousel/owl.carousel.min.js', 'jquery', '2.2.1', true );
		wp_enqueue_script( 'owl-carousel' );

		wp_register_script( 'main-scripts', js_path() . 'scripts.js', 'jquery', '1.0', true );
		wp_enqueue_script( 'main-scripts' );

		/**
		 * Styles
		 */
		wp_register_style( 'owl-carousel-min', vendor_path() .'owl.carousel/assets/owl.carousel.min.css' );
		wp_enqueue_style( 'owl-carousel-min' );
		
		wp_register_style( 'owl-theme-default', vendor_path() .'owl.carousel/assets/owl.theme.default.min.css' );
		wp_enqueue_style( 'owl-theme-default' );

		/* Absolute paths for JS */
		wp_localize_script(
			'main-scripts',
			'paths',
			array(
				'template' => theme_path(),
				'js'       => js_path(),
				'css'      => css_path(),
				'vendor'   => vendor_path(),
				'images'   => images_path()
			)
		);
	}
	
}


/**
 * Option pages
 */
locate_template( '/inc/option-pages.php', true );

/**
 * Theme shortcodes
 */
locate_template( '/inc/shortcodes.php', true );

?>
