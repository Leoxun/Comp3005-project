<?php 
	session_start();
	include 'config.php';

	$query  = "SELECT * FROM orders";

	$output = '
	<div class="table-responsive cart_details" id="books-table">
		<table class="table table-bordered table-striped">
			<tr>
				<th width="5%">Order ID</th>
				<th width="15%">Books</th>
				<th width="10%">Name</th>
				<th width="5%">Country</th>
				<th width="5%">City ID</th>
				<th width="5%">State</th>
				<th width="5%">Postal Code</th>
				<th width="5%">Phone</th>
				<th width="5%">Shipping Address</th>
				<th width="10%">Status</th>
				<th width="10%">Action</th>
				<th width="10%">Action</th>
				<th width="10%">Action</th>
			</tr>

	';
	$statement = $db->prepare($query);
	$count = 0;
    if ($statement->execute()) {
        $result = $statement->fetchAll();
        foreach ($result as $row) {
        	$books_array = unserialize($row["books"]);
        	$books = "";
        	foreach ($books_array as $key => $value) {
        		if ($books == "") {
        			$books = $value["product_name"];
        		}else{
        			$books = $books . ", " . $value["product_name"];
        		}
        	}
        	$output .= '
        	<tr>
				<td>'.$row["order_id"].'</td>
				<td>'.$books.'</td>
				<td>'.$row["f_name"]." ".$row["l_name"].'</td>
				<td>'.$row["country"].'</td>
				<td>'.$row["city"].'</td>
				<td>'.$row["state"].'</td>
				<td>'.$row["postal_code"].'</td>
				<td>'.$row["phone"].'</td>
				<td>'.$row["shipping_address"].'</td>
				<td>'.$row["status"].'</td>
				
				<td>
					<form method="post" action="orders.php">
						<input type="hidden" name="order_id" value="'.$row["order_id"].'"/>
						<input type="submit" class="btn btn-success" name="change_status" value="Change Status">	
					</form>
				</td>
				<td>
					<form method="post" action="orders.php">
						<input type="hidden" name="order_id" value="'.$row["order_id"].'"/>
						<input type="submit" class="btn btn-primary" name="process_order" value="Confirm Sale">	
					</form>
				</td>
				<td>
					<form method="post" action="orders.php">
						<input type="hidden" name="order_id" value="'.$row["order_id"].'"/>
						<input type="submit" class="btn btn-danger" name="delete" value="Delete">	
					</form>
				</td>
			</tr>
        	';
        	$count = $count + 1;
                    
        }
    }
    if ($count < 1) {
    	$output .= '
		<tr>
			<td colspan="5" align="center">No order added</td>
		</tr>
		';
    }
    $output .= '</table></div>';
    if (isset($_POST['change_status'])) {
    	$_SESSION['order_id'] = $_POST['order_id'];
    	header("Location: change_status.php");
    }
    if (isset($_POST['process_order'])) {
    	$order_id = $_POST['order_id'];

    	$sql = $con->prepare("SELECT books FROM orders WHERE order_id = ? limit 1");
    	$sql->bind_param("s", $order_id);
        $sql->execute();

        $result = $sql->get_result();
        if ($result->num_rows > 0) {
        	$row = $result->fetch_assoc();
          	$books_array = unserialize($row["books"]);
          	foreach ($books_array as $key => $value) {
        		$isbn = $value["product_id"];
        		$quantity = $value["product_quantity"];

        		$stmt = $con->prepare("INSERT INTO `sales`(`isbn`, `quantity`) VALUES (?, ?)");
				$stmt->bind_param("ss", $isbn, $quantity);
				$stmt->execute();
			}
			echo "<script>alert('Sales confirmed successfully')</script>";
         }
    }
    if (isset($_POST['delete'])) {
    	$order_id = $_POST['order_id'];
    	$query  = "DELETE FROM orders WHERE order_id = '$order_id'";

        $delete_stmt = $con->prepare($query);

        if ($delete_stmt->execute()) {
            echo "<script>alert('Order deleted successfully')</script>";
            echo "<meta http-equiv='refresh' content='0'>";
   
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
	<div class="div_container">
		<?php echo $output; ?>
	</div>
</body>
</html>