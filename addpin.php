<?php // profile.php

include_once 'assets/header.php';

if (!$loggedin) die();

// Include the googlemapsfunctions javascript
echo '<script type="text/javascript" src="assets/js/googlemapsfunctions.js"></script>';

// Activate the correct tab
echo "<script language='javascript'>
		document.getElementById('addpin').className = 'active';
	</script>";

echo '<div class="container">';

echo "<div class='main'><h1>Add/Edit a Pin</h1>";

$description = stripslashes(preg_replace('/\s\s+/', ' ', $description));

if (isset($_POST['pinid'])){
	$situation = 'edit_existing';
	$unique_pin_id = sanitizeString($_POST['pinid']);
	echo "<h3>$unique_pin_id</h3>";
	$pinrow = mysqli_fetch_row(queryMysql("SELECT * FROM pins WHERE pin_id='$unique_pin_id'"));
	$unique_place_id = $pinrow[1];
	$description = $pinrow[3];
	$query = "SELECT * FROM places WHERE place_id='$unique_place_id'";
	$placerow = mysqli_fetch_row(queryMysql($query));
	$placetitle = $placerow[1];
	$street = $placerow[2];
	$city = $placerow[3];
	$country = $placerow[6];
	echo '<div class="thumbnail span12" style="position:relative;">' .
			'<img src="pins/' . $unique_pin_id . '.jpg" alt=""></img>' .
         "</div>";
}
else {
	if (isset($_POST['placetitle']))
	{
		$placetitle = sanitizeString($_POST['placetitle']);
		$placetitle = preg_replace('/\s\s+/', ' ', $placetitle);
	} else $placetitle = "";
	
	if (isset($_POST['street']))
	{
		$street = sanitizeString($_POST['street']);
		$street = preg_replace('/\s\s+/', ' ', $street);
	} else $street = "";
	
	if (isset($_POST['city']))
	{
		$city = sanitizeString($_POST['city']);
		$city = preg_replace('/\s\s+/', ' ', $city);
	} else $city = "";
	
	if (isset($_POST['country']))
	{
		$country = sanitizeString($_POST['country']);
		$country = preg_replace('/\s\s+/', ' ', $country);
	} else $country = "";
	
	if (isset($_POST['description']))
	{
		$description = sanitizeString($_POST['description']);
		$description = preg_replace('/\s\s+/', ' ', $description);
	} else $description = "";
}




// Execute if the Save has been hit
if (isset($_POST['saveattempt']) && ($unique_pin_id!='' || isset($_FILES['pinimage']['name']))) {

	// Check if the place already exists, if not, create the place
	$query = "SELECT place_id FROM places WHERE street='$street' AND city='$city' AND country='$country'";
	$row = mysql_fetch_row(queryMysql($query));
	$unique_place_id = $row[0];
	if (mysql_num_rows(queryMysql($query)) == 0) {
		queryMysql("INSERT INTO places VALUES('', '$placetitle', '$street', '$city', '', '', '$country')");
		$unique_place_id = mysql_insert_id();
	}
	
	// if the pin already exists, update the existing pin
	if ($situation=='edit_existing') {
		queryMysql("UPDATE pins SET place_id='$unique_place_id', text='$description' WHERE pin_id='$unique_pin_id'");
		die("Your pin has been updated. Please <a href='index.php?view=$user'>click here</a> to continue.<br /><br />");
	}

	
	// if the pin does not already exist, create a new pin
	else {
		queryMysql("INSERT INTO pins VALUES('', '$unique_place_id', '$email', '$description', '', '')");
		$unique_pin_id = mysql_insert_id();
		$saveto ="pins/$unique_pin_id.jpg";
	}
}


if (isset($_FILES['pinimage']['name']))
{
	move_uploaded_file($_FILES['pinimage']['tmp_name'], $saveto);
	$typeok = TRUE;
	
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
	//****
	// HERE I NEED TO ROUTE TO INDEX PAGE ON THE SECOND TIME THROUGH. TRY TO USE THE die() TO PAUSE THE PROCESSING
	//******

	
}

// THINK ABOUT ADDING TWO POSSIBLE HIDDEN FIELDS WHICH POST WHETHER THE USER IT TRYING TO ADD A NEW PIN OR EDIT AN EXISTING PIN
echo <<<_END
<form method='post' action='addpin.php' enctype='multipart/form-data'>
<p>Upload an image and choose to describe it</p><br />
<button class="btn btn-danger" type="button">Delete Pin <i class="icon-trash"></i></button><br /><br />
<input type='text' name='placetitle' id='placetitle' value='$placetitle' placeholder='name this place' class="input-xlarge"><br />
<input type='text' name='street' id='street' value='$street' placeholder='street' class="input-xlarge"><br />
<input type='text' name='city' id='city' value='$city' placeholder='city' class="input-xlarge"><br />
<input type='text' name='country' id='country' value='$country' placeholder='country' class="input-xlarge"><br />
<input type='hidden' name='saveattempt' value='doit'>
<textarea name='description' cols='600' class="input-xxlarge" placeholder='please write a bit about this location' rows='3'>$description</textarea><br />
_END;

if ($situation!='edit_existing') {
	echo "Image: <input type='file' class='form-search' name='pinimage' placeholder='Image' /><br /><br />";
}

echo <<<_END
<input type='submit' class='btn btn-large btn-success' value='Save Pin' />
</form></div><br /></body></html>
_END;
?>



