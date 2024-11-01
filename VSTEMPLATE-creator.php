<?php
/*
Plugin Name: VSTEMPLATE-creator
Plugin URI: http://www.phpphobia.blogspot.com
Description: Wordpress plugin to create template of your desire thus serve as an ease
Author: vikashsrivastava1111989 
Version: 2.0.2
Author URI: http://www.phpphobia.blogspot.com
*/
?>
<?php
$siteurl = get_option('siteurl');
if ( ! defined( 'VSTEMPLATE_FOLDER' ) )
	define('VSTEMPLATE_FOLDER', dirname(plugin_basename(__FILE__)));

if ( ! defined( 'VSTEMPLATE_URL' ) )
	define('VSTEMPLATE_URL', $siteurl.'/wp-content/plugins/' . VSTEMPLATE_FOLDER);

if ( ! defined( 'VSTEMPLATE_FILE_PATH' ) )
	define('VSTEMPLATE_FILE_PATH', dirname(__FILE__));

if ( ! defined( 'VSTEMPLATE_DIR_NAME' ) )
define('VSTEMPLATE_DIR_NAME', basename(VSTEMPLATE_FILE_PATH));

// this is the table prefix
global $wpdb;
$VSTEMPLATE_table_prefix=$wpdb->prefix.'VSTEMPLATE_';
$image_path=dirname(plugin_basename(__FILE__));
if ( ! defined( 'VSTEMPLATE_TABLE_PREFIX' ) )
define('VSTEMPLATE_TABLE_PREFIX', $VSTEMPLATE_table_prefix);
?>
<?php
register_activation_hook(__FILE__,'VSTEMPLATE_install');
register_deactivation_hook(__FILE__ , 'VSTEMPLATE_uninstall' );
function VSTEMPLATE_install()
{
global $wpdb;
$table = VSTEMPLATE_TABLE_PREFIX."TC";
$structure = "CREATE TABLE $table (
id INT(9) NOT NULL AUTO_INCREMENT,
vstemplate_title TEXT NOT NULL,
vstemplate_content LONGTEXT NOT NULL,
_edit_lock text NOT NULL,
vstemplate_crtdb text NOT NULL,
vstemplate_path text NOT NULL,
UNIQUE KEY id (id));";
$wpdb->query($structure);
}
?>
<?php
function VSTEMPLATE_uninstall()
{
global $wpdb;
$table = VSTEMPLATE_TABLE_PREFIX."TC";
$structure = "drop table if exists $table;";
$wpdb->query($structure);     
}
?>
<?php
add_action('admin_menu','VSTEMPLATE_admin_menu');
function VSTEMPLATE_admin_menu(){ 
add_menu_page(
"VSTEMPLATE",
"VSTEMPLATE",
8,
__FILE__,
"VSTEMPLATE_admin_add_template",
VSTEMPLATE_URL."/images/logo_yet_to_come.gif");
add_submenu_page(__FILE__,'View Templates','View Templates','8','list-site','VSTEMPLATE_admin_list_template');
}
function VSTEMPLATE_admin_add_template()
{
echo "<h2 style=\"\" class=\"vstemplate-header\">" . __( 'Create NEW Template' ) . "</h2>"; 
echo "<form name=\"write\" method=\"post\" action=\"\" style=\"margin-top:20px\"> <div class=\"vstemplate-form\">
<div class=\"vstemplate-input\">
<input type=\"text\" name=\"title\" placeholder=\"Title of Template\" id=\"title\" />
</div>
<div class=\"vstemplate-input\">
<textarea name=\"File\" rows=\"22\" cols=\"110\" id=\"text\">";?>
<?php
echo "<?php
/**
 * Template Name: VSTEMPLATE
 *
 * Description:   A page template without sidebar.
 *
 * The \"Template Name:\" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * 
 * 
 */

//Write your all codes just after the closing php tag
//You can change the Template Name 
//You can change the description
// Caution do not remove the Template Name
//otherwise this plugin will may not work
?>";
?>
<?php echo "
</textarea>
</div>
</div>
";
?>
<div class="list-of-all-pages">
<div class="first-list-box">
<div class="first-list-title">
SELECT THE PAGE(Optional)
</div>
<div class="first-list-content">
<table class="pages_title_content">
<tr>
<td>
<?php 
$wp_get_pages = get_pages();
if(count($wp_get_pages) > 0)
{
foreach($wp_get_pages as $wp_get_page)
{
?>
<div class="otpt"><p class="vs_title"><?php echo $wp_get_page-> post_title;?></p><p class="vs_checkbx"><input type="checkbox" class="page-checkbox" name="post_title[]" value="<?php echo $wp_get_page-> post_title.";".$wp_get_page->ID ?>"/></p></div>
<?php
}				
}

if(count($wp_get_pages) <= 0)
{
echo "<span style=\"font-size:12px;color:#000\">sorry, there are no-pages created yet...";			
}
?>
</td>
</tr>
</table>
</div>
<div class=\"vstemplate-input\">
<input type="submit" name="eile" value="create template" id="btn"/>
</div>
</div>
</form>
</div>
<?php
if(isset($_REQUEST["eile"]))
{
?>
<!-- Preloader -->
<div id="preloader" style="width:100%;height:3000px;background:black;opacity:0.5;">
<div id="status" style=""><img src="<?php echo VSTEMPLATE_URL;?>/images/status.gif"/>&nbsp;</div>
<?php 
$title=$_REQUEST["title"];
$File=$_REQUEST["File"];
if(empty($title))
{
echo "<font color=\"white\"><span style=\"font-weight:bold;font-size:23px;text-align:center;width:100%;float:left;position:absolute;top:7%;right:74px\">Please enter the Title of the Page Template</span></font>";
?>
<form action="" method="post" id="please-title" style="position:absolute;left:40%;top:8%">
<input type="submit" name="cont" value="continue"/>
</form>
<?php
}
?>

</div>
<?php
$title=$_REQUEST["title"];
$File=$_REQUEST["File"];
$test=$_REQUEST['post_title'];
if(empty($title))
{
}
else if(!empty($title) and (count($test)>0 or count($test)<=0))
{
global $wpdb;
$sql_pages = "SELECT * FROM wp_vstemplate_tc where vstemplate_title='$title.php' ";
$result_pages = $wpdb->get_results($sql_pages);
$val_rows=count($result_pages);
if($val_rows>0)
{
?>
<div id="preloader" style="width:100%;height:3000px;background:black;opacity:0.5;">
<div id="status" style="color:white;font-weight:bold;font-size:10px;width:100%"><img src="<?php echo VSTEMPLATE_URL ;?>/images/status.gif"/>	<br><br>
<?php
echo "<span class=\"error\">Template &nbsp; [<font color=\"green\">$title.php</font>]&nbsp;is already exists please try another and unique name<br><br></span>"; 
?>
<form action="" method="post">
<input type="submit" name="cont" value="continue"/>
</form>
</div>
<?php
}
else
{
if(!empty($title) and count($test)>0)
{
$halt=count($test);
for($i=0;$i<$halt;$i++)
{
$final_test[$i]=$_REQUEST['post_title'][$i];
$final_ex=explode(";",$final_test[$i]);
$vs_explode=0;
$vs_length=strlen($final_test[$i]);
for($vs1=0;$vs1<$vs_length;$vs1++)
{
if($final_test[$i][$vs1]==";")
{
$vs_explode=$vs_explode+1;
$final_ex[1];
if(sizeof($final_ex[1])>0)
{

global $wpdb;
$File_createds= $title.".php"; 
$time=time();
$wpuid=get_current_user_id( ); 
$magic_tracker_id_cum_recognizer=$time.":".$wpuid ;
$sql_update_wp0 = "UPDATE  wp_postmeta set meta_value='$File_createds' where post_id IN (".$final_ex[1].") and meta_key='_wp_page_template';";
$wpdb->query($sql_update_wp0);
$sql_update_wp1 = "UPDATE  wp_postmeta set meta_value='$magic_tracker_id_cum_recognizer' where post_id IN (".$final_ex[1].") and meta_key='_edit_lock';";
$wpdb->query($sql_update_wp1);
//database code goes here
$File_created =TEMPLATEPATH ."/".$title.".php"; 
$Handle = fopen($File_created, 'w');
fwrite($Handle, stripslashes($File)); //updated on 26-07-2013
$table = VSTEMPLATE_TABLE_PREFIX."TC";
$sql_user_rec = "SELECT *FROM wp_users where ID=$wpuid";
$result_user_rec = $wpdb->get_results($sql_user_rec);
if(count($result_user_rec)==1 and $i==0)
{
foreach($result_user_rec as $result_urec)
{
$result_user=	$result_urec->display_name;
$VSTEMPLATE_TABLE_POPULATED="INSERT INTO $table (vstemplate_title , 	_edit_lock, vstemplate_content , vstemplate_crtdb , vstemplate_path)
VALUES ('$File_createds','$magic_tracker_id_cum_recognizer' , '$File' , '$result_user' , '$File_created')";
$wpdb->query($VSTEMPLATE_TABLE_POPULATED);
}				
}
?>
<div id="preloader" style="width:100%;height:3000px;background:black;opacity:0.5;">
<div id="status" style="color:white;font-weight:bold;font-size:10px;width:100%"><img src="<?php echo VSTEMPLATE_URL ;?>/images/status.gif"/>	<br><br>
<?php
print "Template &nbsp; [<font color=\"green\">$File_createds</font>]&nbsp;is created Successfully<br><br>"; 
?>
<form action="" method="post">
<input type="submit" name="cont" value="continue"/>
</form>
</div>
<?php
fclose($Handle);
}
}
}
}
}
else if(!empty($title) and (count($test)<=0))
{
$title=$_REQUEST["title"];
global $wpdb;
$File_createds= $title.".php"; 
$time=time();
$wpuid=get_current_user_id( ); 
$magic_tracker_id_cum_recognizer=$time.":".$wpuid ;
$File_created =TEMPLATEPATH ."/".$title.".php"; 
$Handle = fopen($File_created, 'w');
fwrite($Handle, stripslashes($File)); //updated on 26-07-2013
$table = VSTEMPLATE_TABLE_PREFIX."TC";
$sql_user_rec = "SELECT *FROM wp_users where ID=$wpuid";
$result_user_rec = $wpdb->get_results($sql_user_rec);
if(count($result_user_rec)==1)
{
foreach($result_user_rec as $result_urec)
{
$result_user=	$result_urec->display_name;
$VSTEMPLATE_TABLE_POPULATED="INSERT INTO $table (vstemplate_title , 	_edit_lock, vstemplate_content , vstemplate_crtdb , vstemplate_path)
VALUES ('$File_createds','$magic_tracker_id_cum_recognizer' , '$File' , '$result_user' , '$File_created')";
$wpdb->query($VSTEMPLATE_TABLE_POPULATED);
}				
}
?>
<div id="preloader" style="width:100%;height:3000px;background:black;opacity:0.5;">
<div id="status" style="color:white;font-weight:bold;font-size:10px;width:100%"><img src="<?php echo VSTEMPLATE_URL ;?>/images/status.gif"/>	<br><br>
<?php
print "Template &nbsp; [<font color=\"green\">$File_createds</font>]&nbsp;is created Successfully<br><br>"; 
?>
<form action="" method="post">
<input type="submit" name="cont" value="continue"/>
</form>
</div>
<?php
fclose($Handle);
}
}
}
}
}
function VSTEMPLATE_admin_list_template()
{
include 'admin-list-site.php';
}
add_shortcode("VSTEMPLATE_tutorial_site_listing","VSTEMPLATE_tutorial_site_listing_shortcode");
function VSTEMPLATE_tutorial_site_listing_shortcode($atts) 
{ 
include 'admin-list-site.php';
}
?>
<?php require_once 'require_once.php' ;?>
