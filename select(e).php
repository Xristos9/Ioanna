<?php
	include "dbConnect.php";
	session_start();

	if($_SERVER["REQUEST_METHOD"] == "GET"){

		$result = mysqli_query($base, "SELECT v.Store_id FROM cases AS c INNER JOIN visits AS v WHERE c.User_id=v.User_id");
		$storeIDs = array();
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				array_push($storeIDs, $row['Store_id']);
			}
		}
		
		$array4 = array();

		foreach($storeIDs as $f){
			$result4 = mysqli_query($base, "SELECT `Types` FROM `stores` WHERE `Store_id`=  '$f'");
			if (mysqli_num_rows($result4) > 0) {
				while($row = mysqli_fetch_assoc($result4)) {
					array_push($array4, $row['Types']);
				}
			}
		}
		echo json_encode($array4,true);
		
	}
?>