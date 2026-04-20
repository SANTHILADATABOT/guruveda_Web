<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
ob_start();
session_start();
require("config.inc.php");
require("Database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

$user_id=$_SESSION['sess_user_id'] ?? '';
$user_type_id=$_SESSION['sess_user_type_id'] ?? '';
$staff_id=$_SESSION['sess_staff_id'] ?? '';
$ipaddress=$_SESSION['sess_ipaddress'] ?? '';

$action = $_GET['action'] ?? '';
$sales_ref_id = $_POST['sales_ref_id'] ?? '';
$area_id = $_POST['area_id'] ?? '';
$sales_ref=$db->query_first("select distributor_id from sales_ref_creation where sales_ref_id='".$db->escape($sales_ref_id)."'") ?? [];
$area=$db->query_first("select * from area_creation where area_id='".$db->escape($area_id)."'") ?? [];
$distributor_id = $sales_ref['distributor_id'] ?? '';
$state_id = $area['state_id'] ?? '';
$district_id = $area['district_id'] ?? '';

switch ($action) {
	case "SUBMIT":
		$data = [
			'area_assign_no' => $_POST['area_assign_no'] ?? '',
			'entry_date' => $_POST['entry_date'] ?? '',
			'random_no' => $_POST['random_no'] ?? '',
			'random_sc' => $_POST['random_sc'] ?? '',
			'sales_ref_id' => $sales_ref_id,
			'distributor_id' => $distributor_id,
			'sub_dealer_id' => $_POST['sub_dealer_id'] ?? '',
			'area_id' => $area_id,
			'state_id' => $state_id,
			'district_id' => $district_id
		];
		$db->query_insert("area_assign_main", $data);
	break;

	case "UPDATE":
		$update_id = $_GET['update_id'] ?? '';
		$data = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'sales_ref_id' => $sales_ref_id,
			'area_id' => $area_id,
			'distributor_id' => $distributor_id,
			'sub_dealer_id' => $_POST['sub_dealer_id'] ?? '',
			'state_id' => $state_id,
			'district_id' => $district_id
		];
		$where = "random_no='".$db->escape($_POST['random_no'] ?? '')."' and random_sc='".$db->escape($_POST['random_sc'] ?? '')."' and area_assign_no='".$db->escape($_POST['area_assign_no'] ?? '')."' and assign_id='".$db->escape($update_id)."'";
		$db->query_update("area_assign_main", $data, $where);
	break;

	case "DELETE":
		$where = "area_assign_no='".$db->escape($_GET['area_assign_no'] ?? '')."' and random_no='".$db->escape($_GET['random_no'] ?? '')."' and random_sc='".$db->escape($_GET['random_sc'] ?? '')."' and assign_id='".$db->escape($_GET['delete_id'] ?? '')."'";
		$db->query_update("area_assign_main", ['delete_status' => '1'], $where);
	break;
}
$db->close();
?>