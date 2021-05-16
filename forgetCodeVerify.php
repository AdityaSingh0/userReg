<?php
try{
    if(!empty($_POST)){	
    $con = new mysqli('localhost', 'root', 'Rubi@123', 'login_system');
    $email = $con->real_escape_string($_POST['user_email']);
		$token = $con->real_escape_string($_POST['code']);
    $result = mysqli_query($con, "SELECT * FROM users WHERE email = '" . $email. "'  AND token='$token' AND is_confirmed=0 ");
	if ($result->num_rows != 0) {
        $con->query("UPDATE users SET is_confirmed=0, token='' WHERE email='$email'");
        // $id = mysqli_fetch_array($result);
        session_start();
        $_SESSION = $_POST;
        session_write_close();
        header("Location: setPassword.php");
	} else {
		echo 'Code validation failed';
	}
    }
    
} catch (Exception $e){
  echo $e->getMessage();
}	
?>


<html>
<head>
	<meta charset="UTF-8">
	<title>Verify Code </title>
</head>
<body>
	<div class="register-form">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-6 text-center">
					
					<form action="" method="post">
                        
                        <label for="user_email">Email</label><br>
                        <input type="text" name="user_email" placeholder="Email" class="form-control">
						<br>
                        <label for="fname">Code</label><br>
                        <input type="text" name="code" placeholder="Code" class="form-control">
                        <br>
						
						<input type="submit" name="verify" value="Verify" class="btn btn-primary">

					</form>
				</div>
			</div>
		</div>

	</div>
</body>
</html>