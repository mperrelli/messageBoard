<?php include('head.php');

if(isset($_POST['submittopic'])){
	$title = $_POST['title'];
	$content = $_POST['content'];
	$author = $_POST['author'];
	$form = $_POST['form'];
	$date = date("m-d-y h:i A");
	$pin = 0;
	if($_POST['pinned'] == 1){
	$pin = 1;
	}
	$qry = "INSERT INTO topics (topic_body, topic_title, topic_author, form, timestamp, topic_pinned) VALUES ('$content', '$title', '$author', $form, '$date', $pin);";
	mysql_query($qry) or die(mysql_error());
	$newtopicid = mysql_fetch_array(mysql_query("SELECT topic_id FROM topics ORDER BY topic_id DESC LIMIT 1;"));
	header("location:topic.php?id=".$newtopicid['topic_id']."");

}
else if(isset($_SESSION['username'])){
	echo'
	<div style="border:1px solid black; background-image:url(images/catagorybarbg.jpg); background-repeat:repeat-x; background-color:#a46c00;">
	<form name="topic" method="post" action="newtopic.php">
	<table>
	<tr><td valign="top" style="align="right">Title: </td><td><input type="text" name="title" style="width:100%;" /></td></tr>
	<tr><td valign="top" style="align="right">Message: </td><td><textarea name="content" rows="10" cols="40"></textarea></td></tr>
	<tr><td colspan="2" align="right"><input type="hidden" name="author" value="'.$_SESSION['username'].'" />
	<input type="hidden" name="form" value="'.$_POST['formid'].'" />';
	
	if($access_level >= $setting_modLevel){
		echo 'Pin topic? <input type="checkbox" name="pinned" value="1" />';
	}
	echo'<input type="submit" name="submittopic" value="Submit"></input></td></tr>
	</table>
	</form></div>
	';
}
else{
	$error = "You must login to add new topics!";
	include('error.php');
}

include('tail.php') ?>