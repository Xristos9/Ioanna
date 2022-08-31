<?php
	include "dbConnect.php";
	session_start();

	if($_SERVER["REQUEST_METHOD"] == "GET"){

		$result = mysqli_query($base, "SELECT s.Types FROM stores AS s INNER JOIN visits AS v WHERE s.Store_id=v.Store_id");
		$types = array();
		if (mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				array_push($types, $row['Types']);
			}
			echo json_encode($types,true);
		}else{
			// echo 0;
		}

	}
?>