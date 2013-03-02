<?php 
if(!$index){
	echo 'NO';
	exit();
}

if(isset($_POST['editUser'])){
extract($_POST);
$qry = "UPDATE users SET postcount = $postcount, username = '$username', user_fname = '$fname', user_lname = '$lname', user_email = '$email', access_level = $aclvl WHERE user_id = $userid;";
mysql_query($qry);
$feedback = "User info for $username updated!";
}
else if(isset($_POST['deleteUser'])){
$uid = $_POST['userid'];
$qry = "DELETE FROM users WHERE user_id = $uid;";
mysql_query($qry);
$feedback = "User with the id of $uid has been removed.";
}

if ( isset ( $_GET['order_var'] ) )
	{
		$order_var = $_GET['order_var'];
		
		switch ( $order_var )
		{
			case 'fn_asc':
				$order_var = "user_fname ASC";
				break;
			case 'fn_dsc':
				$order_var = "user_fname DESC";
				break;
			case 'ln_asc':
				$order_var = "user_lname ASC";
				break;
			case 'ln_dsc':
				$order_var = "user_lname DESC";
				break;
			case 'id_asc':
				$order_var = "user_id ASC";
				break;
			case 'id_dsc':
				$order_var = "user_id DESC";
				break;
			case 'un_asc':
				$order_var = "username ASC";
				break;
			case 'un_dsc':
				$order_var = "username DESC";
				break;
			case 'al_asc':
				$order_var = "access_level ASC";
				break;
			case 'al_dsc':
				$order_var = "access_level DESC";
				break;
			case 'em_asc':
				$order_var = "user_email ASC";
				break;
			case 'em_dsc':
				$order_var = "user_email DESC";
				break;
			case 'pc_asc':
				$order_var = "postcount ASC";
				break;
			case 'pc_dsc':
				$order_var = "postcount DESC";
				break;
		}
	}
else
{
	$order_var = "postcount DESC";
}
	
	
	
$query = "SELECT * FROM users ORDER BY $order_var";
$result = mysql_query($query) or die(mysql_error());


$id_var = "id_asc";
$fn_var = "fn_asc";
$ln_var = "ln_asc";
$un_var = "un_asc";
$al_var = "al_asc";
$em_var = "em_asc";
$pc_var = "pc_asc";

if ( $order_var == "user_id ASC" )
{
	$id_var = "id_dsc";
}
else if ( $order_var == "user_id DESC" )
{
	$id_var = "id_asc";
}

if ( $order_var == "user_fname ASC" )
{
	$fn_var = "fn_dsc";
}
else if ( $order_var == "user_fname DESC" )
{
	$fn_var = "fn_asc";
}

if ( $order_var == "user_lname ASC" )
{
	$ln_var = "ln_dsc";
}
else if ( $order_var == "user_lname DESC" )
{
	$ln_var = "ln_asc";
}

if ( $order_var == "username ASC" )
{
	$un_var = "un_dsc";
}
else if ( $order_var == "username DESC" )
{
	$un_var = "un_asc";
}

if ( $order_var == "access_level ASC" )
{
	$al_var = "al_dsc";
}
else if ( $order_var == "access_level DESC" )
{
	$al_var = "al_asc";
}

if ( $order_var == "user_email ASC" )
{
	$em_var = "em_dsc";
}
else if ( $order_var == "user_email DESC" )
{
	$em_var = "em_asc";
}

if ( $order_var == "postcount ASC" )
{
	$pc_var = "pc_dsc";
}
else if ( $order_var == "postcount DESC" )
{
	$pc_var = "pc_asc";
}


echo '
<table style="width:100%;" cellspacing="0">
<tr>
<td id="a_usertdhead" width="50px"><a href="admin.php?page=users&order_var=' . $pc_var . '">Posts</a></td>
<td id="a_usertdhead" width="100px"><a href="admin.php?page=users&order_var=' . $fn_var . '">First Name</a></td>
<td id="a_usertdhead" width="100px"><a href="admin.php?page=users&order_var=' . $ln_var . '">Last Name</a></td>
<td id="a_usertdhead" width="150px"><a href="admin.php?page=users&order_var=' . $un_var . '">Username</a></td>
<td id="a_usertdhead"><a href="admin.php?page=users&order_var=' . $em_var . '">Email</a></td>
<td id="a_usertdhead" width="120px"><a href="admin.php?page=users&order_var=' . $al_var . '">Level</a></td>
<td id="a_usertdhead" width="180px">options</td>
</tr>';
$color1 = "a56c01";
$color2 = "cb9101";
while ( $users = mysql_fetch_assoc ( $result ) )
{	

	if( $bgcolor == $color1 ){
		$bgcolor = $color2;
	}
	else{
		$bgcolor = $color1;
	}
	
	if ( $users['ip'] == true){
		$tempip = $users['ip'];
	}
	else{
		$tempip = "None recorded";
	}
	
	$disableDelete = "";
	if($users['access_level'] > 4){
		$disableDelete = 'disabled="disabled"';
	}
	
	$action = "admin.php?page=users";
	if(isset($_GET['order_var'])){
		$action .= "&order_var=".$_GET['order_var'];
	}
	
	if(isset($_POST['edit']) && $users['user_id'] == $_POST['userid']){
		echo '
		
		<form name="editUser" method="post" onsubmit="return confirmSubmitcont()" action="'.$action.'" style="display:inline;">
		<tr>
		<td id="a_usertd" style="background-color:#' .$bgcolor. ';"><input type="text" name="postcount" size="3" value="' . $users['postcount'] . '" /></td>
		<td id="a_usertd" style="background-color:#' .$bgcolor. ';"><input type="text" name="fname" size="'.strlen($users['user_fname']).'" value="' . $users['user_fname'] . '" /></td>
		<td id="a_usertd" style="background-color:#' .$bgcolor. ';"><input type="text" name="lname" size="'.strlen($users['user_lname']).'" value="' . $users['user_lname'] . '" /></td>
		<td id="a_usertd" style="background-color:#' .$bgcolor. ';"><input type="text" name="username" size="'.strlen($users['username']).'" value="' . $users['username'] . '" /></td>
		<td id="a_usertd" style="background-color:#' .$bgcolor. ';"><input type="text" name="email" size="'.strlen($users['user_email']).'" value="' . $users['user_email'] . '" /></td>
		<td id="a_usertd" style="background-color:#' .$bgcolor. ';">
		<select name="aclvl">
		'.getRankSelection($users['access_level'], false).'
		</select>
		</td>
		<td id="a_usertd" style="background-color:#' .$bgcolor. ';">
		<input type="hidden" name="userid" value="'.$users['user_id'].'" />
		<input type="submit" name="editUser" value="Submit" />
		</form>
		<form name="cancel" method="post" action="'.$action.'" style="display:inline;">
		<input type="submit" name="cancel" value="Cancel" />
		</form>
		</td>
		</tr>';
	}
	else{
		echo '
		<tr>
		<td id="a_usertd" style="background-color:#' .$bgcolor. ';">' . $users['postcount'] . '</td>
		<td id="a_usertd" style="background-color:#' .$bgcolor. ';">' . $users['user_fname'] . '</td>
		<td id="a_usertd" style="background-color:#' .$bgcolor. ';">' . $users['user_lname'] . '</td>
		<td id="a_usertd" style="background-color:#' .$bgcolor. ';">' . $users['username'] . '</td>
		<td id="a_usertd" style="background-color:#' .$bgcolor. ';">' . $users['user_email'] . '</td>
		<td id="a_usertd" style="background-color:#' .$bgcolor. ';">' . getRank($users['access_level']) . '</td>
		<td id="a_usertd" style="background-color:#' .$bgcolor. ';"><a href="profile.php?user='.$users['username'].'">Profile</a>
		<form name="edit" method="post" action="'.$action.'" style="display:inline;">
		<input type="hidden" name="userid" value="'.$users['user_id'].'" />
		<input type="submit" name="edit" value="Edit" />
		</form>
		<form name="delete" method="post" onsubmit="return confirmSubmitRemUser()" action="'.$action.'" style="display:inline;">
		<input type="hidden" name="userid" value="'.$users['user_id'].'" />
		<input type="submit" name="deleteUser" value="Delete" '.$disableDelete.' />
		</form>
		</td>
		</tr>';
	}
	
}

echo '</table>';
if (isset($_POST['editUser']) || isset($_POST['deleteUser'])){
	echo '<div id="replybox" style="text-align:center;">'.$feedback.'</div>';
}

?>