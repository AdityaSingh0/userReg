
<?php

try{
 $msg = "";
 if( isset($_POST['forgot']) ) {
     $con = new mysqli('localhost', 'root', 'Rubi@123', 'login_system');
     
     $user_email = $con->real_escape_string($_POST['user_email']);
     
         $sql = $con->query("SELECT user_id FROM users WHERE email='$user_email'");
         
         if($sql->num_rows > 0) {

            $token = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!*()$";
             $token = str_shuffle($token);
             $token = substr($token, 0, 10);

             $con->query("UPDATE users SET is_confirmed=0, token='$token' WHERE email='$user_email'");

             // send email
             $headers = "MIME-Version: 1.0" . "\r\n";
             $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

             // More headers
             $headers .= 'From: <aditya.notification@gmail.com>' . "\r\n";

             $subject = "Verify your email";
             $message = '<p>Hi '.$user_name.',<br>Please enter '.$token.' </a> to confirm your email address.</p>';
             mail($user_email, $subject, $message, $headers);
             header("Location: forgetCodeVerify.php");
             
         } else {
             echo "This email not exists. Plese try registration";
         }
     
 }
} catch (Exception $e){
    echo $e->getMessage();
}
 
?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Forgot Password</title>
</head>
<body>
	<div class="login-form">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-6 text-center">
					
					<form action="" method="post">
                        <label for="fname">Email</label><br>
						<input type="text" name="user_email" placeholder="Email" class="form-control">
						<br>
						<input type="submit" name="forgot" value="Get Otp" class="btn btn-primary">
                        <br>
                         <a href="forgot.php">Forgot Password</a>

					</form>
				</div>
			</div>
		</div>

	</div>
</body>
</html>