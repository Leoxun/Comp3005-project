<?php
	include 'config.php';
	if(isset($_POST['add'])){
		$isbn = $_POST['isbn'];
		$name = $_POST['name'];
		$authors = $_POST['authors'];
		$genres = $_POST['genres'];
		$publisher_id = $_POST['publisher_id'];
		$no_of_pages = $_POST['no_of_pages'];
		$b_price = $_POST['b_price'];
		$price = $_POST['price'];
		$quantity = $_POST['quantity'];
		$publisher_share = $_POST['publisher_share'];

		$stmt = $con->prepare("INSERT INTO `book`(`isbn`, `name`, `authors`, `genres`, `publisher_id`, `no_of_pages`, `b_price`, `price`, `quantity`, `publisher_share`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssssssss", $isbn, $name, $authors, $genres, $publisher_id, $no_of_pages, $b_price, $price, $quantity, $publisher_share);
		if ($stmt->execute()) {
			echo "<script>alert('Book added successfully.!!');</script>";

		}else{
			echo "<script>alert('Error occurred. Try again with a different isbn!!');</script>";

		}

	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Book</title>
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
			<li><a href="add_book.php" class="active">Add Book</a></li>
			<li><a href="orders.php">Orders</a></li>
		</ul>
	</div> 
	<div class="container">
		<form method="post" action="add_book.php">
			<h1>Add Book</h1>
			<label>ISBN: </label>
			<input type="text" name="isbn" placeholder="ISBN" required><br>
			<label>Name: </label>
			<input type="text" name="name" placeholder="Name" required><br>
			<label>Authors: </label>
			<input type="text" name="authors" placeholder="Authors" required><br>
			<label>Genres: </label>
			<input type="text" name="genres" placeholder="Genres" required><br>
			<label>Publisher Id: </label>
			<input type="text" name="publisher_id" placeholder="Publisher Id" required><br>
			<label>No. of Pages: </label>
			<input type="text" name="no_of_pages" placeholder="No. of pages" required><br>
			<label>Buying Price: </label>
			<input type="text" name="b_price" placeholder="Buying Price" required><br>
			<label>Price: </label>
			<input type="text" name="price" placeholder="Price" required><br>
			<label>Quantity: </label>
			<input type="number" name="quantity" placeholder="Quantity" required><br>
			<label>Publisher Share: </label>
			<input type="text" name="publisher_share" placeholder="Publisher Share" required><br>

			<center><input type="submit" class="btn btn-primary" name="add" value="Add "></center>
			
		</form>
	</div>
</body>
</html>