        <?php
        include 'config.php';
        session_start();
        error_reporting(E_ALL ^ E_NOTICE);
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

        if (isset($_SESSION['username'])){
            $username=$_SESSION['username'];
        }  else {
            $username="Guest";
        }
        ?>
        <div id="wrap">
            <div id="logo"><h1>Flower shop</h1></div>
            <header>
              <nav>
                    <a href="#">Home</a>
              </nav>
                <div id="login">
                    Hey there, <b><?php echo $username;?>.</b>
                    <?php
                    if($username=="Guest"||(!isset($username))){
                        echo '<a href="loginsession/login.php">Login </a>';
                        echo '<a href="loginsession/register.php">Register </a>';
                    }else{
                        echo '<a href="loginsession/logout.php">Logout</a>';
                    }
                    
                    ?>
                </div>
                <a href="cart.php">Go to cart</a>
            </header>
            <div id="items_c">
                <?php
                $sql="SELECT * FROM $tbl_name";
                $result=  mysqli_query($link, $sql) or mysqli_error($link);
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                <div class="items">
                    <img src="images/<?php echo $row['photo'];?>" width="100px" height="100px"/><br>
                    <span><?php echo $row['name']; ?></span><br>
                    <b><?php echo $row['price']; ?></b>
                                <form method="post" action="cartupdate.php">
                <input type="hidden" name="id" value="<?php echo $row['id'];?>"/>
                <input type="hidden" name="action" value="add"/>
                <input type="hidden" name="return_url" value="<?php echo $current_url;?>"/>
                <button class="btn-default">Add to cart</button>
                </form>
                    
                    <!--<a href="cart.php?action=add&id=<?php echo $row['id'];?>">Add to cart</a>-->
                </div>
                
                <?php
                }
                
                
                
                ?>
            </div>
            
            <div class="cart">
                <iframe src="cart.php"></iframe>
            </div>
            <footer> 
                
            </footer>
        </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="livevalidation_standalone.js"></script>
  </body>
</html>
