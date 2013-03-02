<?php include('head.php') ?>

<div id="breadcrumbs"><a href="index.php">index</a></div>

<table id="catagory_controller">
<tr><td align="center" class="formhead">Form</td><td align="center" class="formhead" style="width:100px;">Topics</td><td align="center" class="formhead" style="width:100px;">Posts</td></tr>

<?php 
$qry = "SELECT * FROM catagories WHERE access_level <= $access_level;";
$result = mysql_query($qry) or die(mysql_error());

while($result_row = mysql_fetch_array($result)){

	echo '<tr><td class="catagory" colspan="3">'.$result_row['cata_name'].'</td></tr>';
	
	$qry2 = "SELECT * FROM forms WHERE catagory = '".$result_row['cata_name']."';";
	$result2 = mysql_query($qry2) or die(mysql_error());
	
	while($result_row2 = mysql_fetch_array($result2)){
		echo '<tr><td class="form"><a href="form.php?id='.$result_row2['form_id'].'" class="formlink"><img src="images/arrow.png" />&nbsp;'.$result_row2['form_name'].'<br /> <div>'.$result_row2['form_description'].'</div></a></td>
		<td class="form" style="width:100px;">'.$result_row2['form_topics'].'</td>
		<td class="form" style="width:100px;">'.$result_row2['form_posts'].'</td></tr>';
	}

}

?>
</table>

<?php include('tail.php') ?>
