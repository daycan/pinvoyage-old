
<?php // functions.php

// Define the document root for PHP 'header' links
define('DOC_ROOT', 'http://LocalHost:8888/');
// define('DOC_ROOT', 'http://www.pinvoyage.com/');

// Database login variables 

$db_hostname = 'localhost';
$db_database = 'pinvoyage';
$db_username = 'root';
$db_password = 'root';

/*
$db_hostname = 'mysql.pinvoyage.com';
$db_database = 'pinvoyage';
$db_username = 'daycan';
$db_password = 'ghettopass';
*/

// Application basics
$appname = "PinVoyage";

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connect to database
$link = mysqli_connect($db_hostname, $db_username, $db_password, $db_database) or die("Error dude" . mysqli_error());


// END OF NEW STUFF
function createTable($name, $query)
{
	queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
	echo "Table '$name' created or already exists.<br />";
}

function queryMysql($query)
{
	global $link;
	$result = mysqli_query($link, $query) or die(mysqli_error($link));
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
	global $link;
	$var = strip_tags($var);
	$var = htmlentities($var);
	$var = stripslashes($var);
	return mysqli_real_escape_string($link, $var);
}

function showProfile($email)
{
	if (file_exists("profiles/profileimages/$email.jpg")) echo "<img src='profiles/profileimages/$email.jpg' align='left' />";
	$result = queryMysql("SELECT * FROM profiles WHERE email='$email'");
	if (mysqli_num_rows($result))
	{
		$row = mysqli_fetch_row($result);
		echo stripslashes($row[1]) . "<br clear=left /><br/>";
	}
}


?>
