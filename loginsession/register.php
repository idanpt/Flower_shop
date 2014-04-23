
<?php
include ('../config.php');
// Report all errors except E_NOTICE   
//error_reporting(E_ALL ^ E_NOTICE);

echo "<h1>Register</h1>";
if(isset($_POST['submit'])){
	$submit=$_POST['submit'];
	$fullname=strip_tags($_POST['fullname']);
	$username=strtolower(strip_tags($_POST['username']));
        
	$password=strip_tags($_POST['password']);
	$repeatpassword=strip_tags($_POST['repeatpassword']);
	$date= date("Y-m-d");
        
}

if($submit){

	$namecheck=mysqli_query($link,"SELECT username FROM users WHERE username = '$username'")or die (mysqli_error());
	$count=mysqli_num_rows($namecheck);
	if($count!=0){
		die('Username isnt avalible');	
	}
		
//check for existance
	if($fullname&&$username&&$password&&$repeatpassword){
		
			//check if passwords match
		if($password==$repeatpassword){
			//check lengths
			if(strlen($username)>25 or strlen($fullname)>25){
			echo "Max limit for username/full name are 24 characters";
			}else{
			//check password length
				if(strlen($password)>10 or strlen($password)<4){
				echo "Password must be between 4 and 10 characters";
				}else{
					//encrypt password:
					$password=md5($_POST['password']);
					$repeatpassword=md5($_POST['repeatpassword']);
					//register the user:
					$queryreg= mysqli_query($link, "INSERT INTO users 
					VALUES('','$username','$password','$fullname')");
					die ("You have been registered! <a href='login.php'>Return to login page</a>");
				}
			}
		}else{
			echo "Your passwords dont match";
		}
	}else{
		echo "Please fill in <b>all</b> of the fields ";
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
            <title>Register</title>
            <link href="../css/bootstrap.css" rel="stylesheet" type="text/css"/>
            <link href="../css/mystyle.css" rel="stylesheet" type="text/css"/>
	</head>
	
<body>
	<p>
	<form action="register.php" method="post">
		<table>
			<tr>
                            <td>
                                <label for="name">Full name</label>
				</td>
				<td>
				<input type="text" name="fullname" id="name" />
				</td>
			</tr>
			<tr>
				<td>
                                    <label for="username">Username</label>
				</td>
				<td>
                                    <input type="text" name="username" id="username" />
				</td>
			</tr>
			<tr>
				<td>
                                    <label for="password">Password</label>
				</td>
				<td>
					<input type="password" name="password" id="password" />
				</td>
			</tr>
			<tr>
				<td>
                                    <label for="r_password">Repeat your password</label>
				</td>
				<td>
                                    <input type="password" name="repeatpassword" id="r_password" />
				</td>
			</tr>
		</table>
		<p>
			<input type="submit" name="submit" value="Register" />
		
		
	</form>
        <script src="../livevalidation_standalone.js"></script>
        <script>
            var fullname = new LiveValidation( "name", { validMessage: "Hey there!", wait: 500 });
            fullname.add(Validate.Presence);
            fullname.add(Validate.Length,{maximum:25});
            fullname.add (Validate.Exclusion,
            {within:['!','@','#','$','%','^','&','*','(',')','+','=','~','`','|',',','>','?','/'], partialMatch:true,
            failureMessage:"only letters and numbers please"});
            
            var username = new LiveValidation ("username", {validMessage: "OK", wait:500});
            username.add(Validate.Presence);
            username.add (Validate.Length,{minimum:4,maximum:15});
            username.add (Validate.Exclusion,
            {within:['!','@','#','$','%','^','&','*','(',')','+','=','~','`','|',',','>','?','/'], partialMatch:true, 
                failureMessage:"only letters and numbers please"});
            
            var password = new LiveValidation ("password", {validMessage: "OK", wait:500});
            password.add(Validate.Presence);
            password.add (Validate.Length,{minimum:4, maximum:10});
            password.add (Validate.Exclusion,
            {within:['!','@','#','$','%','^','&','*','(',')','+','=','~','`','|',',','>','?','/'], partialMatch:true,
            failureMessage:"only letters and numbers please"});
            
            var r_password = new LiveValidation ("r_password", {validMessage: "OK", wait:500});
            r_password.add(Validate.Presence);
            r_password.add (Validate.Confirmation,{match:'password'});
            r_password.add (Validate.Length,{minimum:4, maximum:10});
            
            
        </script>
</body>	
</html>