<?php // checkuser.php
include_once 'assets/functions.php';

if (isset($_POST['user']))
{
	$email = sanitizeString($_POST['user']);
	
	if (mysql_num_rows(queryMysql("SELECT * FROM users WHERE email='$email'")))
		echo 	"<span class='taken'>&nbsp;&#x2718; " . 
				"Sorry, this username is taken</span>";
		else echo "<span class='available'>&nbsp;&#x2714; " .
				"This username is available</span>";
}
?>