<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
ob_start();
session_start();
$sess_user_type_id = $_SESSION['sess_user_type_id'] ?? '';
$sess_staff_id = $_SESSION['sess_staff_id'] ?? '';
$sess_ipaddress = $_SESSION['sess_ipaddress'] ?? '';

require("../model/config.inc.php"); 
require("../model/Database.class.php");  
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect(); 

$action = $_GET['action'] ?? '';

$cur_date=date("Y-m-d");

switch ($action) {
	case "SUBMIT":
		$distributor_name = $_POST['distributor_name'] ?? '';
		$mobile_no = $_POST['mobile_no'] ?? '';
		$sql = "SELECT * FROM distributor_creation WHERE distributor_name='".$db->escape($distributor_name)."' and mobile_no='".$db->escape($mobile_no)."' and delete_status!='1'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'entry_date' => $cur_date,
				'distributor_name' => $distributor_name,
				'mobile_no' => $mobile_no,
				'phone_no' => $_POST['phone_no'] ?? '',
				'address' => $_POST['address'] ?? '',
				'pin_gst_no' => $_POST['pin_gst_no'] ?? '',
				'state_id' => $_POST['state_id'] ?? '',
				'district_id' => $_POST['district_id'] ?? '',
				'area_id' => $_POST['area_id'] ?? ''
			];
			$db->query_insert("distributor_creation", $data);
		}
	break;

    case "UPDATE":
		$distributor_name = $_POST['distributor_name'] ?? '';
		$mobile_no = $_POST['mobile_no'] ?? '';
		$update_id = $_GET['update_id'] ?? '';
		$sql = "SELECT * FROM distributor_creation WHERE distributor_name='".$db->escape($distributor_name)."' and mobile_no='".$db->escape($mobile_no)."' and distributor_id!='".$db->escape($update_id)."' and delete_status!='1'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'distributor_name' => $distributor_name,
				'mobile_no' => $mobile_no,
				'phone_no' => $_POST['phone_no'] ?? '',
				'address' => $_POST['address'] ?? '',
				'pin_gst_no' => $_POST['pin_gst_no'] ?? '',
				'state_id' => $_POST['state_id'] ?? '',
				'district_id' => $_POST['district_id'] ?? '',
				'area_id' => $_POST['area_id'] ?? ''
			];
			$db->query_update("distributor_creation", $data, "distributor_id='".$db->escape($update_id)."'");
		}
	break;

    case "delete":
		$delete_id = $_GET['delete_id'] ?? '';
		$data = ['delete_status' => '1'];
		$db->query_update("distributor_creation", $data, "distributor_id='".$db->escape($delete_id)."'");
	break;
}
$db->close();
?>