
<?php // functions.php

// Define the document root for PHP 'header' links
define('DOC_ROOT', 'http://LocalHost:8888/');
// define('DOC_ROOT', 'http://www.pinvoyage.com/');

// Database login variables 
$db_hostname = 'localhost:8889';
$db_database = 'pinvoyage';
$db_username = 'root';
$db_password = 'root';


/*$db_hostname = 'mysql.pinvoyage.com';
$db_database = 'pinvoyage';
$db_username = 'daycan';
$db_password = 'ghettopass';
*/

// Application basics
$appname = "PinVoyage";

// Connect to database
mysql_connect($db_hostname, $db_username, $db_password) or die(mysql_error());
mysql_select_db($db_database) or die(mysql_error());

function createTable($name, $query)
{
	queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
	echo "Table '$name' created or already exists.<br />";
}

function queryMysql($query)
{
	$result = mysql_query($query) or die(mysql_error());
	return $result;
}

function destroySession()
{
	$_SESSION=array();
	if (session_id() != "" || isset($_COOKIE[SESSION_NAME()])) setcookie(session_name(), '', time()-2592000, '/');
	session_destroy();
}

function sanitizeString($var)
{
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);
	return mysql_real_escape_string($var);
}

function showProfile($email)
{
	if (file_exists("profiles/profileimages/$email.jpg")) echo "<img src='profiles/profileimages/$email.jpg' align='left' />";
	$result = queryMysql("SELECT * FROM profiles WHERE email='$email'");
	if (mysql_num_rows($result))
	{
		$row = mysql_fetch_row($result);
		echo stripslashes($row[1]) . "<br clear=left /><br/>";
	}
}


?>
