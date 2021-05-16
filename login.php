<?php
	$msg = "";
	if( isset($_POST['login']) ) {
		$con = new mysqli('localhost', 'root', 'Rubi@123', 'login_system');

		$user_email = $con->real_escape_string($_POST['user_email']);
		$password = $con->real_escape_string($_POST['password']);
		$password = md5($password);
        $sql = $con->query("SELECT * FROM users WHERE email='$user_email' AND password='$password'");
		if($sql->num_rows > 0) {
            $results = $sql->fetch_array();
            
			if($results['is_confirmed'] == 0) {
				$msg = "Please verify your email.";
			} else {
				$msg = "You are logged in. Your id is ". $results['user_id'];
			}
		} else {
			$msg = "Please check your inputs.";
		}
	}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Login</title>
</head>
<body>
	<div class="login-form">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-6 text-center">
					
					<?php
						if($msg != "") {
							echo '<div class="alert alert-success">'.$msg.'</div>';
						}
					?>
					<form action="login.php" method="post">
                        <label for="fname">Email</label><br>
						<input type="text" name="user_email" placeholder="Email" class="form-control">
						<br>
                        <label for="fname">Password</label><br>
						<input type="password" name="password" placeholder="Password" class="form-control">
						<br>
                        <br>
						<input type="submit" name="login" value="Login" class="btn btn-primary">
                        <br>
                         <a href="forgot.php">Forgot Password</a>

					</form>
				</div>
			</div>
		</div>

	</div>
</body>
</html>