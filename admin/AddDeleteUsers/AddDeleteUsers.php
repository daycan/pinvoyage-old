<?php // AddDeleteUsers.php

  require_once 'login.php';
  
  $db_server = mysql_connect($db_hostname, $db_username, $db_password);
  
  if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
  
  mysql_select_db($db_database, $db_server)
    or die ("Unable to select database: " . mysql_error());
    
  if (isset($_POST['delete']) && isset($_POST['user_id']))
  {
    $user_id = get_post('user_id');
    $query = "DELETE FROM users WHERE user_id='$user_id'";
    
    if (!mysql_query($query, $db_server))
      echo "DELETE failed: $query<br />" .
      mysql_error() . "<br /><br />";
  }
  
  if (isset($_POST['first_name']) &&
      isset($_POST['last_name']) &&
      isset($_POST['email']) &&
      isset($_POST['postal_zip']) &&
      isset($_POST['user_id']))
  {
      $first_name = get_post('first_name');
      $last_name  = get_post('last_name');
      $email      = get_post('email');
      $postal_zip = get_post('postal_zip');
      $user_id    = get_post('user_id');
      
      $query = "INSERT INTO users VALUES" . "('$user_id', '$first_name', '$last_name', '$email', '', '', '', '', '$postal_zip', '')";
      
      if (!mysql_query($query, $db_server))
        echo "INSERT failed: $query<br />" .
        mysql_error() . "<br /><br />";
  }


$information = <<<END
  <form action="AddDeleteUsers.php" method="post"> <pre>
    First Name  <input type="text" name="first_name" />
     Last Name  <input type="text" name="last_name" />
         Email  <input type="text" name="email" />
        Postal  <input type="text" name="postal_zip" />
       User ID  <input type="text" name="user_id" />
                <input type="submit" value="ADD RECORD" />
</pre> </form>
END;
  
  echo $information;
  
  $query = "SELECT * FROM users";
  $result = mysql_query($query);
  
  if (!$result) die ("Database access failed: " . mysql_error() );
  $rows = mysql_num_rows($result);
  
  for ($j = 0 ; $j < $rows ; ++$j)
  {
      $row = mysql_fetch_row($result);
      echo <<<_END
      <pre>
      First Name $row[1]
      Last Name $row[2]
      Email $row[3]
      Postal $row[8]
      User ID $row[0]
    </pre>
    <form action="AddDeleteUsers.php" method="post">
    <input type="hidden" name="delete" value="yes" />
    <input type="hidden" name="user_id" value="$row[0]" />
    <input type="submit" value="DELETE RECORD" /></form>
_END;
  }
  
  mysql_close($db_server);
  
  function get_post($var)
  {
      return mysql_real_escape_string($_POST[$var]);
  }
?>