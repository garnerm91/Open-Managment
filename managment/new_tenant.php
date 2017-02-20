<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
$PageTitle="Open Managment";

$fields = array('fname', 'lname', 'email', 'phone');
$error = false; 
foreach($fields AS $fieldname) { 
  if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
    echo 'Field '.$fieldname.' misses!<br />';
    $error = true; 
}
}

if(!$error) 
{ //Only create queries when no error occurs
$sql = "INSERT INTO tenant (first_name, last_name, email, phone) VALUES (?,?,?,?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssss", $first_name, $last_name, $email, $phone);
$first_name = $_POST["fname"];
$last_name = $_POST["lname"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$stmt->execute();
$stmt->close();
$mysqli->close();
}


function customPageHeader(){
	Echo '<meta http-equiv="refresh" content="0; url=index.php" />';
}
include_once('includes/header.php');	
include_once('includes/footer.php');