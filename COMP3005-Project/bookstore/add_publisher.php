<?php
	include 'config.php';
	if(isset($_POST['add'])){
		$publisher_id = $_POST['publisher_id'];
		$name = $_POST['name'];
		$email = $_POST['email'];
		$address = $_POST['address'];
		$phone = $_POST['phone'];
		$bank_account = $_POST['bank_account'];

		$stmt = $con->prepare("INSERT INTO `publisher`(`publisher_id`, `name`, `email`, `address`, `phone`, `banking_account`) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssss", $publisher_id, $name, $email, $address, $phone, $bank_account);
		if ($stmt->execute()) {
			echo "<script>alert('Publisher added successfully.!!');</script>";

		}else{
			echo "<script>alert('Error occurred. Try again with a different publisher ID!!');</script>";

		}

	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Publisher</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<style>
		.header{
			display: flex;
			background: green;
			padding-left: 40px;
		}
		.header h1{
			font-family: cursive;
			color: white;
		}
		.header ul{
			display: flex;
			margin-top: 10px;
			margin-left: 10%;
		}
		.header ul li{
			list-style: none;
			margin-left: 20px;
		}
		
		.active{
			background: white;
			color: green;
			padding: 5px;
			border-radius: 10px;
		}
		a{
			font-size: 20px;
			color: white;
			text-decoration: none;
		}
		a:hover{
			background: white;
			color: green;
			padding: 5px;
			border-radius: 10px;
		}
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
			margin-top: 2px;
			padding: 5px;
		}
	</style>
</head>
<body>
	<div class="header">
		<h1>Look Inna Book</h1>
		<ul>
			<li><a href="admin.php">Home</a></li>
			<li><a href="add_book.php">Add Book</a></li>
			<li><a href="publishers.php">Publisher</a></li>
			<li><a href="add_publisher.php" class="active">Add Publisher</a></li>
			<li><a href="sales.php">View Sales Reports</a></li>
			<li><a href="orders.php">Orders</a></li>
		</ul>
	</div> 
	<div class="container">
		<form method="post" action="add_publisher.php">
			<h1>Add Publisher</h1>
			<label>Publisher ID: </label>
			<input type="text" name="publisher_id" placeholder="Publisher ID" required><br>
			<label>Name: </label>
			<input type="text" name="name" placeholder="Name" required><br>
			<label>Email: </label>
			<input type="email" name="email" placeholder="Email" required><br>
			<label>Address: </label>
			<input type="text" name="address" placeholder="Address" required><br>
			<label>Phone Number: </label>
			<input type="text" name="phone" placeholder="Phone Number" required><br>
			<label>Bank Account: </label>
			<input type="text" name="bank_account" placeholder="Bank Account" required><br>

			<center><input type="submit" class="btn btn-primary" name="add" value="Add "></center>
			
		</form>
	</div>
</body>
</html>