<?php 
if(!$index){
	echo 'NO';
	exit();
}

if(isset($_POST['editPerSubmit'])){
	$title = $_POST['title'];
	$perid = $_POST['permissionid'];
	$qry = "UPDATE permissions SET title = '$title' WHERE permission_id = $perid;";
	mysql_query($qry);
	$feedback = "Permission updated!";
}

echo'<table style="width:100%;"><tr><td id="a_usertdhead">Title</td><td id="a_usertdhead">Level</td><td id="a_usertdhead">Options</td></tr>';
$action = "admin.php?page=permissions";
$qry = "SELECT * FROM permissions ORDER BY access_level DESC;";
$result = mysql_query($qry);
$count = 0;
while($result_row = mysql_fetch_array($result)){
$count++;
}

$qry = "SELECT * FROM permissions ORDER BY access_level DESC;";
$result = mysql_query($qry);
while($result_row = mysql_fetch_array($result)){
	if(isset($_POST['editPer']) && $_POST['permissionid'] == $result_row['permission_id']){
		echo '<form name="editPerSubmit" method="post" action="'.$action.'" style="display:inline;">
		<tr><td id="a_usertd" ><input type="text" size="'.strlen($result_row['title']).'" name="title" value="'.$result_row['title'].'" /></td>
		<td id="a_usertd" >';
		echo $result_row['access_level'];
//		echo'<select name="aclvl">';
//		for($i = 1; $i < $_POST['count']; $i++){
//			$selected = "";
//			if($i == $result_row['access_level']){ $selected = "selected"; }
//			echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
//		}
//		echo'</select>';
		
		echo'
		</td>
		<td id="a_usertd" >
		<input type="hidden" name="permissionid" value="'.$result_row['permission_id'].'" />
		<input type="submit" name="editPerSubmit" value="Submit" />
		</form>
		<form name="cancel" method="post" action="'.$action.'" style="display:inline;">
		<input type="submit" name="cancel" value="Cancel" />
		</form>
		</td></tr>';
	}
	else{
		echo'<tr><td id="a_usertd" >'.$result_row['title'].'</td><td id="a_usertd" >'.$result_row['access_level'].'</td>
		<td id="a_usertd" >
		<form name="editPer" method="post" action="'.$action.'" style="display:inline;">
		<input type="hidden" name="permissionid" value="'.$result_row['permission_id'].'" />
		<input type="hidden" name="count" value="'.$count.'" />
		<input type="submit" name="editPer" value="Edit" />
		</form>
		</td></tr>';
	}
}
echo'<tr><td id="a_usertdhead">Administrative Level: '.$setting_adminLevel.'</td><td id="a_usertdhead">Moderator Level: '.$setting_modLevel.'</td><td id="a_usertdhead">&nbsp;</td></tr></table>';
if (isset($feedback)){
	echo '<div id="replybox" style="text-align:center;">'.$feedback.'</div>';
}
?>