<html lang="en">
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="js.js"></script>
</head>
<body>



<div id="header">
  <img src="echo.png">
  <span>Super Echo</span>
  <a href="logout.php">Logout</a>
  <a href="register.php">SingUp</a>
  <a href="index.php">Home</a>
</div>

<div id="content" style="height: 300px">
	<?php

  $link = mysqli_connect("localhost", "root", "", "demo");

	if(!$link)
	{
	    die("Failed to connect to database!" . mysqli_connect_error());
	}

	session_start();

if (isset($_POST['submit']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username =="admin" && $password=="admin")
    {
       $_SESSION['username'] = $username;
       header("Location: CMS.php");     // Redirect Admin to Content Managment System page
    }
    else
    {
      $query = "SELECT * FROM users WHERE username='".$username."' and password='".md5($password)."'"; // The md5() function calculates the MD5 hash of a string , use for security 
      $result = mysqli_query($link,$query) or die(mysql_error()); // equvalent to exit()
      $rows = mysqli_num_rows($result);

      if($rows==1)
      {
      	$_SESSION['username'] = $username;
      	header("Location: index.php");
      }
      else
      {
  	    echo "<h3 style='text-align:center'>Username/password is incorrect!<br/>Click here to <a href='login.php'>Login</a></h3>";
      }
  }
}
else
{
?>

<form id="login" action="" name="form"  onsubmit="return loginValidation();" method="post">
<label>Username :</label><input type="text"  name="username">
<label>Password  :</label><input type="password" name="password">
<input class="sub1" type="submit" name="submit" value="Login"/>
</form>
<?php 
} 
?>
    

</div>

<footer>
<br><br>
<p>Copyright &copy; 2017 SuperEcho Team</p>
</footer>

<script type="text/javascript">
function loginValidation()
{
  var user= document.forms["form"]["username"].value;
  var pass= document.forms["form"]["password"].value;
  if(user=="" || pass=="")
  {
    alert("Please fill all the boxes before submitting!");
    return false ;
  }
  else 
  {
    return true;
  }
}
</script>
</body>
</html>

