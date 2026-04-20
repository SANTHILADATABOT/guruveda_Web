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

$item_id = $_POST['item_id'] ?? '';
$item = $db->query_first("select * from item_creation where item_id='".$db->escape($item_id)."'") ?? [];

//Invoice
function get_sales_order_model_sales_invoice(string $acc_year): string
{
	global $db;
	$date=date("Y");
	$st_date=substr($date,2);
	$month=date("m");
	$datee=$st_date.$month;
	$sql="select max(salesorder_no) as set_inv from sales_order_main where acc_year='".$db->escape($acc_year)."' and main_delete_status!='1'";
	$rs=$db->query($sql);
	$salesorder_no='';
	if($rs && $rs instanceof mysqli_result && $rs->num_rows!=0)
	{
		while($rsdata=$rs->fetch_object())
		{
			$set_inv=$rsdata->set_inv ?? '';
			$pur_array=explode('-',$set_inv);
			$inv_no=($pur_array[2] ?? 0)+1;
			$salesorder_no='SAL-'.$datee.'-'.str_pad((string)$inv_no, 4, '0', STR_PAD_LEFT);
		}
	}
	else
	{
		$inv_no=1;
		$salesorder_no='SAL-'.$datee.'-'.str_pad((string)$inv_no, 4, '0', STR_PAD_LEFT);
	}

	return $salesorder_no;
}

$action = $_GET['action'] ?? '';
$cur_date=date('Y-m-d');
$random_no = $_POST['random_no'] ?? '';
$random_sc = $_POST['random_sc'] ?? '';
$salesorder_no_post = $_POST['salesorder_no'] ?? '';
$acc_year = $_POST['acc_year'] ?? '';

switch ($action) {
    case "SUBMIT":
		$salesorder_no=get_sales_order_model_sales_invoice($acc_year);

		$data_main = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'random_no' => $random_no,
			'random_sc' => $random_sc,
			'salesorder_no' => $salesorder_no,
			'distributor_id' => $_POST['distributor_id'] ?? '',
			'sub_dealer_id' => $_POST['sub_dealer_id'] ?? '',
			'sales_ref_id' => $_POST['sales_ref_id'] ?? '',
			'total_qty' => $_POST['total_qty'] ?? '',
			'total_amount' => $_POST['total_amount'] ?? '',
			'description' => $_POST['description'] ?? '',
			'sess_user_type_id' => $sess_user_type_id,
			'sess_user_id' => $sess_user_id,
			'sess_ipaddress' => $sess_ipaddress,
			'acc_year' => $acc_year,
			'state_id' => $_POST['state_id'] ?? '',
			'district_id' => $_POST['district_id'] ?? '',
			'area_id' => $_POST['area_id'] ?? ''
		];
		$db->query_insert("sales_order_main", $data_main);

		$data_sub = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'sess_user_type_id' => $sess_user_type_id,
			'total_qty' => $_POST['total_qty'] ?? '',
			'total_amount' => $_POST['total_amount'] ?? ''
		];
		$db->query_update("sales_order_sublist", $data_sub, "random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."'");
	break;

	case "UPDATE":
		$update_id = $_GET['update_id'] ?? '';
		$data_main = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'sub_dealer_id' => $_POST['sub_dealer_id'] ?? '',
			'total_qty' => $_POST['total_qty'] ?? '',
			'total_amount' => $_POST['total_amount'] ?? '',
			'sess_user_type_id' => $sess_user_type_id,
			'sess_user_id' => $sess_user_id,
			'sess_ipaddress' => $sess_ipaddress,
			'distributor_id' => $_POST['distributor_id'] ?? '',
			'description' => $_POST['description'] ?? ''
		];
		$where_main = "random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and salesorder_no='".$db->escape($salesorder_no_post)."' and salesorder_id ='".$db->escape($update_id)."'";
		$db->query_update("sales_order_main", $data_main, $where_main);

		$db->query_update(
			"sales_order_sublist",
			[
				'entry_date' => $_POST['entry_date'] ?? '',
				'sess_user_type_id' => $sess_user_type_id,
				'total_qty' => $_POST['total_qty'] ?? '',
				'total_amount' => $_POST['total_amount'] ?? ''
			],
			"random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and salesorder_no='".$db->escape($salesorder_no_post)."'"
		);
	break;

	case "DELETE":
		$delete_id = $_GET['delete_id'] ?? '';
		$random_no_get = $_GET['random_no'] ?? '';
		$random_sc_get = $_GET['random_sc'] ?? '';
		$salesorder_no_get = $_GET['salesorder_no'] ?? '';

		$db->query_update(
			"sales_order_main",
			['main_delete_status' => '1'],
			"random_no='".$db->escape($random_no_get)."' and random_sc='".$db->escape($random_sc_get)."' and salesorder_id='".$db->escape($delete_id)."'"
		);

		$db->query_update(
			"sales_order_sublist",
			['delete_status' => '1'],
			"random_no='".$db->escape($random_no_get)."' and random_sc='".$db->escape($random_sc_get)."' and salesorder_no='".$db->escape($salesorder_no_get)."'"
		);
	break;

	case "CANCEL":
		$random_no_get = $_GET['random_no'] ?? '';
		$random_sc_get = $_GET['random_sc'] ?? '';
		$db->query_delete("sales_order_sublist", "random_no='".$db->escape($random_no_get)."' and random_sc='".$db->escape($random_sc_get)."'");
	break;

	case "ADD":
		$data_sub_insert = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'random_no' => $random_no,
			'random_sc' => $random_sc,
			'salesorder_no' => $salesorder_no_post,
			'sub_dealer_id' => $_POST['sub_dealer_id'] ?? '',
			'sales_ref_id' => $_POST['sales_ref_id'] ?? '',
			'category_id' => $item['category_id'] ?? '',
			'group_id' => $item['group_id'] ?? '',
			'item_id' => $_POST['item_id'] ?? '',
			'qty' => $_POST['qty'] ?? '',
			'rate' => $_POST['rate'] ?? '',
			'tax_id' => $_POST['tax_id'] ?? '',
			'tax_per' => $_POST['tax_per'] ?? '',
			'tax_amount' => $_POST['tax_amount'] ?? '',
			'amount' => $_POST['amount'] ?? '',
			'rd_amt' => $_POST['rd_amt'] ?? '',
			'sess_user_type_id' => $sess_user_type_id,
			'sess_user_id' => $sess_user_id,
			'sess_ipaddress' => $sess_ipaddress,
			'acc_year' => $acc_year
		];
		$db->query_insert("sales_order_sublist", $data_sub_insert);

		include("../sales_order_entry/sales_order_sublist.php");
	break;

	case "EDIT":
		$sub_id = $_GET['sub_id'] ?? '';
		$data_edit = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'sub_dealer_id' => $_POST['sub_dealer_id'] ?? '',
			'item_id' => $_POST['item_id'] ?? '',
			'sales_ref_id' => $_POST['sales_ref_id'] ?? '',
			'category_id' => $item['category_id'] ?? '',
			'group_id' => $item['group_id'] ?? '',
			'qty' => $_POST['qty'] ?? '',
			'tax_amount' => $_POST['tax_amount'] ?? '',
			'rate' => $_POST['rate'] ?? '',
			'tax_id' => $_POST['tax_id'] ?? '',
			'tax_per' => $_POST['tax_per'] ?? '',
			'amount' => $_POST['amount'] ?? '',
			'rd_amt' => $_POST['rd_amt'] ?? '',
			'sess_user_id' => $sess_user_id,
			'sess_user_type_id' => $sess_user_type_id,
			'sess_ipaddress' => $sess_ipaddress
		];
		$where_edit = "random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and salesorder_no='".$db->escape($salesorder_no_post)."' and sub_id='".$db->escape($sub_id)."'";
		$db->query_update("sales_order_sublist", $data_edit, $where_edit);
		include("../sales_order_entry/sales_order_sublist.php");
	break;

	case "DELETE_SUB":
		$del_id = $_GET['del_id'] ?? '';
		$random_no_get = $_GET['random_no'] ?? '';
		$random_sc_get = $_GET['random_sc'] ?? '';
		$salesorder_no_get = $_GET['salesorder_no'] ?? '';
		$data_del = [
			'delete_status' => '1',
			'sess_user_type_id' => $sess_user_type_id,
			'sess_user_id' => $sess_user_id,
			'sess_ipaddress' => $sess_ipaddress
		];
		$where_del = "random_no='".$db->escape($random_no_get)."' and random_sc='".$db->escape($random_sc_get)."' and sub_id='".$db->escape($del_id)."' and salesorder_no='".$db->escape($salesorder_no_get)."'";
		$db->query_update("sales_order_sublist", $data_del, $where_del);
		include("../sales_order_entry/sales_order_sublist.php");
	break;

	case "APPROVE":
		$cur_date=date('Y-m-d');
		$status = $_GET['status'] ?? '';
		$random_no_get = $_GET['random_no'] ?? '';
		$sales_id = $_GET['sales_id'] ?? '';
		$approval_status = ($status === 'approve') ? '1' : '2';
		$db->query_update(
			"sales_order_main",
			[
				'bill_approval_status' => $approval_status,
				'bill_approved_date' => $cur_date
			],
			"random_no='".$db->escape($random_no_get)."' and salesorder_id='".$db->escape($sales_id)."'"
		);
	break;
}
$db->close();
?>