<?php
	session_start();
	include 'config.php';
	$output = '';
	$isfound = False;
	if (isset($_POST['track'])) {
		$order_number = $_POST['order_number'];
		$query  = "SELECT * FROM orders WHERE order_id = '$order_number' LIMIT 1";
		$statement = $db->prepare($query);
	    if ($statement->execute()) {
	        $result = $statement->fetchAll();
	        foreach ($result as $row) {

	        	$output = '<h4>Order Status: <span id="order_status">'.$row["status"].'</span></h4>';
	        	$isfound = True;
	                    
	        }
	    }
	}
	if(!$isfound){
		$output = '<h4>Invalid Order Number</h4>';
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
		#order_status{
			color: green;
		}
	</style>
</head>
<body>
	<div class="header">
		<h1>Look Inna Book</h1>
		<ul>
			<li><a href="home.php">Home</a></li>
			<li><a id="shopping_cart" href="shopping_cart.php"><i id="cart_icon" class="fa fa-shopping-cart" aria-hidden="true"></i><span id="cart_items">
				<?php 
					if (isset($_SESSION["shopping_cart"])) {
						echo count($_SESSION["shopping_cart"]);
					}else{
						echo "0";
					}
				?>
			</span></a></li> 
			
			<li><a href="track_order.php" class="active">Track Order</a></li>

		</ul>
	</div>
	<div class="container">
		<center><h1>Enter your Order Number</h1>
		<form method="post" action="track_order.php">
			<input type="text" id="search_entry" name="order_number" placeholder="Order Number" required>
			<input type="submit" class="btn btn-primary" name="track" value="Track">
			
		</form>
		<div style="margin-top: 30px;">
			<?php echo $output; ?>
		</div>
		</center>
		
		
	</div>
</body>
</html>