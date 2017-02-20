
<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
$PageTitle="Open Managment";
$sql = "INSERT INTO payment (tenancy_id, property_id, date, amount, amount_type_id ) VALUES (?,?,?,?,?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("iisii", $tenancy, $prop, $date, $apay, $pay_type);
$apay = $_POST["apay"];
$pay_type = $_POST["pay_type"];
$tenancy = $_GET['parent'];
$prop = $_GET['prop'];
$date = $_POST["dpay"];

$stmt->execute();
$stmt->close();
$mysqli->close();
function customPageHeader(){ }//add html to head here

include_once('includes/header.php');


include_once('includes/footer.php');