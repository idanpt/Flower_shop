<?php
session_start(); 
include '../config.php';
// Report all errors except E_NOTICE   
//error_reporting(E_ALL ^ E_NOTICE);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flower Shop</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="css/mystyle.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
      <?php
if($_SESSION['username']=="admin" || isset($_COOKIE['admin'])){
	echo "<h2>Welcome, Admin!</h2>";?>
		
	<h3>What do you want to do?</h3>
        <a href="admin.php?action=add_item">Add Item</a><br>
	<a href="admin.php?action=delete_item">Delete item</a><br>
	<a href="admin.php?action=statistics">Get statistics</a><br>
	<a href="../index.php">Back to shop</a><br>
	<a href="admin.php?action=logout">Log out</a><p></p>
	<?php
	$action= $_GET['action'];
        switch ($action){
            case "logout":
                 session_destroy();
                echo "<script>alert('Youve been logged out.'); 
                window.location.href='../index.php'</script>";
                break;
            case "add_item":
                ?>
                <div id="add_item">
                    <form action="" method="post" enctype="multipart/form-data">
                        <table>
                            <tr>
                                <td><label for="item_name">Name</label></td>
                                <td><input type="text" name="item_name" id="item_name"/></td>
                            </tr>
                            <tr>
                                <td><label for="price">Price</label></td>
                                <td><input type="number" name="price" id="price"/></td>
                            </tr>
                            <tr>
                                <td><label for="quantity">Quantity</label></td>
                                <td><input type="number" name="quantity" id="quantity"/></td>
                            </tr>
                            <tr>
                                <td><label for="img">Image</label></td>
                                <td><input type="file" accept="image/*" id="img" name="img"/></td>
                            </tr>          
                            <tr>
                                <td>
                                    <input type="submit" name="submit" value="Add item"/>
                                </td>
                            </tr>
                        </table>

                     </form> 
                </div>
        <?php
                include '../validation_class.php';
        $validation= new validation($link);
        $name_validated= $validation->nameValidation();
        $price_validated= $validation->priceValidation();
        $quantity_validated= $validation->quantityValidation();
        $img_validated= $validation->imgValidation();
        
        $sql="INSERT INTO flowers (id, name, photo, price, quantity) "
                . "VALUES('', '$name_validated', '$img_validated', '$price_validated', '$quantity_validated')";
        $query=mysqli_query($link, $sql)or die (mysqli_error($link));
        if($query){
            echo 'item inserted succssesfully';
        }
        
        }

	
}else{
	echo "Please <a href='login.php'>login</a> as admin.";

}

?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="livevalidation_standalone.js"></script>
  </body>
</html>