<?php

require_once("includes/conf.php");
require_once("classes/Login.php");
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
$PageTitle="Open Managment";
function customPageHeader(){?>

  <!--Arbitrary HTML Tags-->
<?php }
include_once('includes/header.php');


echo '<span> You are veiwing:</span>';

//get tenant name and current var
 $a = intval($_GET['parent']);
 $results = $mysqli->query("SELECT id, first_name, last_name, current FROM tenant WHERE id = '$a'");
while($row = $results->fetch_array()) { 
echo $row["first_name"], '&nbsp', $row["last_name"];
$current = $row["current"];
}
 
if(isset($_POST['submit'])) {
	$fields = array('prop_id', 'rent', 'late', 'start_d');
$error = false; //No errors yet
foreach($fields AS $fieldname) { //Loop trough each field
  if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
    echo 'Field '.$fieldname.' misses!<br />'; //Display error with field
    $error = true; //Yup there are errors
  }
}
if(!$error) {


 $stmt = $mysqli->prepare("INSERT INTO tenancy (property_id, tent_id, rent, late, start_date, current) VALUES(?, ?, ?, ?, ?, ?)");
 $stmt->bind_param("iiiisi", $prop_id, $tent_id, $rent, $late, $start_date, $b);
 $prop_id = $_POST["prop_id"];
 $b = 1;
 $tent_id = $_GET['parent'];
 $rent = $_POST["rent"];
 $late = $_POST["late"];
 $start_date = $_POST["start_d"];

 $stmt->execute();
 $stmt->close();
 
 $mysqli->query("
 		UPDATE tenant SET current='1' WHERE id=' $tent_id';
 		");
 $mysqli->query("
 		UPDATE property SET occupied='1' WHERE id=' $prop_id';
 		");
 $results = $mysqli->query("SELECT id FROM tenancy WHERE tent_id ='$tent_id' AND current=1");
 while($row = $results->fetch_array()) {
 	$tenancyid= $row['id'];
 }
 $mysqli->query("
 		INSERT INTO payment (tenancy_id, property_id, amount_type_id)
 		VALUES ('$tenancyid','$prop_id','6');
 		");
include_once 'autorent.php';
}
} elseif ($current == 0) {
?>
  
  <form action="list_tenant.php?parent=<?=$a?>" method="post">
  <select name="prop_id">
  <?php //get props for drop down 
  $results = $mysqli->query("SELECT id, address FROM property WHERE occupied=0");
  while($row = $results->fetch_array()) { ?>
  	<option value="<?= $row['id'] ?>"><?= $row["address"] ?></option>
  <?php 
  }  
  ?>
  </select>
  Rent Amount<input type="text" name="rent">
  Late Fee<input type="text" name="late">
  Move in date<input type="text" name="start_d">
 <input type="submit" name="submit" value="submit"> 
 </form>
 
 <?php
 $mysqli->close();
 }
 elseif ($current == 1){
 	echo '<form action="move_out.php?parent=',$a,'" method="post">
Move out date<input type="text" name="end_d">
<input type="submit" name="submit" value="submit"> 
</form>';
 }
include_once('includes/footer.php');
} else {
	// the user is not logged in. you can do whatever you want here.
	// for demonstration purposes, we simply show the "you are not logged in" view.
	include("views/not_logged_in.php");
}
