<?php
 $link = mysqli_connect("localhost", "root", "", "demo");
// Check connection
if(!$link)
{
    die("Failed to connect to database!" . mysqli_connect_error());
}
session_start();

$pID = "" ;
$pname ="";
$price ="";
$image ="";
$found=false ;

function getPosts()
{
	$posts = array();
	$posts[0] = $_POST['pID'];
	$posts[1] = $_POST['pname'];
	$posts[2] = $_POST['price'];
	return $posts;
}

function getPosts_s() // get id
{
  $id = $_POST['pID'];
  return $id;
}


//=========== Rearch  ================

if(isset($_POST["search"]))
{
  $data = getPosts_s();
  $searchQuery = "select* from products where pID =$data";
  $result = mysqli_query($link ,$searchQuery );
  
  	if(mysqli_num_rows($result)>0)
  	{
  		$row=mysqli_fetch_array($result);
  		
		  $pID =$row["pID"] ;
			$pname =$row["pname"] ;
			$price =$row["price"] ;
	   $found=true ;
   }
   else
   {
       echo "<script>alert('there no product with this ID')</script>";
   }
}


// =========  Add product  ================ 

if(isset($_POST["insert"]))
{
  $data = getPosts();
   $target_path = "products/";
  $target_path= $target_path.basename($_FILES['pimage']['name']);
  $sql = "INSERT INTO products(pID, pname, price,pimage) VALUES ('$data[0]', '$data[1]', '$data[2]','$target_path')";

  $result = mysqli_query($link ,$sql );

  if($result)
  {
	 echo "<script>alert('Added Successfully')</script>"; 
  }
  else
  {
	 echo "<script>alert('Fail to Add')</script>";
  }
}

//============ Delete =================== 

if(isset($_POST["delete"]))
{
  $data = getPosts_s();

  $searchQuery = "select* from products where pID =$data";
  $result1 = mysqli_query($link ,$searchQuery );

  if(mysqli_num_rows($result1))
  {
  $delete = "DELETE FROM products WHERE pID='$data'";
  $result = mysqli_query($link ,$delete );

  if($result)
  {
     echo "<script>alert('Deleted Successfully')</script>";
  }
  else
  {
    echo "<script>alert('Fail to Delete')<script>";
  }
  
 }
 else
 {
  echo "<script>alert('there no product with this ID')</script>";
 }
}

// Updata product

if(isset($_POST["update"]))
{
  $data = getPosts();
  
  $searchQuery = "select* from products where pID =$data[0]";
  $result1 = mysqli_query($link ,$searchQuery );
  if(mysqli_num_rows($result1))
  {

    $sql = "UPDATE products SET  pname ='$data[1]' , price='$data[2]' WHERE pID='$data[0]'";
    $result = mysqli_query($link ,$sql );

    if($result)
    {
      echo "<script>alert('Update Successfully')</script>";
    }
    else
    {
      echo "<script>alert('Fail to Update')</script>";
    }
  }
  else
  {
    echo "<script>alert('there no product with this ID')</script>";
  }
}
mysqli_close($link); 
?>

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
  <a href="register.php">SingUp</a>
  <a href="index.php">Home</a>
</div>

<div id="content" style="height:auto;">


<form id="insert" action="" name="form" enctype="multipart/form-data" method="post" onsubmit="return addValidation();">
		<label>Product ID</label><br>
		<input type="text" placeholder="Product ID" name="pID" value=""><br>
		<label>Product name</label><br>
		<input type="text"  placeholder="Product name" name="pname" value=""><br>
		<label>Price</label><br>
		<input type="text" placeholder="Price" name="price" value="" ><br>
		<label>Product image</label><br>
		<input type="file" placeholder="Product image" name="pimage" value=""><br> 
		<input  class="sub1" type="submit" name="insert" value="Add">
		<input  class="sub1" type="submit" name="update" value="Update">
	</form>
  
  <form id="insert" action="" name="form" method="post">
  <label>Product ID</label><br>
  <input type="text" placeholder="Product ID" name="pID" value="" required ><br>
  <input  class="sub1" type="submit" name="delete" value="Delete">
  </form>
  
  <form id="insert" action="" name="form" method="post">
  <label>Product ID</label><br>
  <input type="text" placeholder="Product ID" name="pID" value="" required><br> 
  <input  class="sub1" type="submit" name="search" value="Search">
</form>
<?php
if($found)
{
  // print search data
?>
<div id="insert" style="width:350px;">
  <table id="show">
    <tr><th>Product ID</th><th>Product Name</th><th>Product Price</th></tr>
    <tr><td><?php echo $pID ?></td><td><?php echo $pname ?></td><td><?php echo $price ?></td></tr>
  </table>
</div>
<?php
}
?>

</div>
<footer>
	<br>
<p>Copyright &copy; 2017 SuperEcho Team</p>
</footer>

<script type="text/javascript">
  function addValidation()
{
  var pID= document.forms["form"]["pID"].value;
  var pname= document.forms["form"]["pname"].value;
  var price= document.forms["form"]["price"].value;

  if(pID=="" || pname=="" || price=="")
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