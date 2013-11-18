<?php // header.php
session_start();
echo "<!DOCTYPE html><html lang='en'>\n<html><head><script src='OSC.js'></script>";
include 'assets/functions/functions.php';
$emailstr = ' (Guest)';

if (isset($_SESSION['user']))
{
	$email		= $_SESSION['user'];
	$loggedin	= TRUE;
	$emailstr	= " ($email)";
}
else $loggedin = FALSE;

// Load jQuery - NOTE: NOT SURE THIS IS WORKING YET
echo '<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>';
echo '<script type="text/javascript" src="assets/js/script.js"></script>';

echo "<title>$appname$emailstr</title>" .

	 // Meta-stuff from Bootstrap header
	 '<meta charset="utf-8">'.
	 "<title>Template &middot; Bootstrap</title>" .
	 '<meta name="viewport" content="width=device-width, initial-scale=1.0">' .
	 '<meta name="description" content="">' .
	 '<meta name="author" content="">' .

	 // Load the Bootstrap stylesheets
	 "<link rel='stylesheet' href='assets/css/bootstrap.css' type='text/css' />" . 
     "<link href='assets/css/bootstrap-responsive.css' rel='stylesheet'>" .
	 
	 // Load specific Bootstrap Modifiers from 'Justified Nav' template
	 '<style type="text/css">
	 body {
        padding-top: 20px;
        padding-bottom: 60px;
      }

      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 1000px;
      }
      .container > hr {
        margin: 60px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 80px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 100px;
        line-height: 1;
      }
      .jumbotron .lead {
        font-size: 24px;
        line-height: 1.25;
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
	  </style>
	  ' .
	 
	 // A bunch more stuff from the bottom of the Bootstrap <head>... likely for different browsers and iOS
	 '<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->' .
     '<!--[if lt IE 9]>' .
     '<script src="../assets/js/html5shiv.js"></script>' .
     '<![endif]-->' .

     '<!-- Fav and touch icons -->' .
     '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">' .
     '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">' .
     '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">' .
                    '<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">' .
                                   '<link rel="shortcut icon" href="../assets/ico/favicon.png">' .
	 
	 
	 // End of Head
	 "</head><body><div class='appname'>$appname$emailstr</div>";

// Google Analytics Tracking
echo '<script type="text/javascript">' .

  'var _gaq = _gaq || [];' .
  "_gaq.push(['_setAccount', 'UA-34863242-1']);" .
  "_gaq.push(['_setDomainName', 'pinvoyage.com']);" .
  "_gaq.push(['_trackPageview']);" .

  "(function() {" .
    "var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;" .
    "ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';" .
    "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);" .
  "})();" .

'</script>';
// End of Google Analytics Tracking


//shows the right menu items depending on whether or not the user is logged in		
if ($loggedin)
{
	echo "<div class='masthead'>" .
		 "<ul class='nav nav-pills pull-right'>" .
	     "<li><a href='index.php?view=$email' id='home'>Home</a></li>" .
		 "<li><a href='members.php' id='members'>Members</a></li>" .
		 "<li><a href='profile.php' id='mastheadProfile'>Profile</a></li>" .
		 "<li><a href='addpin.php' id='addpin'>Add Pin</a></li>" .
		 "<li><a href='signIn_or_signUp.php'>Log Out</a></li></ul></div><br />";
}

else
{
	echo ("<div class='masthead'>" .
		 "<br /><ul class='nav nav-pills pull-right'>" .
	     "<li id='Home' class='active'><a href='index.php'>Home</a></li>" .
		 "<li><a href='signIn_or_signUp.php'>Sign Up</a></li>" .
		 "<li><a href='signIn_or_signUp.php' id='signIn'>Sign in</a></li></ul><br />" .
		 "<span class='info'>&#8658; You must be logged in to " .
		 "view this page.</span><br /><br />");
}

?>
