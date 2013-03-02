<?php
include('head.php');

echo '
<table style="width:100%; height:100%;" cellpadding="0" cellspacing="0"><tr><td></td><td style="width:100%; height:100%;">
<div align="center" style="border:1px solid black; background-image:url(images/catagorybarbg.jpg); background-repeat:repeat-x; background-color:#a46c00;"><div width="400px">
';

if (isset($_POST['submitted'])){

	if (!empty( $_POST['username'])){
		$username = $_POST['username'];
	}
	else{
		$errors[] = "Missing a username.";
	}
	
	if (!empty($_POST['password1']) && !empty($_POST['password2'])){
		$password = scramble($_POST['password1']);
	}
	else
	{
		$errors[] = "Missing a password.";
	}
	
	if ( !empty ( $_POST['fname']))
	{
		$fname = $_POST['fname'];
	}
	else
	{
		$errors[] = "Missing your first name.";
	}
	
	if ( !empty ( $_POST['lname']))
	{
		$lname = $_POST['lname'];
	}
	else
	{
		$errors[] = "Missing your last name.";
	}
	
	if ( !empty ( $_POST['email']))
	{
		$email = $_POST['email'];
	}
	else
	{
		$errors[] = "Missing your e-mail address.";
	}
	
	$count = mysql_num_rows ( mysql_query ("SELECT * FROM users WHERE username='$username' ") ) ;
	
	if ( $count > 0 )
	{
		$errors[] = "Username already taken.";
	}
	
	if ( $_POST['password1'] != $_POST['password2'] )
	{
		$errors[] = "Passwords dont match.";
	}
	
	if (  $_POST['validate'] != $_POST['n1'] + $_POST['n2'] ){
		
		$errors[] = "Bad Validation!";
	}
	
	if ( checkemail($_POST['email']) == false )
	{
		$errors[] = "Invalid e-mail address.";
	}
	
	if ( empty ( $errors ))
	{
		
		$level = 1;
		mysql_query ("INSERT INTO users (username, upass, user_fname, user_lname, user_email, access_level) VALUES ('$username', '$password', '$fname', '$lname', '$email', '$level');") or die( mysql_error() );
		echo 'You have been registered successfully!';
	
	}
	else
	{	
		foreach ( $errors AS $error )
		{
			print "<span style='color:red;'>" . $error . "</span><br />";
		}
		echo "<a href='register.php'>Try again</a>";
	}

}
else{
$n1 = rand(1, 10);
$n2 = rand(1, 10);
echo '

	<table cellspacing="0" cellpadding="5" border="0">
	<form name="input" action="register.php" method="post">
	<tr><td colspan="3"><center><b>Registration</b></center></td>
	<tr><td>First name:</td><td><input type="text" name="fname" style="width:100px;" /></td></tr>
	<tr><td style="border-bottom:1px solid white;">Last name:</td><td colspan="2" style="border-bottom:1px solid white;"><input style="width:100px;" type="text" name="lname" /></td></tr>
	<tr><td>e-mail address: </td><td><input style="width:100px;" type="text" name="email" size="30" /></td></tr>
	<tr><td>Username:</td><td><input style="width:100px;" type="text" name="username" /></td></tr>
	<tr><td style="border-bottom:1px solid white;">Password:</td><td style="border-bottom:1px solid white;"><input type="password" style="width:100px;" name="password1" maxlength="12"/></td><td style="border-bottom:1px solid white;"><input type="password" style="width:100px;" name="password2" maxlength="12"/></td></tr>
	<tr><td style="border-bottom:1px solid white;">Validation: '.$n1.' + '.$n2.' = </td><td colspan="2" style="border-bottom:1px solid white;"><input type="text" style="width:100px;" name="validate" /></td></tr>
	<tr><td colspan="3" align="center"><input type="hidden" name="submitted" /><input type="hidden" name="n1" value="'.$n1.'"/><input type="hidden" name="n2" value="'.$n2.'"/>
		<input style="width:100px;" type="submit" value="Submit" style="width:100px;" /></td></tr>
	</form>
	
	</table>

';

}


echo '
</div></div>
</td><td></td></tr></table>
';
include('tail.php');
?>