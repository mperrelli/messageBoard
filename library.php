<?php 

function safe($value){

	$value = htmlentities( $value, ENT_QUOTES, 'UTF-8' );
	
	return $value;
}

function bbcode2html($text) {

	$text = safe($text);
	// [B]old 
	$text = preg_replace('/\[B](.+?)\[\/B]/i', '<strong>$1</strong>', $text);
	// [I]talic 
	$text = preg_replace('/\[I](.+?)\[\/I]/i', '<em>$1</em>', $text);
	// Convert Windows (\r\n) to Unix (\n) 
	$text = str_replace("\r\n", "\n", $text); 
	$text = str_replace("[br]", "<br />", $text); 
	// Convert Macintosh (\r) to Unix (\n) 
	$text = str_replace("\r", "\n", $text);
	// Line breaks 
	$text = str_replace("\n", '<br/>', $text);
	// [URL]link[/URL] 
	$text = preg_replace('/\[URL]([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)\[\/URL]/i', '<a href="$1">$1</a>', $text);
	// [URL=url]link[/URL] 
	$text = preg_replace('/\[URL=([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)](.+?)\[\/URL]/i', '<a href="$1">$2</a>', $text);
	// [IMG]link[/IMG]
	$text = preg_replace("@\[IMG\](.*)\[\/img\]@si", "<img src=\"$1\" border=\"0\" />", $text);
	// [CODE]code[/CODE]
	$text = preg_replace ('/\[CODE\](.*?)\[\/CODE\]/isx', '<div class="postedcode" style="border-bottom:0px; font-size:10px; padding:0px; width:30px;">&nbspCode</div><div class="postedcode"><pre>$1</pre></div>', $text);
	
	
	return $text;

}

function userInfoBox($username) {
	
	$user = mysql_fetch_array ( mysql_query ("SELECT user_id, username, access_level, postcount, profile_avatar FROM users WHERE username='$username';") );
	
    echo '<div><a href="profile.php?id='.$user['user_id'].'" class="formlink">
    '.$user['username'].'</a><br />
    '.getRank($user['access_level']).'<br />';
    
    for($i = 0; $i < $user['access_level']; $i++){
    	echo'<img src="images/star1.gif" alt="" />';
    }
    echo '<br /><img src="images/profilepics/'.$user['profile_avatar'].'" width="100px" style="border:1px solid black;" /><br />
    Posts: '.$user['postcount'];
    
    echo '</div>';
}

function getSignature($username) {
	
	$user = mysql_fetch_array ( mysql_query ("SELECT profile_signature FROM users WHERE username='$username';") );
	
    echo '<br /><br /><div class="signature">-----------------------------<br />';
    echo bbcode2html($user['profile_signature']);
    echo '</div>';
}

function getRank($ACLevel){
	$getrank = mysql_fetch_array(mysql_query("SELECT * FROM permissions WHERE access_level = $ACLevel;"));
	
	return $getrank['title'];
}

function getRankSelection($selectedlevel, $includeUnregistered){
	if($selectedlevel != ""){
		$checklevel = $selectedlevel;
	}
	$output = "";
	if ($includeUnregistered){
		$ranks = mysql_query("SELECT * FROM permissions;");
	}
	else{
		$ranks = mysql_query("SELECT * FROM permissions WHERE access_level <> 0;");
	}
	while($result = mysql_fetch_array($ranks)){
		$selected = "";
		if(isset($checklevel) && $checklevel == $result['access_level']){
			$selected = "selected";
		}
		$output .= '<option value="'.$result['access_level'].'" '.$selected.'>'.$result['title'].'</option>';
	}
	return $output;
}

function scramble($pw){
	return md5($pw . 'mboard');
}

function checkemail($email){

	if(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) {
	
	  return true;
	
	}
	
	else {
	
	  return false;
	
	}
	
}



?>