<?php // index.php

include_once 'assets/header.php';

// Activate the right tab
echo "<script language='javascript'>
document.getElementById('home').className = 'Active';
</script>";


if (!$loggedin) header('Location: ' .DOC_ROOT. 'signIn_or_signUp.php');

    echo '<div class="container">

      <!-- Jumbotron -->
      <div class="jumbotron">' .
	  	// loadStamen maps effect layer for background layer
	  	'<script type="text/javascript" src="http://maps.stamen.com/js/tile.stamen.js?v1.2.1"></script>' .
		
        '<h1>Welcome to PinVoyage</h1>
        <p class="lead">PinVoyage helps you keep track of all the places you&rsquo;d like to see around the world 
so that you can make sure to visit them all some day.</p>
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

$result = queryMysql("SELECT * FROM pins WHERE email='$email'");
$num = mysql_num_rows($result);


// render the users pins


for ($j = 0 ; $j < $num ; ++$j)
{
	$row = mysql_fetch_row($result);
	$imagename = 'pins/' . $row[0] . '.jpg';
	
	// select the correct column in which to palce the pin's image 
	$column = $j%3;
	
	// Insert thumbnail with text
	echo "<script type='text/javascript'>$(\"#column_$column\").append(" . 
		 "'<div class=\"thumbnail\">" .
		 '<img src="' . $imagename . '" alt=""></img>' .
		 "<p class='muted'>" . $row[3] . "</p>" . 
         "</div><br />')" .
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
