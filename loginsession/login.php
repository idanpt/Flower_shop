
<?php
session_start();
include ('../config.php');
?>
    <!DOCTYPE html>
    <html>
        <head>
            <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
            <link href="../css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
        </head>
    	<body> <?php
if(!isset($_POST['submit'])){?>

            <form action="login.php" method="post" class="form-signin">
            <table>
                <tr>
                    <td>
                        <label for="user">Username</label>
                    </td>
                    <td>
                        <input type="text" name="username" id="user" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="password">Password</label>
                    </td>
                    <td>
                        <input type="password" name="password" id="password" />
                    </td>
                <tr>
                    <td>
                        <input type="submit" name="submit" value="Login" />
                    </td>
                </tr>
   
            </table>
	
        </form>
    		<a href="register.php">Register?</a></br>
    		

<?php
}else
{
    $username=  strtolower($_POST['username']);
    $password=$_POST['password'];
    if($username&&$password){
    	$query= mysqli_query($link, "SELECT * FROM users WHERE username='$username'")or die (mysqli_error($link));
    	
    	$numrows=mysqli_num_rows($query) or die('that user doesnt exsist');
    	
    	if($numrows>0){
    		//code to login
            
            //get user&password from db
    		while ($row=mysqli_fetch_assoc($query)){     
    			$dbusername=$row['username'];
    			$dbpassword=$row['password'];
    		}
    		//check to see if they match
    		
    		if($username==$dbusername&&md5($password)==$dbpassword){     //user input match db info - set cookie and session and get in
                    
                    if($username=='admin'){                                  //check if current user is admin
                        setcookie("admin_cookie", "admin", time()+3600*24);
                        $_SESSION['username']="admin";
                        echo "<script>
                                alert('Youre in, Admin!');
                                window.location.href='admin.php';
                                </script>";
                    } else {                                                //if not admin 
                        setcookie("remember_user", "value", time()+3600*24);
                        $_SESSION['username']=$dbusername;
             
    			echo "<script>
                                alert('Youre in! (and will be for the next 24 hours /until you logout)');
                                window.location.href='../index.php';
                                </script>";
    			
                    }                                                         
    	
    		}else{
    			die("incorret password");
    		}
    		
    	}else{
    		die("that user doesnt exsist");
    	}
    	
    }else{
    	die("please enter a username and a password");
    }
}




?>
    	</body>
    </html>