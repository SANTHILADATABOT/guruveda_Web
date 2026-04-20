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

function customer_creation_get_image_customer($update_id)
{
	global $db;
	$Isql = $db->query_first("select * from customer_creation where customer_id='".$db->escape($update_id)."'");
	return $Isql['image_name'] ?? '';
}
$action = $_GET['action'] ?? '';
$cur_date=date('Y-m-d');
switch ($action) {
    case "ADD":
		$image_array = $_FILES['file_data'] ?? [];
		$picturename1 = $image_array['name'] ?? '';
		$main_name = $image_array['tmp_name'] ?? '';
		$customer_name = $_POST['customer_name'] ?? '';
		
		$sql = "SELECT * FROM customer_creation WHERE customer_name='".$db->escape($customer_name)."'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{
			$data = [
				'entry_date' => $cur_date,
				'customer_no' => $_POST['customer_no'] ?? '',
				'customer_name' => $customer_name,
				'comm_address' => $_POST['comm_address'] ?? '',
				'perm_address' => $_POST['perm_address'] ?? '',
				'pin_gst_no' => $_POST['pin_gst_no'] ?? '',
				'contact_no' => $_POST['contact_no'] ?? '',
				'phone_no' => $_POST['phone_no'] ?? '',
				'email_address' => $_POST['email_id'] ?? '',
				'image_name' => $picturename1,
				'status' => $_POST['status'] ?? ''
			];
			$db->query_insert("customer_creation", $data);
			if($main_name && $picturename1) {
				$upload_file1='../customer_image/'.$picturename1;
				copy($main_name,$upload_file1);
			}
			echo "<span class=text-success>Successfully Added</span>";
		}
		else
			echo "<span class=text-danger>Already Exit</span>";
    break;
	
	 case "UPDATE":
		$image_array = $_FILES['file_data'] ?? [];
		$picturename1 = $image_array['name'] ?? '';
		$main_name = $image_array['tmp_name'] ?? '';
		$update_id = $_GET['update_id'] ?? '';
		$customer_name = $_POST['customer_name'] ?? '';

		$update_pic=customer_creation_get_image_customer($update_id);
		if($picturename1!='')
		{ $get_up_img=$picturename1; }
		else{ $get_up_img=$update_pic; }
		
		$sql = "SELECT * FROM customer_creation WHERE customer_name='".$db->escape($customer_name)."' and customer_id!='".$db->escape($update_id)."'";
		$row = $db->query($sql); 
		if($db->affected_rows === 0)
		{	
			$data = [
				'customer_no' => $_POST['customer_no'] ?? '',
				'customer_name' => $customer_name,
				'comm_address' => $_POST['comm_address'] ?? '',
				'perm_address' => $_POST['perm_address'] ?? '',
				'pin_gst_no' => $_POST['pin_gst_no'] ?? '',
				'contact_no' => $_POST['contact_no'] ?? '',
				'phone_no' => $_POST['phone_no'] ?? '',
				'email_address' => $_POST['email_id'] ?? '',
				'image_name' => $get_up_img,
				'status' => $_POST['status'] ?? ''
			];
			$db->query_update("customer_creation", $data, "customer_id='".$db->escape($update_id)."'");
			if($main_name && $get_up_img) {
				$upload_file2='../customer_image/'.$get_up_img;
				copy($main_name,$upload_file2);
			}
			echo "<span class=text-success>Successfully Updated</span>";
		}
    break;
	case "DELETE":
		$delete_id = $_GET['delete_id'] ?? '';
		$db->query_delete("customer_creation", "customer_id='".$db->escape($delete_id)."'");
		echo "<span class=text-success>Successfully Deleted</span>";
	break;

	}
$db->close();
?>