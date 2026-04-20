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
		$attendance_type = $_POST['att_type_id'] ?? '';
		$att_no = $_POST['att_no'] ?? '';
		$random_no = $_POST['random_no'] ?? '';
		$random_sc = $_POST['random_sc'] ?? '';
		$staff_id = $_POST['staff_id'] ?? '';
		$entry_time = $_POST['entry_time'] ?? '';
		$att_date = $_POST['att_date'] ?? '';
		
		$attendance_type1 = explode(',',$attendance_type);
		
		if(isset($attendance_type1[1]) && $attendance_type1[1]!='2')
		{
			$data = [
				'attendance_no' => $att_no,
				'random_no' => $random_no,
				'random_sc' => $random_sc,
				'staff_name' => $staff_id,
				'attendance_type' => $attendance_type1[0] ?? '',
				'type_id' => $attendance_type1[1] ?? '',
				'attendance_time' => $entry_time,
				'entry_date' => $att_date
			];
			$db->query_insert("attendance_entry", $data);
			
			$in_time = $db->query("select * from attendance_entry where staff_name='".$db->escape($staff_id)."' and entry_date='".$db->escape($att_date)."' and type_id='".$db->escape($attendance_type1[1] ?? '')."'");
			
			$count = ($in_time && $in_time instanceof mysqli_result) ? $in_time->num_rows : 0;
			
			if($count==1)
			{
				$data_upd = ['in_time' => $entry_time];
				$db->query_update("attendance_entry", $data_upd, "staff_name='".$db->escape($staff_id)."' and entry_date='".$db->escape($att_date)."' and attendance_no='".$db->escape($att_no)."'");
			}
			else
			{
				$data_upd = ['out_time' => $entry_time];
				$db->query_update("attendance_entry", $data_upd, "staff_name='".$db->escape($staff_id)."' and entry_date='".$db->escape($att_date)."' and attendance_no='".$db->escape($att_no)."'");
			}
		}
		elseif(isset($attendance_type1[1]) && $attendance_type1[1]=='2')
		{
			if(isset($attendance_type1[0]) && $attendance_type1[0]=='3')
			{
				$data = [
					'attendance_no' => $att_no,
					'random_no' => $random_no,
					'random_sc' => $random_sc,
					'staff_name' => $staff_id,
					'attendance_type' => $attendance_type1[0],
					'type_id' => $attendance_type1[1],
					'attendance_time' => $entry_time,
					'in_time' => $entry_time,
					'entry_date' => $att_date
				];
				$db->query_insert("attendance_entry", $data);
			}
			elseif(isset($attendance_type1[0]) && $attendance_type1[0]=='4')
			{
				$data = [
					'attendance_no' => $att_no,
					'random_no' => $random_no,
					'random_sc' => $random_sc,
					'staff_name' => $staff_id,
					'attendance_type' => $attendance_type1[0],
					'type_id' => $attendance_type1[1],
					'attendance_time' => $entry_time,
					'out_time' => $entry_time,
					'entry_date' => $att_date
				];
				$db->query_insert("attendance_entry", $data);
			}
		}
		
		if(isset($attendance_type1[0]) && $attendance_type1[0]=='2')
		{
			$get_in_time = $db->query_first("select * from attendance_entry where staff_name='".$db->escape($staff_id)."' and entry_date='".$db->escape($att_date)."' and attendance_type='1' order by att_id asc");
			
			$in_time_calc = $get_in_time['in_time'] ?? '';
			
			$lunch_in_time = $db->query_first("select * from attendance_entry where staff_name='".$db->escape($staff_id)."' and entry_date='".$db->escape($att_date)."' and attendance_type='5' order by att_id asc");
			
			$lunch_in_time_calc = $lunch_in_time['attendance_time'] ?? '';
			
			$get_out_time = $db->query_first("select * from attendance_entry where staff_name='".$db->escape($staff_id)."' and entry_date='".$db->escape($att_date)."' and attendance_type='2' order by att_id desc");
			
			$out_time_calc = $get_out_time['out_time'] ?? '';
			
			$lunch_out_time = $db->query_first("select * from attendance_entry where staff_name='".$db->escape($staff_id)."' and entry_date='".$db->escape($att_date)."' and attendance_type='6' order by att_id asc");
			
			$lunch_out_time_calc = $lunch_out_time['attendance_time'] ?? '';

			$time1  = "00:00:00";
			
			if($in_time_calc && $out_time_calc) {
				$secs = (strtotime("$out_time_calc") - strtotime("$in_time_calc"));
				$result = date("H:i:s",strtotime($time1)+$secs);
			} else {
				$result = "00:00:00";
			}
			
			if($lunch_in_time_calc && $lunch_out_time_calc) {
				$lunch_calc = (strtotime("$lunch_out_time_calc") - strtotime("$lunch_in_time_calc"));
				$lunch_result = date("H:i:s",strtotime($time1)+$lunch_calc);
			} else {
				$lunch_result = "00:00:00";
			}
			
			if($result && $lunch_result) {
				$final_calc =  (strtotime("$result") - strtotime("$lunch_result"));
				$final_result = date("H:i:s",strtotime($time1)+$final_calc);
			} else {
				$final_result = "00:00:00";
			}
			
			$data_upd = [
				'tot_ofc_time' => $final_result,
				'tot_free_time' => $lunch_result
			];
			$db->query_update("attendance_entry", $data_upd, "staff_name='".$db->escape($staff_id)."' and entry_date='".$db->escape($att_date)."' and attendance_no='".$db->escape($att_no)."'");
		}
		echo "<span class=text-success>Successfully Added</span>";
    break;
	
	case "UPDATE":
		$update_id = $_GET['update_id'] ?? '';
		$entry_time = $_POST['entry_time'] ?? '';
		$staff_name = $_POST['staff_name'] ?? '';
		$entry_date = $_POST['entry_date'] ?? '';
		
		$Insql2 = $db->query_first("select * from attendance_entry where att_id='".$db->escape($update_id)."'");
		
		$in_time_upd = $Insql2['in_time'] ?? '';
		$out_time_upd = $Insql2['out_time'] ?? '';
		$attendance_type_get = $Insql2['attendance_type'] ?? '';
		
		if($in_time_upd!='')
		{
			$data_upd = [
				'in_time' => $entry_time,
				'attendance_time' => $entry_time
			];
			$db->query_update("attendance_entry", $data_upd, "att_id='".$db->escape($update_id)."'");
		}
		elseif($out_time_upd!='')
		{
			$data_upd = [
				'out_time' => $entry_time,
				'attendance_time' => $entry_time
			];
			$db->query_update("attendance_entry", $data_upd, "att_id='".$db->escape($update_id)."'");
		}
		
		if($attendance_type_get=='1' || $attendance_type_get=='2')
		{
			$get_in_time = $db->query_first("select * from attendance_entry where staff_name='".$db->escape($staff_name)."' and entry_date='".$db->escape($entry_date)."' and attendance_type='1' order by att_id asc");
			
			$in_time_calc = $get_in_time['in_time'] ?? '';
			
			$lunch_in_time = $db->query_first("select * from attendance_entry where staff_name='".$db->escape($staff_name)."' and entry_date='".$db->escape($entry_date)."' and attendance_type='5' order by att_id asc");
			
			$lunch_in_time_calc = $lunch_in_time['attendance_time'] ?? '';
			
			$get_out_time = $db->query_first("select * from attendance_entry where staff_name='".$db->escape($staff_name)."' and entry_date='".$db->escape($entry_date)."' and attendance_type='2' order by att_id desc");
			
			$out_time_calc = $get_out_time['out_time'] ?? '';
			
			$lunch_out_time = $db->query_first("select * from attendance_entry where staff_name='".$db->escape($staff_name)."' and entry_date='".$db->escape($entry_date)."' and attendance_type='6' order by att_id asc");
			
			$lunch_out_time_calc = $lunch_out_time['attendance_time'] ?? '';
			
			$time1  = "00:00:00";
			
			if($in_time_calc && $out_time_calc) {
				$secs = (strtotime("$out_time_calc") - strtotime("$in_time_calc"));
				$result = date("H:i:s",strtotime($time1)+$secs);
			} else {
				$result = "00:00:00";
			}
			
			if($lunch_in_time_calc && $lunch_out_time_calc) {
				$lunch_calc = (strtotime("$lunch_out_time_calc") - strtotime("$lunch_in_time_calc"));
				$lunch_result = date("H:i:s",strtotime($time1)+$lunch_calc);
			} else {
				$lunch_result = "00:00:00";
			}
			
			if($result && $lunch_result) {
				$final_calc =  (strtotime("$result") - strtotime("$lunch_result"));
				$final_result = date("H:i:s",strtotime($time1)+$final_calc);
			} else {
				$final_result = "00:00:00";
			}
			
			$data_upd = [
				'tot_ofc_time' => $final_result,
				'tot_free_time' => $lunch_result
			];
			$db->query_update("attendance_entry", $data_upd, "staff_name='".$db->escape($staff_name)."' and entry_date='".$db->escape($entry_date)."' and attendance_type='2'");
		}
		break;
		
	case "DELETE":
		$delete_id = $_GET['delete_id'] ?? '';
		$db->query_delete("attendance_entry", "att_id='".$db->escape($delete_id)."'");
		break;
}
$db->close();
?>
