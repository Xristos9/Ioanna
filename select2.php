<?php

include "dbConnect.php";
session_start();
$id = $_SESSION["User_id"];

$result = mysqli_query($base, "SELECT `Name`,`Date` FROM `visits` WHERE `User_id`= $id");
$stores = array();
if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
		array_push($stores, array('name'=>$row['Name'], 'date' => $row['Date']));
	}
}
echo json_encode($stores,true);