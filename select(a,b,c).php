<?php

	include "dbConnect.php";
	session_start();

	if($_SERVER["REQUEST_METHOD"] == "GET"){

		$sum = array();
		$result = mysqli_num_rows(mysqli_query($base, "SELECT `Store_id` FROM `visits`"));
		$result2 = mysqli_num_rows(mysqli_query($base, "SELECT `Case_id` FROM `cases`"));

		$result3 = mysqli_query($base, "SELECT `User_id`,`Date` FROM `cases` ORDER BY `cases`.`Date` DESC");
		$cases = array();
		if (mysqli_num_rows($result3) > 0) {
			while($row = mysqli_fetch_assoc($result3)) {
				array_push($cases, array('id' =>  $row['User_id'], 'date' => $row['Date']));
			}
		}

		$ids = array();
		for($i=0; $i<count($cases); $i++){
			$u = $cases[$i]['id'];
			$date = date($cases[$i]['date']);
			$date2 = date('Y-m-d', strtotime('-7 day', strtotime($date)));
			$date3 = date('Y-m-d', strtotime('+14 day', strtotime($date)));
			$result4 = mysqli_query($base, "SELECT `Visit_id` FROM `visits` WHERE `User_id`= $u AND `Date` BETWEEN DATE('$date2') AND DATE('$date3')");
			if (mysqli_num_rows($result4) > 0) {
				while($row = mysqli_fetch_assoc($result4)) {
					array_push($ids,$row['Visit_id']);
				}
			}
		}
		// print_r($result2);
		$unique = count(array_unique($ids));
		// print_r($unique);

		array_push($sum, $result,$result2,$unique);
		echo json_encode($sum,true);
	}
?>