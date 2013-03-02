<?php 
if(!$index){
	echo 'NO';
	exit();
}

if(isset($_POST['settingsSub'])){
extract($_POST);
$qry = "UPDATE settings SET setting_adminLevel = $adminLevel, setting_modLevel = $modLevel, setting_boardTitle = '$boardTitle', setting_boardHeader = '$boardHeader';";
$feedback = "Settings updated!";
mysql_query($qry) or die(mysql_error());
}
$settings = mysql_fetch_array(mysql_query("SELECT * FROM settings"));
extract($settings);

echo 'Message Board Settings<br /><br />
<form name="settings" onsubmit="return confirmSubmitcont()" action="admin.php?page=settings" method="post">
Administration Level: <input type="text" name="adminLevel" value="'.$setting_adminLevel.'" /><br /><br />
Moderator Level: <input type="text" name="modLevel" value="'.$setting_modLevel.'" /><br /><br />
Site Title: <input type="text" name="boardTitle" value="'.$setting_boardTitle.'" /><br /><br />
Site Header: <input type="text" name="boardHeader" value="'.$setting_boardHeader.'" /><br /><br />
<input type="submit" name="settingsSub" value="Submit" />
</form>
';
if (isset($feedback)){
	echo '<div id="replybox" style="text-align:center;">'.$feedback.'</div>';
}
?>