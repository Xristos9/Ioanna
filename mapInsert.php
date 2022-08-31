<?php

include "dbConnect.php";
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$id = $_SESSION["User_id"];
	$visit = $_POST["key"];
	$estimation = $_POST["estimation"];
	$sid = $visit["id"];
	$name = $visit["name"];
	$address = $visit["address"];
	$lat = $visit["lat"];
	$lng = $visit["lng"];
	$sql = "INSERT INTO `visits`(`User_id`, `Store_id`, `Name`, `Address`, `lat`, `lng`, `Estimation`) VALUES ('$id','$sid','$name','$address','$lat','$lng','$estimation')";
	if(mysqli_query($base, $sql)){
		echo "Records inserted successfully.";
	} else{
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($base);
	}
}

