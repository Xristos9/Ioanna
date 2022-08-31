<?php

session_start();
include "dbConnect.php";

if(isset($_POST['boolval'])){
	$query = "DELETE FROM `stores`";
	if ($base->query($query) === TRUE) {
		echo 1;
	} else {
		echo 3;
		echo "Error deleting record: " . $base->error;
	}
	$query2 = "DELETE FROM `populartimes`";
	if ($base->query($query2) === TRUE) {
		echo 1;
	} else {
		echo 3;
		echo "Error deleting record: " . $base->error;
	}
}else {
	echo 2;
}
