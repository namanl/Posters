<?php
/*
Plugin Name: Coustomslider Plugin
Plugin URI: wordpress-slider-plugin
Description: The custom slider plugin.
Version: 1.6.2
Author: Ashish sharma
*/
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
define( 'Customslider_slider_VERSION', '1.6.2' );
define( 'Customslider_slider_RELEASE_DATE', date_i18n( 'F j, Y', '1397937230' ) );
define( 'Customslider_slider_DIR', plugin_dir_path( __FILE__ ) );
define( 'Customslider_slider_URL', plugin_dir_url( __FILE__ ) );
if (!class_exists("custom_slider")) :
class custom_slider {
	var $settings, $options_page;
	
	function __construct() {	

		if (is_admin()) {
			// Load slider settings page
			if (!class_exists("customslider"))
				require(Customslider_slider_DIR . 'customslider-ex-settings.php');
			$this->settings = new custom_slider_Settings();	
		}
		
		add_action('init', array($this,'init') );
		add_action('admin_init', array($this,'admin_init') );
		add_action('admin_menu', array($this,'admin_menu') );
		
		register_activation_hook( __FILE__, array($this,'activate') );
		register_deactivation_hook( __FILE__, array($this,'deactivate') );
	}

	/*
		Propagates pfunction to all blogs within our multisite setup.
		More details -
		http://customshake.com/wordpress-theme/write-a-plugin-for-wordpress-multi-site
		
		If not multisite, then we just run pfunction for our single blog.
	*/
	function network_propagate($pfunction, $networkwide) {
		global $wpdb;

		if (function_exists('is_multisite') && is_multisite()) {
			// check if it is a network activation - if so, run the activation function 
			// for each blog id
			if ($networkwide) {
				$old_blog = $wpdb->blogid;
				// Get all blog ids
				$blogids = $wpdb->get_col("SELECT blog_id FROM {$wpdb->blogs}");
				foreach ($blogids as $blog_id) {
					switch_to_blog($blog_id);
					call_user_func($pfunction, $networkwide);
				}
				switch_to_blog($old_blog);
				return;
			}	
		} 
		call_user_func($pfunction, $networkwide);
	}

	function activate($networkwide) {
		$this->network_propagate(array($this, '_activate'), $networkwide);
	}

	function deactivate($networkwide) {
		$this->network_propagate(array($this, '_deactivate'), $networkwide);
	}

	/*
		Enter our plugin activation code here.
	*/
	function _activate() {
		global $wpdb;
		$table_name = $wpdb->prefix . "customslider_settings";
      
   $sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  optionname VARCHAR(255) NOT NULL,
  optionvalue VARCHAR(255) NOT NULL,
  UNIQUE KEY id (id)
    );";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );
 
   add_option( "jal_db_version", $jal_db_version );
   
   
   $table_name = $wpdb->prefix . "customslider_images";
      
   $sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  imagename VARCHAR(255) NOT NULL,
  imageurl VARCHAR(255) NOT NULL,
  thumburl VARCHAR(255) NOT NULL,
  youtube VARCHAR(255) NOT NULL,
  typem VARCHAR(255) NOT NULL,
 slideorder INT(255) NOT NULL,
  UNIQUE KEY id (id)
    );";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );
 
   add_option( "jal_db_version", $jal_db_version );
		
		 $upload_dir = wp_upload_dir();
  $upload_loc=$upload_dir['basedir']."/slider";
  if (!is_dir($upload_loc)) {
    wp_mkdir_p($upload_loc);
  }
	/* For thumbnail width and height */
	
	$myarra=array("thumbnails"=>'1');
	$serialize=serialize($myarra);
	$wpdb->query("insert into ".$wpdb->prefix."customslider_settings(optionname,optionvalue) values('thumbnail','$serialize')");
	
   
    	
		}

	/*
		Enter our plugin deactivation code here.
	*/
	function _deactivate() {}
	

	/*
		Load language translation files (if any) for our plugin.
	*/
	function init() {
		load_plugin_textdomain( 'custom_slider', custom_slider_DIR . 'lang', 
							   basename( dirname( __FILE__ ) ) . '/lang' );
	wp_register_script( 'jssorcore', plugins_url('/js/jssor.core.js',__FILE__ ));
    wp_register_script( 'jssorutils', plugins_url('/js/jssor.utils.js',__FILE__ ));
    wp_register_script( 'jssorslider', plugins_url('/js/jssor.slider.js',__FILE__ ));
    wp_register_script( 'jssorplayerytiframe', plugins_url('/js/jssor.player.ytiframe.js',__FILE__ ));
	
	}

	function admin_init() {
	}

	function admin_menu() {
	}


	/*
		slider print function for debugging. 
	*/	
	function print_slider($str, $print_info=TRUE) {
		if (!$print_info) return;
		__($str . "<br/><br/>\n", 'custom_slider' );
	}

	/*
		Redirect to a different page using javascript. More details-
		http://customshake.com/wordpress-theme/wordpress-page-redirect
	*/	
	function javascript_redirect($location) {
		// redirect after header here can't use wp_redirect($location);
		?>
<script type="text/javascript">
		  <!--
		  window.location= <?php echo "'" . $location . "'"; ?>;
		  //-->
		  </script>
<?php
		exit;
	}

} // end class
endif;

// Initialize our plugin object.
global $custom_slider;
if (class_exists("custom_slider") && !$custom_slider) {
    $custom_slider = new custom_slider();	
}	

function getslider( $atts ){
	global $wpdb;
	 wp_enqueue_script('jssorcore');
	 wp_enqueue_script('jssorutils');
	 wp_enqueue_script('jssorslider');
	 wp_enqueue_script('jssorplayerytiframe');
	 
	?>
<?php



$useragent=$_SERVER['HTTP_USER_AGENT']; 



if(preg_match('/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))



{ ?>
<script>
        jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: false,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $ThumbnailNavigatorOptions: {
                    $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

                    $Loop: 0,                                       //[Optional] Enable loop(circular) of carousel or not, 0: stop, 1: loop, 2 rewind, default value is 1
                    $SpacingX: 30,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                    $SpacingY: 3,                                   //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                    $DisplayPieces: 2,                              //[Optional] Number of pieces to display, default value is 1
                    $ParkingPosition: 204,                          //[Optional] The offset position to park thumbnail,

                    $ArrowNavigatorOptions: {
                        $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                        $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                        $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                        $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                    }
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {

                //reserve blank width for margin+padding: margin+padding-left (10) + margin+padding-right (10)
                var paddingWidth = 20;

                //minimum width should reserve for text
                var minReserveWidth = 150;

                var parentElement = jssor_slider1.$Elmt.parentNode;

                //evaluate parent container width
                var parentWidth = parentElement.clientWidth;

                if (parentWidth) {

                    //exclude blank width
                    var availableWidth = parentWidth - paddingWidth;

                    //calculate slider width as 70% of available width
                    var sliderWidth = availableWidth * 1.0;

                    //slider width is maximum 600
                    sliderWidth = Math.min(sliderWidth, 1024); 

                    //slider width is minimum 200
                    sliderWidth = Math.max(sliderWidth, 200);

                    //evaluate free width for text, if the width is less than minReserveWidth then fill parent container
                    if (availableWidth - sliderWidth < minReserveWidth) {

                        //set slider width to available width
                        sliderWidth = availableWidth;

                        //slider width is minimum 200
                        sliderWidth = Math.max(sliderWidth, 200);
                    }

                    jssor_slider1.$SetScaleWidth(sliderWidth);
                }
                else
                    window.setTimeout(ScaleSlider, 30);
            }

            ScaleSlider();

            if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
                $(window).bind('resize', ScaleSlider);
            }


          
            //responsive code end
			
			$('.jssora11r,.o,.jssora11l').on('click', function() {
				
    
	$( ".popup-youtube-player" ).each(function( index ) {
$( this )[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');   

});
 });
 $('.o').on('click', function() {
				
   
	var mainimg = $(this).prev('img').attr('src');
	
	if($(this).prev('img').attr('my')=="manually")
	{
		
	var html_value = '<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/fb.jpg"  /></a></li><li><a target="_blank" href="mailto:?subject=default subject&body=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li><li><a target="_blank" href="http://twitter.com/home?status=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/twt.jpg"/></a></li>';	
		$('#social').html('<ul>'+html_value+'</ul>');
	}
	if($(this).prev('img').attr('my')=="youtube")
	{
		
		var vidid = $(this).prev('img').attr('vidid');
		var html_value = '<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=http://www.youtube.com/watch?v=' + vidid + '"><img src="<?php echo plugins_url(); ?>/customslider/images/fb.jpg"  /></a></li><li><a target="_blank" href="mailto:?subject=default subject&body=http://www.youtube.com/watch?v=' + vidid + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li><li><a target="_blank" href="http://twitter.com/home?status=http://www.youtube.com/watch?v=' + vidid + '"><img src="<?php echo plugins_url(); ?>/customslider/images/twt.jpg"/></a></li>';	
		$('#social').html('<ul>'+html_value+'</ul>');
	}
	if($(this).prev('img').attr('my')=="featured")
	{
		
		
		var html_value = '<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/fb.jpg"  /></a></li><li><a target="_blank" href="mailto:?subject=default subject&body=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li><li><a target="_blank" href="http://twitter.com/home?status=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li>';	
		$('#social').html('<ul>'+html_value+'</ul>');
	}
	

});
				
    
	var mainimg = $(".o:first").prev('img').attr('src');
		
	if($(".o:first").prev('img').attr('my')=="manually")
	{
		
	var html_value = '<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/fb.jpg"  /></a></li><li><a target="_blank" href="mailto:?subject=default subject&body=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li><li><a target="_blank" href="http://twitter.com/home?status=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/twt.jpg"/></a></li>';	
		$('#social').html('<ul>'+html_value+'</ul>');
	}
	if($(".o:first").prev('img').attr('my')=="youtube")
	{
		
		var vidid = $(this).prev('img').attr('vidid');
		var html_value = '<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=http://www.youtube.com/watch?v=' + vidid + '"><img src="<?php echo plugins_url(); ?>/customslider/images/fb.jpg"  /></a></li><li><a target="_blank" href="mailto:?subject=default subject&body=http://www.youtube.com/watch?v=' + vidid + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li><li><a target="_blank" href="http://twitter.com/home?status=http://www.youtube.com/watch?v=' + vidid + '"><img src="<?php echo plugins_url(); ?>/customslider/images/twt.jpg"/></a></li>';	
		$('#social').html('<ul>'+html_value+'</ul>');
	}
	if($(".o:first").prev('img').attr('my')=="featured")
	{
		
		
		var html_value = '<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/fb.jpg"  /></a></li><li><a target="_blank" href="mailto:?subject=default subject&body=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li><li><a target="_blank" href="http://twitter.com/home?status=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li>';	
		$('#social').html('<ul>'+html_value+'</ul>');
	}
	



        });
    </script>
<?php
$mainimages=$wpdb->get_results("select * from ".$wpdb->prefix."customslider_images order by slideorder ASC");

?>
<style>
@media (min-width:768px) and (max-width:1200px) {
.slid_out
{
  width:75% !important
}
}

@media (min-width:310px) and (max-width:767px) {
.slid_out
{
  width:90% !important
}
}
</style>
<div  class="slid_out" style="display: block; margin:0 auto;  width: 67%; max-width:960px; min-width: 240px; position:relative;">
<div id="social" style="position:absolute;left:-44px; top:12%;"> </div>
<div id="slider1_container" style="position: relative; width: 960px; margin:auto;  height:735px; overflow: visiable;">
    <!-- Loading Screen -->
    <div u="loading" style="position: absolute; top: 0px; left: 0px;">
        <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;"> </div>
        <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;"> </div>
    </div>
    <!-- Slides Container -->
    <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 960px; height:550px;
            overflow: hidden;">
        <?php foreach($mainimages as $myim)
{
	echo "<div>";
	if($myim->typem == "manually")
	{
		?>
        <img u="image" src="<?php echo site_url(); ?>/wp-content/uploads/slider/<?php echo $myim->imageurl; ?>" my="manually" /> <img u="thumb" src="<?php echo site_url(); ?>/wp-content/uploads/slider/<?php echo $myim->imageurl; ?>" my="manually" />
        <?php
	}
	if($myim->typem == "youtube")
	{
		?>
        <div u="player" style="position: relative; top: 0px; left: 0px; width:960px; height: 550px; overflow: hidden;">
            <iframe width="960px" u="image" height="500" id="popup-youtube-player" pHandler="ytiframe" pHideControls="0" src="//www.youtube.com/embed/<?php echo $myim->youtube; ?>?enablejsapi=1&version=3&playerapiid=ytplayer&fs=1&wmode=transparent" frameborder="0" allowfullscreen></iframe>
            <div u="cover" class="videoCover" style="position: absolute; top: 0px; left: 0px; background-color: #000; background-image: url(<?php echo plugins_url(); ?>/customslider/images/play.png); background-position: center center; background-repeat: no-repeat; filter: alpha(opacity=40); opacity: .4; cursor: pointer; display: none; z-index: 1;"></div>
        </div>
        <img u="thumb" src="http://img.youtube.com/vi/<?php echo $myim->youtube; ?>/maxresdefault.jpg" height="200" width="200" my="youtube" vidid="<?php echo $myim->youtube; ?>" />
        <?php
	}
	if($myim->typem == "featured")
	{
		?>
        <img u="image" src="<?php echo $myim->imageurl; ?>" my="featured" /> <img u="thumb" src="<?php echo $myim->imageurl; ?>" height="200" width="200" my="featured" />
        <?php
	}
	echo "</div>";
}
?>
    </div>
    <div u="thumbnavigator" class="jssort07" style="position: absolute; width: 960px; height:260px; left: 0px; bottom:-40px; overflow: hidden; border-radius:10px; ">
        <div style=" background-color:#e6e6e6;  margin:5px 0 0 0 filter:alpha(opacity=30); width: 100%; height:100%;"></div>
        <!-- Thumbnail Item Skin Begin -->
        <style>
                         			
				.jssort07 .i {
                    position: absolute;
                    top: 0px;
                    left: 0px;
                    width: 300px;
                    height: 200px;
                    filter: alpha(opacity=80);
                    opacity: .8;
                }


        .jssora11l
				  {
					  background:url(<?php bloginfo('url'); ?>/wp-content/plugins/customslider/images/left.png) no-repeat;
					   height: 103px !important;
    width: 52px !important;
				  }
				  
				   .jssora11r
				  {
					  background:url(<?php bloginfo('url'); ?>/wp-content/plugins/customslider/images/right.png) no-repeat;
					   height: 103px !important;
    width: 52px !important;
				  }
                .jssort07 .p:hover .i, .jssort07 .pav .i {
                    filter: alpha(opacity=100);
                    opacity: 1;
                }
              .jssort07 .o {
                    position: absolute;
                    top: 0px;
                    left: 0px;
                    width: 300px;
                    height:200px;
                    transition: border-color .6s;
                    -moz-transition: border-color .6s;
                    -webkit-transition: border-color .6s;
                    -o-transition: border-color .6s;
                }
			

                * html .jssort07 .o {
                    /* ie quirks mode adjust */
                    width /**/: 300px;
                    height /**/: 200px;
                }

                .jssort07 .pav .o, .jssort07 .p:hover .o {
                    border-color: #fff;
                }

                .jssort07 .pav:hover .o {
                    border-color: #0099FF;
                }

                .jssort07 .p:hover .o {
                    transition: none;
                    -moz-transition: none;
                    -webkit-transition: none;
                    -o-transition: none;
                }
            </style>
        <div u="slides" style="cursor: move;">
            <div u="prototype" class="p" style="POSITION: absolute; WIDTH: 300px; HEIGHT:200px; TOP: 0; LEFT: 0;">
                <thumbnailtemplate class="i" style="position:absolute;"></thumbnailtemplate>
                <div class="o"> </div>
            </div>
        </div>
        <!-- Thumbnail Item Skin End -->
        <!-- Arrow Navigator Skin Begin -->
        <style>
                    /* jssor slider arrow navigator skin 11 css */
                    /*
                .jssora11l              (normal)
                .jssora11r              (normal)
                .jssora11l:hover        (normal mouseover)
                .jssora11r:hover        (normal mouseover)
                .jssora11ldn            (mousedown)
                .jssora11rdn            (mousedown)
                */
                    .jssora11l, .jssora11r, .jssora11ldn, .jssora11rdn {
                        position: absolute;
                        cursor: pointer;
                        display: block;
                     
                        overflow: hidden;
                    }

                    .jssora11l {
                       height: 37px;
    left: 18px !important;
    top:70.5px !important;
    width: 37px;
                    }

                    .jssora11r {
                         right: 17px !important;
    top:70.5px !important;
                    }

                   

                    
                    .jssora11ldn {
                        background-position: -251px -41px;
                    }

                    .jssora11rdn {
                        background-position: -311px -41px;
                    }
            </style>
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora11l" style="width: 37px; height: 37px; top: 123px; left: 8px;"> </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora11r" style="width: 37px; height: 37px; top: 123px; right: 8px"> </span>
        <!-- Arrow Navigator Skin End -->
    </div>
</div>
<?php } else {
?>
<script>
        jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: false,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $ThumbnailNavigatorOptions: {
                    $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always

                    $Loop: 0,                                       //[Optional] Enable loop(circular) of carousel or not, 0: stop, 1: loop, 2 rewind, default value is 1
                    $SpacingX: 30,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                    $SpacingY: 3,                                   //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                    $DisplayPieces: 3,                              //[Optional] Number of pieces to display, default value is 1
                    $ParkingPosition: 204,                          //[Optional] The offset position to park thumbnail,

                    $ArrowNavigatorOptions: {
                        $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
                        $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                        $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                        $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                    }
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {

                //reserve blank width for margin+padding: margin+padding-left (10) + margin+padding-right (10)
                var paddingWidth = 20;

                //minimum width should reserve for text
                var minReserveWidth = 150;

                var parentElement = jssor_slider1.$Elmt.parentNode;

                //evaluate parent container width
                var parentWidth = parentElement.clientWidth;

                if (parentWidth) {

                    //exclude blank width
                    var availableWidth = parentWidth - paddingWidth;

                    //calculate slider width as 70% of available width
                    var sliderWidth = availableWidth * 1.0;

                    //slider width is maximum 600
                    sliderWidth = Math.min(sliderWidth, 1024); 

                    //slider width is minimum 200
                    sliderWidth = Math.max(sliderWidth, 200);

                    //evaluate free width for text, if the width is less than minReserveWidth then fill parent container
                    if (availableWidth - sliderWidth < minReserveWidth) {

                        //set slider width to available width
                        sliderWidth = availableWidth;

                        //slider width is minimum 200
                        sliderWidth = Math.max(sliderWidth, 200);
                    }

                    jssor_slider1.$SetScaleWidth(sliderWidth);
                }
                else
                    window.setTimeout(ScaleSlider, 30);
            }

            ScaleSlider();

            if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
                $(window).bind('resize', ScaleSlider);
            }


         
            //responsive code end
			
			$('.jssora11r,.o,.jssora11l').on('click', function() {
				
   
	$( ".popup-youtube-player" ).each(function( index ) {
$( this )[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');   

});
 });
 $('.o').on('click', function() {
				
    
	var mainimg = $(this).prev('img').attr('src');
	
	if($(this).prev('img').attr('my')=="manually")
	{
		
	var html_value = '<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/fb.jpg"  /></a></li><li><a target="_blank" href="mailto:?subject=default subject&body=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li><li><a target="_blank" href="http://twitter.com/home?status=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/twt.jpg"/></a></li>';	
		$('#social').html('<ul>'+html_value+'</ul>');
	}
	if($(this).prev('img').attr('my')=="youtube")
	{
		
		var vidid = $(this).prev('img').attr('vidid');
		var html_value = '<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=http://www.youtube.com/watch?v=' + vidid + '"><img src="<?php echo plugins_url(); ?>/customslider/images/fb.jpg"  /></a></li><li><a target="_blank" href="mailto:?subject=default subject&body=http://www.youtube.com/watch?v=' + vidid + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li><li><a target="_blank" href="http://twitter.com/home?status=http://www.youtube.com/watch?v=' + vidid + '"><img src="<?php echo plugins_url(); ?>/customslider/images/twt.jpg"/></a></li>';	
		$('#social').html('<ul>'+html_value+'</ul>');
	}
	if($(this).prev('img').attr('my')=="featured")
	{
		
		
		var html_value = '<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/fb.jpg"  /></a></li><li><a target="_blank" href="mailto:?subject=default subject&body=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li><li><a target="_blank" href="http://twitter.com/home?status=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li>';	
		$('#social').html('<ul>'+html_value+'</ul>');
	}
	

});
				
   
	var mainimg = $(".o:first").prev('img').attr('src');
	
	if($(".o:first").prev('img').attr('my')=="manually")
	{
		
	var html_value = '<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/fb.jpg"  /></a></li><li><a target="_blank" href="mailto:?subject=default subject&body=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li><li><a target="_blank" href="http://twitter.com/home?status=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/twt.jpg"/></a></li>';	
		$('#social').html('<ul>'+html_value+'</ul>');
	}
	if($(".o:first").prev('img').attr('my')=="youtube")
	{
		
		var vidid = $(this).prev('img').attr('vidid');
		var html_value = '<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=http://www.youtube.com/watch?v=' + vidid + '"><img src="<?php echo plugins_url(); ?>/customslider/images/fb.jpg"  /></a></li><li><a target="_blank" href="mailto:?subject=default subject&body=http://www.youtube.com/watch?v=' + vidid + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li><li><a target="_blank" href="http://twitter.com/home?status=http://www.youtube.com/watch?v=' + vidid + '"><img src="<?php echo plugins_url(); ?>/customslider/images/twt.jpg"/></a></li>';	
		$('#social').html('<ul>'+html_value+'</ul>');
	}
	if($(".o:first").prev('img').attr('my')=="featured")
	{
		
		
		var html_value = '<li><a target="_blank" href="http://www.facebook.com/sharer.php?u=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/fb.jpg"  /></a></li><li><a target="_blank" href="mailto:?subject=default subject&body=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li><li><a target="_blank" href="http://twitter.com/home?status=' + mainimg + '"><img src="<?php echo plugins_url(); ?>/customslider/images/msg.jpg"/></a></li>';	
		$('#social').html('<ul>'+html_value+'</ul>');
	}
	



        });
    </script>
<?php
$mainimages=$wpdb->get_results("select * from ".$wpdb->prefix."customslider_images order by slideorder ASC");

?>
<div  class="slid_out" style="display: block; margin:0 auto;  width: 90%; max-width:960px; min-width: 240px; position:relative;">
<style>
	#social ul li {
    margin: 0;
    padding: 0 0 13px;
	list-style:none;
}
#social ul {
    margin: 0;
    padding: 0 ;
}
</style>
<div id="social" style="position:absolute;left:-44px; top:12%;"> </div>
<div id="slider1_container" style="position: relative; width: 960px; margin:auto;  height:685px; overflow: visiable;">
    <!-- Loading Screen -->
    <div u="loading" style="position: absolute; top: 0px; left: 0px;">
        <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;"> </div>
        <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;"> </div>
    </div>
    <!-- Slides Container -->
    <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 960px; height:500px;
            overflow: hidden;">
        <?php foreach($mainimages as $myim)
{
	echo "<div>";
	if($myim->typem == "manually")
	{
		?>
        <img u="image" src="<?php echo site_url(); ?>/wp-content/uploads/slider/<?php echo $myim->imageurl; ?>" my="manually" /> <img u="thumb" src="<?php echo site_url(); ?>/wp-content/uploads/slider/<?php echo $myim->imageurl; ?>" my="manually" />
        <?php
	}
	if($myim->typem == "youtube")
	{
		?>
        <div u="player" style="position: relative; top: 0px; left: 0px; width:960px; height: 500px; overflow: hidden;">
            <iframe width="960px" u="image" height="500" id="popup-youtube-player" pHandler="ytiframe" pHideControls="0" src="//www.youtube.com/embed/<?php echo $myim->youtube; ?>?enablejsapi=1&version=3&playerapiid=ytplayer&fs=1&wmode=transparent" frameborder="0" allowfullscreen></iframe>
            <div u="cover" class="videoCover" style="position: absolute; top: 0px; left: 0px; background-color: #000; background-image: url(<?php echo plugins_url(); ?>/customslider/images/play.png); background-position: center center; background-repeat: no-repeat; filter: alpha(opacity=40); opacity: .4; cursor: pointer; display: none; z-index: 1;"></div>
        </div>
        <img u="thumb" src="http://img.youtube.com/vi/<?php echo $myim->youtube; ?>/maxresdefault.jpg" height="200" width="200" my="youtube" vidid="<?php echo $myim->youtube; ?>" />
        <?php
	}
	if($myim->typem == "featured")
	{
		?>
        <img u="image" src="<?php echo $myim->imageurl; ?>" my="featured" /> <img u="thumb" src="<?php echo $myim->imageurl; ?>" height="200" width="200" my="featured" />
        <?php
	}
	echo "</div>";
}
?>
    </div>
    <div u="thumbnavigator" class="jssort07" style="position: absolute; width: 960px; height:210px; left: 0px; bottom:-40px; overflow: hidden; border-radius:10px; ">
        <div style=" background-color:#e6e6e6;  margin:5px 0 0 0 filter:alpha(opacity=30); width: 100%; height:100%;"></div>
        <!-- Thumbnail Item Skin Begin -->
        <style>
                
				.jssort07 .i {
                    position: absolute;
                    top: 0px;
                    left: 0px;
                    width: 250px;
                    height: 152px;
                    filter: alpha(opacity=80);
                    opacity: .8;
                }


        .jssora11l
				  {
					  background:url(<?php bloginfo('url'); ?>/wp-content/plugins/customslider/images/left.png) no-repeat;
					   height: 103px !important;
    width: 52px !important;
				  }
				  
				   .jssora11r
				  {
					 background:url(<?php bloginfo('url'); ?>/wp-content/plugins/customslider/images/right.png) no-repeat;
					   height: 103px !important;
    width: 52px !important;
				  }
                .jssort07 .p:hover .i, .jssort07 .pav .i {
                    filter: alpha(opacity=100);
                    opacity: 1;
                }
              .jssort07 .o {
                    position: absolute;
                    top: 0px;
                    left: 0px;
                    width: 250px;
                    height:152px;
                    transition: border-color .6s;
                    -moz-transition: border-color .6s;
                    -webkit-transition: border-color .6s;
                    -o-transition: border-color .6s;
                }

                * html .jssort07 .o {
                    /* ie quirks mode adjust */
                    width: 250px;
                    height: 152px;
                }

                .jssort07 .pav .o, .jssort07 .p:hover .o {
                    border-color: #fff;
                }

                .jssort07 .pav:hover .o {
                    border-color: #0099FF;
                }

                .jssort07 .p:hover .o {
                    transition: none;
                    -moz-transition: none;
                    -webkit-transition: none;
                    -o-transition: none;
                }
            </style>
        <div u="slides" style="cursor: move;">
            <div u="prototype" class="p" style="POSITION: absolute; WIDTH: 250px; HEIGHT:152px; TOP: 0; LEFT: 0;">
                <thumbnailtemplate class="i" style="position:absolute;"></thumbnailtemplate>
                <div class="o"> </div>
            </div>
        </div>
        <!-- Thumbnail Item Skin End -->
        <!-- Arrow Navigator Skin Begin -->
        <style>
                    /* jssor slider arrow navigator skin 11 css */
                   
                    .jssora11l, .jssora11r, .jssora11ldn, .jssora11rdn {
                        position: absolute;
                        cursor: pointer;
                        display: block;
                        overflow: hidden;
                    }

                    .jssora11l {
                       height: 37px;
    left: 15px !important;
    top: 51.5px !important;
    width: 37px;
                    }

                    .jssora11r {
                         right: 14px !important;
    top:51.5px !important;
                    }

                   

                    
                    .jssora11ldn {
                        background-position: -251px -41px;
                    }

                    .jssora11rdn {
                        background-position: -311px -41px;
                    }
            </style>
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora11l" style="width: 37px; height: 37px; top: 123px; left: 8px;"> </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora11r" style="width: 37px; height: 37px; top: 123px; right: 8px"> </span>
        <!-- Arrow Navigator Skin End -->
    </div>
</div>
<?php
	
}
}
add_shortcode( 'mainslider', 'getslider' );
?>
