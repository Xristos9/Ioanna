<?php

session_start();
include "dbConnect.php";

$email = $_POST['email'];
$pass = $_POST['password'];

$result = mysqli_query($base, "SELECT * FROM person WHERE Email='$email' AND Password='$pass' ");
if(mysqli_num_rows($result) === 1) {
	$row = mysqli_fetch_assoc($result);
	$_SESSION['Admin'] = $row['Admin'];
	$_SESSION['Email'] = $row['Email'];
	$_SESSION['User_id'] = $row['User_id'];
	if($row['Admin']){
		echo 1;
		exit();
	} else{
		echo 0;
		exit();
	}
} else{
	echo 2;
	exit();
}