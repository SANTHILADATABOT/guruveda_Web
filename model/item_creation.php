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
		$group_id = $_POST['group_id'] ?? '';
		$item_name = $_POST['item_name'] ?? '';
		$item_code = $_POST['item_code'] ?? '';
		$sql = "SELECT * FROM item_creation WHERE category_id='".$db->escape($category_id)."' and group_id='".$db->escape($group_id)."' and item_name='".$db->escape($item_name)."'";
		$row = $db->query($sql);
		$rs = $db->query("SELECT * FROM item_creation WHERE item_code='".$db->escape($item_code)."'");
		$num = ($rs && $rs instanceof mysqli_result) ? $rs->num_rows : 0;

		if(($db->affected_rows === 0)&&($num=='0'))
		{
			$data = [
				'category_id' => $category_id,
				'group_id' => $group_id,
				'item_name' => $item_name,
				'item_code' => $item_code,
				'hsn_code' => $_POST['hsn_code'] ?? '',
				'tax_id' => $_POST['tax_id'] ?? '',
				'distributor_rate' => $_POST['distributor_rate'] ?? '',
				'sub_dealer_rate' => $_POST['sub_dealer_rate'] ?? '',
				'description' => $_POST['description'] ?? ''
			];
			$db->query_insert("item_creation", $data);
		}
		else
			echo "<span class=text-danger>Already Exit</span>";
	break;

	case "UPDATE":
		$category_id = $_POST['category_id'] ?? '';
		$group_id = $_POST['group_id'] ?? '';
		$item_name = $_POST['item_name'] ?? '';
		$item_code = $_POST['item_code'] ?? '';
		$update_id = $_GET['update_id'] ?? '';
		$sql = "SELECT * FROM item_creation WHERE category_id='".$db->escape($category_id)."' and group_id='".$db->escape($group_id)."' and item_name='".$db->escape($item_name)."' and item_id!='".$db->escape($update_id)."'";
		$row = $db->query($sql); 
		$rs = $db->query("SELECT * FROM item_creation WHERE item_code='".$db->escape($item_code)."' and item_id!='".$db->escape($update_id)."'");
		$num = ($rs && $rs instanceof mysqli_result) ? $rs->num_rows : 0;

		if(($db->affected_rows === 0)&&($num=='0'))
		{	
			$data = [
				'category_id' => $category_id,
				'group_id' => $group_id,
				'item_name' => $item_name,
				'item_code' => $item_code,
				'hsn_code' => $_POST['hsn_code'] ?? '',
				'tax_id' => $_POST['tax_id'] ?? '',
				'distributor_rate' => $_POST['distributor_rate'] ?? '',
				'sub_dealer_rate' => $_POST['sub_dealer_rate'] ?? '',
				'description' => $_POST['description'] ?? ''
			];
			$db->query_update("item_creation", $data, "item_id='".$db->escape($update_id)."'");
		}
    break;

	case "DELETE":
		$delete_id = $_GET['delete_id'] ?? '';
		$db->query_delete("item_creation", "item_id='".$db->escape($delete_id)."'");
		echo "<span class=text-success>Successfully Deleted</span>";
	break;
}
$db->close();
?>