<?php

include "dbConnect.php";
session_start();
$id = $_SESSION["User_id"];
$sql = mysqli_query($base, "SELECT `Date` FROM `cases` WHERE `User_id` = '$id' ORDER BY `cases`.`Date` DESC");
$dates = array();
if (mysqli_num_rows($sql) > 0) {
	while($row = mysqli_fetch_assoc($sql)) {
		array_push($dates,$row['Date']);
	}
}
echo json_encode($dates,true);

