<?php 
session_start();
error_reporting(E_ALL ^ E_NOTICE);
?>
        <?php
            if(isset($_POST['id'])){
            $product_id=$_POST['id'];

            }
            if(isset($_POST['action'])){
            $action=$_POST['action'];

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

header('location:index.php')
        ?>
