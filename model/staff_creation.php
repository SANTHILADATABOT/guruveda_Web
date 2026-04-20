<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
ob_start();
session_start();
$sess_user_type_id = $_SESSION['sess_user_type_id'] ?? '';
$sess_staff_id = $_SESSION['sess_staff_id'] ?? '';
$sess_ipaddress = $_SESSION['sess_ipaddress'] ?? '';

require("../model/config.inc.php"); 
require("../model/Database.class.php");  
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect(); 

$action = $_GET['action'] ?? '';
$delete_id = $_GET['delete_id'] ?? '';
$table = "staff_creation";

function get_staff_creation_model_academic_year($academic_year_id)
{
	global $db;
	$year = $db->query_first("select * from account_year where accyear_id='".$db->escape($academic_year_id)."'");
	$academic_year = ($year['from_year'] ?? '')."-".($year['to_year'] ?? '');
	return $academic_year;
}

function get_staff_creation_model_registration_no()
{
	global $db;
	$date=date("Y");
	$st_date=substr($date,2);
	$month=date("m");	   
	$datee=$st_date.$month;

	$rs1 = $db->query("select registration_no from staff_creation where delete_status!='1' order by staff_id desc");
	$res1 = $db->fetch_array($rs1);
	$enquiry_no = '';
	if($res1)
	{
		$pur_array=explode('-',$res1['registration_no'] ?? '');
	
	   	$year1 = $pur_array[1] ?? '';
        $year2=substr($year1, 0, 2);
	    $year='20'.$year2;
		$enquiry_no=$pur_array[2] ?? '';
	}
	if($enquiry_no=='')
		$enquiry_nos='STF-'.$datee.'-0001';
	elseif($year!=date("Y"))
		$enquiry_nos='STF-'.$datee.'-0001';
	else
	{
		$enquiry_no+=1;
		$enquiry_nos='STF-'.$datee.'-'.str_pad($enquiry_no, 4, '0', STR_PAD_LEFT);
	}
	return $enquiry_nos;
}

function y() 
{ 
	if(date("m")<4) 
	{ 
		return date("Y") - 1; 
	} 
	else 
	{ 
		return date("Y"); 
	}
}

$year = y() + 1;
$year21=y();
$acc_year=$year21."-".$year;

$cur_date=date("Y-m-d");

$academic_year_id_post = $_POST['academic_year_id'] ?? '';
$academic_year=get_staff_creation_model_academic_year($academic_year_id_post);

##### 
switch ($action) {
	case "SUBMIT":
		$staff_name = $_POST['staff_name'] ?? '';
		$mobile_no = $_POST['mobile_no'] ?? '';
		$sql = "SELECT * FROM `".$table."` WHERE staff_name='".$db->escape($staff_name)."' and  mobile_no='".$db->escape($mobile_no)."'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$password = base64_encode($_POST['teac_password'] ?? '');
			$confirm_password = base64_encode($_POST['teac_confirm_password'] ?? '');

			$registration_no=get_staff_creation_model_registration_no();

			$data = [
				'random_no' => $_POST['random_no'] ?? '',
				'random_sc' => $_POST['random_sc'] ?? '',
				'registration_no' => $registration_no,
				'enter_date' => $cur_date,
				'staff_name' => $staff_name,
				'gender' => $_POST['gender'] ?? '',
				'date_of_birth' => $_POST['date_of_birth'] ?? '',
				'blood_group' => $_POST['blood_group'] ?? '',
				'father_name' => $_POST['father_name'] ?? '',
				'mother_name' => $_POST['mother_name'] ?? '',
				'com_address' => $_POST['com_address'] ?? '',
				'per_address' => $_POST['per_address'] ?? '',
				'mobile_no' => $mobile_no,
				'mail_id' => $_POST['mail_id'] ?? '',
				'adhar_card_no' => $_POST['adhar_card_no'] ?? '',
				'academic_year_id' => $academic_year_id_post,
				'academic_year' => $academic_year,
				'join_date' => $_POST['join_date'] ?? '',
				'degree' => $_POST['degree'] ?? '',
				'qualification' => $_POST['qualification'] ?? '',
				'experience' => $_POST['experience'] ?? '',
				'past_school' => $_POST['past_school'] ?? '',
				'salary' => $_POST['salary'] ?? '',
				'others' => $_POST['others'] ?? '',
				'acc_year' => $acc_year,
				'designation' => $_POST['designation'] ?? '',
				'teac_user_name' => $_POST['teac_user_name'] ?? '',
				'teac_password' => $password,
				'teac_confirm_password' => $confirm_password,
				'ip_address' => $sess_ipaddress,
				'sess_user_type_id' => '2',
				'sess_staff_id' => $sess_staff_id
			];
			$insert_id = $db->query_insert("staff_creation", $data);

			$data2 = [
				'user_type_id' => '2',
				'user_name' => $_POST['teac_user_name'] ?? '',
				'password' => $password,
				'confirm_password' => $confirm_password,
				'user_status' => 1,
				'sess_user_type_id' => '2',
				'sess_user_id' => $insert_id,
				'staff_id' => $insert_id,
				'sess_ipaddress' => $sess_ipaddress,
				'delete_status' => '0'
			];
			$db->query_insert("user_creation", $data2);

			echo "<span class=text-success>Successfully Added</span>";
		}
		else
			echo "<span class=text-danger>Already Exit</span>";
	
	break;

    case "UPDATE":
		$staff_name = $_POST['staff_name'] ?? '';
		$mobile_no = $_POST['mobile_no'] ?? '';
		$update_id = $_POST['update_id'] ?? '';
		$sql = "SELECT  * FROM `".$table."` WHERE staff_name='".$db->escape($staff_name)."' and  mobile_no='".$db->escape($mobile_no)."' and  staff_id!='".$db->escape($update_id)."'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$password = base64_encode($_POST['teac_password'] ?? '');
			$confirm_password = base64_encode($_POST['teac_confirm_password'] ?? '');
		
			$data = [
				'update_date' => $cur_date,
				'staff_name' => $staff_name,
				'gender' => $_POST['gender'] ?? '',
				'date_of_birth' => $_POST['date_of_birth'] ?? '',
				'blood_group' => $_POST['blood_group'] ?? '',
				'father_name' => $_POST['father_name'] ?? '',
				'mother_name' => $_POST['mother_name'] ?? '',
				'com_address' => $_POST['com_address'] ?? '',
				'per_address' => $_POST['per_address'] ?? '',
				'mobile_no' => $mobile_no,
				'mail_id' => $_POST['mail_id'] ?? '',
				'adhar_card_no' => $_POST['adhar_card_no'] ?? '',
				'academic_year_id' => $academic_year_id_post,
				'academic_year' => $academic_year,
				'join_date' => $_POST['join_date'] ?? '',
				'degree' => $_POST['degree'] ?? '',
				'qualification' => $_POST['qualification'] ?? '',
				'experience' => $_POST['experience'] ?? '',
				'past_school' => $_POST['past_school'] ?? '',
				'salary' => $_POST['salary'] ?? '',
				'others' => $_POST['others'] ?? '',
				'acc_year' => $acc_year,
				'designation' => $_POST['designation'] ?? '',
				'teac_user_name' => $_POST['teac_user_name'] ?? '',
				'teac_password' => $password,
				'teac_confirm_password' => $confirm_password,
				'ip_address' => $sess_ipaddress,
				'sess_user_type_id' => '2',
				'sess_staff_id' => $sess_staff_id
			];
			$where = "random_no='".$db->escape($_POST['random_no'] ?? '')."' and random_sc='".$db->escape($_POST['random_sc'] ?? '')."' and registration_no='".$db->escape($_POST['registration_no'] ?? '')."' and staff_id='".$db->escape($update_id)."'";
			$db->query_update("staff_creation", $data, $where);

			$data2 = [
				'user_type_id' => '2',
				'user_name' => $_POST['teac_user_name'] ?? '',
				'password' => $password,
				'confirm_password' => $confirm_password,
				'user_status' => '1',
				'sess_user_type_id' => '2',
				'sess_user_id' => $update_id,
				'sess_ipaddress' => $sess_ipaddress,
				'delete_status' => '0'
			];
			$db->query_update("user_creation", $data2, "staff_id='".$db->escape($update_id)."'");
		
			echo "<span class=text-success>Successfully Updated</span>";
		}
		else
			echo "<span class=text-danger>Already Exit</span>";
	break;

    case "delete":
		$data = ['delete_status' => '1'];
		$db->query_update("staff_creation", $data, "staff_id='".$db->escape($delete_id)."'");
		$data2 = ['delete_status' => '1', 'user_status' => '1'];
		$db->query_update("user_creation", $data2, "staff_id='".$db->escape($delete_id)."'");
		echo "<span class=text-success>Successfully Deleted</span>";
	break;
	
}
##### 

$db->close();

?>