<?php
include_once 'db_connect.php';	
	class write_fuc {
		public function new_fee(){
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
	}
	public function new_pay($tenancy, $prop, $date, $apay, $pay_type){
		$sql = "INSERT INTO payment (tenancy_id, property_id, date, amount, amount_type_id ) VALUES (?,?,?,?,?)";
		$stmt = $mysqli->prepare($sql);
		$stmt->bind_param("iisii", $tenancy, $prop, $date, $apay, $pay_type);
		$stmt->execute();
		$stmt->close();
		$mysqli->close();
	}
	public function new_tenant(){
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
	}
	$obj=new write_fuc;
