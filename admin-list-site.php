<?php  error_reporting(0);?>
<?php
// 'admin-list-site.php’ file 
$columns = array(
		'template_name' => 'Template Name',
		'creatd_by' => 'Created By',		
		'view' => 'View' ,
  'delete' => 'Delete'
	);
	register_column_headers('VSTEMPLATE-list-site', $columns);	
?>
<div class="wrap">  
 <?php    echo "<h2 style=\"background:#BBBBBB;color:white;font-weight:bold;width:;height:30px\">" . __( 'List Of All Templates' ) . "</h2>"; ?>  
<table class="widefat page fixed" cellspacing="0">
  <thead>
  <tr>
<?php print_column_headers('VSTEMPLATE-list-site'); ?>
  </tr>
  </thead>
<tfoot style="display:none">
  <tr>
<?php print_column_headers('VSTEMPLATE-list-site', false); ?>
  </tr>
  </tfoot>
  <tbody>
<?php
global $wpdb;
$sql = "SELECT * FROM ".VSTEMPLATE_TABLE_PREFIX."TC";
$results = $wpdb->get_results($sql);
if(count($results) > 0)
{
	foreach($results as $result)
	{
$id=$result->id;
 $vs_to_be_del=$request->vstemplate_title;
 $VSTEMPLATE_content=$result->vstemplate_content;
	echo "<tr>
	<td>".$result-> vstemplate_title."</td><td>".$result->vstemplate_crtdb."</td>
<td>
<form name=\"vstemplate_form_vw_de\" action=\" \" method=\"post\" 
enctype=\"multipart/form-data\">
<input type=\"submit\" name=\"view\" value=\"View\"/>
<input type=\"hidden\" name=\"id\" value=\"$id\"/>
<input type=\"hidden\" name=\"vs_to_be_del\" value=\"".$result->vstemplate_title."\"/>
</form>
	</td><td><form name=\"vstemplate_form_vw_de\" action=\" \" method=\"post\" 
enctype=\"multipart/form-data\"><input type=\"submit\" name=\"delete\" value=\"Delete\"/><input type=\"hidden\" name=\"id\" value=\"$id\"/><input type=\"hidden\" name=\"vs_to_be_del\" value=\"".$result->vstemplate_title."\"/></form></td></tr>";
}				
}
?>
<?php
if(isset($_REQUEST["view"]) and (!isset($_REQUEST["cancel"]) or (!isset($_REQUEST["update"]))))
{
$id=$_REQUEST["id"];
 ?>
<div id="mask"></div>
<div id="popupwindow">
<div class="pop_1">
<div class="text_area_update">
<form name="update_verify" action="" method="post">
<?php
global $wpdb;
$sql = "SELECT * FROM ".VSTEMPLATE_TABLE_PREFIX."TC where id=$id";
$results = $wpdb->get_results($sql);
if(count($results) > 0)
{
	foreach($results as $result)
	{
	$vstemplate_title=$result->vstemplate_title ;
	   $File_created =TEMPLATEPATH ."/".$vstemplate_title;
	 
$File_created_final = str_replace("\"", "/", $File_created);
	 //$file="C:/xampp/htdocs/sauraveducation/wp-content/themes/sauraveducation/astb.php";
	  if (file_exists($File_created_final)) {
$handle = fopen($File_created_final, "rb");
 $contents = stripslashes(stream_get_contents($handle, filesize($File_created_final)));
fclose($handle);
   }
else
{
echo "file dsnt exist";
}	 
?>
<textarea rows="20" cols="30" name="VSTEMPLATE_update"><?php  echo $contents ; ?></textarea><?php } }?>
<input type="hidden" name="vstemplate_to_be_edited" value="<?php echo $vstemplate_title;?>"/>
</div>
<div class="link" style="border:0px solid #9E013D;width:94%;height:45px;position:relative; display:block;  margin: 345px auto 6px;" >
<div class="btns">
<input type="hidden" name="id" value="<?php echo $_REQUEST["id"];?>"/>
<input type="submit" name="update" value="Update" class="update" title="Please click this button  when you are confirm to update "/>
</div>
<div class="btnr">
<input value="Cancel" name="cancel" type="submit" class="cancel" title="Please click this button to cancel"/>
</div>
</form> 
</div>
</div>
</div>
<?php
}
else if(isset($_REQUEST["delete"]) and (!isset($_REQUEST["cancel"]) or (!isset($_REQUEST["update"]))))
{
$id=$_REQUEST["id"];
$VSTEMPLATE_to_be_finally_delete=$_REQUEST["vs_to_be_del"];
?>
<div id="mask"></div>
<div id="popupwindow">
<div class="pop_1">
<div class="link" style="border:0px solid #9E013D;width:94%;height:45px;position:relative; display:block;  margin: 186px auto 6px;" >
<span style="color:black;font-size:25px;text-align:left;font-weight:bold;bottom:87px;left:17%;position:relative">Are You Sure you want to delete?&nbsp;[<?php echo "<font color=\"red\"><i style=\"text-decoration:blink\">$VSTEMPLATE_to_be_finally_delete </i></font>";?>]</span>
<form name="update_verify" action="" method="post">
<div class="btns" style="float: left;margin-left: 175px;margin-right: 105px;
  width: 36%
">
<input type="submit" name="fdel" value="Okay" class="update" title="Please click this button  when you are confirm to update "/>
<input type="hidden" name="vs_okay_finally_del_title" value="<?php echo $VSTEMPLATE_to_be_finally_delete ;?>"/>
<input type="hidden" name="vs_okay_finally_del_id" value="<?php echo $id ;?>"/>
</div>
<div class="btnr">
<input value="Cancel" name="cancel" type="submit" class="cancel" title="Please click this button to cancel"/>
</div>
</form> 
</div>
</div>
</div>
<?php
}
?>
<?php
if(isset($_REQUEST["update"]))
{
 $id=$_REQUEST["id"];
 $vstemplate_to_be_edited=$_REQUEST["vstemplate_to_be_edited"];
 $File_created =TEMPLATEPATH ."/".$vstemplate_to_be_edited;
$VSTEMPLATE_update=stripslashes($_REQUEST["VSTEMPLATE_update"]);
global $wpdb;
$sql = "update ".VSTEMPLATE_TABLE_PREFIX."TC set vstemplate_content='$VSTEMPLATE_update' where id=$id";
$wpdb->query($sql);
$fp = fopen($File_created,"w") or die ("Error opening file in write mode!");
    fputs($fp,$VSTEMPLATE_update);
    fclose($fp) or die ("Error closing file!");
	?>
<div id="preloader" style="width:100%;height:3000px;background:black;opacity:0.5;">
	<div id="status" style="color:white;font-weight:bold;font-size:12px;width:100%;position:absolute !important;top:160px !important"><img src="<?php echo VSTEMPLATE_URL ;?>/images/status.gif"/>	<br><br><?php
	echo "<span class=\"success\"><font color=\"green\">[$vstemplate_to_be_edited]</font>Successfully Updated</span>";

?>
<form action="" method="post" id="please-title">
<input type="submit" name="cont" value="continue"/>
</form></div>
</div>
<?php
}
?>
<?php
if(isset($_REQUEST["fdel"]))
{
$vs_okay_finally_del_title=$_REQUEST["vs_okay_finally_del_title"];
 $File_path_to_be_deleted =TEMPLATEPATH ."/".$vs_okay_finally_del_title;
 $File_del_path_final = str_replace("\"", "/",  $File_path_to_be_deleted);
$vs_okay_finally_del_id=$_REQUEST["vs_okay_finally_del_id"];
unlink("$File_del_path_final");
global $wpdb;
$sql = "delete from ".VSTEMPLATE_TABLE_PREFIX."TC  where id=$vs_okay_finally_del_id";
$wpdb->query($sql);
?>
<div id="preloader" style="width:100%;height:3000px;background:black;opacity:0.5;">
	<div id="status" style="color:white;font-weight:bold;font-size:12px;width:100%;position:absolute !important;top:160px !important"><img src="<?php echo VSTEMPLATE_URL ;?>/images/status.gif"/>	<br><br>
<?php
echo "<span class=\"success\"><font color=\"green\">File&nbsp;[<span style=\"color:red;font-weight:bold\">$vs_okay_finally_del_title</span>]&nbsp; has been deleted successfully</font></span>";
?>
<form action="" method="post">
<input type="submit" name="cont" value="continue"/>
</form>
<?php
}
?>
</div>
 </div>
  </tbody>
</table>
<?php require_once 'require_once.php' ;?>
