<html lang="en">
<head>
	<title>SuperEcho</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="js.js"></script>
</head>
<body>


<div id="header">
  <img src="echo.png">
  <span>Super Echo</span>
  <a href="logout.php">Logout</a>
  <a href="index.php">Home</a>
</div>

<div id="content">
   <form id="register" action="" name="form" method="post" onsubmit="return singupValidations();">
		<label>First name </label><br>
		<input type="text" placeholder="First Name" name="fname"><br>
		<label>Last name</label><br>
		<input type="text"  placeholder="Last Name" name="lname" ><br>
		<label>Age</label><br>
		<input type="text" placeholder="Age" name="age" ><br>
		<label>Username   </label><br>
		<input type="text"  placeholder="Username" name="username" required><br>
		<label>Email      </label><br>
		<input type="text"  placeholder="Email" name="email"><br>
		<label>Password   </label><br>
		<input type="password" placeholder="Password" name="password" ><br>
		<label>Password(Confirm)</label><br>
		<input type="password" placeholder="Passwor Confirm" name="cpassword" ><br>
		<input  class="sub1" type="submit" name="submit" value="Register">
	</form>

</div>
<footer>

<br><br>
<p>Copyright &copy; 2017 SuperEcho Team</p>
</footer>
<script type="text/javascript">
	function CheckEmail(mail)
{
  var flag = true;
  
 if(mail.indexOf("@")==-1 || mail.indexOf(".")==-1)
 {
   flag = false;
 }
 return flag;
}


function singupValidations()
{

  	var fname= document.forms["form"]["fname"].value;
  	var lname = document.forms["form"]["lname"].value;
    var age= document.forms["form"]["age"].value;
    var email = document.forms["form"]["email"].value;
    var username= document.forms["form"]["username"].value;
    var password = document.forms["form"]["password"].value;
    var pattern1 =/[0-9]/;
    var pattern2 =/[0-9A-Za-z]/ ;

  	if(fname=="" && lname=="" && username=="" && age=="" && email=="" && password=="")
  	{
  		
  		alert("Please fill all the boxes before submitting!");
  		return false ;
  	}
    else if(!CheckEmail(email))
    {
      alert("Email missing '@' and '.' character"); 
       return false ;
    }
    else if (password.length>3 || !pattern2.test(password) )
    {
    	
    	alert("password must be letter or number and its length must be greater then 3 charachters");
    	return false;
    }
    else if(!pattern1.test(age))
    {
       alert("Age must be number");
        return false;
    }
    else 
    {
      return true;
    }
    
}
</script>
</body>
</html>

<?php

$link = mysqli_connect("localhost", "root", "", "demo");

// Check connection
if(!$link)
{
    die("Failed to connect to database!" . mysqli_connect_error());
}

$fname ="";
$lname ="";
$username="";
$email  ="";
$password="";
$password2="";
$age =0 ;

if(isset($_POST["submit"]))
{
  
  $fname    = $_POST['fname'];
  $lname    = $_POST['lname'];
  $username = $_POST['username'];
  $email    = $_POST['email'];
  $password = $_POST['password'];
  $password2 = $_POST['cpassword'];
  $age      = $_POST['age'];

 if($password==$password2)
{
	//echo  $username;
	$password=md5($password) ;// hash password before storing for security porpese
    $sql = "INSERT into users(fname ,lname,age,email,username ,password) values ('$fname','$lname','$age','$email' , '$username','$password')";
    
  if(mysqli_query($link, $sql))
	{
    echo '<script>alert("you have Registered successfully")</script>';
    header("location: login.php");
	} 
	else
	{
	    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
}
else
{
   echo '<script>alert("two password do not much")</script>';
}
}


mysqli_close($link); 

?>