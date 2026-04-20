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
		$state_name = $_POST['state_name'] ?? '';
		$sql = "SELECT * FROM state_creation WHERE state_name='".$db->escape($state_name)."' and delete_status!='1'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'state_name' => $state_name,
				'state_code' => $_POST['state_code'] ?? '',
				'description' => $_POST['description'] ?? ''
			];
			$db->query_insert("state_creation", $data);
			echo "<span class=text-success>Successfully Added</span>";
		}
		else
			echo "<span class=text-danger>Already Exit</span>";
	break;
	case "UPDATE":
		$state_name = $_POST['state_name'] ?? '';
		$update_id = $_GET['update_id'] ?? '';
		$sql = "SELECT * FROM state_creation WHERE state_name='".$db->escape($state_name)."' and state_id!='".$db->escape($update_id)."' and delete_status!='1'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{	
			$data = [
				'state_name' => $state_name,
				'state_code' => $_POST['state_code'] ?? '',
				'description' => $_POST['description'] ?? ''
			];
			$db->query_update("state_creation", $data, "state_id='".$db->escape($update_id)."'");
			echo "<span class=text-success>Successfully Updated</span>";
		}
    break;
	case "DELETE":
		$delete_id = $_GET['delete_id'] ?? '';
		$data = ['delete_status' => '1'];
		$db->query_update("state_creation", $data, "state_id='".$db->escape($delete_id)."'");
		echo "<span class=text-success>Successfully Deleted</span>";
	break;
}
$db->close();
?>