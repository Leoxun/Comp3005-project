<?php 
	session_start();
	include 'config.php';

	if (isset($_POST['change'])) {
		$status = $_POST['status'];
		$stmt = $con->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
		$stmt->bind_param("ss", $status, $_SESSION['order_id']);
		if ($stmt->execute()) {
			header("Location: orders.php");
		}else{
			echo "<script>alert('Error occurred. Try again later.')</script>";
		}
	}

	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Page</title>
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
		#books-table{
			margin: 10px;
		}
		#status{
			height: 40px;
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
			<li><a href="add_publisher.php">Add Publisher</a></li>
			<li><a href="sales.php">View Sales Reports</a></li>
			<li><a href="orders.php" class="active">Orders</a></li>
		</ul>
	</div>
	<div class="container">
		<center>
			<form method="post" action="change_status.php" id="form_change">
			<h1>Select Status</h1>
			<select name="status" id="status">
				<option value="Order Placed">Order Placed</option>
				<option value="Order Processed">Order Processed</option>
				<option value="Order Disbursed">Order Disbursed</option>
				<option value="Currently Oversee">Currently Oversee</option>
				<option value="Order Delivered">Order Delivered</option>
			</select>
			<input type="submit" class="btn btn-success" name="change" value="Save Changes">
			
		</form>
		</center>
	</div>
</body>
</html>