<?php
	session_start();
	include 'config.php';
	if (isset($_POST['search'])) {
		$book_searched = "%".$_POST['book_searched']."%";
		$query  = "SELECT * FROM book WHERE name LIKE '".$book_searched."'";
	}else{
		$query  = "SELECT * FROM book";	
	}
	
	$output = '';

	$statement = $db->prepare($query);
    if ($statement->execute()) {
        $result = $statement->fetchAll();
        foreach ($result as $row) {
        	$output .= '
                <div class="book">
					<h4>'.$row["name"].'</h4>
					<p>By '.$row["authors"].'</p>
					<label>Genre: '.$row["genres"].'</label><br>
					<label>Publisher: '.getPublisher($row["publisher_id"]).'</label><br>
					<label>No of Pages: '.$row["no_of_pages"].'</label>
					<h4>$'.$row["price"].'</h4>
					<form method="post" action="home.php">
						<input type="hidden" name="isbn" value="'.$row["isbn"].'"/>
						<input type="hidden" name="name" value="'.$row["name"].'"/>
						<input type="hidden" name="price" value="'.$row["price"].'"/>
						<center><input type="submit" class="btn btn-success" name="add_to_cart" value="Add to Cart"></center>	
					</form>
				</div>';
                    
        }
    }
    function getPublisher($publisher_id){
    	include 'config.php';
        $stmt  = $con->prepare("SELECT name FROM publisher WHERE publisher_id = ? limit 1");
		$stmt->bind_param("s", $publisher_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $publisher = "";
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $publisher = $row["name"];
        }
        return $publisher;

    }
    if (isset($_POST['add_to_cart'])) {
    	$isbn = $_POST['isbn'];
    	$name = $_POST['name'];
    	$price = $_POST['price'];
    	$quantity = 1;
    	if (isset($_SESSION["shopping_cart"])) {
			$is_available = 0;
			foreach ($_SESSION['shopping_cart'] as $key => $value) {
				if ($_SESSION['shopping_cart'][$key]['product_id'] == $isbn) {
					$is_available++;
					$_SESSION['shopping_cart'][$key]['product_quantity'] = $_SESSION['shopping_cart'][$key]['product_quantity'] + $quantity;
					

					echo "<script>alert('Quantity updated to cart.')</script>";
				}
				

				# code...
			}
			if ($is_available == 0) {
				$item_array = array(
					'product_id' => $isbn,
		            'product_quantity' => $quantity,
		            'product_name' => $name,
		            'product_price' => $price
				);
				$_SESSION["shopping_cart"][] = $item_array;
				echo "<script>alert('Book added to cart.')</script>";
				# code...
			}
			# code...
		}else{
			$item_array = array(
				'product_id' => $isbn,
	            'product_quantity' => $quantity,
	            'product_name' => $name,
	            'product_price' => $price
			);
			$_SESSION["shopping_cart"][] = $item_array;
			echo "<script>alert('Book added to cart.')</script>";

			
		}
    }

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Look Inna Book</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
		.books{
			margin-left: 20px;
			display: flex;
			flex-flow: wrap;
		}
		.book{
			width: 30%;
			border: 1px solid black;
			padding: 10px;
			border-radius: 20px;
			margin: 10px;
		}
		#shopping_cart{
			font-size: 25px;
		}
		#form_search{
			margin-left: 20px;
		}
		#search_entry{
			height: 40px;
			border-radius: 20px;
			padding: 10px;
		}
	</style>
</head>
<body>
	<div class="header">
		<h1>Look Inna Book</h1>
		<ul>
			<li><a href="home.php" class="active">Home</a></li>
			<li><a id="shopping_cart" href="shopping_cart.php"><i id="cart_icon" class="fa fa-shopping-cart" aria-hidden="true"></i><span id="cart_items">
				<?php 
					if (isset($_SESSION["shopping_cart"])) {
						echo count($_SESSION["shopping_cart"]);
					}else{
						echo "0";
					}
				?>
			</span></a></li> 
			<form method="post" action="home.php" id="form_search">
				<input type="text" id="search_entry" name="book_searched" placeholder="Book Name" required>
				<input type="submit" class="btn btn-primary" name="search" value="Search">
				
			</form>
			<li><a href="track_order.php">Track Order</a></li>
			<li><a href="index.php">Login</a></li>

		</ul>
	</div>
	<div class="container">
		<center><h1>All Books</h1></center>
		<div class="books">
			<?php echo $output; ?>
			
		</div>
		
	</div>
</body>
</html>