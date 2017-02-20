<?php 
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
$PageTitle="Open Managment";
$fields = array('end_d');
$error = false; //No errors yet
foreach($fields AS $fieldname) { //Loop trough each field
  if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
    echo 'Field '.$fieldname.' misses!<br />'; //Display error with field
    $error = true; //Yup there are errors
  }
}
if(!$error) { //Only create queries when no error occurs
$ten_id = $_GET['parent'];
$end_d = $_POST["end_d"];

$stmt = $mysqli->prepare("SELECT property_id FROM tenancy WHERE tent_id = ? AND current = 1");
$stmt->bind_param("s", $ten_id);
$stmt->execute(); 
$stmt->bind_result($property);
$stmt->fetch();
$stmt->close();

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
}
function customPageHeader(){ }//add html to head here
include_once('includes/header.php');


include_once('includes/footer.php');

