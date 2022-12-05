<?php
	include 'config.php';
	session_start();
	$error_message = "";
	if(isset($_POST['login'])){
		$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
		$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

		$sql = $con->prepare("select username, role from user where email = ? and password = ? limit 1");
        $sql->bind_param("ss", $email, $password);
        $sql->execute();

        $result = $sql->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $username = $row["username"];
            $role = $row["role"];
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            if ($role == "admin") {
            	header("Location: admin.php");
            }else{
            	header("Location: home.php");
            }
        }else{
        	$error_message = "Incorrect email or password";
        }

	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login System</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<style>
		.container{
			border: 1px solid black;
			width: 30%;
			padding-bottom: 20px;
		}
		.container label{
			font-size: 20px;
		}
		.container input{
			font-size: 15px;
			margin-top: 20px;
			padding: 10px;
		}
		#login{
			background: blue;
			color: white;
			margin-bottom: 20px;
		}
		#error{
			color: crimson;
			font-size: 14px;
		}
		
	</style>
</head>
<body>
	<center>
		<div class="container">
			<form method="post" action="index.php">
				<h1>User Login</h1>
				<p id="error"><?php echo $error_message; ?></p>
				<label>Email: </label>
				<input style="margin-top: 5px;" type="email" name="email" placeholder="email" required><br>
				<label>Password: </label>
				<input type="text" name="password" placeholder="password" required><br>

				<input type="submit" class="btn btn-success" name="login" value="Login">
				<center><p>or</p></center>
				<a href="signup.php" class="btn btn-primary">Register</a>
				
			</form>

		</div>
	</center>

</body>
</html>