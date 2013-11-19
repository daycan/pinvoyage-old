<?php // index.php

include_once 'assets/header.php';

if (isset($_POST['pinid'])){
	$unique_pin_id = sanitizeString($_POST['pinid']);
	queryMysql("DELETE FROM pins WHERE pin_id='$unique_pin_id'");
}

// Restart the container -- header in header.php is in a 
echo '<div class="container">';

// echo '<div id="map-canvas" style="width: 100%; height: 300px"></div>';

echo '<!-- Jumbotron -->
  <div class="jumbotron" style="z-index: 100; position: relative; top: -30px;" >' .
  	// the is the div that google maps loads in to
	'<div id="map-canvas" style="left: 0; right: 0; top: 0; bottom: 0; z-index: 0; position: absolute;"></div>' .
	// this div hovers over the google map
	'<div style="z-index: 100; position: relative; padding-top: 30px; padding-bottom: 30px" >' .
		'<h1>Welcome to PinVoyage</h1>' .
		'<p class="lead">PinVoyage helps you keep track of all the places you&rsquo;d like to see ' . 
			'around the world so that you can make sure to visit them all some day.</p>' .
		'<a id="add_pin_button" class="btn btn-large btn-success" href="addpin.php">Add a Pin</a>' .
	'</div>' .
  '</div>' .
  
  // Map to expand the map and remove the 'jumbotron'
	'<button id="expand_map_button" class="btn" type="button" >Expand Map</button><br /><br />' .

  '<hr>' .

  '<!-- Example row of columns -->' .
  '<div class="row-fluid">' .
	'<div class="span4" id="column_0">' .
	'</div>' .
	'<div class="span4" id="column_1">' .
   '</div>' .
	'<div class="span4" id="column_2">' .
	'</div>' .
	
  '</div>';


if ($loggedin == TRUE){
	$result = queryMysql("SELECT * FROM pins WHERE email='$email'");
	$num = mysqli_num_rows($result);


	// render the users pins

	for ($j = 0 ; $j < $num ; ++$j)
	{
		$row = mysqli_fetch_row($result);
		$imagename = 'pins/' . $row[0] . '.jpg';
		
		// select the correct column in which to palce the pin's image 
		$column = $j%3;
		
		//OLD METHOD OF PICKING THE RIGHT COLUMN
		echo "<script type='text/javascript'>$(\"#column_$column\").append('" . 
				// The form which contains the photo and buttons to edit delete etc.
			 		'<div class="thumbnail" style="position:relative;">' .
					
						'<img src="' . $imagename . '" alt=""></img>' .
						'<p class="muted">' . $row[3] . "</p>" . 
						'<form method="post" action="addpin.php" enctype="multipart/form-data">' .
							'<input type="hidden" name="pinid" value="' . $row[0] . '">' .
							'<input type="submit" class="btn btn-medium btn-action show_on_hover" value="Edit" style="height:32px; width:60px; ' .
								'margin: -15px -46px; position:absolute; top:50%; left:50%;"/>' .
						"</form>" .
						'<form method="post" action="index.php" enctype="multipart/form-data">' .
							'<input type="hidden" name="pinid" value="' . $row[0] . '">' .
							'<button type="submit" action="index.php" class="btn btn-medium btn-danger show_on_hover" style="height:32px; ' .
								'margin: -15px 20px; position:absolute; top:50%; left:50%;"><i class="icon-trash icon-white"></i></button>'. 
						"</form>" .
						
					"</div>" .
				"<br />')" .
	         "</script>";
	}
}

echo '<hr>
	  
      <div class="footer">
        <p>&copy; PinVoyage 2013</p>
      </div>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>';
	
	// Activate the corrent tab NOTE: move this until after $(document).ready(function(){});
	echo '<script language="javascript">
	$(document).ready(function() {
		$("#home").addClass("active");
	});
	</script>';
	
	
?>

<br /></div></body></html>
