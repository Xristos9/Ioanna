<?php

	include "dbConnect.php";
	session_start();
	$id = $_SESSION["User_id"];

	$date = date('Y-m-d');
	$date2 = date('Y-m-d', strtotime('-7 day', strtotime($date)));
	$date3 = date('Y-m-d', strtotime('-14 day', strtotime($date)));

	$result = mysqli_query($base, "SELECT `User_id` FROM `cases` WHERE `Date` BETWEEN DATE('$date2') AND DATE('$date') ");
	$array = array();
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			array_push($array,$row['User_id']);
		}
	}

	$array2 = array();
	foreach($array as $c){
		$result2 = mysqli_query($base, "SELECT `Store_id`,`Date` FROM `visits` WHERE `User_id`= '$c' AND `Date` BETWEEN DATE('$date3') AND DATE('$date') ");

		if (mysqli_num_rows($result2) > 0) {
			while($row = mysqli_fetch_assoc($result2)) {
				array_push($array2, array('id'=>$row['Store_id'], 'date' => $row['Date']));
			}
		}
	}

	$array3 = array();
	$result3 = mysqli_query($base, "SELECT `Store_id`,`Date` FROM `visits` WHERE `User_id`= '$id' AND `Date` BETWEEN DATE('$date3') AND DATE('$date') ");

	if (mysqli_num_rows($result3) > 0) {
		while($row = mysqli_fetch_assoc($result3)) {
			array_push($array3, array('id'=>$row['Store_id'], 'date' => $row['Date']));
		}
	}

	$storeIDs = array();
	for($i = 0; $i< count($array2); $i++){
		for($j = 0; $j< count($array3); $j++){
			$time = strtotime($array2[$i]['date']);
			$time2 = strtotime($array3[$j]['date']);
			if($array3[$j]['id'] == $array2[$i]['id'] and abs($time - $time2) <= 7200 ){
				array_push($storeIDs,array('id'=>$array3[$j]['id'], 'date' => $array3[$j]['date'] ));
			}
		}
	}

	$array4 = array();

	for($i=0; $i<count($storeIDs); $i++){
		$f = $storeIDs[$i]['id'];
		$result4 = mysqli_query($base, "SELECT * FROM `stores` WHERE `Store_id`= '$f' ");
		if (mysqli_num_rows($result4) > 0) {
			while($row = mysqli_fetch_assoc($result4)) {
				array_push($array4, array('Name' => $row['Name'], 'date' => $storeIDs[$i]['date'] ));
			}
		}
	}

	echo json_encode($array4,true);
