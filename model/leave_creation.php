<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
ob_start();
session_start();
require("config.inc.php"); 
require("Database.class.php"); 
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect(); 

$sess_staff_id = $_SESSION['sess_staff_id'] ?? '';
$sess_user_type_id = $_SESSION['sess_user_type_id'] ?? '';
$sess_user_id = $_SESSION['sess_user_id'] ?? '';
$sess_ipaddress = $_SESSION['sess_ipaddress'] ?? '';

$action = $_GET['action'] ?? '';
$cur_date=date('Y-m-d');
switch ($action) {
    case "ADD":
		$leave_type_id = $_POST['leave_type_id'] ?? '';
		if(($leave_type_id=='1')||($leave_type_id=='2')||($leave_type_id=='5'))
		{ $day_type="1"; }
		else if(($leave_type_id=='3')||$leave_type_id=='4')
		{ $day_type="0.5"; }
		else {
			$day_type="1";
		}
		
		$from_date = $_POST['from_date'] ?? '';
		$to_date = $_POST['to_date'] ?? '';
		$sql = "SELECT * FROM leave_entry_form WHERE '".$db->escape($from_date)."' between from_date and to_date and '".$db->escape($to_date)."' between from_date and to_date and staff_id='".$db->escape($sess_staff_id)."'";
		$row = $db->query($sql);
		if($db->affected_rows === 0)
		{		
			$data = [
				'leave_date' => $_POST['apply_date'] ?? '',
				'month_year' => $_POST['month_year'] ?? '',
				'leave_type_id' => $leave_type_id,
				'day_type' => $day_type,
				'staff_id' => $sess_user_id,
				'description' => $_POST['description'] ?? '',
				'from_date' => $from_date,
				'to_date' => $to_date
			];
			$db->query_insert("leave_entry_form", $data);
			echo "<span class=text-success>Successfully Added</span>";
		}
		else
		{
			echo "Already Applied";
		}
		
    break;
	
	case "APPROVE":
		$leave_type_id = $_POST['leave_type_id'] ?? '';
		$staff_id = $_POST['staff_id'] ?? '';
		$from_date = $_POST['from_date'] ?? '';
		$to_date = $_POST['to_date'] ?? '';
		$update_id = $_GET['update_id'] ?? '';
		$data = ['status' => '1'];
		$db->query_update("leave_entry_form", $data, "leave_type_id='".$db->escape($leave_type_id)."' and staff_id='".$db->escape($staff_id)."' and from_date='".$db->escape($from_date)."' and to_date='".$db->escape($to_date)."' and id='".$db->escape($update_id)."'");
	break;
		
	case "CANCEL":
		$leave_type_id = $_POST['leave_type_id'] ?? '';
		$staff_id = $_POST['staff_id'] ?? '';
		$from_date = $_POST['from_date'] ?? '';
		$to_date = $_POST['to_date'] ?? '';
		$update_id = $_GET['update_id'] ?? '';
		$data = ['status' => '2'];
		$db->query_update("leave_entry_form", $data, "leave_type_id='".$db->escape($leave_type_id)."' and staff_id='".$db->escape($staff_id)."' and from_date='".$db->escape($from_date)."' and to_date='".$db->escape($to_date)."' and id='".$db->escape($update_id)."'");
	break;
}
?>