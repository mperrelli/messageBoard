<?php 
if(!$index){
	echo 'NO';
	exit();
}

if(isset($_POST['addCataSubmit'])){
$name = $_POST['name'];
$aclvl = $_POST['aclvl'];
$qry = "INSERT INTO catagories (cata_name, access_level) VALUES ('$name', $aclvl);";
mysql_query($qry);
}
else if(isset($_POST['deleteCata'])){
$cataid = $_POST['cataid'];
$qry = "DELETE FROM catagories WHERE cata_id = $cataid;";
mysql_query($qry);
$feedback = "Catagory deleted.";
}
else if(isset($_POST['addFormSubmit'])){
$name = $_POST['name'];
$description = $_POST['description'];
$catagory = $_POST['catagory'];
$qry = "INSERT INTO forms (form_name, form_description, catagory) VALUES('$name', '$description', '$catagory');";
mysql_query($qry) or die(mysql_error());
$feedback = "Form $name added to catagory $catagory! ";
}
else if(isset($_POST['deleteForm'])){
$formid = $_POST['formid'];
$qry = "DELETE FROM forms WHERE form_id = $formid;";
mysql_query($qry);
$feedback = "Form deleted.";
}
else if(isset($_POST['editCataSubmit'])){
$cataid = $_POST['cataid'];
$name = $_POST['name'];
$aclvl = $_POST['aclvl'];
$qry = "UPDATE catagories SET cata_name = '$name', access_level = $aclvl WHERE cata_id = $cataid;";
mysql_query($qry);
$feedback = "Catagory updated!";
}
else if(isset($_POST['editFormSubmit'])){
$formid = $_POST['formid'];
$name = $_POST['name'];
$description = $_POST['description'];
$qry = "UPDATE forms SET form_name = '$name', form_description = '$description' WHERE form_id = $formid;";
mysql_query($qry);
$feedback = "Form updated!";
}

?>

<table style="width:100%;">
<tr><td align="center" id="a_usertdhead" width="250px">Catagories and forms</td><td align="center" id="a_usertdhead">Desciption</td><td align="center" id="a_usertdhead" style="width:130px;">Min access</td><td align="center" id="a_usertdhead" width="180px">Options</td></tr>

<?php 
$action = "admin.php?page=catasforms";
$qry = "SELECT * FROM catagories;";
$result = mysql_query($qry) or die(mysql_error());

while($result_row = mysql_fetch_array($result)){
	
	$disableDelete = 'disabled="disabled"';
	$qry = "SELECT * FROM forms WHERE catagory = '".$result_row['cata_name']."';";
    $testres = mysql_query($qry) or die(mysql_error());
	$count = 0;
	while($resultsss = mysql_fetch_array($testres)){
		$count = $count + 1;
	}
	if($count == 0){
		$disableDelete = '';
	}
	
	if(isset($_POST['editCata']) && $_POST['cataid'] == $result_row['cata_id']){
		echo '<form name="editCataSubmit" method="post" onsubmit="return confirmSubmitcont()" action="'.$action.'" style="display:inline;">
		<tr><td id="a_usertdhead" colspan="2"><input type="text" name="name" size="'.strlen($result_row['cata_name']).'" value="'.$result_row['cata_name'].'" /></td>
		<td id="a_usertdhead">
		<select name="aclvl">
		'.getRankSelection($result_row['access_level'], true).'
		</select>
		</td>
		<td id="a_usertdhead">
		<input type="hidden" name="cataid" value="'.$result_row['cata_id'].'" />
		<input type="submit" name="editCataSubmit" value="Submit" />
		</form>
		<form name="cancel" method="post" action="'.$action.'" style="display:inline;">
		<input type="submit" name="cancel" value="Cancel" />
		</form>
		</td></tr>';
	}
	else{
		echo '<tr><td id="a_usertdhead" colspan="2">'.$result_row['cata_name'].'</td>
		<td id="a_usertdhead">'.getRank($result_row['access_level']).'</td>
		<td id="a_usertdhead">
		<form name="editCata" method="post" action="'.$action.'" style="display:inline;">
		<input type="hidden" name="cataid" value="'.$result_row['cata_id'].'" />
		<input type="submit" name="editCata" value="Edit" />
		</form>
		<form name="deleteCata" method="post" onsubmit="return confirmSubmitcont()" action="'.$action.'" style="display:inline;">
		<input type="hidden" name="cataid" value="'.$result_row['cata_id'].'" />
		<input type="submit" name="deleteCata" value="Delete" '.$disableDelete.'/>
		</form>
		<form name="addForm" method="post" action="'.$action.'" style="display:inline;">
		<input type="hidden" name="cataid" value="'.$result_row['cata_id'].'" />
		<input type="submit" name="addForm" value="Add Form" />
		</form></div>
		</td></tr>';
	}
	
	$qry2 = "SELECT * FROM forms WHERE catagory = '".$result_row['cata_name']."';";
	$result2 = mysql_query($qry2) or die(mysql_error());
	$color1 = "a56c01";
	$color2 = "cb9101";
	while($result_row2 = mysql_fetch_array($result2)){
		if( $bgcolor == $color1 ){
			$bgcolor = $color2;
		}
		else{
			$bgcolor = $color1;
		}
		
		if(isset($_POST['editForm']) && $_POST['formid'] == $result_row2['form_id']){
			echo '<form name="editFormSubmit" method="post" onsubmit="return confirmSubmitcont()" action="'.$action.'" style="display:inline;">
			<tr><td id="a_usertd" style="background-color:#' .$bgcolor. ';"><img src="images/arrow.png" />&nbsp;<input type="text" name="name" size="'.strlen($result_row2['form_name']).'" value="'.$result_row2['form_name'].'" /></td>
			<td id="a_usertd" style="background-color:#' .$bgcolor. ';" colspan="2"><input type="text" name="description" size="'.strlen($result_row2['form_description']).'" value="'.$result_row2['form_description'].'" /></td>
			<td id="a_usertd" style="background-color:#' .$bgcolor. ';">
			<input type="hidden" name="formid" value="'.$result_row2['form_id'].'" />
			<input type="submit" name="editFormSubmit" value="Submit" />
			</form>
			<form name="cancel" method="post" action="'.$action.'" style="display:inline;">
			<input type="submit" name="cancel" value="Cancel" />
			</form></td>
			</tr>';
		}
		else{
			echo '<tr><td id="a_usertd" style="background-color:#' .$bgcolor. ';"><img src="images/arrow.png" />&nbsp;'.$result_row2['form_name'].'</td>
			<td id="a_usertd" style="background-color:#' .$bgcolor. ';" colspan="2">'.$result_row2['form_description'].'</td>
			<td id="a_usertd" style="background-color:#' .$bgcolor. ';">
			<form name="editForm" method="post" action="'.$action.'" style="display:inline;">
			<input type="hidden" name="formid" value="'.$result_row2['form_id'].'" />
			<input type="submit" name="editForm" value="Edit" />
			</form>
			<form name="deleteForm" method="post" onsubmit="return confirmSubmitcont()" action="'.$action.'" style="display:inline;">
			<input type="hidden" name="formid" value="'.$result_row2['form_id'].'" />
			<input type="submit" name="deleteForm" value="Delete" />
			</form></td>
			</tr>';
		}
	}
	if(isset($_POST['addForm']) && $_POST['cataid'] == $result_row['cata_id']){
		echo '<form name="addFormSubmit" method="post" action="'.$action.'" style="display:inline;">
			<tr><td id="a_usertd" style="background-color:#' .$bgcolor. ';"><img src="images/arrow.png" />&nbsp;<input type="text" name="name" /></td>
			<td id="a_usertd" style="background-color:#' .$bgcolor. ';" colspan="2"><input type="text" name="description" /></td>
			<td id="a_usertd" style="background-color:#' .$bgcolor. ';">
			<input type="hidden" name="catagory" value="'.$result_row['cata_name'].'" />
			<input type="submit" name="addFormSubmit" value="Submit" />
			</form>
			<form name="cancel" method="post" action="'.$action.'" style="display:inline;">
			<input type="submit" name="cancel" value="Cancel" />
			</form></td>
			</tr>';
	}
}

if(isset($_POST['addCata'])){
	echo '<form name="addCataSubmit" method="post" action="'.$action.'" style="display:inline;">
	<tr><td id="a_usertdhead" colspan="2"><input type="text" name="name" /></td>
	<td id="a_usertdhead">
	<select name="aclvl">
	'.getRankSelection("0", true).'
	</select>
	</td>
	<td id="a_usertdhead">
	<input type="submit" name="addCataSubmit" value="Submit" />
	</form>
	<form name="cancel" method="post" action="'.$action.'" style="display:inline;">
	<input type="submit" name="cancel" value="Cancel" />
	</form>
	</td></tr>';
}

echo '</table>';
if (isset($feedback)){
	echo '<div id="replybox" style="text-align:center;">'.$feedback.'</div>';
}
echo'
<div align="left">
<form name="addCata" method="post" action="'.$action.'" style="display:inline;">
<input type="submit" name="addCata" value="New Catagory" />
</form>
';
?>


