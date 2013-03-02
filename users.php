<?php include("head.php");

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
<style>

#a_usertd {
border:1px solid black;
font-size:12px;
}

#a_usertdhead {
font-size:14px;
background-image:url("images/formtitlebg.jpg");
border:1px solid black;
}

#a_usertdhead a{
display:block;
}

a{
color:white;
}

a:hover{
color:black;
}
</style>
<table style="width:100%;" cellspacing="0">
<tr>
<td id="a_usertdhead"><a href="users.php?order_var=' . $pc_var . '">Posts</a></td>
<td id="a_usertdhead"><a href="users.php?order_var=' . $fn_var . '">First Name</a></td>
<td id="a_usertdhead"><a href="users.php?order_var=' . $ln_var . '">Last Name</a></td>
<td id="a_usertdhead"><a href="users.php?order_var=' . $un_var . '">Username</a></td>
<td id="a_usertdhead"><a href="users.php?order_var=' . $em_var . '">Email</a></td>
<td id="a_usertdhead"><a href="users.php?order_var=' . $al_var . '">Level</a></td>
<td id="a_usertdhead">Options</td>
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
	
	echo '
	<tr>
	<td id="a_usertd" style="background-color:#' .$bgcolor. ';">' . $users['postcount'] . '</td>
	<td id="a_usertd" style="background-color:#' .$bgcolor. ';">' . $users['user_fname'] . '</td>
	<td id="a_usertd" style="background-color:#' .$bgcolor. ';">' . $users['user_lname'] . '</td>
	<td id="a_usertd" style="background-color:#' .$bgcolor. ';">' . $users['username'] . '</td>
	<td id="a_usertd" style="background-color:#' .$bgcolor. ';">' . $users['user_email'] . '</td>
	<td id="a_usertd" style="background-color:#' .$bgcolor. ';">' . getRank($users['access_level']) . '</td>
	<td id="a_usertd" style="background-color:#' .$bgcolor. ';"><a href="profile.php?user='.$users['username'].'">Profile</a></td>
	
	</tr>';
	
}

echo '</table>';

include("tail.php");
?>