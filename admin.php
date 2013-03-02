<?php include('connect.php'); include('library.php'); 
$settings = mysql_fetch_array(mysql_query("SELECT * FROM settings"));
extract($settings);
Session_start();
$qry = "SELECT * FROM users WHERE username='".$_SESSION['username']."';";
$userinfo = mysql_fetch_array ( mysql_query ($qry) );
$access_level = $userinfo['access_level'];
if($access_level >= $setting_adminLevel){
$index = true;
}
else{
echo 'You need to login with an administrative account.';
exit();
}
echo '<HTML><head><title>Admin Control Panel</title>
<script type="text/javascript">
<!--
function confirmSubmitRemUser(){
var agree=confirm("Do you really want to remove that user?");
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
<style>
body{
font-size:12px;
}

#a_usertd {
border:1px solid black;
font-size:12px;
}

#a_usertdhead {
font-size:14px;
background-image:url("images/formtitlebg.jpg");
border:1px solid black;
background-repeat:repeat-x;
background-color:#296d00;
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
<link type="text/css" rel="stylesheet" href="styles.css" />
</head><body><div id="admincpcontainer" align="center">
<div id="admincpnav"><a href="index.php"><< Back to Index</a> | <a href="admin.php?page=users">Users</a> | <a href="admin.php?page=catasforms">Catagories & forms</a> | <a href="admin.php?page=permissions">Permissions</a> | <a href="admin.php?page=settings">Settings</a></div>
<div id="admincpbody">';
$page = $_GET['page'];
if(isset($_GET['page'])){
	include('admin/'.$page.'.php');
}
else{
	include('admin/users.php');
}

echo '</div></div></body></HTML>';
?>