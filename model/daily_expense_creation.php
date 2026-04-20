<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
ob_start();
session_start();
require("config.inc.php"); 
require("Database.class.php"); 
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect(); 

$sess_staff_id = $_SESSION['sess_staff_id'] ?? '';
$sess_user_type_id = $_SESSION['sess_user_type_id'] ?? '';
$sess_user_id = $_SESSION['sess_user_id'] ?? '';
$sess_ipaddress = $_SESSION['sess_ipaddress'] ?? '';

$action = $_GET['action'] ?? '';
$cur_date=date('Y-m-d');
switch ($action) {
    case "ADD":
		$data = [
			'expense_no' => $_POST['exp_no'] ?? '',
			'random_no' => $_POST['random_no'] ?? '',
			'random_sc' => $_POST['random_sc'] ?? '',
			'entry_date' => $_POST['exp_date'] ?? '',
			'expense_type' => $_POST['exp_type_id'] ?? '',
			'sub_expense_type' => $_POST['travel_exp'] ?? '',
			'amount' => $_POST['exp_amount'] ?? '',
			'description' => $_POST['description'] ?? '',
			'user_id' => $sess_user_id,
			'user_type' => $sess_user_type_id,
			'ipaddress' => $sess_ipaddress,
			'staff_id' => $sess_staff_id
		];
		$db->query_insert("daily_expense", $data);
		echo "<span class=text-success>Successfully Added</span>";
    break;
	
	case "UPDATE":
		$update_id = $_GET['update_id'] ?? '';
		$data = [
			'entry_date' => $_POST['exp_date'] ?? '',
			'expense_type' => $_POST['exp_type_id'] ?? '',
			'sub_expense_type' => $_POST['travel_exp'] ?? '',
			'amount' => $_POST['exp_amount'] ?? '',
			'description' => $_POST['description'] ?? ''
		];
		$db->query_update("daily_expense", $data, "exp_id='".$db->escape($update_id)."'");
	break;
	
	case "DELETE":
		$delete_id = $_GET['delete_id'] ?? '';
		$data = ['delete_status' => '1'];
		$db->query_update("daily_expense", $data, "exp_id='".$db->escape($delete_id)."'");
	break;
}