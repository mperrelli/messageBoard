<?php include('head.php');

if(isset($_POST['submitEdit'])){
	$userid = $_POST['username'];
	$signature = $_POST['signature'];
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$email = $_POST['email'];
	$image = false;
	$updateac = "";
	if(isset($_POST['aclvl'])){ $updateac = ", access_level = ".$_POST['aclvl'].""; }
	
	if ( $_FILES['avatar']['name'] != "" ){
		move_uploaded_file($_FILES['avatar']['tmp_name'], "images/profilepics/" . basename($_FILES['avatar']['name']));
		$avatar = basename($_FILES['avatar']['name']);
		$image = true;
	}
	
	if($image){
		mysql_query("UPDATE users SET profile_signature = '$signature', user_fname = '$fname', user_lname = '$lname', user_email = '$email', profile_avatar = '$avatar'$updateac WHERE username = '$userid';");
	}
	else{
		mysql_query("UPDATE users SET profile_signature = '$signature', user_fname = '$fname', user_lname = '$lname', user_email = '$email'$updateac WHERE username = '$userid';") or die(mysql_error());
	}
	
	echo '<div id="replybox" style="text-align:center;">Profile Updated!</div>';
}

$usercheck = false;
if(isset($_GET['id'])){
	$userid = $_GET['id'];
	$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE user_id = $userid"));
	$ref = "id=".$userid;
}
else if(isset($_GET['user'])){
	$userid = $_GET['user'];
	$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username = '$userid'"));
	$ref = "user=".$userid;
}

if($_SESSION['username'] == $info['username'] || $access_level >= $setting_adminLevel){ $usercheck = true; }

echo '<table id="profile"><tr><td colspan="2" id="profileheader" ><div style="float:left;">Profile : '.$info['username'].'</div><div style="float:right;">';

if($usercheck){
	echo '<form name="edit" method="post" action="profile.php?'.$ref.'#editbox">
	<input type="submit" name="edit" value="Edit" />
	</form>
	';
}

echo'</div></td></tr>
<tr><td id="postuserbox" style="width:150px; text-align:center;">';
userinfobox($info['username']);
echo'</td><td id="postbody">
<table id="profileorganizer">
<tr><td style="width:100px;">Name: </td><td>'.$info['user_fname'].' '.$info['user_lname'].'</td></tr>
<tr><td>E-mail: </td><td>'.$info['user_email'].'</td></tr>
<tr><td colspan="2">';
getSignature($info['username']);
echo'</td></tr></table>
</td></tr></table>';

if(isset($_POST['edit']) && $usercheck){

	$profileinfo = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username = '".$info['username']."';"));

	echo'<div id="replybox"><a name="editbox"></a><form enctype="multipart/form-data" name="editProfile" method="post" action="profile.php?'.$ref.'">
	<table>
	<tr><td>Name: </td><td><input type="text" name="fname" value="'.$profileinfo['user_fname'].'" /><input type="text" name="lname" value="'.$profileinfo['user_lname'].'" /></td></tr>
	<tr><td>E-mail: </td><td><input type="text" name="email" value="'.$profileinfo['user_email'].'" /></td></tr>
	<tr><td>Signature: </td><td><textarea name="signature" rows="5" cols="40">'.$profileinfo['profile_signature'].'</textarea></td></tr>
	<tr><td>Avatar: </td><td><input type="file" name="avatar"></td></tr>';
	if ($access_level >= $setting_adminLevel){
		echo '<tr><td>Access Level: </td><td><select name="aclvl">
		'.getRankSelection($profileinfo['access_level'], false).'
		</select></td></tr>';
	}
	echo'<tr><td colspan="2"><input type="hidden" name="username" value="'.$profileinfo['username'].'" /><input type="submit" name="submitEdit" value="Submit Changes!" /></td></tr>
	</table>
	</form></div>';
}


include('tail.php') ?>