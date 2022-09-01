<?php

include "dbConnect.php";
session_start();

$id = $_SESSION['User_id'];

$old = $_POST['oldPassword'];
$new = $_POST['newPassword'];

$result = mysqli_query($base,"SELECT `Password` FROM `person` WHERE `User_id`='$id' AND `Password`='$old'");
// $result = mysqli_query($base,"SELECT * FROM cases");
echo json_encode(mysqli_num_rows($result),true);

if(mysqli_num_rows($result) > 0){
	$result = mysqli_query($base,"UPDATE `person` SET `Password`='$new' WHERE `User_id`='$id'");
	echo 0;
} else{
	echo 1;
	exit();
}