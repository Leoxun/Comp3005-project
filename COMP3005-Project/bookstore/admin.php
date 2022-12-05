<?php 
	session_start();
	include 'config.php';

	$query  = "SELECT * FROM book";

	$output = '
	<div class="table-responsive cart_details" id="books-table">
		<table class="table table-bordered table-striped">
			<tr>
				<th width="5%">ISBN</th>
				<th width="20%">Name</th>
				<th width="10%">Authors</th>
				<th width="10%">Genres</th>
				<th width="5%">Publisher ID</th>
				<th width="5%">Pages</th>
				<th width="10%">Buying Price</th>
				<th width="10%">Price</th>
				<th width="5%">Quantity</th>
				<th width="10%">Publisher Share</th>
				<th width="10%">Action</th>
			</tr>

	';
	$statement = $db->prepare($query);
	$count = 0;
    if ($statement->execute()) {
        $result = $statement->fetchAll();
        foreach ($result as $value) {
        	$output .= '
        	<tr>
				<td>'.$value["isbn"].'</td>
				<td>'.$value["name"].'</td>
				<td>'.$value["authors"].'</td>
				<td>'.$value["genres"].'</td>
				<td>'.$value["publisher_id"].'</td>
				<td>'.$value["no_of_pages"].'</td>
				<td align="right">$'.$value["b_price"].'</td>
				<td align="right">$'.$value["price"].'</td>
				<td>'.$value["quantity"].'</td>
				<td>'.$value["publisher_share"].'%</td>
				<td>
					<form method="post" action="admin.php">
						<input type="hidden" name="isbn" value="'.$value["isbn"].'"/>
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
			<td colspan="5" align="center">No book added</td>
		</tr>
		';
    }
    $output .= '</table></div>';
    if (isset($_POST['delete'])) {
    	$isbn = $_POST['isbn'];
    	$query  = "DELETE FROM book WHERE isbn = '$isbn'";

        $delete_stmt = $con->prepare($query);

        if ($delete_stmt->execute()) {
            echo "<script>alert('Book deleted successfully')</script>";
            echo "<meta http-equiv='refresh' content='0'>";
   
        }else{
        	echo "<script>alert('Error occurred. Try again later.')</script>";
        }
    }
    // Automatically placing orders
    placeOrderAutomatically();
    function placeOrderAutomatically(){
    	include 'config.php';
    	$query  = "SELECT * FROM book";
    	$statement = $db->prepare($query);
	    if ($statement->execute()) {
	        $result = $statement->fetchAll();
	        foreach ($result as $value) {
	        	$isbn = $value["isbn"];
	        	$publisher_id = $value["publisher_id"];

	        	$books_sold = getQuantitySold($isbn);
	        	$total_books = getBookQuantity($isbn) + getQuantityOrdered($isbn);
	        	$books_available = $total_books - $books_sold;
	        	if($books_available < 10){
	        		$books_to_order = 10 - $books_available;
	        		$stmt = $con->prepare("INSERT INTO `expenditure`(`publisher_id`, `isbn`, `quantity`) VALUES (?, ?, ?)");
					$stmt->bind_param("sss", $publisher_id, $isbn, $books_to_order);
					$stmt->execute();
	        	}
	        }
	    }

    }

    function getBookQuantity($isbn){
    	include 'config.php';
    	$sql = $con->prepare("SELECT quantity FROM book WHERE isbn = ? limit 1");
    	$sql->bind_param("s", $isbn);
        $sql->execute();

        $result = $sql->get_result();
        $quantity = 0;
        if ($result->num_rows > 0) {
        	$row = $result->fetch_assoc();
          	$quantity = intval($row["quantity"]);
          	
         }
         return $quantity;
    }
    function getQuantitySold($isbn){
    	include 'config.php';
    	$query  = "SELECT * FROM sales WHERE isbn = '$isbn'";
    	$statement = $db->prepare($query);
    	$quantity = 0;
    	if ($statement->execute()) {
	        $result = $statement->fetchAll();
	        foreach ($result as $value) {
	        	$quantity = $quantity + intval($value["quantity"]);
	        }
	    }
	    return $quantity;
    }
    function getQuantityOrdered($isbn){
    	include 'config.php';
    	$query  = "SELECT * FROM expenditure WHERE isbn = '$isbn'";
    	$statement = $db->prepare($query);
    	$quantity = 0;
    	if ($statement->execute()) {
	        $result = $statement->fetchAll();
	        foreach ($result as $value) {
	        	$quantity = $quantity + intval($value["quantity"]);
	        }
	    }
	    return $quantity;
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
			margin-top: 10px;
		}
	</style>
</head>
<body>
	<div class="header">
		<h1>Look Inna Book</h1>
		<ul>
			<li><a href="admin.php" class="active">Home</a></li>
			<li><a href="add_book.php">Add Book</a></li>
			<li><a href="publishers.php">Publisher</a></li>
			<li><a href="add_publisher.php">Add Publisher</a></li>
			<li><a href="sales.php">View Sales Reports</a></li>
			<li><a href="orders.php">Orders</a></li>
		</ul>
	</div>
	<div class="container">
		<?php echo $output; ?>
	</div>
</body>
</html>