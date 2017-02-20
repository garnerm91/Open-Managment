<?php
require_once("includes/conf.php");
require_once("classes/Login.php");
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/writefuncs.php';
// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {


$PageTitle="Open Managment";
function customPageHeader(){ }
include_once('includes/header.php');

echo '<span> You are veiwing:</span>';

//MySqli Select Query
 $prop_id = intval($_GET['parent']);
 $results = $mysqli->query("SELECT id, title, address, occupied FROM property WHERE id = '$prop_id'");

while($row = $results->fetch_array()) { 
echo $row["title"], '&nbsp', $row["address"];
$occupied = $row["occupied"];
}

 if($occupied == 1){
 	$results = $mysqli->query("SELECT id, tent_id, rent, late, start_date FROM tenancy WHERE current ='1' AND property_id = '$prop_id'");
 	
 	while($row = $results->fetch_array()) {
 		$tenancy = $row["id"];
 		$tent_id = $row["tent_id"];
 		$rent = $row["rent"];
 		$late = $row["late"];
 		$sdate = $row["start_date"];}

$results = $mysqli->query("SELECT first_name, last_name FROM tenant WHERE id = '$tent_id'");

while($row = $results->fetch_array()) {
	$firstn = $row["first_name"];
	$lastn = $row["last_name"]; }

$results = $mysqli->query("SELECT SUM(amount) AS amount_sum FROM payment WHERE tenancy_id ='$tenancy' ");

while($row = $results->fetch_array()) {
	$balance = $row['amount_sum'];}

 ?>
 <div>
<p>This propery is currently occupied by <?= $firstn, ' ', $lastn, ' rent is ', $rent,' with a late fee of ', $late; ?> balance is: <b><?= $balance;?></b> </p> 
 </div>
<div>
<div>
	<div class="propr">
	<div class="propc"><h4>Amount</h4></div>
	<div class="propc"><h4>Date</h4></div>
	<div class="propc"><h4>Type</h4></div>
</div>
<?php $results = $mysqli->query("SELECT payment.amount, payment.date, payment_type.type FROM payment JOIN payment_type ON payment.amount_type_id = payment_type.id WHERE payment.tenancy_id ='$tenancy'");
while($row = $results->fetch_array()) { ?>
<div class="propr">
	<div class="propc"><?= $row["amount"] ?></div>
	<div class="propc"><?= $row["date"] ?></div>
	<div class="propc"><?= $row["type"] ?></div>
</div>
<?php 
}?>
</div>
<h4>Add Payment:</h4>
 <form action="new_pay.php?parent=<?= $tenancy ;?>&prop= <?=  $prop_id ?>" method="post">
     <select name="pay_type">
  <?php //get props for drop down 
  $results = $mysqli->query("SELECT id, type FROM payment_type  LIMIT 0, 5");
  while($row = $results->fetch_array()) { ?>
  	<option value="<?= $row['id'] ?>"><?= $row["type"] ?></option>
  <?php 
  }
  
  ?>
  </select>
      Date paid<input type="text" value="<?= date("Y-m-d") ?>" name="dpay">
       Amount<input type="text" name="apay" >
        <input type="submit" value="Submit">   
        </form>  
</div>
<div>

<h4>Add Fee:</h4>
 <form action="new_fee.php?parent=<?= $tenancy ;?>&prop= <?=  $prop_id ?>" method="post">
     <select name="fee_type">
 <?php //get props for drop down 
  $results = $mysqli->query("SELECT id, type FROM payment_type LIMIT 1, 4");
  while($row = $results->fetch_array()) { ?>
  	<option value="<?= $row['id'] ?>"><?= $row["type"] ?></option>
  <?php 
  }
  
  ?>
  </select>
       Amount<input type="text" name="afee" value="<?= $late ;?>">
        <input type="submit" value="Submit">   
        </form> 
     
</div>
<?php	
 } else{
 	
 	echo '<p>no one lives here</p>';
 }
include_once('includes/footer.php');
} else {
	// the user is not logged in. you can do whatever you want here.
	// for demonstration purposes, we simply show the "you are not logged in" view.
	include("views/not_logged_in.php");
}
          