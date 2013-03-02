<?php include('head.php');

$form = $_GET['id'];
$forminfo = mysql_fetch_array(mysql_query("SELECT * FROM forms WHERE form_id = $form;"));
echo'
<div id="breadcrumbs"><a href="index.php">index</a> > <a href="form.php?id='.$form.'">'.$forminfo['form_name'].'</a></div>
<div id="formcommands">
<form name="newtopic" method="post" action="newtopic.php">
<input type="hidden" name="formid" value="'.$form.'" />
<input type="submit" name="newtopic" value="New Topic" />
</form>
</div>
<table id="form_controller">
<tr><td align="center" class="formhead">Topics</td><td align="center" class="formhead" style="width:150px;">Author</td><td align="center" class="formhead" style="width:70px;">Replys</td></tr>
';

$qry = "SELECT * FROM topics WHERE form = '$form' AND topic_pinned = 1;";
$result = mysql_query($qry) or die(mysql_error());

while($result_row = mysql_fetch_array($result)){

	echo '<tr><td class="form"><a href="topic.php?id='.$result_row['topic_id'].'" class="formlink"><img src="images/pin.png" height="25px" />&nbsp;'.$result_row['topic_title'].'</a></td>
	<td class="form"><a href="profile.php?user='.$result_row['topic_author'].'" class="formlink">'.$result_row['topic_author'].'</a></td>
	<td class="form">'.$result_row['topic_replys'].'</td></tr>';

}

$qry = "SELECT * FROM topics WHERE form = '$form' AND topic_pinned = 0;";
$result = mysql_query($qry) or die(mysql_error());
echo '<tr><td colspan="3" class="separator"></td></tr>';
while($result_row = mysql_fetch_array($result)){

	echo '<tr><td class="form"><a href="topic.php?id='.$result_row['topic_id'].'" class="formlink"><img src="images/arrow.png" />&nbsp;'.$result_row['topic_title'].'</a></td>
	<td class="form"><a href="profile.php?user='.$result_row['topic_author'].'" class="formlink">'.$result_row['topic_author'].'</a></td>
	<td class="form">'.$result_row['topic_replys'].'</td>';

}

?>
</table>

<?php include('tail.php') ?>