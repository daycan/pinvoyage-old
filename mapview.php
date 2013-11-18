<?php // index.php

include_once 'assets/header.php';

// Activate the right tab
echo "<script language='javascript'>
document.getElementById('home').className = 'Active';
</script>";

if (isset($_POST['pinid'])){
	$unique_pin_id = sanitizeString($_POST['pinid']);
	queryMysql("DELETE FROM pins WHERE pin_id='$unique_pin_id'");
}

// Restart the container -- header in header.php is in a 
echo '<div class="container">';

// the is the div that google maps loads in to
echo '<div id="map-canvas" style="width: 100%; height: 500px; z-index: 0; position: relative;"></div>';
	
$result = queryMysql("SELECT * FROM pins WHERE email='$email'");
$num = mysqli_num_rows($result);

// render the users pins

for ($j = 0 ; $j < $num ; ++$j)
{
	$row = mysqli_fetch_row($result);
	// This is where you do something with the pins
	
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
