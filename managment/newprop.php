<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
$PageTitle="Open Managment";

$fields = array('title', 'address');
$error = false; //No errors yet
foreach($fields AS $fieldname) { //Loop trough each field
  if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
    echo 'Field '.$fieldname.' misses!<br />'; //Display error with field
    $error = true; //Yup there are errors
  }
}
if(!$error) { //Only create queries when no error occurs
$sql = "INSERT INTO property (title, address) VALUES (?,?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $title, $address);
$title = $_POST["title"];
$address = $_POST["address"];
$stmt->execute();
$stmt->close();
$mysqli->close();
}
function customPageHeader(){
	Echo '<meta http-equiv="refresh" content="0; url=index.php" />';
}

include_once('includes/header.php');

include_once('includes/footer.php');