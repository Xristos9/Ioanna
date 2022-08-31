<?php

include "dbConnect.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
	$stores = array();
	$query = mysqli_query($base,"SELECT s.Store_id,s.Name,s.Address,s.lat,s.lng,p.value0,p.value1,p.value2,p.value3,p.value4,p.value5,p.value6,p.value7,p.value8,p.value9,p.value10,p.value11,p.value12,p.value13,p.value14,p.value15,p.value16,p.value17,p.value18,p.value19,p.value20,p.value21,p.value22,p.value23,p.Day FROM stores AS s INNER JOIN populartimes AS p WHERE s.Store_id=p.Store_id");
	if($query->num_rows >0){
		while($row = $query->fetch_assoc()){
			array_push($stores, array('id'=>$row['Store_id'],  'name'=>$row['Name'], 'address'=>$row['Address'],  'lat'=>$row['lat'],  'lng'=>$row['lng'],'populartimes'=>[$row['value0'],$row['value1'],$row['value2'],$row['value3'],$row['value4'],$row['value5'],$row['value6'],$row['value7'],$row['value8'],$row['value9'],$row['value10'],$row['value11'],$row['value12'],$row['value13'],$row['value14'],$row['value15'],$row['value16'],$row['value17'],$row['value18'],$row['value19'],$row['value20'],$row['value21'],$row['value22'],$row['value23']],'day'=>$row['Day']));
		}
	}
	echo json_encode($stores,true);
}