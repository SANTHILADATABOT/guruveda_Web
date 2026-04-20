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

switch ($action) {
    case "ADD":
		$tax_name = $_POST['tax_name'] ?? '';
		$percentage = $_POST['percentage'] ?? '';
		$sql = "SELECT * FROM tax_creation WHERE (tax_name='".$db->escape($tax_name)."' or percentage='".$db->escape($percentage)."') and delete_status!='1'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'tax_name' => $tax_name,
				'percentage' => $percentage
			];
			$db->query_insert("tax_creation", $data);
		}
		else
			echo "<span class=text-danger>Already Exit</span>";
	break;

	case "UPDATE":
		$tax_name = $_POST['tax_name'] ?? '';
		$percentage = $_POST['percentage'] ?? '';
		$update_id = $_GET['update_id'] ?? '';
		$sql = "SELECT * FROM tax_creation WHERE (tax_name='".$db->escape($tax_name)."' or percentage='".$db->escape($percentage)."') and delete_status!='1' and tax_id!='".$db->escape($update_id)."'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{	
			$data = [
				'tax_name' => $tax_name,
				'percentage' => $percentage
			];
			$db->query_update("tax_creation", $data, "tax_id='".$db->escape($update_id)."'");
		}
		else
			echo "<span class=text-danger>Already Exit</span>";
    break;

	case "DELETE":
		$delete_id = $_GET['delete_id'] ?? '';
		$data = ['delete_status' => '1'];
		$db->query_update("tax_creation", $data, "tax_id='".$db->escape($delete_id)."'");
	break;
	}
$db->close();
?>