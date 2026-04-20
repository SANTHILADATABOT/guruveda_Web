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

$district_id_post = $_POST['district_id'] ?? '';
$district_data = $db->query_first("SELECT * FROM district_creation WHERE district_id='".$db->escape($district_id_post)."'");

$action = $_GET['action'] ?? '';
$cur_date=date('Y-m-d');
switch ($action) {
	case "SUBMIT":
		$area_name = $_POST['area_name'] ?? '';
		$sql = "SELECT * FROM area_creation WHERE district_id='".$db->escape($district_id_post)."' and area_name='".$db->escape($area_name)."' and delete_status!='1'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'state_id' => $district_data['state_id'] ?? '',
				'district_id' => $district_id_post,
				'area_name' => $area_name,
				'description' => $_POST['description'] ?? ''
			];
			$db->query_insert("area_creation", $data);
		}
		else
			echo "<span class=text-danger>Already Exit</span>";
    break;

	case "UPDATE":
		$area_name = $_POST['area_name'] ?? '';
		$update_id = $_GET['update_id'] ?? '';
		$sql = "SELECT * FROM area_creation WHERE district_id='".$db->escape($district_id_post)."' and area_name='".$db->escape($area_name)."' and area_id!='".$db->escape($update_id)."' and delete_status!='1'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{	
			$data = [
				'state_id' => $district_data['state_id'] ?? '',
				'district_id' => $district_id_post,
				'area_name' => $area_name,
				'description' => $_POST['description'] ?? ''
			];
			$db->query_update("area_creation", $data, "area_id='".$db->escape($update_id)."'");
		}
    break;

	case "DELETE":
		$delete_id = $_GET['delete_id'] ?? '';
		$data = ['delete_status' => '1'];
		$db->query_update("area_creation", $data, "area_id='".$db->escape($delete_id)."'");
		echo "<span class=text-success>Successfully Deleted</span>";
	break;
}
$db->close();
?>