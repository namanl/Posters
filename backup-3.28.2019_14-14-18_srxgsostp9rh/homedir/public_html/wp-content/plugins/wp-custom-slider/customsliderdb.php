<?php
/*
Save and edit the slides.
*/
if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
$upload_dir = wp_upload_dir();
$upload_loc=$upload_dir['basedir']."/slider";   /* Set the default locations */
global $wpdb;
global $mainvar; 
$vidid="";
extract($_REQUEST);
if($_REQUEST['editid'])
{

	if($choose=="manually")
{

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);

if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& in_array($extension, $allowedExts)) {
  if ($_FILES["file"]["error"] > 0) {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
  } else {
    if (file_exists($upload_loc.'/'. $_FILES["file"]["name"])) {
      echo $_FILES["file"]["name"] . " already exists. ";
    } else {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      $upload_loc.'/'. $_FILES["file"]["name"]);
	
 $mainvar=$_FILES["file"]["name"];
	$typem="manually";
    }
  }
} else {
  echo "Invalid file";
}
	
 

}
if($choose=="youtube")
{
	
	
	$urls = array("http://www.youtube.com/watch?v=","https://www.youtube.com/watch?v=");
    $vidid= str_replace($urls, "", $youtubevideo);
	$typem="youtube";
	
}
if($choose=="featured")
{
	
  if (has_post_thumbnail($page_id) ):
    $image = wp_get_attachment_image_src( get_post_thumbnail_id($page_id), 'single-post-thumbnail' );
   endif;
   $mainvar = $image[0];
	
   $typem="featured";
}
mysql_query("update ".$wpdb->prefix."customslider_images set imagename='$thumbtitle',imageurl='$mainvar',youtube='$vidid',typem='$typem' where id=$editid");
header('location:'.$_SERVER['HTTP_REFERER']);

}
else
{
if($choose=="manually")
{

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);

if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& in_array($extension, $allowedExts)) {
  if ($_FILES["file"]["error"] > 0) {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
  } else {
    if (file_exists($upload_loc.'/'. $_FILES["file"]["name"])) {
      echo $_FILES["file"]["name"] . " already exists. ";
    } else {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      $upload_loc.'/'. $_FILES["file"]["name"]);
	  $thumb=$_FILES["file"]["name"];
 $mainvar=$_FILES["file"]["name"];
	$typem="manually";
    }
  }
} else {
  echo "Invalid file";
}

}
if($choose=="youtube")
{
	$urls = array("http://www.youtube.com/watch?v=","https://www.youtube.com/watch?v=");
    $vidid= str_replace($urls, "", $youtubevideo);
	$typem="youtube";
	
}
if($choose=="featured")
{
  if (has_post_thumbnail($page_id) ):
    $image = wp_get_attachment_image_src( get_post_thumbnail_id($page_id), 'single-post-thumbnail' );
   endif;
   $mainvar = $image[0];
   $typem="featured";
}
if($typem!="")
{
if($wpdb->query("insert into ".$wpdb->prefix."customslider_images(imagename,imageurl,thumburl,youtube,typem,slideorder) values('$thumbtitle','$mainvar','$thumb','$vidid','$typem',0)"))
{
	header('location:'.$_SERVER['HTTP_REFERER']);
}
}
}
?>
