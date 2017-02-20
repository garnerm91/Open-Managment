<?php 
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
$PageTitle="Open Managment";

$ten_id = $_GET['parent'];
$end_d = $_POST["end_d"];

$results = $mysqli->query("SELECT property_id FROM tenancy WHERE tent_id = '$ten_id' AND current = 1");
while($row = $results->fetch_array()) {
 $property = $row["property_id"];
}
$stmt1 = $mysqli->prepare("UPDATE tenant SET current='0' WHERE id=?;");
$stmt1->bind_param("i", $ten_id);		
$stmt1->execute();
$stmt1->close();

$stmt2 = $mysqli->prepare("UPDATE property SET occupied='0' WHERE id=?;");
$stmt2->bind_param("i", $property);		
$stmt2->execute();
$stmt2->close();
 		
$stmt3 = $mysqli->prepare("UPDATE tenancy SET current='0', end_date=? WHERE tent_id=? AND current = 1;");
$stmt3->bind_param("si", $end_d, $ten_id);		
$stmt3->execute();
$stmt3->close();
 		
function customPageHeader(){ }//add html to head here
include_once('includes/header.php');


include_once('includes/footer.php');
