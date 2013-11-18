<?php // profile.php

include_once 'assets/header.php';

//if (!$loggedin) die();

// Set the highlight on the site navagation items in the header
echo '<script type="text/javascript">document.getElementByID("mastheadProfile").addClass("active");</script>';

echo "<div class='main'><h1>Your Profile</h1>";

if (isset($_POST['text']))
{
	$text = sanitizeString($_POST['text']);
	$text = preg_replace('/\s\s+/', ' ', $text);
	
	if (mysql_num_rows(queryMysql("SELECT * FROM profiles WHERE email='$email'"))) queryMysql("UPDATE profiles SET text='$text' where email='$email'");
	else queryMysql("INSERT INTO profiles VALUES('$email', '$text')");
}

else
{
	$result = queryMysql("SELECT * FROM profiles WHERE email='$email'");
	if (mysql_num_rows($result))
	{
		$row = mysql_fetch_row(result);
		$text = stripslashes($row[1]);
	}
	
	else $text = "";
}



$text = stripslashes(preg_replace('/\s\s+/', ' ', $text));

if (isset($_FILES['image']['name']))
{
	$saveto ="profiles/profileimages/$email.jpg";
	
	move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
	$typeok = TRUE;
	
	switch($_FILES['image']['type'])
	{
		case "image/gif":	$src = imagecreatefromgif($saveto); break;
		case "image/jpeg":	$src = imagecreatefromjpeg($saveto); break;
		case "image/pjpeg":	$src = imagecreatefromjpeg($saveto); break;
		case "image/png":	$src = imagecreatefrompng($saveto); break;
		default:			$typeok = FALSE; break;
	}
	
	if ($typeok)
	{
		list($w, $h) = getimagesize($saveto);
		
		$max = 300;
		$tw = $w;
		$th = $h;
		
		if ($w > $h && $max < $w)
		{
			$th = $max / $w * $h;
			$tw = $max;
		}
		elseif ($h > $w && $max < $h)
		{
			$tw = $max / $h * $w;
			$th = $max;
		}
		elseif ($max < $w)
		{
			$tw = $th = $max;
		}
		
		$tmp = imagecreatetruecolor($tw, $th);
		imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
		imageconvolution($tmp, array(array(-1, -1, -1), 
			array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
		imagejpeg($tmp, $saveto);
		imagedestroy($tmp);
		imagedestroy($src);
	}
}


showProfile($email);

echo <<<_END
<form method='post' action='profile.php' enctype='multipart/form-data'>
<p>Enter or edit your details and/or upload an image</p>
<textarea name='text' cols='200' rows='3'>$text</textarea><br />
_END;
?>

Image: <input type='file' name='image' size='14' maxlength='32' />
<input type='submit' value='Save Profile' />
</form></div><br /></body></html>
