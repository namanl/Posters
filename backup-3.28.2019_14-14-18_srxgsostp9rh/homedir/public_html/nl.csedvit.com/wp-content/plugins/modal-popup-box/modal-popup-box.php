<?php
/**
Plugin Name: Modal Popup Box
Plugin URI: https://awplife.com/wordpress-plugins/modal-popup-box-premium/
Description: A set of experimental modal window appearance effects with CSS transitions and animations.An Easy And Powerful modal popup box plugin for wordpress.
Version: 0.3.2
Author: A WP Life
Author URI: https://awplife.com/
License: GPLv2 or later
Text Domain: modal-popup-box
Domain Path: /languages

Modal Popup Box is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Modal Popup Box is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Modal Popup Box. If not, see https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html.
*/

if ( ! class_exists( 'Modal_Popup_Box' ) ) {

	class Modal_Popup_Box {
		
		protected $protected_plugin_api;
		protected $ajax_plugin_nonce;
		
		public function __construct() {
			$this->_constants();
			$this->_hooks();
		}		
		
		protected function _constants() {
			//Plugin Version
			define( 'MPB_PLUGIN_VER', '0.3.2' );
			
			//Plugin Text Domain
			define("MPB_TXTDM","modal-popup-box" );

			//Plugin Name
			define( 'MPB_PLUGIN_NAME', __( 'Modal Popup Box', MPB_TXTDM ) );

			//Plugin Slug
			define( 'MPB_PLUGIN_SLUG', 'modalpopupbox' );

			//Plugin Directory Path
			define( 'MPB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

			//Plugin Directory URL
			define( 'MPB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

			/**
			 * Create a key for the .htaccess secure download link.
			 * @uses    NONCE_KEY     Defined in the WP root config.php
			 */
			define( 'MPB_SECURE_KEY', md5( NONCE_KEY ) );
			
		} // end of constructor function
		
		
		protected function _hooks() {
			
			//Load text domain
			add_action( 'plugins_loaded', array( $this, '_load_textdomain' ) );
			
			//add gallery menu item, change menu filter for multisite
			add_action( 'admin_menu', array( $this, '_srgallery_menu' ), 101 );
			
			//Create Image Gallery Custom Post
			add_action( 'init', array( $this, 'codex_modalpopupbox_init' ));
			
			//Add meta box to custom post
			add_action( 'add_meta_boxes', array( $this, '_admin_add_meta_box' ) );
			 
			//loaded during admin init 
			add_action( 'admin_init', array( $this, '_admin_add_meta_box' ) );
			
			//save setting 
			add_action('save_post', array(&$this, '_mpb_save_settings'));

			//Shortcode Compatibility in Text Widgets
			add_filter('widget_text', 'do_shortcode');
			
			// add pfg cpt shortcode column - manage_{$post_type}_posts_columns
			add_filter( 'manage_modalpopupbox_posts_columns', array(&$this, 'set_modalpopupbox_shortcode_column_name') );
			
			// add pfg cpt shortcode column data - manage_{$post_type}_posts_custom_column
			add_action( 'manage_modalpopupbox_posts_custom_column' , array(&$this, 'custom_modalpopupbox_shodrcode_data'), 10, 2 );

		} // end of hook function
		
		// Modal Box cpt shortcode column before date columns
		public function set_modalpopupbox_shortcode_column_name($defaults) {
			$new = array();
			$shortcode = $columns['modalpopupbox_shortcode'];  // save the tags column
			unset($defaults['tags']);   // remove it from the columns list

			foreach($defaults as $key=>$value) {
				if($key=='date') {  // when we find the date column
				   $new['modalpopupbox_shortcode'] = __( 'Shortcode', MPB_TXTDM );  // put the tags column before it
				}    
				$new[$key] = $value;
			}
			return $new;  
		}
		
		// Modal Box cpt shortcode column data
		public function custom_modalpopupbox_shodrcode_data( $column, $post_id ) {
			switch ( $column ) {
				case 'modalpopupbox_shortcode' :
					echo "<input type='text' class='button button-primary' id='modalpopupbox-shortcode-$post_id' value='[MPBOX id=$post_id]' style='font-weight:bold; background-color:#32373C; color:#FFFFFF; text-align:center;' />";
					echo "<input type='button' class='button button-primary' onclick='return MODALCopyShortcode$post_id();' readonly value='Copy' style='margin-left:4px;' />";
					echo "<span id='copy-msg-$post_id' class='button button-primary' style='display:none; background-color:#32CD32; color:#FFFFFF; margin-left:4px; border-radius: 4px;'>copied</span>";
					echo "<script>
						function MODALCopyShortcode$post_id() {
							var copyText = document.getElementById('modalpopupbox-shortcode-$post_id');
							copyText.select();
							document.execCommand('copy');
							
							//fade in and out copied message
							jQuery('#copy-msg-$post_id').fadeIn('1000', 'linear');
							jQuery('#copy-msg-$post_id').fadeOut(2500,'swing');
						}
						</script>
					";
				break;
			}
		}
		
		public function _load_textdomain() {
			load_plugin_textdomain( MPB_TXTDM, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}
		
		public function _srgallery_menu() {
			$featured_plugin_menu = add_submenu_page( 'edit.php?post_type='.MPB_PLUGIN_SLUG, __( 'Featured-Plugin', MPB_TXTDM ), __( 'Featured Plugin', MPB_TXTDM ), 'administrator', 'sr-featured-plugin-page', array( $this, '_featured_plugin_page') );
			$buy_plugin_page = add_submenu_page( 'edit.php?post_type='.MPB_PLUGIN_SLUG, __( 'Upgrade Plugin', MPB_TXTDM ), __( 'Upgrade Plugin', MPB_TXTDM ), 'administrator', 'sr-upgrade-mpb-page', array( $this, '_buy_mpb_page') );
			$theme_menu    = add_submenu_page( 'edit.php?post_type='.MPB_PLUGIN_SLUG, __( 'Our Theme', MPB_TXTDM ), __( 'Our Theme', MPB_TXTDM ), 'administrator', 'sr-theme-page', array( $this, '_theme_page') );
		}
		
	
		// Modal Popup Box Custom Post Type
		function codex_modalpopupbox_init() {
			$labels = array(
				'name'               => __( 'Modal Popup Box', 'post type general name', MPB_TXTDM ),
				'singular_name'      => __( 'Modal Popup Box', 'post type singular name', MPB_TXTDM ),
				'menu_name'          => __( 'Modal Popup Box', MPB_TXTDM ),
				'name_admin_bar'     => __( 'Modal Popup Box', 'add new on admin bar', MPB_TXTDM ),
				'add_new'            => __( 'Add New', MPB_TXTDM ),
				'add_new_item'       => __( 'Add New Modal Popup Box', MPB_TXTDM ),
				'new_item'           => __( 'New Modal Popup Box', MPB_TXTDM ),
				'edit_item'          => __( 'Edit Modal Popup Box', MPB_TXTDM ),
				'view_item'          => __( 'View Modal Popup Box', MPB_TXTDM ),
				'all_items'          => __( 'All Modal Popup Box', MPB_TXTDM ),
				'search_items'       => __( 'Search Modal Popup Box', MPB_TXTDM ),
				'parent_item_colon'  => __( 'Parent Modal Popup Box', MPB_TXTDM ),
				'not_found'          => __( 'No Modal Popup Box found', MPB_TXTDM ),
				'not_found_in_trash' => __( 'No Modal Popup Box found in Trash', MPB_TXTDM )
				
			);

			$args = array(
				'labels'             => $labels,
				'description'        => __( 'Description', MPB_TXTDM ),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'modalpopupbox' ),
				'capability_type'    => 'page',
				'menu_icon'           => 'dashicons-archive',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => array( 'title','editor')
				
			);

			register_post_type( 'modalpopupbox', $args );
		}
		
		public function _admin_add_meta_box() {
			// Syntax: add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
			add_meta_box( __('Modal Box Settings', MPB_TXTDM), __('Modal Box Settings', MPB_TXTDM), array(&$this, 'mpb_metabox_function'), 'modalpopupbox', 'normal', 'default' );
		    add_meta_box( __('Upgrade Modal Popup Pro', MPB_TXTDM), __('Upgrade Modal Popup Pro', MPB_TXTDM), array(&$this, 'mpb_upgrade_pro'), 'modalpopupbox', 'side', 'default' );
			add_meta_box( __('Rate Our Plugin', MPB_TXTDM), __('Rate Our Plugin', MPB_TXTDM), array(&$this, 'mpb_rate_plugin'), 'modalpopupbox', 'side', 'default' );
		}
		// meta upgrade pro
		public function mpb_upgrade_pro() { ?>
			<img src="<?php echo MPB_PLUGIN_URL ?>img/model-popup-box-premium.jpg"/ width="250" height="280">
			<a href="https://awplife.com/demo/model-popup-box-pemium/" target="_new" class="button button-primary button-large" style="background: #008EC2; text-shadow: none; margin-top:10px"><span class="dashicons dashicons-search" style="line-height:1.4;" ></span> Live Demo</a>
			<a href="https://awplife.com/wordpress-plugins/modal-popup-box-premium/" target="_new" class="button button-primary button-large" style="background: #008EC2; text-shadow: none; margin-top:10px"><span class="dashicons dashicons-unlock" style="line-height:1.4;" ></span> Upgrade Pro</a>
		<?php }
		
		// meta rate us
		Public function mpb_rate_plugin() { ?>
		<div style="text-align:center">
			<p><?php _e('If you like our plugin then please', MPB_TXTDM); ?> <b><?php _e('Rate us', MPB_TXTDM); ?></b><?php _e('on WordPress', MPB_TXTDM); ?> </p>
		</div>
		<div style="text-align:center">
			<span class="dashicons dashicons-star-filled"></span>
			<span class="dashicons dashicons-star-filled"></span>
			<span class="dashicons dashicons-star-filled"></span>
			<span class="dashicons dashicons-star-filled"></span>
			<span class="dashicons dashicons-star-filled"></span>
		</div>
		<br>
		<div style="text-align:center">
			<a href="https://wordpress.org/support/plugin/modal-popup-box/reviews/?filter=5" target="_new" class="button button-primary button-large" style="background: #008EC2; text-shadow: none;"><span class="dashicons dashicons-heart" style="line-height:1.4;" ></span><?php _e('Please Rate Us', MPB_TXTDM); ?></a>
		</div>	
		<?php } 
		
		public function mpb_metabox_function($post) { 
			wp_enqueue_script('jquery');
			
			//css
			wp_enqueue_style('mbp-bootstrap-css', MPB_PLUGIN_URL . 'css/bootstrap.css');
			wp_enqueue_style('mbp-font-awesome-css', MPB_PLUGIN_URL . 'css/font-awesome.css');
			wp_enqueue_style('mbp-animate-css', MPB_PLUGIN_URL.'css/animate.css' );			
			wp_enqueue_style('mbp-styles-css', MPB_PLUGIN_URL.'css/styles.css' );			
			
			//js
			wp_enqueue_style('wp-color-picker' );
			wp_enqueue_script('mbp-bootstrap-js', MPB_PLUGIN_URL .'js/bootstrap.js', array('jquery'), '' , true);
			wp_enqueue_script('mbp-color-picker-js', MPB_PLUGIN_URL .'js/mb-color-picker.js', array( 'wp-color-picker' ), false, true );
			?>
			<h1><?php _e('Copy Modal Popup Box Shortcode', MPB_TXTDM); ?></h1>
			<hr>
			<p class="input-text-wrap">
				<p><?php _e('Copy & Embed shotcode into any Page/ Post / Text Widget to display your Modal popup box on site', MPB_TXTDM); ?><br></p>
				<input type="text" name="shortcode" id="shortcode" value="<?php echo "[MPBOX id=".$post->ID."]"; ?>" readonly style="height: 60px; text-align: center; font-size: 24px; width: 25%; border: 2px dashed;" >
			</p>
			<br>
			<br>
			<h1><?php _e('Modal Popup Box Setting', MPB_TXTDM); ?></h1>
			<hr>
			<?php
			require_once("modal-popup-box-settings.php");
		} // end of upload multiple image
		
		public function _mpb_save_settings($post_id) {
			if(isset($_POST['mpb_save_nonce'])) {
				if ( !isset( $_POST['mpb_save_nonce'] ) || !wp_verify_nonce( $_POST['mpb_save_nonce'], 'mpb_save_settings' ) ) {
				   print 'Sorry, your nonce did not verify.';
				   exit;
				} else {
					$awl_modal_popup_box_shortcode_setting = "awl_mpb_settings_".$post_id;
					update_post_meta($post_id, $awl_modal_popup_box_shortcode_setting, base64_encode(serialize($_POST)));
				}	
			}
		}// end save setting
	
		public function _featured_plugin_page() {
			require_once('featured-plugins/featured-plugins.php');
		}
		public function _buy_mpb_page() {
			require_once('buy-mpb-premium.php');
		}
	
		// theme page
		public function _theme_page() {
			require_once('our-theme/awp-theme.php');
		}
	} // end of class

	/**
	 * Instantiates the Class
	 * @since     3.0
	 * @global    object	$ig_gallery_object
	 */
	$mpbox_object = new Modal_Popup_Box();
	require_once('modal-popup-box-shortcode.php');
	
} // end of class exists
?>