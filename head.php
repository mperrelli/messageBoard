<?php include('connect.php'); include('library.php'); 
$settings = mysql_fetch_array(mysql_query("SELECT * FROM settings"));
extract($settings);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd"> 
<HTML>
<head>
<title><?php echo $setting_boardTitle ?></title>
<link type="text/css" rel="stylesheet" href="styles.css" />
<script type="text/javascript">
<!--
function confirmSubmitDel(){
var agree=confirm("Are you sure you want to delete that?");
if (agree)
	return true ;
else
	return false ;
}
//-->
</script>
<script type="text/javascript">
<!--
function confirmSubmitcont(){
var agree=confirm("Are you sure you want to continue?");
if (agree)
	return true ;
else
	return false ;
}
//-->
</script>
</head>
<body>
<table id="layout_controller" align="center">
<tr><td id="header"><?php echo $setting_boardHeader ?></td></tr>
<?php include('nav.php') ?>
<tr><td id="userinfo">
<?php
Session_start();
if(isset($_SESSION['username'])){
	$user = $_SESSION['username'];
	$userinfo = mysql_fetch_array ( mysql_query ("SELECT * FROM users WHERE username='$user';") );
	$access_level = $userinfo['access_level'];
	echo 'Welcome back '.$_SESSION['username'].'! 
	<form method="post" action="logout.php" style="display:inline;">
	<input type="submit" name="logout" value="Logout!" style="width:50px;" />
	</form>&nbsp;&nbsp;<a href="profile.php?user='.$user.'">My Profile</a>&nbsp;&nbsp;
	';
	if($access_level >= $setting_adminLevel){
	echo '<form method="post" action="admin.php" style="display:inline;">
	<input type="submit" name="admin" value="Admin CP" style="width:75px;" />
	<input type="hidden" name="user" value="'.$user.'" />
	</form>';
	}
	echo '<div align="right" style="float:right;">Account type: ';echo getRank($access_level);echo'</div>';
	
	
	
}
else{
	$access_level = 0;
	echo'
	<form method="post" action="checklogin.php" style="display:inline;">
	Username: 
	<input type="text" name="username" />&nbsp;Pass: 
	<input type="password" name="password" />
	<input type="submit" name="login" value="Login!" style="width:50px;" />
	</form> OR <a href="register.php">Register</a>
	';
}
?>
</td></tr>
<tr><td>