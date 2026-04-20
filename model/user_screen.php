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

$screen_name = $_POST['user_screen'] ?? '';

$cur_date=date("Y-m-d");

$screen_ids = "";
if($screen_name=='Admin')
{ $screen_ids="2"; }
elseif($screen_name=='Master')
{ $screen_ids="3"; }
elseif($screen_name=='Inward')
{ $screen_ids="4"; }
elseif($screen_name=='Sales')
{ $screen_ids="5"; }
elseif($screen_name=='Report')
{ $screen_ids="6"; }
elseif($screen_name=='Others')
{ $screen_ids="8"; }

switch ($action) {
    case "SUBMIT":
		$sub_screen_name = $_POST['sub_screen_name'] ?? '';
		$sql = "SELECT * FROM sub_screen WHERE screen_name='".$db->escape($screen_name)."' and sub_screen='".$db->escape($sub_screen_name)."'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'entry_date' => $cur_date,
				'screen_name' => $screen_name,
				'sub_screen' => $sub_screen_name,
				'screen_ids' => $screen_ids,
				'status' => $_POST['user_screen_status'] ?? '',
				'sess_user_type_id' => $sess_user_type_id,
				'sess_user_id' => $sess_user_id,
				'sess_ipaddress' => $sess_ipaddress
			];
			$insert_id = $db->query_insert("sub_screen", $data);

			$data2 = [
				'entry_date' => $cur_date,
				'user_name' => $screen_name,
				'user_screen' => $sub_screen_name,
				'form_id' => $screen_ids,
				'screen_id' => $insert_id,
				'sess_user_type_id' => $sess_user_type_id,
				'sess_user_id' => $sess_user_id,
				'sess_ipaddress' => $sess_ipaddress
			];
			$db->query_insert("user_rights", $data2);
		}
    break;

    case "UPDATE":
		$sub_screen_name = $_POST['sub_screen_name'] ?? '';
		$update_id = $_GET['update_id'] ?? '';
		$sql = "SELECT * FROM sub_screen WHERE screen_name='".$db->escape($screen_name)."' and sub_screen='".$db->escape($sub_screen_name)."' and screen_id!='".$db->escape($update_id)."'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'entry_date' => $cur_date,
				'screen_name' => $screen_name,
				'sub_screen' => $sub_screen_name,
				'screen_ids' => $screen_ids,
				'status' => $_POST['user_screen_status'] ?? '',
				'sess_user_type_id' => $sess_user_type_id,
				'sess_user_id' => $sess_user_id,
				'sess_ipaddress' => $sess_ipaddress
			];
			$db->query_update("sub_screen", $data, "screen_id='".$db->escape($update_id)."'");

			$data2 = [
				'entry_date' => $cur_date,
				'user_name' => $screen_name,
				'user_screen' => $sub_screen_name,
				'form_id' => $screen_ids,
				'sess_user_type_id' => $sess_user_type_id,
				'sess_user_id' => $sess_user_id,
				'sess_ipaddress' => $sess_ipaddress
			];
			$db->query_update("user_rights", $data2, "screen_id='".$db->escape($update_id)."'");
		}
	break;

	case "DELETE":
		$delete_id = $_GET['delete_id'] ?? '';
		$db->query_delete("sub_screen", "screen_id='".$db->escape($delete_id)."'");
		$db->query_delete("user_rights", "screen_id='".$db->escape($delete_id)."'");
	break;
}
$db->close();
?>
