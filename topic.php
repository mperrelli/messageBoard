<?php include('head.php');

if(isset($_POST['deletePost'])){
$table = $_POST['table'];
if($table == "replies"){$pre = "reply";}else{$pre = "topic";}
$col = $pre."_id";
$id = $_POST['id'];
$replies = mysql_fetch_array(mysql_query("SELECT topic_replys FROM topics where topic_id = $id;"));
$replycount = $replies['topic_replys'];
$qry = "DELETE FROM $table WHERE $col = $id;";
$form = $_POST['form'];
mysql_query($qry);
if ($table == "topics"){
	mysql_query("CALL deletereplies($id);");
	mysql_query("UPDATE forms SET form_posts = form_posts - $replycount WHERE form_id = $form;");
	header("location:form.php?id=".$form."");
}
$repmessage = "Post Deleted!";
}

$topicid = $_GET['id'];
$topicinfo = mysql_fetch_array(mysql_query("SELECT * FROM topics WHERE topic_id = $topicid;"));
$forminfo = mysql_fetch_array(mysql_query("SELECT form_name FROM forms WHERE form_id = ".$topicinfo['form'].";"));

function editbuttons($author, $user, $post, $isreply, $form){
	if($isreply){ $table = "replies"; }
	else{ $table = "topics"; }
	echo '<a name="post_'.$post.'"></a>';
	if($user['username'] == $author){
		echo'<form name="editPost" method="post" action="topic.php?id='.$_GET['id'].'#replybox" style="float:left;">
		<input type="hidden" name="id" value="'.$post.'" />
		<input type="hidden" name="table" value="'.$table.'" />
		<input type="submit" name="edit" value="Edit" />
		</form>
		<form name="deletePost" method="post" onsubmit="return confirmSubmitDel()" action="topic.php?id='.$_GET['id'].'#replybox" style="float:left;">
		<input type="hidden" name="id" value="'.$post.'" />
		<input type="hidden" name="table" value="'.$table.'" />
		<input type="hidden" name="form" value="'.$form.'" />
		<input type="submit" name="deletePost" value="Delete" />
		</form>';
	}
	else if($user['access_level'] >= $setting_modLevel){
		echo '<form name="editPost" method="post" action="topic.php?id='.$_GET['id'].'#replybox" style="float:left;">
		<input type="hidden" name="id" value="'.$post.'" />
		<input type="hidden" name="table" value="'.$table.'" />
		<input type="submit" name="edit" value="Edit" />
		</form>
		<form name="deletePost" method="post" onsubmit="return confirmSubmitDel()" action="topic.php?id='.$_GET['id'].'#replybox" style="float:left;">
		<input type="hidden" name="id" value="'.$post.'" />
		<input type="hidden" name="table" value="'.$table.'" />
		<input type="hidden" name="form" value="'.$form.'" />
		<input type="submit" name="deletePost" value="Delete" />
		</form>';
	}
}

if(isset($_POST['replytotopic'])){
	$valid = true;
	if($access_level == 0){
		$valid = false;
		if($_POST['validate'] == $_POST['n1'] + $_POST['n2']){
			$valid = true;
		}
	}
	
	$content = $_POST['content'];
	$author = $_POST['author'];
	$date = date("m-d-y h:i A");
	$qry = "INSERT INTO replies (topic_id, reply_author, reply_body, timestamp) VALUES ($topicid, '$author', '$content', '$date');";
	if($valid){ 
		mysql_query($qry) or die(mysql_error()); 
		$repmessage ="Reply added!";
	}
	else { $repmessage = "<font color='orange'>You must login OR answer validation correctly to add a post.</font>";}
	

}
else if(isset($_POST['editPost'])){
$table = $_POST['table'];
$id = $_POST['postid'];
$content = $_POST['content'];
if($table == "replies"){$pre = "reply";}else{$pre = "topic";}
$body = $pre."_body";
$rowid = $pre."_id";
$qry = "UPDATE $table SET $body = '$content' WHERE $rowid = $id;";
mysql_query($qry);
$repmessage = "Post Changed!";
}

$topicinfo = mysql_fetch_array(mysql_query("SELECT * FROM topics WHERE topic_id = $topicid;"));
$forminfo = mysql_fetch_array(mysql_query("SELECT form_name FROM forms WHERE form_id = ".$topicinfo['form'].";"));

echo '<div id="breadcrumbs"><a href="index.php">index</a> > <a href="form.php?id='.$topicinfo['form'].'">'.$forminfo['form_name'].'</a> > <a href="topic.php?id='.$topicid.'">'.$topicinfo['topic_title'].'</a></div>';

echo'
<div id="formcommands">
<form name="newtopic" method="post" action="newtopic.php">
<input type="hidden" name="formid" value="'.$topicinfo['form'].'" />
<input type="submit" name="newtopic" value="New Topic" />
</form>
<form name="reply" method="post" action="topic.php?id='.$topicid.'#replybox">
<input type="hidden" name="topicid" value="'.$topicid.'" />
<input type="submit" name="reply" value="Reply" />
</form>
</div>
<Table id="post">
<tr><td colspan="2" id="posthead">'.$topicinfo['topic_title'].'</td>
<tr><td id="postuserbox">';
userInfoBox($topicinfo['topic_author']);
echo '</td><td id="postbody">
<table class="postorganizer"><tr><td class="postbodyhead">
<div style="width:100%; font-size:10px;"><div style="float:left;">Posted on: '.$topicinfo['timestamp'].'</div><div style="float:right;">';editbuttons($topicinfo['topic_author'], $userinfo, $topicinfo['topic_id'], false, $topicinfo['form']);echo'</div></div>
</td></tr><tr>
<td class="postbodycontent">
'.bbcode2html($topicinfo['topic_body']).' </td></tr><tr><td class="signature">';
getSignature($topicinfo['topic_author']);
echo '</td></tr></table></td></tr>';

$qry = "SELECT * FROM replies WHERE topic_id = ".$topicid." ORDER BY reply_id ASC;";
$result = mysql_query($qry) or die(mysql_error());

while($result_row = mysql_fetch_array($result)){

	echo '<tr><td id="reply">';
	userInfoBox($result_row['reply_author']);
	echo'</td><td id="reply"><table class="postorganizer"><tr><td class="postbodyhead">
	<div style="width:100%; font-size:10px;"><div style="float:left;">Posted on: '.$result_row['timestamp'].'</div><div style="float:right;">';editbuttons($result_row['reply_author'], $userinfo, $result_row['reply_id'], true, $topicinfo['form']);echo'</div></div>
	</td></tr><tr>
	<td class="postbodycontent">
	'.bbcode2html($result_row['reply_body']).' </td></tr><tr><td class="signature">';
	getSignature($result_row['reply_author']);
	echo'</td></tr></table></td></tr>';

}

echo'</table>';

if(isset($_POST['replytotopic']) || isset($_POST['editPost']) || isset($_POST['deletePost'])){
	
	echo '<div id="replybox" style="text-align:center;"><a name="replyadded"></a>'.$repmessage.'</div>';

}
else if(isset($_POST['reply'])){

	echo'<div id="replybox"><a name="replybox"></a><form name="topic" method="post" action="topic.php?id='.$topicid.'#replyadded">
	<table>
	<tr><td valign="top" style="align="right">Message: </td><td><textarea name="content" rows="10" cols="40"></textarea></td></tr>
	<tr><td colspan="2" align="right"><input type="hidden" name="author" value="'.$_SESSION['username'].'" />
	<input type="hidden" name="form" value="'.$topicinfo['form'].'" /></td></tr>';
	if ( $access_level == 0 ){
			$n1 = rand(1, 10);
			$n2 = rand(1, 10);
			echo '
			<tr><td><input type="hidden" name="n1" value="'.$n1.'"/>
			<input type="hidden" name="n2" value="'.$n2.'"/>
			Validation: '.$n1.' + '.$n2.' = </td><td><input type="text" name="validate"/></td></tr>
			';
		
		}
	echo '<tr><td><input type="submit" name="replytotopic" value="Post Reply!"></input></td></tr>
	</table>
	</form></div>';
	
}
else if(isset($_POST['edit'])){
	$table = $_POST['table'];
	if($table == "replies"){$pre = "reply";}else{$pre = "topic";}
	$id = $_POST['id'];
	$col = $pre."_id";
	$author = $pre."_author";
	$body = $pre."_body";
	$author = $pre."_author";
	$qry = "SELECT * FROM $table WHERE $col = $id;";
	$result = mysql_fetch_array(mysql_query($qry));
	
	echo'<div id="replybox"><a name="replybox"></a><form name="topic" method="post" action="topic.php?id='.$topicid.'#post_'.$id.'">
	<table>
	<tr><td valign="top" style="align="right">Message: </td><td><textarea name="content" rows="10" cols="40">'.$result[$body].'</textarea></td></tr>
	<tr><td colspan="2"><input type="hidden" name="table" value="'.$table.'" /><input type="hidden" name="postid" value="'.$id.'" />
	<input type="submit" name="editPost" value="Edit Post"></input></td></tr>
	</table>
	</form></div>';
}

include('tail.php') ?>