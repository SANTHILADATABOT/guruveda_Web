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
    case "SUBMIT":
		$category_id = $_POST['category_id'] ?? '';
		$group_name = $_POST['group_name'] ?? '';
		$sql = "SELECT * FROM group_creation WHERE category_id='".$db->escape($category_id)."' and group_name='".$db->escape($group_name)."' and delete_status!='1'";
		$row = $db->query($sql);
		if($db->affected_rows === 0)
		{
			$data = [
				'category_id' => $category_id,
				'group_name' => $group_name,
				'hsn_code' => $_POST['hsn_code'] ?? '',
				'description' => $_POST['description'] ?? ''
			];
			$db->query_insert("group_creation", $data);
		}
		else
			echo "Already Exists";
	break;

	case "UPDATE":
		$category_id = $_POST['category_id'] ?? '';
		$group_name = $_POST['group_name'] ?? '';
		$update_id = $_GET['update_id'] ?? '';
		$sql = "SELECT * FROM group_creation WHERE category_id='".$db->escape($category_id)."' and group_name='".$db->escape($group_name)."' and delete_status!='1' and  
		group_id!='".$db->escape($update_id)."'";
		$row = $db->query($sql);
		if($db->affected_rows === 0)
		{
			$data = [
				'category_id' => $category_id,
				'group_name' => $group_name,
				'hsn_code' => $_POST['hsn_code'] ?? '',
				'description' => $_POST['description'] ?? ''
			];
			$db->query_update("group_creation", $data, "group_id='".$db->escape($update_id)."'");
		}
		else
			echo "Already Exists";
	break;

	case "DELETE":
		$delete_id = $_GET['delete_id'] ?? '';
		$data = ['delete_status' => '1'];
		$db->query_update("group_creation", $data, "group_id='".$db->escape($delete_id)."'");
	break;
}
$db->close();
?>