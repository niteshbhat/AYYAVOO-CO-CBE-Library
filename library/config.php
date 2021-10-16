<?php
	$conn = mysqli_connect('localhost:3306', 'root', '', 'library') or die(mysqli_error());
 
	if(!$conn){
		die("Error: Failed to connect to database");
	}
?>