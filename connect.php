<?php
$connection = mysql_connect('localhost', 'perrelli', '3115');
if ($connection){
	mysql_select_db('MessageBoard') or die("No database".mysql_error());
}
else{
	die('Crash<br />'.mysql_error());
}
?>