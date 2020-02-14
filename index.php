<?php
 
 session_start();

 $link = mysqli_connect("localhost", "root", "", "demo");

  if(!$link)
  {
  	echo "Failed to conect to Database!";
  }



if(!isset($_SESSION["username"]))
{
header("Location: login.php");
exit(); 
}

require("array_column.php");

if(isset($_POST["add_to_cart"]))  
 {  
      if(isset($_SESSION["shopping_cart"]))  
      {  
           $item_array_id = array_column($_SESSION["shopping_cart"], "id");  
           if(!in_array($_GET["pID"], $item_array_id))  
           {  
                $count = count($_SESSION["shopping_cart"]);  
                $item_array = array(  
                     'id'=>$_GET["pID"],  
                     'name'=>$_POST["pname"],  
                     'price'=>$_POST["price"],  
                     'quantity'=>$_POST["Qty"]  
                );  
                $_SESSION["shopping_cart"][$count] = $item_array;  
           }  
           else  
           {  
                echo '<script>alert("Item Already Added")</script>';    
           }  
      }  
      else  
      {  
           $item_array = array(  
                'id'=>$_GET["pID"],  
                'name'=>$_POST["pname"],  
                'price'=>$_POST["price"],  
                'quantity'=>$_POST["Qty"]  
           );  
           $_SESSION["shopping_cart"][0] = $item_array;  
      }  
 }  
 
 if(isset($_GET["action"]))  
 {  
      if($_GET["action"] == "delete")  
      {  
           foreach($_SESSION["shopping_cart"] as $keys => $values)  
           {  
                if($values["id"] == $_GET["pID"])  
                {  
                     unset($_SESSION["shopping_cart"][$keys]);  
                     echo '<script>alert("Item Removed")</script>';  
                }  
           }  
      }  
 }  
 
if(isset($_POST["place"]))  
 {  
   unset($_SESSION["shopping_cart"]) ; 
   echo '<script>alert("Your order has been placed successfully")</script>'; 
 }

?>

<html lang="en">
<head>
	<title>SuperEcho</title>
	<link rel="stylesheet" type="text/css" href="style.css">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div id="header">
  <img src="echo.png">
  <span>Super Echo</span>
  <a href="logout.php">Logout</a>
  <?php if($_SESSION["username"]=="admin")
   echo '<a href="CMS.php">CMS</a>';
  ?>
  <a href="register.php">SingUp</a>
  <a href="index.php">Home</a>
  <br>
  <p style="font-size:23;">Welcome <?php echo $_SESSION['username']; ?></p>
</div>
<br><br>
<section>
<div class="container" style="height: 900px;">

<?php
$sql = "SELECT * FROM products ORDER BY pID ASC"; 
$result = $link->query($sql);

if ($result->num_rows > 0) 
{
 
   while($row =mysqli_fetch_array($result)) 
   {
   ?>
   	<div class="block">
      <form method="post" action="index.php?action=add&pID=<?php echo $row["pID"]; ?>">
          <img src="<?php echo $row['pimage'] ?>" width="160" height="250" ><br>
          <span style=""></span>
          <span><?php echo  $row['pname'] ?></span><br>
          <span><?php echo "$" . $row['price'] ?></span><br>
           <input type="hidden" name="pname" value="<?php echo $row["pname"]; ?>" >  
           <input type="hidden" name="price" value="<?php echo $row["price"]; ?>" > 
          Quantity:  <input type="number"  name="Qty" min="1" style="max-width:50px;" value="1" >
          <input type="submit" id="btnAddAction" class ="sub1" name="add_to_cart" value="Add to Cart">
      </form>
    </div>

<?php
}
}

$link->close();
?>

</div>
</section>
<br>
<section>
<div class="container">
  <br>
<h3 class="cart-heading" style="text-align: center;">Shopping Cart</h3>     
<table>  
    <tr>  
         <th width="35%">Item Name</th>  
         <th width="25%">Quantity</th>  
         <th width="25%">Price</th>  
         <th width="25%">Total</th>  
         <th width="15%">Action</th>  
    </tr>  
    <?php   
    if(!empty($_SESSION["shopping_cart"]))  
    {  
         $total = 0;  
         foreach($_SESSION["shopping_cart"] as $keys => $values)  
         {  
    ?>  
    <tr>  
         <td width="35%"><?php echo $values["name"]; ?></td>  
         <td width="25%"><?php echo $values["quantity"]; ?></td>  
         <td width="25%">$ <?php echo $values["price"]; ?></td>  
         <td width="25%">$ <?php echo number_format($values["quantity"] * $values["price"], 2); ?></td>  
         <td width="15%" ><a href="index.php?action=delete&pID=<?php echo $values["id"]; ?>"><span>Remove</span></a></td>  
    </tr>  
    <?php  
              $total = $total + ($values["quantity"] * $values["price"]);  
    }  
    ?>  
    <tr>  
         <td></td>  
         <td></td> 
         <td></td> 
         <td float="left"><strong>Total: $<?php echo number_format($total, 2); ?></strong></td>  
          <td ></td>  

    </tr>  
    
    <?php  
    }  
    ?>  
</table > 

  <form method="post" action="index.php?action=place" >
  <input style="margin:  10px;" type="submit" class="submit" name="place" value="Place Order">
  </form>
  </div> 
</section>  
<br>
<footer >
<br>
<p>Copyright &copy; 2017 SuperEcho Team</p>
</footer>
<script type="text/javascript" crs="js.js"></script>
</body>
</html>