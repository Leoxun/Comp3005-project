<?php
	include 'config.php';
	if(isset($_POST['register'])){
		$username = $_POST['username'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$address = $_POST['address'];
		$password = $_POST['password'];
		$role = "user";

		$stmt = $con->prepare("INSERT INTO `user`(`username`, `email`, `phone`, `address`, `password`, `role`) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssss", $username, $email, $phone, $address, $password, $role);
		if ($stmt->execute()) {
			echo "<script>alert('Account created successfully.!!');</script>";

		}else{
			echo "<script>alert('Error occurred. Try again with a different email address!!');</script>";

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
			font-size: 15px;
		}
		.container input{
			/*font-size: 15px;*/
			margin-top: 10px;
			padding: 5px;
		}
		#login{
			background: blue;
			color: white;
			margin-bottom: 20px;
		}
		
	</style>
</head>
<body>
	<!-- <center> -->
		<div class="container">
			<form method="post" action="signup.php">
				<h1>Register Account</h1>
				<label>Username: </label>
				<input type="text" name="username" placeholder="username" required><br>
				<label>Email Address: </label>
				<input type="email" name="email" placeholder="email" required><br>
				<label>Phone Number: </label>
				<input type="text" name="phone" placeholder="phone" required><br>
				<label>Address: </label>
				<input type="text" name="address" placeholder="address" required><br>
				<label>Password: </label>
				<input type="text" name="password" placeholder="password" required><br>

				<center><input type="submit" class="btn btn-primary" name="register" value="Register"></center>
				<center><p>or</p></center>
				<center><a href="index.php" class="btn btn-success">Login</a></center>
				
			</form>

		</div>
	<!-- </center> -->

</body>
</html>