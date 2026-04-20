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

//pur_inward_no
function get_student_creation_model_registration_no($acc_year)
{
	global $db;
	$date=date("Y");
	$st_date=substr($date,2);
	$month=date("m");
	$datee=$st_date.$month;

	$sql="select max(registration_no) as set_inv from student_creation where acc_year='".$db->escape($acc_year)."' and delete_status!='1'";
	$rs = $db->query($sql);
	$rscount = ($rs && $rs instanceof mysqli_result) ? $rs->num_rows : 0;
	if($rscount!=0)
	{
		while($rsdata = $rs->fetch_object())
		{			
			$set_inv = $rsdata->set_inv ?? '';
			$pur_array=explode('-',$set_inv);
			$inv_no = ($pur_array[2] ?? 0)+1;
			$reg_nos='STU-'.$datee.'-'.str_pad($inv_no, 4, '0', STR_PAD_LEFT);
		}
	}
	else
	{
		$inv_no=0001;
		$reg_nos='STU-'.$datee.'-'.str_pad($inv_no, 4, '0', STR_PAD_LEFT);
	}
	return $reg_nos;
}

$cur_date=date("Y-m-d");

##### 
	switch ($action) {
	case "SUBMIT":
		$acc_year_post = $_POST['acc_year'] ?? '';
		$reg_no=get_student_creation_model_registration_no($acc_year_post);

		$data = [
			'enter_date' => $cur_date,
			'random_no' => $_POST['random_no'] ?? '',
			'random_sc' => $_POST['random_sc'] ?? '',
			'registration_no' => $reg_no,
			'student_name' => $_POST['student_name'] ?? '',
			'gender' => $_POST['gender'] ?? '',
			'date_of_birth' => $_POST['dob'] ?? '',
			'blood_group' => $_POST['blood_group'] ?? '',
			'contact_mobile_no' => $_POST['contact_mobile_no'] ?? '',
			'aadhar_card_no' => $_POST['aadhar_card_no'] ?? '',
			'father_name' => $_POST['father_name'] ?? '',
			'father_occupation' => $_POST['father_occupation'] ?? '',
			'father_mobile_no' => $_POST['father_mobile_no'] ?? '',
			'mother_name' => $_POST['mother_name'] ?? '',
			'mother_occupation' => $_POST['mother_occupation'] ?? '',
			'mother_mobile_no' => $_POST['mother_mobile_no'] ?? '',
			'guardian_name' => $_POST['guardian_name'] ?? '',
			'guardian_occupation' => $_POST['guardian_occupation'] ?? '',
			'guardian_mobile_no' => $_POST['guardian_mobile_no'] ?? '',
			'com_address' => $_POST['com_address'] ?? '',
			'per_address' => $_POST['per_address'] ?? '',
			'annual_income' => $_POST['annual_income'] ?? '',
			'religion' => $_POST['religion'] ?? '',
			'caste' => $_POST['caste'] ?? '',
			'sub_caste' => $_POST['sub_caste'] ?? '',
			'academic_year_id' => $_POST['academic_year_id'] ?? '',
			'join_date' => $_POST['doj'] ?? '',
			'past_school' => $_POST['past_school'] ?? '',
			'standard_id' => $_POST['standard_id'] ?? '',
			'section_id' => $_POST['section_id'] ?? '',
			'identify_marks' => $_POST['identify_marks'] ?? '',
			'acc_year' => $acc_year_post,
			'sess_user_type_id' => $sess_user_type_id,
			'sess_user_id' => $sess_user_id,
			'sess_ipaddress' => $sess_ipaddress
		];
		$db->query_insert("student_creation", $data);
	break;

    case "UPDATE":
		$update_id = $_GET['update_id'] ?? '';
		$data = [
			'update_date' => $cur_date,
			'student_name' => $_POST['student_name'] ?? '',
			'gender' => $_POST['gender'] ?? '',
			'date_of_birth' => $_POST['dob'] ?? '',
			'blood_group' => $_POST['blood_group'] ?? '',
			'contact_mobile_no' => $_POST['contact_mobile_no'] ?? '',
			'father_name' => $_POST['father_name'] ?? '',
			'aadhar_card_no' => $_POST['aadhar_card_no'] ?? '',
			'father_occupation' => $_POST['father_occupation'] ?? '',
			'father_mobile_no' => $_POST['father_mobile_no'] ?? '',
			'mother_name' => $_POST['mother_name'] ?? '',
			'mother_occupation' => $_POST['mother_occupation'] ?? '',
			'mother_mobile_no' => $_POST['mother_mobile_no'] ?? '',
			'guardian_name' => $_POST['guardian_name'] ?? '',
			'guardian_occupation' => $_POST['guardian_occupation'] ?? '',
			'guardian_mobile_no' => $_POST['guardian_mobile_no'] ?? '',
			'com_address' => $_POST['com_address'] ?? '',
			'per_address' => $_POST['per_address'] ?? '',
			'caste' => $_POST['caste'] ?? '',
			'annual_income' => $_POST['annual_income'] ?? '',
			'religion' => $_POST['religion'] ?? '',
			'sub_caste' => $_POST['sub_caste'] ?? '',
			'academic_year_id' => $_POST['academic_year_id'] ?? '',
			'identify_marks' => $_POST['identify_marks'] ?? '',
			'join_date' => $_POST['doj'] ?? '',
			'past_school' => $_POST['past_school'] ?? '',
			'standard_id' => $_POST['standard_id'] ?? '',
			'sess_user_type_id' => $sess_user_type_id,
			'section_id' => $_POST['section_id'] ?? '',
			'sess_user_id' => $sess_user_id,
			'sess_ipaddress' => $sess_ipaddress
		];
		$where = "random_no='".$db->escape($_POST['random_no'] ?? '')."' and random_sc='".$db->escape($_POST['random_sc'] ?? '')."' and registration_no='".$db->escape($_POST['registration_no'] ?? '')."' and student_id='".$db->escape($update_id)."'";
		$db->query_update("student_creation", $data, $where);
	break;

    case "DELETE":
		$delete_id = $_GET['delete_id'] ?? '';
		$data = ['delete_status' => '1'];
		$db->query_update("student_creation", $data, "student_id='".$db->escape($delete_id)."'");
	break;
}
$db->close();
?>