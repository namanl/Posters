<?php
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if (!class_exists("custom_slider_Settings")) :
?>
<?php
/*  
	Create slider settings page for our plugin.
	
	- We show how to render our own controls using HTML.
	- We show how to get WordPress to render controls for us using do_settings_sections'
	
	WordPress Settings API tutorials
	http://codex.wordpress.org/Settings_API
	http://ottopress.com/2009/wordpress-settings-api-tutorial/
*/
if(isset($_POST['save_options']))
		{
		 include('customsliderdb.php');
		}
class custom_slider_Settings {

	public static $default_settings = 
		array( 	
			  	'slider_text' => 'Test text',
			  	'slider_checkbox1' => 'apples',
				'slider_checkbox2' => 'oranges',
			  	'mbox_slider_text' => 'custom slider plugin by customShake',
			  	'mbox_slider_checkbox1' => 'grapes',
				'mbox_slider_checkbox2' => 'lemons'
				);
	var $pagehook, $page_id, $settings_field, $options;

	
	function __construct() {	
		$this->page_id = 'custom_slider';
		// This is the get_options slug used in the database to store our plugin option values.
		$this->settings_field = 'custom_slider_options';
		$this->options = get_option( $this->settings_field );

		add_action('admin_init', array($this,'admin_init'), 20 );
		add_action( 'admin_menu', array($this, 'admin_menu'), 20);
	}
	
	function admin_init() {
		register_setting( $this->settings_field, $this->settings_field, array($this, 'sanitize_theme_options') );
		add_option( $this->settings_field, custom_slider_Settings::$default_settings );
		
		
		/* 
			This is needed if we want WordPress to render our settings interface
			for us using -
			do_settings_sections
			
			It sets up different sections and the fields within each section.
		*/
		add_settings_section('custom_main', '',  
			array($this, 'main_section_text'), 'slider_settings_page');

		add_settings_field('slider_text', 'slider Text', 
			array($this, 'render_slider_text'), 'slider_settings_page', 'custom_main');

		add_settings_field('slider_checkbox1', 'slider Checkboxes', 
			array($this, 'render_slider_checkbox'), 'slider_settings_page', 'custom_main', 
			array('id' => 'slider_checkbox1', 'value' => 'apples', 'text' => 'Apples') );
		add_settings_field('slider_checkbox2', '', 
			array($this, 'render_slider_checkbox'), 'slider_settings_page', 'custom_main',
			array('id' => 'slider_checkbox2', 'value' => 'oranges', 'text' => 'Oranges') );
	}

	function admin_menu() {
		if ( ! current_user_can('update_plugins') )
			return;
	
		// Add a new submenu to the standard Settings panel
		$this->pagehook = $page =  add_options_page(	
			__('custom slider', 'custom_slider'), __('custom slider', 'custom_slider'), 
			'administrator', $this->page_id, array($this,'render') );
		
		// Executed on-load. Add all metaboxes.
		add_action( 'load-' . $this->pagehook, array( $this, 'metaboxes' ) );

		// Include js, css, or header *only* for our settings page
		add_action("admin_print_scripts-$page", array($this, 'js_includes'));
//		add_action("admin_print_styles-$page", array($this, 'css_includes'));
		add_action("admin_head-$page", array($this, 'admin_head') );
	}

	function admin_head() { ?>
<style>
		.settings_page_custom_slider label { display:inline-block; width: 150px; }
		</style>
<?php }

     
	function js_includes() {
		// Needed to allow metabox layout and close functionality.
		wp_enqueue_script( 'postbox' );
	}


	/*
		Sanitize our plugin settings array as needed.
	*/	
	function sanitize_theme_options($options) {
		$options['slider_text'] = stripcslashes($options['slider_text']);
		return $options;
	}


	/*
		Settings access functions.
		
	*/
	protected function get_field_name( $name ) {

		return sprintf( '%s[%s]', $this->settings_field, $name );

	}

	protected function get_field_id( $id ) {

		return sprintf( '%s[%s]', $this->settings_field, $id );

	}

	protected function get_field_value( $key ) {

		return $this->options[$key];

	}
		

	/*
		Render settings page.
		
	*/
	
	function render() {
		global $wp_meta_boxes;

		$title = __('custom slider', 'custom_slider');
		?>
<div class="wrap">
  <h2><?php echo esc_html( $title ); ?></h2>
  <?php $pageURL = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; ?>
  <p>
    <?php
                 if(!isset($_REQUEST['showall'])==true)
   {
	   ?>
  <form method="post" action="" enctype="multipart/form-data">
  <input type="submit" class="button button-primary" name="save_options" value="<?php esc_attr_e('Save Options'); ?>" />
  <?php } else { ?>
  <form method="post" enctype="multipart/form-data"<?php if(isset($_REQUEST['edit'])) { ?> action="" <?php } ?>>
    <a href="?page=custom_slider<?php if(isset($_REQUEST['edit'])) { ?>&showall=true<?php } ?>">
    <input type="button" class="button button-primary" name="back_options" value="<?php esc_attr_e('Back to options'); ?>" />
    </a>
    <?php } ?>
    <a href="?page=custom_slider&showall=true">
    <input type="button" class="button button-primary" name="all_images" value="<?php esc_attr_e('All Images'); ?>" />
    </a>
    </p>
    <div class="metabox-holder">
      <div class="postbox-container" style="width: 99%;">
        <?php 
						// Render metaboxes
                        settings_fields($this->settings_field); 
                        do_meta_boxes( $this->pagehook, 'main', null );
                      	if ( isset( $wp_meta_boxes[$this->pagehook]['column2'] ) )
 							do_meta_boxes( $this->pagehook, 'column2', null );
                    ?>
      </div>
    </div>
    <p>
      <?php
                 if(!isset($_REQUEST['showall'])==true)
   {
	   ?>
      <input type="submit" class="button button-primary" name="save_options" value="<?php esc_attr_e('Save Options'); ?>" />
      <?php
   } elseif(!isset($_REQUEST['edit'])) { ?>
      <input type="submit" name="saveorder" id="confirm" value="Save Order" class="button button-primary" />
      <?php } ?>
    </p>
  </form>
   <div class="cs-sidebox" id="cs-help">
	<h3>Shortcode</h3>
	
	<p>Please use this shortcode to insert slider to any page,any post or any widget.</p>
	<em><strong>[mainslider]</strong></em>
	
	<p>Or you can place this to any custom template like as follows:</p> 
	<em><strong><pre>&lt;?php echo do_shortcode('[mainslider]'); ?&gt;</pre></strong></em>

</div>
  <div class="cs-sidebox" id="cs-help">
	<h3>Need Support?</h3>
	
	<p>Please ask your question in the <a target="_blank" href="http://wordpress.org/support/plugin/watu">support forum at Wordpress.</a></p>
	
	<p>Or you can mail me as well at: <em><strong>ashish.sharma537@gmail.com</strong></em></p>
</div>
</div>
<!-- Needed to allow metabox layout and close functionality. -->
<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready( function ($) {
				// close postboxes that should be closed
				
				$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				// postboxes setup
				postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
				
				$( "#choose" ).change(function() {
					var tyoe= $(this).val();
					
					$(".myoptions").hide();
					$("#"+tyoe).show();
					$(".tit").show();

});
			});
			
		</script>
<?php }
	
	
	function metaboxes() {

   if(!isset($_REQUEST['showall'])==true)
   {
		// slider metabox showing plugin version and release date. 
		// Also includes and slider input text box, rendered in HTML in the info_box function
		add_meta_box( 'custom-slider-version', __( 'Information', 'custom_slider' ), array( $this, 'info_box' ), $this->pagehook, 'main', 'high' );

		// slider metabox containing two slider checkbox controls.
		// Also includes and slider input text box, rendered in HTML in the condition_box function
		

		// slider metabox containing an slider text box & two slider checkbox controls.
		// slider settings rendered by WordPress using the do_settings_sections function.
		

   }
   else
   {
	   add_meta_box( 'custom-slider-version', __( 'Information', 'custom_slider' ), array( $this, 'info_all' ), $this->pagehook, 'main', 'high' );
   }
	}

	function info_box() {


		?>
<div id="choosediv">
  <select name="choose" id="choose">
    <option value="" selected="selected">Select method</option>
    <option value="manually">Upload image</option>
    <option value="youtube">Youtube Video</option>
    <option value="featured">Featured Image</option>
  </select>
</div>
<br>
<div class="myoptions" id="manually" style="display:none;">
  <label for="">
  <?php _e( 'Slider Images', 'custom_slider' ); ?>
  </label>
  <input type="file" name="file" accept="image/*" />
</div>
<div class="myoptions" id="youtube" style="display:none;">
  <label for="">
  <?php _e( 'Youtube Video', 'custom_slider' ); ?>
  </label>
  <input type="text" name="youtubevideo" id="youtubevideo">
</div>
<div class="myoptions" id="featured" style="display:none;">
  <label for="">
  <?php _e( 'Featured Image', 'custom_slider' ); ?>
  </label>
  <?php wp_dropdown_pages(); ?>
</div>
<input type="hidden" name="thumbtitle" id="title" class="tit" style="display:none;" />
<?php

	}
	
	function info_all() {
		global $wpdb;
	 
		?>
<style type="text/css">
           
            #loading{
                width: 100%;
                position: absolute;
                top: 100px;
                left: 100px;
				margin-top:200px;
            }
            #container .pagination ul li.inactive,
            #container .pagination ul li.inactive:hover{
                background-color:#ededed;
                color:#bababa;
                border:1px solid #bababa;
                cursor: default;
            }
            #container .data ul li{
                list-style: none;
                font-family: verdana;
                margin: 5px 0 5px 0;
                color: #000;
                font-size: 13px;
            }

            #container .pagination{
                width: 800px;
                height: 25px;
            }
            #container .pagination ul li{
                list-style: none;
                float: left;
                border: 1px solid #006699;
                padding: 2px 6px 2px 6px;
                margin: 0 3px 0 3px;
                font-family: arial;
                font-size: 14px;
                color: #006699;
                font-weight: bold;
                background-color: #f2f2f2;
            }
            #container .pagination ul li:hover{
                color: #fff;
                background-color: #006699;
                cursor: pointer;
            }
			.go_button
			{
			background-color:#f2f2f2;border:1px solid #006699;color:#cc0000;padding:2px 6px 2px 6px;cursor:pointer;position:absolute;margin-top:-1px;
			}
			.total
			{
			float:right;font-family:arial;color:#999;
			}
			.editbox
			{
			display:none;
			
			}
			td, th
			{
			width:30%;
			text-align:left;;
			padding:5px;
			}
			.editbox
			{
			padding:4px;
			
			}
	
        </style>
<div id="container">
<?php
if(isset($_REQUEST['edit']))
{
	$id=$_REQUEST['edit'];
$query_pag_data=$wpdb->get_results("select * from ".$wpdb->prefix."customslider_images where id=$id");
?>
<table style="float:right;width:390px;">
  <tr>
    <td><?php

if($query_pag_data[0]->typem == "manually")
	{
		?>
      <img src="<?php echo site_url(); ?>/wp-content/uploads/slider/<?php echo $query_pag_data[0]->imageurl; ?>" height="200" width="200" />
      <?php
	}
	if($query_pag_data[0]->typem == "youtube")
	{
		?>
      <iframe width="200" u="image" height="200" class="popup-youtube-player" pHandler="ytiframe" pHideControls="0" src="//www.youtube.com/embed/<?php echo $query_pag_data[0]->youtube; ?>?enablejsapi=1&version=3&playerapiid=ytplayer&fs=1&wmode=transparent" frameborder="0" allowfullscreen></iframe>
      <div u="cover" class="videoCover" style="position: absolute; top: 0px; left: 0px; background-color: #000; background-image: url(<?php echo plugins_url(); ?>/customslider/images/play.png); background-position: center center; background-repeat: no-repeat; filter: alpha(opacity=40); opacity: .4; cursor: pointer; display: none; z-index: 1;">
      <?php
	}
	if($query_pag_data[0]->typem == "featured")
	{
		?>
      <img u="thumb" src="<?php echo $query_pag_data[0]->imageurl; ?>" height="200" width="200" my="featured" />
      <?php
	}


?>
    </td>
  </tr>
</table>
<form name="editform" id="editform" method="post" action="" >
  <table>
    <tr>
    
      <td><input type="hidden" name="thumbtitle" id="thumbtitle" value="<?php echo $query_pag_data[0]->imagename; ?>">
      </td>
    </tr>
    <tr>
      <td>Change Image :</td>
      <td><div id="choosediv">
          <select name="choose" id="choose">
            <option value="manually"<?php if($query_pag_data[0]->typem == "manually") { ?> selected="selected" <?php  } ?>>Upload image</option>
            <option value="youtube" <?php if($query_pag_data[0]->typem == "youtube") { ?> selected="selected" <?php  } ?>>Youtube Video</option>
            <option value="featured" <?php if($query_pag_data[0]->typem == "featured") { ?> selected="selected" <?php  } ?>>Featured Image</option>
          </select>
        </div></td>
      <td><div class="myoptions" id="manually" style="display:none;">
          <label for="">
          <?php _e( 'Upload Image', 'custom_slider' ); ?>
          </label>
          <input type="file" name="file" accept="image/*" />
        </div>
        <div class="myoptions" id="youtube" style="display:none;">
          <label for="">
          <?php _e( 'Youtube Video', 'custom_slider' ); ?>
          </label>
          <input type="text" name="youtubevideo" id="youtubevideo">
        </div>
        <div class="myoptions" id="featured" style="display:none;">
          <label for="">
          <?php _e( 'Featured Image', 'custom_slider' ); ?>
          </label>
          <?php wp_dropdown_pages(); ?>
        </div></td>
    </tr>
    <tr>
      <td><input type="hidden" name="editid" id="editid" value="<?php echo $_REQUEST['edit']; ?>" />
        <input type="hidden" name="mainvar" id="" value="<?php echo $query_pag_data[0]->imageurl; ?>" />
        <input type="hidden" name="vidid" id="" value="<?php echo $query_pag_data[0]->youtube; ?>" />
        <input type="hidden" name="typem" id="" value="<?php echo $query_pag_data[0]->typem; ?>" />
        <input type="submit" name="confirm" id="confirm" value="Submit" class="button button-primary" />
      </td>
    </tr>
  </table>
</form>
<div style="clear:both;"></div>
<?php	
}
else
{
$query_pag_data=$wpdb->get_results("select * from ".$wpdb->prefix."customslider_images order by slideorder asc");

?>
<table>
  <tr>
    <th>Image</th>
    <th>Title</th>
    <th>Order</th>
    <th>Edit</th>
    <th>Delete</th>
  </tr>
  <?php foreach($query_pag_data as $myim)
{
	?>
  <tr class='edit_tr'>
    <td class='edit_td' ><span id='one' class='text'>
      <?php
if($myim->typem == "manually")
	{
		?>
      <img src="<?php echo site_url(); ?>/wp-content/uploads/slider/<?php echo $myim->imageurl; ?>" height="100" width="100" />
      <?php
	}
	if($myim->typem == "youtube")
	{
		?>
      <img src="http://img.youtube.com/vi/<?php echo $myim->youtube; ?>/maxresdefault.jpg" height="100" width="100" />
      <?php
	}
	if($myim->typem == "featured")
	{
		?>
      <img src="<?php echo $myim->imageurl; ?>" height="100" width="100"  />
      <?php
	}
?>
      </span> </td>
    <td class='edit_td' ><span class='text'><?php echo $myim->imagename; ?></span> </td>
    <td class='edit_td' ><span class='text'>
      <input type="text" name="sliderorder[<?php echo $myim->id;?>]" value="<?php echo $myim->slideorder ; ?>">
      </span> </td>
    <td class='edit_td' ><span class='text'><a href="?page=custom_slider&showall=true&edit=<?php echo $myim->id;?>">
      <input type="button" class="button button-primary text213" value="Edit"  />
      </a></span> </td>
    <td class='edit_td' ><span class='text'><a href="?page=custom_slider&showall=true&delete=<?php echo $myim->id;?>">
      <input type="button" class="button button-primary text213" value="Delete"  />
      </a></span> </td>
  </tr>
  <?php
}
	?>
</table>
<?php
}
echo "</div>";
	}
	
	
	


	function do_settings_box() {
		do_settings_sections('slider_settings_page'); 
	}
	
	/* 
		WordPress settings rendering functions
		
		ONLY NEEDED if we are using wordpress to render our controls (do_settings_sections)
	*/
																	  
																	  
	function main_section_text() {
		echo '<p>Some slider inputs.</p>';
	}
	
	function render_slider_text() { 
		?>
<input id="slider_text" style="width:50%;"  type="text" name="<?php echo $this->get_field_name( 'slider_text' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'slider_text' ) ); ?>" />
<?php 
	}
	
	function render_slider_checkbox($args) {
		$id = 'custom_slider_options['.$args['id'].']';
		?>
<input name="<?php echo $id;?>" type="checkbox" value="<?php echo $args['value'];?>" <?php echo isset($this->options[$args['id']]) ? 'checked' : '';?> />
<?php echo " {$args['text']}"; ?> <br/>
<?php 
	}
	

} // end class
endif;

        if(isset($_REQUEST['delete']))
		{
		global $wpdb;
			$id=mysql_escape_String($_REQUEST['delete']);
$sql = "delete from ".$wpdb->prefix."customslider_images where id='$id'";
$wpdb->query($sql);
header('location:'.$_SERVER['HTTP_REFERER']);

		}  
		 if(isset($_REQUEST['saveorder']))
		{
		global $wpdb;
		$te=$_REQUEST['sliderorder'];
		foreach($te as $key=>$val)
		{
		mysql_query("update ".$wpdb->prefix."customslider_images set slideorder=$val where id=$key");
		}
		header('location:'.$_SERVER['HTTP_REFERER']);

		}  
		
?>