<?php
/**
 * 'popup_anything' Shortcode
 * 
 * @package Popup anything on click
 * @since 1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function popupaoc_popup_anything_shortcode( $atts, $content = null ) {
	
	global $paoc_popup_data;
	
	// Shortcode Parameter
	extract(shortcode_atts(array(
		'id'     		=> 0		
	), $atts));

	// If id is not there then return
	if( empty($id) ) {
		return $content;
	}
	
	// Enqueus required script	
	wp_enqueue_script('popupaoc-legacy-js');
	wp_enqueue_script('popupaoc-popup-js');
	
	// Taking some variables
	$prefix = POPUPAOC_META_PREFIX; // Metabox prefix

	// Getting post data
	$post_data = get_post($id);
	$unique = popupaoc_get_unique();	
	
	ob_start();
	// If it is button post type and post is publish
	if(isset($post_data->post_type) && $post_data->post_type == POPUPAOC_POST_TYPE && $post_data->post_status == 'publish') {
		
		// Getting button type
		$popup_type 			= get_post_meta( $id, $prefix.'popup_type', true );
		$popup_link_txt 		= get_post_meta( $id, $prefix.'popup_link_txt', true );
		$popup_button_txt 		= get_post_meta( $id, $prefix.'popup_button_txt', true );
		$popup_image_url 		= get_post_meta( $id, $prefix.'popup_image_url', true );
		$attachment_id 			= attachment_url_to_postid( $popup_image_url );
		$image_alt 				= get_post_meta( $attachment_id, '_wp_attachment_image_alt', true); 	
		$full_screen 			= get_post_meta( $id, $prefix.'full_screen', true );
		$enable_loader 			= get_post_meta( $id, $prefix.'enable_loader', true );
		$enable_ovelay 			= get_post_meta( $id, $prefix.'enable_ovelay', true );
		$popup_effect 			= get_post_meta( $id, $prefix.'popup_effect', true );
		$popup_positionx 		= get_post_meta( $id, $prefix.'popup_positionx', true );
		$popup_positiony 		= get_post_meta( $id, $prefix.'popup_positiony', true );
		$speedin 				= get_post_meta( $id, $prefix.'speedin', true );
		$speedout 				= get_post_meta( $id, $prefix.'speedout', true );
		$delay 					= get_post_meta( $id, $prefix.'delay', true );
		
		if(empty($speedin)){ $speedin = 300; }
		if(empty($speedout)){ $speedout = 300; }
		if(empty($delay)){ $delay = 150; }
		
		$popup_content 			= do_shortcode( wpautop($post_data->post_content) );

		// Assigning it into global var
		$paoc_popup_data[ $unique ] = $popup_content;

		// Creating Popup Configuration			
		
		$data_popupaoc_str = '{"content":';
		$data_popupaoc_str .= '{ "target" : "#paoc-modal-'.$unique.'", "effect": "'.$popup_effect.'", "positionX": "'.$popup_positionx.'", "positionY": "'.$popup_positiony.'", "fullscreen": '.$full_screen.', "speedIn": '.$speedin.', "speedOut": '.$speedout.', "delay": '.$delay.'},';	
		$data_popupaoc_str .= '"loader":';
		$data_popupaoc_str .= '{"active": '.$enable_loader.'},';
		$data_popupaoc_str .= '"overlay":';	
		$data_popupaoc_str .= '{"active": '.$enable_ovelay.'}';	
		$data_popupaoc_str .= '}';
		
		// If it is a simple button
		if($popup_type == 'simple_link') { ?>
			<a class="paoc-popup popupaoc-link" href="javascript:void(0);" data-conf='<?php echo $data_popupaoc_str;?>'><?php echo $popup_link_txt;?></a>
		<?php }
		elseif($popup_type == 'image'){	?>
			<a class="paoc-popup popupaoc-link-image" href="javascript:void(0);" data-conf='<?php echo $data_popupaoc_str;?>'><img class="popupaoc-img" src="<?php echo esc_url($popup_image_url);?>" alt="<?php echo esc_attr($image_alt); ?>" /></a>
		<?php } else { ?>
			<a class="paoc-popup popupaoc-button" href="javascript:void(0);" data-conf='<?php echo $data_popupaoc_str;?>'><?php echo $popup_button_txt;?></a>
			
	<?php }
	}
	$content .= ob_get_clean();
	return $content;
	
}
// 'popup_anything' shortcode
add_shortcode('popup_anything', 'popupaoc_popup_anything_shortcode');