<?php

session_start();
include "dbConnect.php";

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])){

	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];

	$result = mysqli_query($base, "SELECT * FROM person WHERE Username='$username'");
	$result2 = mysqli_query($base, "SELECT * FROM person WHERE Email='$email'");

	if(mysqli_num_rows($result) > 0){
		echo 0;
		exit();
	} elseif(mysqli_num_rows($result2) > 0){
		echo 1;
		exit();
	} else{
		$result3 = mysqli_query($base, "INSERT INTO person(Username, Password, Email) VALUES('$username', '$password', '$email')");

		if($result3) {
			echo 2;
			exit();
		} else{
			echo 3;
			exit();
		}
	}

} else {
	echo 3;
	exit();
}