<?php
	try{
        if ($db = new PDO("mysql:host=localhost;dbname=bookstore", "root", "")) {
            
        }else{
            throw new Exception("Error Processing Request", 1);
            
        }
        if ($con = mysqli_connect("localhost", "root", "", "bookstore")) {
        	
            
        }else{
            throw new Exception("Error Processing Request", 1);
            
        }
    }
    catch(Exception $e){
        echo $e->getMessage();

    }
?>