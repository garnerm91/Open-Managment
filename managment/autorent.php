<?php 
include_once 'includes/db_connect.php';
//before the loop
$date = date(Y.m.d);
$dt2 = new DateTime($date);

//during
$loop = $mysqli->query("SELECT tent_id FROM tenancy WHERE current ='1'");
while($rowl = $loop->fetch_array()) {
	$tent_id = $rowl["tent_id"] ;

	$results = $mysqli->query("SELECT id, rent, start_date FROM tenancy WHERE tent_id ='$tent_id'");
	while($row = $results->fetch_array()) {
	$tenancy_id = $row["id"];
	$rent = $row["rent"];
	$movein = $row["start_date"];
	}	
	$results->free();
		$dt1 = new DateTime($movein);
		$occupancy = $dt1->diff($dt2);
		$time = ($occupancy->format('%y') * 12) + $occupancy->format('%m');
		$updaterent = $time * -abs($rent);

	$mysqli->query("UPDATE payment SET amount=$updaterent, date=$date WHERE amount_type_id=6 AND tenancy_id=$tenancy_id");
}
?>
it works