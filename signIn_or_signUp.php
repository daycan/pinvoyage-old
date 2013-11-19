<?php // signIn_or_signUp.php

include_once 'assets/header.php';

if (isset($_SESSION['user'])) {
    destroySession();
    echo "<script>alert('you have been logged out')</script>";
}

// Set the highlight on the site navagation items in the header

echo <<<_END
<script>
function checkUser(user)
{
    if (user.value == '')
    {
        O('info').innerHTML = ''
        return
    }

    params  = "user=" + user.value
    request = new ajaxRequest()
    request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
    request.setRequestHeader("Content-length", params.length)
    request.setRequestHeader("Connection", "close")
    
    request.onreadystatechange = function()
    {
        if (this.readyState == 4)
            if (this.status == 200)
                if (this.responseText != null)
                    O('info').innerHTML = this.responseText
    }
    request.send(params)
}

function ajaxRequest()
{
    try { var request = new XMLHttpRequest() }
    catch(e1) {
        try { request = new ActiveXObject("Msxml2.XMLHTTP") }
        catch(e2) {
            try { request = new ActiveXObject("Microsoft.XMLHTTP") }
            catch(e3) {
                request = false
    }   }   }
    return request
}
</script>
_END;

echo "<div class='main'><h3>Please enter your details:</h3>";
$error = $email = $pass = "";

if (isset($_POST['email']))
{
	$email = sanitizeString($_POST['email']);
	$pass = sanitizeString($_POST['pass']);
	
	if ($email == "" || $pass == "")
	{
		$error = "<span class='error'>Not all Fields were Entered</span><br /><br />";
        echo "<h3>Error 10</h3>";
	}
	else
	{
		$query = "SELECT email,password FROM users WHERE email='$email' AND password='$pass'";
		if (mysqli_num_rows(queryMysql($query)) == 0)
		{ 
        	if (mysqli_num_rows(queryMysql("SELECT * FROM users WHERE email='$email'"))){
            	$error = "<span class='error'>Incorrect Password</span><br /><br />";
                echo "<h3>Error 1</h3>";}
            else
			{
				queryMysql("INSERT INTO users VALUES('', '', '', '$email', '', '$pass', '', '', '', '')");
				$_SESSION['user'] = $email;
				$_SESSION['pass'] = $pass;
                die("You are now logged in. Please <a href='index.php?view=$user'>" .
                "click here</a> to continue.<br /><br />");
			}
            
      
			$error = "<span class='error'>Username/Password invalid</span><br /><br />";
            echo "<h3>Error 2</h3>";
		}
		else
		{
			$_SESSION['user'] = $email;
			$_SESSION['pass'] = $pass;
            echo "<script language='javascript'> window.location.href = 'index.php?view=$user'</script>";
            die("You are now logged in. Please <a href='index.php?view=$user'>" .
                "click here</a> to continue.<br /><br />");
            
		}
	}
}

echo <<<_END
<form method='post' action='signIn_or_signUp.php'>
$error
<span class='fieldname'>Email</span><input type='text' maxlength='50' name='email' value='$email' autocomplete='off' /><br />
$error
<span class='fieldname'>Password</span><input type='password' maxlength='16' name='pass' value='$pass' />
_END;
?>

<br />
<span class='fieldname'>&nbsp;</span>
<input type='submit' value='Login' />
</form><br /></div>

    echo "<script language='javascript'>
        document.getElementById('signIn').className = 'Active';
    </script>"; 

</body></html>
