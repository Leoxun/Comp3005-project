<?php 
	session_start();
	include 'config.php';

	function totalSales(){
    	include 'config.php';
    	$query  = "SELECT * FROM sales";
    	$statement = $db->prepare($query);
    	$quantity = 0;
    	$sales = 0;
    	if ($statement->execute()) {
	        $result = $statement->fetchAll();
	        foreach ($result as $value) {
	        	$isbn = $value["isbn"];
	        	$sales = $sales + (intval($value["quantity"]) * intval(getPrice($isbn)));
	        	
	        }
	    }
	    return $sales;
    }
    function totalExpenditure(){
    	include 'config.php';
    	$query  = "SELECT * FROM expenditure";
    	$statement = $db->prepare($query);
    	$expenditure = 0;
    	if ($statement->execute()) {
	        $result = $statement->fetchAll();
	        foreach ($result as $value) {
	        	$isbn = $value["isbn"];
	        	$expenditure = $expenditure + (intval($value["quantity"]) * intval(getBuyingPrice($isbn)));
	        }
	    }
	    return $expenditure;
    }

    function getSalesPerGenre(){
    	include 'config.php';
    	$genre_output = '';
    	foreach (getAllGenres() as $genre) {
	    	$query  = "SELECT * FROM book WHERE genres = '$genre'";
	    	$statement = $db->prepare($query);
	    	if ($statement->execute()) {
		        $result = $statement->fetchAll();
		        $sales = 0;
		        foreach ($result as $value) {
		        	$isbn = $value["isbn"];
		        	
		        	$sales = $sales + (getQuantitySold($isbn) * getPrice($isbn));
		        	
		        }
		        $genre_output .= '<li><label style="font-size: 20px;">'.$genre.': <span style="font-weight: bold; color: blue;">$'.strval($sales).'</span></label></li>';
		    }
	    }
	    return $genre_output;
    }
     function getSalesPerAuthor(){
    	include 'config.php';
    	$author_output = '';
    	foreach (getAllAuthors() as $author) {
	    	$query  = "SELECT * FROM book WHERE authors = '$author'";
	    	$statement = $db->prepare($query);
	    	if ($statement->execute()) {
		        $result = $statement->fetchAll();
		        $sales = 0;
		        foreach ($result as $value) {
		        	$isbn = $value["isbn"];
		        	
		        	$sales = $sales + (getQuantitySold($isbn) * getPrice($isbn));
		        	
		        }
		        $author_output .= '<li><label style="font-size: 20px;">'.$author.': <span style="font-weight: bold; color: blue;">$'.strval($sales).'</span></label></li>';
		    }
	    }
	    return $author_output;
    }
    function getAllGenres(){
    	include 'config.php';
    	$query  = "SELECT * FROM book GROUP BY genres";
    	$statement = $db->prepare($query);
    	$quantity = 0;
    	$genre_array = array();
    	if ($statement->execute()) {
	        $result = $statement->fetchAll();
	        foreach ($result as $value) {
	        	$genre = $value["genres"];
	        	array_push($genre_array, $genre);
	        }
	    }
	    return $genre_array;
    }
    function getAllAuthors(){
    	include 'config.php';
    	$query  = "SELECT * FROM book GROUP BY authors";
    	$statement = $db->prepare($query);
    	$author_array = array();
    	if ($statement->execute()) {
	        $result = $statement->fetchAll();
	        foreach ($result as $value) {
	        	$author = $value["authors"];
	        	array_push($author_array, $author);
	        }
	    }
	    return $author_array;
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
    function getPrice($isbn){
    	include 'config.php';
    	$sql = $con->prepare("SELECT price FROM book WHERE isbn = ?");
    	$sql->bind_param("s", $isbn);
        $sql->execute();

        $result = $sql->get_result();
        $price = 0;
        if ($result->num_rows > 0) {
        	$row = $result->fetch_assoc();
          	$price = intval($row["price"]);
          	
         }
         return $price;
    }
    function getBuyingPrice($isbn){
    	include 'config.php';
    	$sql = $con->prepare("SELECT b_price FROM book WHERE isbn = ?");
    	$sql->bind_param("s", $isbn);
        $sql->execute();

        $result = $sql->get_result();
        $price = 0;
        if ($result->num_rows > 0) {
        	$row = $result->fetch_assoc();
          	$price = intval($row["b_price"]);
          	
         }
         return $price;
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
			<li><a href="publishers.php">Publisher</a></li>
			<li><a href="add_publisher.php">Add Publisher</a></li>
			<li><a href="sales.php" class="active">View Sales Reports</a></li>
			<li><a href="orders.php">Orders</a></li>
		</ul>
	</div>
	<div class="container">
		<hr>
		<h3>Sales vs Expenditures</h3>
		<label style="font-size: 20px;">Total Sales: <span style="font-weight: bold; color: blue;">$<?php echo totalSales(); ?></span></label>
		<label style="font-size: 20px; margin-left: 30px;">Total Expenditure: <span style="font-weight: bold; color: blue;">$<?php echo totalExpenditure(); ?></span></label>
		<hr>

		<h3>Sales by Genre</h3>
		<ul>
			<?php echo getSalesPerGenre(); ?>
		</ul>
		<hr>
		<h3>Sales by Author</h3>
		<ul>
			<?php echo getSalesPerAuthor(); ?>
		</ul>
		<hr>
		

	</div>
</body>
</html>