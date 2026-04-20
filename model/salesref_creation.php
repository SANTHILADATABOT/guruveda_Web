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

function customer_creation_get_image_customer($update_id)
{
	global $db;
	$Isql = $db->query_first("select * from customer_creation where customer_id='".$db->escape($update_id)."'");
	return $Isql['image_name'] ?? '';
}

$action = $_GET['action'] ?? '';
$cur_date=date("Y-m-d");


switch ($action) {
	case "SUBMIT":
		$image_array = $_FILES['file_data'] ?? [];
		$picturename1 = $image_array['name'] ?? '';
		$main_name = $image_array['tmp_name'] ?? '';
		$sales_ref_name = $_POST['sales_ref_name'] ?? '';
		$mobile_no = $_POST['mobile_no'] ?? '';
		$sql = "SELECT * FROM sales_ref_creation WHERE sales_ref_name='".$db->escape($sales_ref_name)."' and mobile_no='".$db->escape($mobile_no)."' and delete_status!='1'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'entry_date' => $cur_date,
				'sales_ref_name' => $sales_ref_name,
				'mobile_no' => $mobile_no,
				'phone_no' => $_POST['phone_no'] ?? '',
				'address' => $_POST['address'] ?? '',
				'pin_gst_no' => $_POST['pin_gst_no'] ?? '',
				'state_id' => $_POST['state_id'] ?? '',
				'district_id' => $_POST['district_id'] ?? '',
				'area_id' => $_POST['area_id'] ?? '',
				'image_name' => $picturename1
			];
			$db->query_insert("sales_ref_creation", $data);
			if($main_name && $picturename1) {
				$upload_file1='../salesref_image/'.$picturename1;
				copy($main_name,$upload_file1);
			}
		}

	break;

	case "UPDATE":
		$image_array = $_FILES['file_data'] ?? [];
		$picturename1 = $image_array['name'] ?? '';
		$main_name = $image_array['tmp_name'] ?? '';
		$update_id = $_GET['update_id'] ?? '';
		$sales_ref_name = $_POST['sales_ref_name'] ?? '';
		$mobile_no = $_POST['mobile_no'] ?? '';

		$update_pic=customer_creation_get_image_customer($update_id);
		if($picturename1!='')
		{ $get_up_img=$picturename1; }
		else{ $get_up_img=$update_pic; }
		
		$sql = "SELECT * FROM sales_ref_creation WHERE sales_ref_name='".$db->escape($sales_ref_name)."' and mobile_no='".$db->escape($mobile_no)."' and 
		sales_ref_id!='".$db->escape($update_id)."' and delete_status!='1'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'sales_ref_name' => $sales_ref_name,
				'mobile_no' => $mobile_no,
				'phone_no' => $_POST['phone_no'] ?? '',
				'address' => $_POST['address'] ?? '',
				'pin_gst_no' => $_POST['pin_gst_no'] ?? '',
				'state_id' => $_POST['state_id'] ?? '',
				'district_id' => $_POST['district_id'] ?? '',
				'area_id' => $_POST['area_id'] ?? '',
				'image_name' => $get_up_img
			];
			$db->query_update("sales_ref_creation", $data, "sales_ref_id='".$db->escape($update_id)."'");
			if($main_name && $get_up_img) {
				$upload_file2='../salesref_image/'.$get_up_img;
				copy($main_name,$upload_file2);
			}
		}
	break;

	case "DELETE":
		$delete_id = $_GET['delete_id'] ?? '';
		$data = ['delete_status' => '1'];
		$db->query_update("sales_ref_creation", $data, "sales_ref_id='".$db->escape($delete_id)."'");
	break;
}
$db->close();
?>