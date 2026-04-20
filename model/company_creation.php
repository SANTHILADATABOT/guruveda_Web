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

$cur_date=date("Y-m-d");

$action = $_GET['action'] ?? '';
$update_id = $_GET['update_id'] ?? '';
$delete_id = $_GET['delete_id'] ?? '';

function company_creation_get_image_company($update_id)
{
	global $db;
	$Isql = $db->query_first("select * from company_details where id='".$db->escape($update_id)."'");
	return $Isql['image_name'] ?? '';
}

switch ($action) {
	case "SUBMIT":
        $image_array = $_FILES['file_data'] ?? [];
		$picturename1 = $image_array['name'] ?? '';
		$main_name = $image_array['tmp_name'] ?? '';
		$company_name = $_POST['company_name'] ?? '';
		$mobile_no = $_POST['mobile_no'] ?? '';
		$sql = "SELECT * FROM company_details WHERE (company_name ='".$db->escape($company_name)."' or mobile_no='".$db->escape($mobile_no)."') and delete_status!='1'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'entry_date' => $cur_date,
				'company_name' => $company_name,
				'address' => $_POST['company_address'] ?? '',
				'mobile_no' => $mobile_no,
				'phone_no' => $_POST['phone_no'] ?? '',
				'gst_no' => $_POST['gst_no'] ?? '',
				'tin_no' => $_POST['tin_no'] ?? '',
				'image_name' => $picturename1,
				'email_id' => $_POST['email_id'] ?? '',
				'sess_user_type_id' => $sess_user_type_id,
				'sess_user_id' => $sess_user_id,
				'sess_ipaddress' => $sess_ipaddress
			];
			$db->query_insert("company_details", $data);
			if($main_name && $picturename1) {
				$upload_file1='../company_images/'.$picturename1;
				copy($main_name,$upload_file1);
			}
		}
		else
			echo "Already Exist";
	break;

    case "UPDATE":
		$image_array = $_FILES['file_data'] ?? [];
		$picturename1 = $image_array['name'] ?? '';
		$main_name = $image_array['tmp_name'] ?? '';
		$update_id_post = $_POST['update_id'] ?? '';
		$company_name = $_POST['company_name'] ?? '';
		$mobile_no = $_POST['mobile_no'] ?? '';

		$update_pic=company_creation_get_image_company($update_id_post);
		if($picturename1!=''){ $get_up_img=$picturename1; }
		else{ $get_up_img=$update_pic; }

		$sql = "SELECT * FROM company_details WHERE (company_name='".$db->escape($company_name)."' or mobile_no='".$db->escape($mobile_no)."') and id!='".$db->escape($update_id_post)."' and 
		delete_status!='1'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'company_name' => $company_name,
				'address' => $_POST['company_address'] ?? '',
				'phone_no' => $_POST['phone_no'] ?? '',
				'mobile_no' => $mobile_no,
				'gst_no' => $_POST['gst_no'] ?? '',
				'tin_no' => $_POST['tin_no'] ?? '',
				'image_name' => $get_up_img,
				'email_id' => $_POST['email_id'] ?? '',
				'sess_user_id' => $sess_user_id,
				'sess_user_type_id' => $sess_user_type_id,
				'sess_ipaddress' => $sess_ipaddress
			];
			$db->query_update("company_details", $data, "id='".$db->escape($update_id_post)."'");
			if($main_name && $get_up_img) {
				$upload_file2='../company_images/'.$get_up_img;
				copy($main_name,$upload_file2);
			}
		}
		else
			echo "Already Exist";
	break;

    case "DELETE":		
		$delete_id_get = $_GET['delete_id'] ?? '';
		$data = [
			'delete_status' => '1',
			'sess_user_id' => $sess_user_id,
			'sess_user_type_id' => $sess_user_type_id,
			'sess_ipaddress' => $sess_ipaddress
		];
		$db->query_update("company_details", $data, "id='".$db->escape($delete_id_get)."'");
		echo "Successfully Deleted";
	break;
}
$db->close();
?>
