<?php
$connection = mysql_connect('localhost', 'dbname', 'dbpass');
if ($connection){
	mysql_select_db('MessageBoard') or die("No database".mysql_error());
}
else{
	die('Crash<br />'.mysql_error());
}
?>