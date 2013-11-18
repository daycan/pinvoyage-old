<?php // members.php

include_once 'assets/header.php';

if (!$loggedin) header('Location: ' .DOC_ROOT. 'signIn_or_signUp.php');

echo "<div class='main'>";

if (isset($_GET['view']))
{
	$view = sanitizeString($_GET['view']);
	
	if ($view == $email) $name = "Your";
	else $name = "$view's";
	
	echo "<h3>$name Profile</h3>";
	showProfile($view);
	echo "<a class='button' href='messages.php?view=$view'>" .
			"View $name messages</a><br /><br />";
	die("</div></body></html>");
}

if (isset($_GET['add']))
{
	$add = sanitizeString($_GET['add']);
	
	if (!mysql_num_rows(queryMysql("SELECT * FROM friends WHERE email='$email' AND friend='$add'")))
		queryMysql("INSERT INTO friends VALUES ('$add', '$email')");
}

elseif (isset($_GET['remove']))
{
	$remove = sanitizeString($_GET['remove']);
	queryMysql("DELETE FROM friends WHERE friend='$remove' AND email='$email'");
}

$result = queryMysql("SELECT email FROM users ORDER BY email");
$num = mysql_num_rows($result);

echo "<h3>Other Members</h3><ul>";


for ($j = 0 ; $j < $num ; ++$j)
{
	$row = mysql_fetch_row($result);
	if ($row[0] == $email) continue;
	
	echo "<li><a href='members.php?view=row[0]'>$row[0]</a>";
	$follow = "follow";
	
	$t1 = mysql_num_rows(queryMysql("SELECT * FROM friends WHERE email='$row[0]' AND friend='$email'"));
	$t2 = mysql_num_rows(queryMysql("SELECT * FROM friends WHERE email='$email' AND friend='$row[0]'"));
	
	if (($t1 + $t2) > 1) 	echo " &harr; is a mutual friend";
	elseif($t1)			  { echo " &rarr; is following you"; $follow = "recip"; }
	elseif($t2)				echo " &larr; you are following";

	
	if (!$t2) echo " [<a href='members.php?add=".$row[0]	. "'>$follow</a>]";
	else 	  echo " [<a href='members.php?remove=".$row[0] . "'>drop</a>]";
}

?>

<br /></div></body></html>