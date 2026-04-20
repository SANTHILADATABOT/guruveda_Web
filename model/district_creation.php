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
		$district_name = $_POST['district_name'] ?? '';
		$sql = "SELECT * FROM district_creation WHERE district_name='".$db->escape($district_name)."' and delete_status!='1'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'state_id' => $_POST['state_id'] ?? '',
				'district_name' => $district_name,
				'description' => $_POST['description'] ?? ''
			];
			$db->query_insert("district_creation", $data);
			echo "<span class=text-success>Successfully Added</span>";
		}
		else
			echo "<span class=text-danger>Already Exit</span>";
    break;

	case "UPDATE":
		$district_name = $_POST['district_name'] ?? '';
		$update_id = $_GET['update_id'] ?? '';
		$sql = "SELECT * FROM district_creation WHERE district_name='".$db->escape($district_name)."' and district_id!='".$db->escape($update_id)."' and delete_status!='1'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{	
			$data = [
				'state_id' => $_POST['state_id'] ?? '',
				'district_name' => $district_name,
				'description' => $_POST['description'] ?? ''
			];
			$db->query_update("district_creation", $data, "district_id='".$db->escape($update_id)."'");
			echo "<span class=text-success>Successfully Updated</span>";
		}
    break;

case "DELETE":
	$delete_id = $_GET['delete_id'] ?? '';
	$data = ['delete_status' => '1'];
	$db->query_update("district_creation", $data, "district_id='".$db->escape($delete_id)."'");
	echo "<span class=text-success>Successfully Deleted</span>";
	break;
}
$db->close();
?>