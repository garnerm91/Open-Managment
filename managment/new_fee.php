
<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
$PageTitle="Open Managment";
$sql = "INSERT INTO payment (tenancy_id, property_id, date, amount, amount_type_id ) VALUES (?,?,?,?,?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("iisii", $tenancy, $prop, $date, $afee, $fee_type);
$tenancy = $_GET['parent'];
$prop = $_GET['prop'];
$date = date(Y.m.d);
$afee = -abs($_POST["afee"]);
$fee_type = $_POST["fee_type"];

$stmt->execute();
$stmt->close(); 
$mysqli->close();
function customPageHeader(){ }//add html to head here

include_once('includes/header.php');



include_once('includes/footer.php');
