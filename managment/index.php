<?php

require_once("includes/conf.php");
require_once("classes/Login.php");
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
$login = new Login();
if ($login->isUserLoggedIn() == true) {

$PageTitle="Open Managment";
function customPageHeader(){?>
  <!--Arbitrary HTML Tags-->
<?php }
include_once('includes/header.php');

$results = $mysqli->query("SELECT id, title, address, occupied FROM property ");
?>
<div class="pro">
	<div class="propr">
	<div class="propc"><h2>Property Title</h2></div>
	<div class="propc"><h2>Address</h2></div>
	<div class="propc"><h2>Occupied</h2></div>
	<div class="propc"><h2>Balance</h2></div>
</div>
<?php 
while($row = $results->fetch_array()) { ?>
<div class="propr">
	<div class="propc"><a href="list_prop.php?parent=<?= $row['id'] ?>"><?= $row["title"] ?></a></div>
	<div class="propc"><?= $row["address"] ?></div>
	<div class="propc"><?php if ($row["occupied"] == 1) {echo 'yes';} else { echo 'no'; }?></div>
	<div class="propc"><?php 
	$prop_id =  $row['id'];
	$tid= $mysqli->query("SELECT id FROM tenancy WHERE current='1' AND property_id='$prop_id'");
	while($row = $tid->fetch_array()) {
		$tenancy= $row['id'];
	}
	
	$sums = $mysqli->query("SELECT SUM(amount) AS amount_sum FROM payment WHERE tenancy_id ='$tenancy'");
	while($row = $sums->fetch_array()) {
		echo $row['amount_sum'];
	}
	unset($tenancy);
	?> </div>
</div>
<?php 
}?>  
</div>


  <p> Add a new property:</p>
  
   <form action="newprop.php" method="post">
        Property Name<input type="text" name="title">
        Address<input type="text" name="address">
        <input type="submit" value="Submit">   
        </form>  
<div>
<?php 
$results = $mysqli->query("SELECT id, first_name, last_name, email, phone FROM tenant");

while($row = $results->fetch_array()) { ?>
<div class="propr">
	<div class="propc"><a href="list_tenant.php?parent=<?= $row['id'] ?>"><?= $row["first_name"] ?></a></div>
	<div class="propc"><?= $row["last_name"] ?></div>
	<div class="propc"><?= $row["email"] ?></div>
	<div class="propc"><?= $row["phone"] ?></div>
</div>
<?php 
}  ?>
</div>
<p>Add tenant</p>

 <form action="new_tenant.php" method="post">
        First Name<input type="text" name="fname">
        Last Name<input type="text" name="lname">
        Email<input type="text" name="email">
        Phone Number<input type="text" name="phone">    
        <input  type="submit" value="Submit">   
        </form>   
      
<?php include_once('includes/footer.php');
} else {
	// the user is not logged in. you can do whatever you want here.
	// for demonstration purposes, we simply show the "you are not logged in" view.
	include("views/not_logged_in.php");
}