<?php session_start();
 include 'config.php';
//error_reporting(0);
error_reporting(E_ALL ^ E_NOTICE);
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>My Shopping Cart</title>
         <link type="text/css" rel="stylesheet" href="css/mystyle.css">
         <link href="css/bootstrap.css" rel="stylesheet">
         <link href="css/bootstrap-theme.css" rel="stylesheet">
    </head>
    <body>
        <?php
            if(isset($_POST['id'])){
            $product_id=$_POST['id'];

            }
            if(isset($_POST['action'])){
            $action=$_POST['action'];

            }

        if($product_id && !productExists($product_id)){
            die("Error. Product doesn't exist");
        }
        switch ($action) {
            case "add":
                $_SESSION['cart'][$product_id]++;

                break;
            case "remove":
                $_SESSION['cart'][$product_id]--;
                if ($_SESSION['cart'][$product_id]==0) {
                    unset($_SESSION['cart'][$product_id]);
                }
                break;
            case "empty":
                unset($_SESSION['cart']);
                break;
        }
                                                    
        if($_SESSION['cart']){
            ?>
        <table class="table-hover" id="cart_table">
            <th>Product</th>
            <th>Quantity</th>
            <th>Add/Remove</th>
            <th>Price</th>
            <?php 
            $total=0;
            foreach ($_SESSION['cart'] as $product_id => $quantity){
                $sql=  "SELECT name, price FROM flowers WHERE id = '$product_id'";
                $result=  mysqli_query($link, $sql);
                if(mysqli_num_rows($result)>0){
                    list($name,$price) = mysqli_fetch_row($result);
                    $line_cost = $price * $quantity;

                        $total= $total + $line_cost;
                        $_SESSION['cart_total']=$total;

                    
                ?>
            <tr>
                <td><?php echo $name ;?></td> 
                <td><?php echo $quantity ;?> </td>
                <td>  <form method="post" action="" class="cart_form">                                             <!-- Add button-->
                        <input type="hidden" name="id" value="<?php echo $product_id ;?>"/>
                        <input type="hidden" name="action" value="add"/>
                        <button name="add" class="btn-default"><b>+</b></button>
                    </form>
                    <form method="post" action="" class="cart_form">                                             <!-- Remove button-->
                        <input type="hidden" name="id" value="<?php echo $product_id ;?>"/>
                        <input type="hidden" name="action" value="remove"/>
                        <button name="remove" class="btn-default"><b>-</b></button>
                    </form> </td> 
                <td><?php echo $line_cost ;?></td>  
            </tr>          
                    <?php
                }
                
            } ?>
            <tr>
                <td colspan="3"><b><i>Total</i></b></td>
                <td><b><?php echo $total;?></b>
                </td>
            </tr>
        </table>
        <form method="post" action="">                                             <!-- Empty button-->
                        <input type="hidden" name="action" value="empty"/>
                        <button name="empty">Empty cart</button>
                    </form>
        <?php

                }else{
            echo "You have no items in your shopping cart.<br>";
            echo '<a href="index.php">back to the shop</a>';
        }
        //function to check if a product exists
function productExists($product_id) {
    global $host;
    global $user;
    global $password;
    global $db_name;
    global $link;
    //use sprintf to make sure that $product_id is inserted into the query as a number - to prevent SQL injection
    $sql = "SELECT * FROM flowers WHERE id = '$product_id'"; 
    
    return mysqli_num_rows(mysqli_query($link,$sql)) > 0;
}

        ?>
    </body>
</html>



