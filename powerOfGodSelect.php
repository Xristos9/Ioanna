<?php

include "dbConnect.php";
session_start();

$result = mysqli_query($base, "SELECT `User_id`,`Username`,`Admin` FROM `person` WHERE `Admin`='0'");
$person = array();
if (mysqli_num_rows($result) > 0) {
	while($row = mysqli_fetch_assoc($result)) {
		array_push($person, array('User_id' =>  $row['User_id'], 'Username' => $row['Username'], 'Admin' => $row['Admin']));
	}
}
echo json_encode($person,true);
