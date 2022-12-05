<?php
	session_start();
	include 'config.php';

	$total_price = 0;
	$total_item = 0;
	if (!isset($_SESSION["order_status"])) {
		$_SESSION["order_status"] = "";
	}

	$output = '
	<div class="table-responsive cart_details" id="order-table">
		<table class="table table-bordered table-striped">
			<tr>
				<th width="10%">ISBN</th>
				<th width="40%">Product Name</th>
				<th width="10%">Quantity</th>
				<th width="20%">Price</th>
				<th width="15%">Total</th>
				<th width="5%">Action</th>
			</tr>

	';
	if (!empty($_SESSION["shopping_cart"])) {
		foreach ($_SESSION["shopping_cart"] as $key => $value) {
			$product_id = $value["product_id"];
			$output .= '
			<tr>
				<td>'.$value["product_id"].'</td>
				<td>'.$value["product_name"].'</td>
				<td>'.$value["product_quantity"].'</td>
				<td align="right">$'.$value["product_price"].'</td>
				<td align="right">$.'.number_format($value["product_quantity"] * $value["product_price"], 2).'</td>
				<td>
					<form method="post" action="shopping_cart.php">
						<input type="hidden" name="product_id" value="'.$value["product_id"].'"/>
						<input type="submit" class="btn btn-danger" name="remove" value="Remove">	
					</form>
				</td>
			</tr>
			';

			$total_price = $total_price + ($value["product_quantity"] * $value["product_price"]);
			$total_item = $total_item + 1;
			# code...
		}
		$output .= '
		<tr>
			<td colspan="3" align="right">Total</td>
			<td align="right">$.'.number_format($total_price, 2).'</td>
			
		</tr>
		';
		# code...
	}else{
		$output .= '
		<tr>
			<td colspan="5" align="center">Your cart is empty</td>
		</tr>
		';

	}
	$output .= '</table></div>';
	if (isset($_POST['remove'])) {
		$product_id = $_POST['product_id'];
		foreach ($_SESSION['shopping_cart'] as $key => $value) {
			if ($value['product_id'] == $product_id) {
				unset($_SESSION['shopping_cart'][$key]);
				
			}
		}
		header("Refresh:0");
	}

	if(isset($_POST['place_order'])){
		if (isset($_SESSION['username'])) {
			$f_name = $_POST['f_name'];
			$l_name = $_POST['l_name'];
			$country = $_POST['country'];
			$city = $_POST['city'];
			$state = $_POST['state'];
			$postal_code = $_POST['postal_code'];
			$phone = $_POST['phone'];
			$shipping_address = $_POST['shipping_address'];
			$book = serialize($_SESSION['shopping_cart']);
			$status = "Order Placed";
			$length = 8;

			$order_id = strtoupper(substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, $length));

			$stmt = $con->prepare("INSERT INTO `orders`(`order_id`, `books`, `f_name`, `l_name`, `country`, `city`, `state`, `postal_code`, `phone`, `shipping_address`, `status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("sssssssssss", $order_id, $book, $f_name, $l_name, $country, $city, $state, $postal_code, $phone, $shipping_address, $status);
			if ($stmt->execute()) {
				$_SESSION["order_status"] = "Order placed successfully. Your Order Number is: ". $order_id;
				unset($_SESSION['shopping_cart']);

			}else{
				$_SESSION["order_status"] = "Error occurred. Try again later.";

			}
		}else{
			$_SESSION["order_status"] = "You need to login or create account first before placing an order.";
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
		
		#shopping_cart{
			font-size: 25px;
		}
		#order-table{
			width: 60%;
			margin-top: 10px;
		}
		
		.shipping_info{
			position: absolute;
			top: 100px;
			left: 60%;
			padding-left: 10px;
			padding-right: 10px;
			border: 1px solid gray;
			margin-left: 10px;
			padding-bottom: 20px;
		}
		#order_status{
			background: green;
			margin: 5px;
			border-radius: 20px;
			color: white;
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
			<li><a href="index.php">Login</a></li>
		</ul>
	</div>
	<center><h4 id="order_status"><?php
		echo $_SESSION["order_status"];
		unset($_SESSION["order_status"]);
	?>
	</h4></center>
	<div class="cart_details">
		<?php echo $output; ?>
	</div>
	<div class="shipping_info">
		<h4>Billing and Shipping Information</h4>
		<form method="post" action="shopping_cart.php">
			<label>First Name: </label>
			<input type="text" name="f_name" placeholder="First Name" required><br>
			<label>Last Name: </label>
			<input type="text" name="l_name" placeholder="Last Name" required><br>
			<label>Country: </label>
			<input type="text" name="country" placeholder="Country" required><br>
			<label>City: </label>
			<input type="text" name="city" placeholder="City" required><br>
			<label>State: </label>
			<input type="text" name="state" placeholder="State" required><br>
			<label>Postal Code: </label>
			<input type="text" name="postal_code" placeholder="Postal Code" required><br>
			<label>Phone Number: </label>
			<input type="text" name="phone" placeholder="Phone Number" required><br>
			<label>Shipping Address: </label>
			<input type="text" name="shipping_address" placeholder="Shipping Address" required><br>

			<center><input type="submit" class="btn btn-primary" name="place_order" value="Place Order "></center>
			
		</form>
	</div>
	
	
</body>
</html>