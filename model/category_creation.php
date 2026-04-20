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
		$category_name = $_POST['category_name'] ?? '';
		$sql = "SELECT * FROM category_creation WHERE category_name='".$db->escape($category_name)."' and delete_status!='1'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'category_name' => $category_name,
				'description' => $_POST['description'] ?? ''
			];
			$db->query_insert("category_creation", $data);
		}
		else
			echo "<span class=text-danger>Already Exit</span>";
	break;

	case "UPDATE":
		$category_name = $_POST['category_name'] ?? '';
		$update_id = $_GET['update_id'] ?? '';
		$sql = "SELECT * FROM category_creation WHERE category_name='".$db->escape($category_name)."' and delete_status!='1' and category_id!='".$db->escape($update_id)."'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{	
			$data = [
				'category_name' => $category_name,
				'description' => $_POST['description'] ?? ''
			];
			$db->query_update("category_creation", $data, "category_id='".$db->escape($update_id)."'");
		}
		else
			echo "<span class=text-danger>Already Exit</span>";
    break;

	case "DELETE":
		$delete_id = $_GET['delete_id'] ?? '';
		$data = ['delete_status' => '1'];
		$db->query_update("category_creation", $data, "category_id='".$db->escape($delete_id)."'");
	break;
	}
$db->close();
?>