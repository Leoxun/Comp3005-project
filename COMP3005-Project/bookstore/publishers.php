<?php 
	session_start();
	include 'config.php';

	$query  = "SELECT * FROM publisher";

	$output = '
	<div class="table-responsive cart_details" id="books-table">
		<table class="table table-bordered table-striped">
			<tr>
				<th width="10%">publisher_id</th>
				<th width="20%">Name</th>
				<th width="10%">Email</th>
				<th width="10%">Address</th>
				<th width="10%">Phone</th>
				<th width="10%">Banking Account</th>
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
				<td>'.$value["publisher_id"].'</td>
				<td>'.$value["name"].'</td>
				<td>'.$value["email"].'</td>
				<td>'.$value["address"].'</td>
				<td>'.$value["phone"].'</td>
				<td>'.$value["banking_account"].'</td>
				<td>
					<form method="post" action="publisher.php">
						<input type="hidden" name="publisher_id" value="'.$value["publisher_id"].'"/>
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
			<td colspan="5" align="center">No publisher found</td>
		</tr>
		';
    }
    $output .= '</table></div>';
    if (isset($_POST['delete'])) {
    	$publisher_id = $_POST['publisher_id'];
    	$query  = "DELETE FROM publisher WHERE publisher_id = '$publisher_id'";

        $delete_stmt = $con->prepare($query);

        if ($delete_stmt->execute()) {
            echo "<script>alert('Publisher deleted successfully')</script>";
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
			margin-top: 10px;
		}
	</style>
</head>
<body>
	<div class="header">
		<h1>Look Inna Book</h1>
		<ul>
			<li><a href="admin.php">Home</a></li>
			<li><a href="add_book.php">Add Book</a></li>
			<li><a href="publishers.php" class="active">Publisher</a></li>
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