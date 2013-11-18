<?php // query.php

  echo 'What the fuck?';

  require_once 'login.php';
  
  $db_server = mysql_connect($db_hostname, $db_username, $db_password);
  
  if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
  
  mysql_select_db($db_database) or die ("Unable to select database: " . mysql_error());
    
  $query = "SELECT * FROM users";
  $result = mysql_query($query);
 
  if (!$result) die ("Database access failed: " . mysql_error());
  
  $rows = mysql_num_rows($result);
  
  echo $rows;
  
  echo 'First Name: ' . mysql_result($result, 1, 'first_name')	. '<br />';
  
    for ($j = 0; $j < $rows ; ++$j)
    {
      echo 'First Name: '	. mysql_result($result,$j, 'first_name')	. '<br />';
      echo 'Last Name: '	. mysql_result($result,$j, 'last_name')		. '<br />';
      echo 'Phone: '		. mysql_result($result,$j, 'phone')		. '<br />';
      echo 'Email: '	 	. mysql_result($result,$j, 'email')		. '<br /><br />';
    }
  
?>