<?php // index.php

include_once 'assets/header.php';

// Activate the right tab
echo "<script language='javascript'>
document.getElementById('home').className = 'Active';
</script>";

if (isset($_POST['pinid'])){
	$unique_pin_id = sanitizeString($_POST['pinid']);
	mysql_query("DELETE FROM pins WHERE pin_id='$unique_pin_id'");
}

echo '<div class="container">



  <!-- Jumbotron -->
  <div class="jumbotron">' .
	// loadStamen maps effect layer for background layer
	'<script type="text/javascript" src="http://maps.stamen.com/js/tile.stamen.js?v1.2.1"></script>' .
	
	'<h1>Welcome to PinVoyage</h1>
	<p class="lead">PinVoyage helps you keep track of all the places you&rsquo;d like to see' . 
		'around the world so that you can make sure to visit them all some day.</p>
	<a class="btn btn-large btn-success" href="addpin.php">Add a Pin</a>
  </div>

  <hr>

  <!-- Example row of columns -->
  <div class="row-fluid">
	<div class="span4" id="column_0">
	</div>
	<div class="span4" id="column_1">
   </div>
	<div class="span4" id="column_2">
	</div>
  </div>';

$result = mysql_query("SELECT * FROM pins WHERE email='$email'");
$num = mysql_num_rows($result);


// render the users pins


for ($j = 0 ; $j < $num ; ++$j)
{
	$row = mysql_fetch_row($result);
	$imagename = 'pins/' . $row[0] . '.jpg';
	
	// select the correct column in which to palce the pin's image 
	$column = $j%3;
	
	//OLD METHOD OF PICKING THE RIGHT COLUMN
	echo "<script type='text/javascript'>$(\"#column_$column\").append('" . 
			// The form which contains the photo and buttons to edit delete etc.
		 		'<div class="thumbnail" style="position:relative;">' .
				
					'<img src="' . $imagename . '" alt=""></img>' .
					'<form method="post" action="addpin.php" enctype="multipart/form-data">' .
						'<input type="hidden" name="pinid" value="' . $row[0] . '">' .
						'<input type="submit" class="btn btn-medium btn-warning show_on_hover" value="Edit" style="height:32px; width:60px; ' .
							'margin: -15px -46px; position:absolute; top:50%; left:50%;"/>' .
						'<p class="muted">' . $row[3] . "</p>" . 
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
	
	
?>

<br /></div></body></html>
