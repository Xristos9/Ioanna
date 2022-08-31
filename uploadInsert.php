<?php

include "dbConnect.php";
session_start();
$data = json_decode($_POST["data"], true);
// print_r($data);
foreach($data as $row){
	for ($j = 0; $j <=6; $j++){

		$query = "INSERT INTO `populartimes` (`Store_id`,`Day`, `value0`,`value1`,`value2`,`value3`,`value4`,`value5`,`value6`,`value7`,`value8`,`value9`,`value10`,`value11`,`value12`,`value13`,`value14`,`value15`,`value16`,`value17`,`value18`,`value19`,`value20`,`value21`,`value22`,`value23`) VALUES ('".$row['id']."','".$row['day'][$j]."','".$row['data'][$j][0]."','".$row['data'][$j][1]."','".$row['data'][$j][2]."','".$row['data'][$j][3]."','".$row['data'][$j][4]."','".$row['data'][$j][5]."','".$row['data'][$j][6]."','".$row['data'][$j][7]."','".$row['data'][$j][8]."','".$row['data'][$j][9]."','".$row['data'][$j][10]."','".$row['data'][$j][11]."','".$row['data'][$j][12]."','".$row['data'][$j][13]."','".$row['data'][$j][14]."','".$row['data'][$j][15]."','".$row['data'][$j][16]."','".$row['data'][$j][17]."','".$row['data'][$j][18]."','".$row['data'][$j][19]."','".$row['data'][$j][20]."','".$row['data'][$j][21]."','".$row['data'][$j][22]."','".$row['data'][$j][23]."')";

		if (mysqli_query($base, $query)) {
			// echo "New record created successfully";
		} else {
			// echo "Error: " . $query . mysqli_error($base);
		}
	}
	$query2 = "INSERT INTO stores (Store_id, Name, Address,lat,lng,Rating,RatingN,Types) VALUES ('".$row['id']."', '".$row['name']."', '".$row['address']."','".$row['lat']."','".$row['lng']."', '".$row['rating']."', '".$row['rating_n']."','".$row['types']."')";
	if (mysqli_query($base, $query2)) {
		// echo "New record created successfully";
	} else {
		// echo "Error: " . $query2 . mysqli_error($base);
	}
}
echo 1;
