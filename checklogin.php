<?php 
include('connect.php');

function scramble($pw){
	return md5($pw . 'mboard');
}

$username = $_POST['username'];
$password = scramble($_POST['password']);

$qry = "SELECT * FROM users WHERE username='$username' AND upass='$password';";
$result = mysql_query($qry);
$count = 0;
while($result_row = mysql_fetch_array($result)){
	$count++;
}
if ($count == 1){
	Session_start();
	$userinfo = mysql_fetch_array(mysql_query("SELECT * FROM users where username='$username';"));
	$_SESSION['username'] = $username;
	$_SESSION['access_level'] = $userinfo['access_level'];
	header("location:index.php");
}
else{
	$error = "Invalid user data! Try again.";
	include('error.php');
}

?>