<?php

	include ("config.php");

	// CLIENT INFORMATION
	$fname        = htmlspecialchars(trim($_POST['fname']));
	$lname        = htmlspecialchars(trim($_POST['lname']));

    $addClient  = "INSERT INTO complaints (name,complaint) VALUES ('$fname','$lname')";
    mysql_query($addClient) or die(mysql_error());

?>