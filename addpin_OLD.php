<?php // profile.php

include_once 'assets/header.php';

if (!$loggedin) die();

echo "<script language='javascript'>

// Activate the correct tab
document.getElementById('addpin').className = 'Active';
</script>";

echo '<div class="container">';

echo "<div class='main'><h1>Add/Edit a Pin</h1>";

// commenting out because may be left over from something weird
//$text = stripslashes(preg_replace('/\s\s+/', ' ', $text));



if (isset($_FILES['pinimage']['name']))
{

	if (isset($_POST['text']))
	{
		$text = sanitizeString($_POST['text']);
		$text = preg_replace('/\s\s+/', ' ', $text);
		queryMysql("INSERT INTO pins VALUES('', '', '$email', '$text', '', '')");
		echo "well we got this far $text $email";
	}
	else queryMysql("INSERT INTO pins VALUES('', '', '$email', '', '', '')");
	
	echo "well we got this far";
	// gets the unique identifier of the the DB entry for the pin to use as the filename for the picture
	$unique_pin_id = mysql_insert_id();
	$saveto ="pins/$unique_pin_id.jpg";
	
	move_uploaded_file($_FILES['pinimage']['tmp_name'], $saveto);
	$typeok = TRUE;
	
	// DEALS WITH IMAGE FILE
	switch($_FILES['pinimage']['type'])
	{
		case "pinimage/gif":	$src = imagecreatefromgif($saveto); break;
		case "pinimage/jpeg":	$src = imagecreatefromjpeg($saveto); break;
		case "pinimage/pjpeg":	$src = imagecreatefromjpeg($saveto); break;
		case "pinimage/png":	$src = imagecreatefrompng($saveto); break;
		default:			$typeok = FALSE; break;
	}
	
	if ($typeok)
	{
		list($w, $h) = getimagesize($saveto);
		
		$max = 600;
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

echo <<<_END
<form method='post' action='addpin.php' enctype='multipart/form-data'>
<p>Upload an image and choose to describe it</p><br />
<button class="btn btn-danger" type="button">Delete Pin <i class="icon-trash"></i></button><br /><br />
<input type='text' name='pintitle' placeholder='name this place' class="input-xlarge"><br />
<input type='text' name='street' placeholder='street' class="input-xlarge"><br />
<input type='text' name='city' placeholder='city' class="input-xlarge"><br />
<input type='text' name='country' placeholder='country' class="input-xlarge"><br />
<textarea name='text' cols='600' class="input-xxlarge" placeholder='please write a bit about this location' rows='3'>$text</textarea><br />
_END;
?>

Image: <input type='file' class='form-search' name='pinimage' placeholder="Image" /><br /><br />

<input type='submit' class='btn btn-large btn-success' value='Save Pin' />
</form></div><br /></body></html>
