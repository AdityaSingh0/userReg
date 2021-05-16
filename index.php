<?php

   try{
    $msg = "";
	if( isset($_POST['register']) ) {
		$con = new mysqli('localhost', 'root', 'Rubi@123', 'login_system');
		$user_name = $con->real_escape_string($_POST['user_name']);
		$user_email = $con->real_escape_string($_POST['user_email']);
		$password = $con->real_escape_string($_POST['password']);
		
            $sql = $con->query("SELECT user_id FROM users WHERE email='$user_email'");
            
			if($sql->num_rows > 0) {
				$msg = "This email already exists. Plese try forgetting the password";
			} else {
				$password = md5($password);
				// generate token
				$token = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!*()$";
				$token = str_shuffle($token);
				$token = substr($token, 0, 10);

				$con->query("INSERT INTO users (name, email, password, is_confirmed, token) VALUES ('$user_name', '$user_email', '$password', 0, '$token')");

				// send email
				$headers = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

				// More headers
				$headers .= 'From: <aditya.notification@gmail.com>' . "\r\n";

				$subject = "Verify your email";
				$message = '<p>Hi '.$user_name.',<br>Please enter '.$token.' </a> to confirm your email address.</p>';
                mail($user_email, $subject, $message, $headers);
                header("Location: codeVerify.php");
				
			}
		
	}
   } catch (Exception $e){
       echo $e->getMessage();
   }
	
?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Register</title>
</head>
<body>
	<div class="register-form">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-6 text-center">
					
					<?php
						if($msg != "") {
							echo '<div class="alert alert-success">'.$msg.'</div>';
						}
					?>
					<form action="" method="post">
                        <label for="fname">Name</label><br>
                        <input type="text" name="user_name" placeholder="Name" class="form-control">
                        <br>
                        <label for="user_email">Email</label><br>
                        <input type="text" name="user_email" placeholder="Email" class="form-control">
						<br>
                        <label for="password">Password</label><br>
						<input type="password" name="password" placeholder="Password" class="form-control">
						<br>
						
						<input type="submit" name="register" value="Register" class="btn btn-primary">

					</form>
				</div>
			</div>
		</div>

	</div>
</body>
</html>