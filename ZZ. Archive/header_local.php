<?php // header.php
session_start();
echo "<!DOCTYPE html>\n<html><head><script src='OSC.js'></script>";
include '/assets/functions/functions.php';
$userstr = ' (Guest)';

if (isset($_SESSION['user']))
{
	$user		= $_SESSION['user'];
	$loggedin	= TRUE;
	$userstr	= " ($user)";
}
else $loggedin = FALSE;

echo "<title>$appname$userstr</title>" .

	 // Load the Bootstrap stylesheets
	 "<link rel='stylesheet'" . 
	 "href='/assets/css/bootstrap.css' type='text/css' />" . 
	 "<style type='text/css'>
      body {padding-top: 20px; padding-bottom: 40px;}

      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 700px;
      }
      .container-narrow > hr {
        margin: 30px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 60px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 72px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }
    </style>" .
    "<link href='/assets/css/bootstrap-responsive.css' rel='stylesheet'>" .
	 
	 "</head><body><div class='appname'>$appname$userstr</div>";

//shows the right menu items depending on whether or not the user is logged in		
if ($loggedin)
{
	echo "<br ><ul class='menu'>" .
	     "<li><a href='members.php?view=$user'>Home</a></li>" .
		 "<li><a href='members.php'>Members</a></li>" .
		 "<li><a href='friends.php'>Friends</a></li>" .
		 "<li><a href='messages.php'>Messages</a></li>" .
		 "<li><a href='profile.php'>Profile</a></li>" .
		 "<li><a href='logout.php'>Log Out</a></li></ul><br />";
}

else
{
	echo ("<br /><ul class='menu'>" .
	     "<li><a href='index.php'>Home</a></li>" .
		 "<li><a href='signup.php'>Sign Up</a></li>" .
		 "<li><a href='login.php'>Log in</a></li></ul><br />" .
		 "<span class='info'>$#8658; You must be logged in to " .
		 "view this page.</span><br /><br />");
}

?>
