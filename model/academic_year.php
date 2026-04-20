<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
ob_start();
session_start();
require("config.inc.php"); 
require("Database.class.php"); 
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect(); 

$sess_user_type_id = $_SESSION['sess_user_type_id'] ?? '';
$sess_user_id = $_SESSION['sess_user_id'] ?? '';
$sess_ipaddress = $_SESSION['sess_ipaddress'] ?? '';

$action = $_GET['action'] ?? '';
$cur_date=date('Y-m-d');

switch ($action) {
    case "ADD":
		$from_academic = $_POST['from_academic'] ?? '';
		$to_academic = $_POST['to_academic'] ?? '';
		$sql = "SELECT from_year FROM account_year WHERE from_year='".$db->escape($from_academic)."' and delete_status!='1'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'entry_date' => $cur_date,
				'from_year' => $from_academic,
				'to_year' => $to_academic,
				'accountyear_status' => '0',
				'sess_user_type_id' => $sess_user_type_id,
				'sess_user_id' => $sess_user_id,
				'sess_ipaddress' => $sess_ipaddress
			];
			$db->query_insert("account_year", $data);
		}
		else
			echo "Already Exists";
	break;	

	case "UPDATE":
		$from_academic = $_POST['from_academic'] ?? '';
		$to_academic = $_POST['to_academic'] ?? '';
		$update_id = $_GET['update_id'] ?? '';
		$sql = "SELECT * FROM account_year WHERE from_year='".$db->escape($from_academic)."' and delete_status!='1' and  accyear_id!='".$db->escape($update_id)."'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'from_year' => $from_academic,
				'to_year' => $to_academic,
				'sess_user_id' => $sess_user_id,
				'sess_user_type_id' => $sess_user_type_id,
				'sess_ipaddress' => $sess_ipaddress
			];
			$db->query_update("account_year", $data, "accyear_id='".$db->escape($update_id)."'");
		}
		else
			echo "Already Exists";
	break;

	case "status_zero":
		$value = $_POST['value'] ?? '';
		$id = $_POST['id'] ?? '';
		$sql1 = $db->query("UPDATE account_year SET accountyear_status='".$db->escape($value)."' WHERE accyear_id='".$db->escape($id)."'");
	break;

	case "status_one":
		$sql3 = "SELECT accountyear_status FROM account_year WHERE accountyear_status='1' AND delete_status!='1'";
		$row = $db->query($sql3); 
		if($db->affected_rows === 0)
		{	
			$value = $_POST['value'] ?? '';
			$id = $_POST['id'] ?? '';
			$sql2 = $db->query("UPDATE account_year SET accountyear_status='".$db->escape($value)."' WHERE accyear_id='".$db->escape($id)."'");
			echo 'Updated';
		}
		
	break;
}
$db->close();
?>