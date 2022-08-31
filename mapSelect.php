<?php

include "dbConnect.php";
session_start();
if($_SERVER["REQUEST_METHOD"] == "GET"){
	$query = mysqli_query($base, "SELECT `Store_id`,`Name`,`Address`,`lat`,`lng` FROM `stores` ORDER BY `stores`.`Store_id` ASC");
	$array = array();
	if (mysqli_num_rows($query) > 0) {
		while($row = mysqli_fetch_assoc($query)) {
			array_push($array, array("id" => $row['Store_id'], "name" => $row['Name'],"address" => $row['Address'],"lat" => $row['lat'],"lng" => $row['lng'],));
		}
	}
	echo json_encode($array,true);
}

