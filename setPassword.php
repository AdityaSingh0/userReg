<?php
session_start();
// print_r($_SESSION);
try{
   
    if(!empty($_POST) && isset($_POST['password']) && isset($_POST['c_password']) ){
       if($_POST['password'] == $_POST['c_password']){
        $con = new mysqli('localhost', 'root', 'Rubi@123', 'login_system');
        $email = $con->real_escape_string($_SESSION['user_email']);

        $result = mysqli_query($con, "SELECT * FROM users WHERE email = '" . $email. "' ");
        if ($result->num_rows != 0) {
            $password = $con->real_escape_string($_POST['password']);
            $password = md5($password);
            $con->query("UPDATE users SET is_confirmed=1, token='',password='$password' WHERE email='$email'");
            // $id = mysqli_fetch_array($result);
            session_destroy();
            echo 'Password changed. You can <a href="login.php">login</a> now.';
        } else {
            echo 'Code validation failed';
        }
       } else {
        echo "Invalid password";
       }
    }
    
} catch (Exception $e){
  echo $e->getMessage();
}	
?>


          <form action="" method="post">
                        
                        <label for="password">Password</label><br>
						<input type="password" name="password" placeholder="Password" class="form-control">
						<br>

                        <label for="password">Confirm Password</label><br>
						<input type="password" name="c_password" placeholder="Confirm Password" class="form-control">
						<br>
						
						<input type="submit" name="cpass" value="Re-setpass" class="btn btn-primary">

					</form>