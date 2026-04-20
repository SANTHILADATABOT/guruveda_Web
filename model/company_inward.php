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
function get_company_inward_model_sales_invoice(string $acc_year): string
{
	global $db;
	$date = date("Y");
	$st_date = substr($date,2);
	$month = date("m");
	$datee = $st_date.$month;
	$sql = "select max(compinward_no) as set_inv from company_inward_main where acc_year='".$db->escape($acc_year)."' and main_delete_status!='1'";
	$rs = $db->query($sql);
	$compinward_no = '';
	if($rs && $rs instanceof mysqli_result && $rs->num_rows!=0)
	{
		while($rsdata = $rs->fetch_object())
		{
			$set_inv = $rsdata->set_inv ?? '';
			$pur_array = explode('-',$set_inv);
			$inv_no = ($pur_array[2] ?? 0)+1;
			$compinward_no = 'CIN-'.$datee.'-'.str_pad((string)$inv_no, 4, '0', STR_PAD_LEFT);
		}
	}
	else
	{
		$inv_no = 1;
		$compinward_no = 'CIN-'.$datee.'-'.str_pad((string)$inv_no, 4, '0', STR_PAD_LEFT);
	}
	return $compinward_no;
}

$action = $_GET['action'] ?? '';
$cur_date = date('Y-m-d');
$random_no = $_POST['random_no'] ?? '';
$random_sc = $_POST['random_sc'] ?? '';
$compinward_no_post = $_POST['compinward_no'] ?? '';
$acc_year = $_POST['acc_year'] ?? '';

switch ($action) {
    case "SUBMIT":
		$compinward_no = get_company_inward_model_sales_invoice($acc_year);

		$data_main = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'random_no' => $random_no,
			'random_sc' => $random_sc,
			'compinward_no' => $compinward_no,
			'total_qty' => $_POST['total_qty'] ?? '',
			'total_amount' => $_POST['total_amount'] ?? '',
			'sess_user_type_id' => $sess_user_type_id,
			'sess_user_id' => $sess_user_id,
			'sess_ipaddress' => $sess_ipaddress,
			'acc_year' => $acc_year
		];
		$db->query_insert("company_inward_main", $data_main);

		$data_sub = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'compinward_no' => $compinward_no
		];
		$db->query_update("company_inward_sublist", $data_sub, "random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."'");

		$db->query_update(
			"stock_in",
			['entry_date' => $_POST['entry_date'] ?? '', 'invoice_no' => $compinward_no],
			"random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and ref_name='Company Inward' and stock_type='Company Inward'"
		);
	break;

	case "UPDATE":
		$update_id = $_GET['update_id'] ?? '';
		$data_main = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'total_qty' => $_POST['total_qty'] ?? '',
			'total_amount' => $_POST['total_amount'] ?? '',
			'sess_user_type_id' => $sess_user_type_id,
			'sess_user_id' => $sess_user_id,
			'sess_ipaddress' => $sess_ipaddress
		];
		$where_main = "compinward_no='".$db->escape($compinward_no_post)."' and random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and compinward_id ='".$db->escape($update_id)."'";
		$db->query_update("company_inward_main", $data_main, $where_main);

		$db->query_update(
			"company_inward_sublist",
			['entry_date' => $_POST['entry_date'] ?? ''],
			"random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and compinward_no='".$db->escape($compinward_no_post)."'"
		);

		$db->query_update(
			"stock_in",
			['entry_date' => $_POST['entry_date'] ?? ''],
			"random_sc='".$db->escape($random_sc)."' and random_no='".$db->escape($random_no)."' and invoice_no='".$db->escape($compinward_no_post)."' and ref_name='Company Inward' and stock_type='Company Inward'"
		);
	break;

	case "DELETE":
		$delete_id = $_GET['delete_id'] ?? '';
		$random_no_get = $_GET['random_no'] ?? '';
		$random_sc_get = $_GET['random_sc'] ?? '';
		$compinward_no_get = $_GET['compinward_no'] ?? '';

		$db->query_update(
			"company_inward_main",
			['main_delete_status' => '1'],
			"random_no='".$db->escape($random_no_get)."' and random_sc='".$db->escape($random_sc_get)."' and compinward_id='".$db->escape($delete_id)."'"
		);

		$db->query_update(
			"company_inward_sublist",
			['delete_status' => '1'],
			"random_no='".$db->escape($random_no_get)."' and random_sc='".$db->escape($random_sc_get)."' and compinward_no='".$db->escape($compinward_no_get)."'"
		);

		$db->query_update(
			"stock_in",
			['delete_status' => '1'],
			"random_no='".$db->escape($random_no_get)."' and random_sc='".$db->escape($random_sc_get)."' and invoice_no='".$db->escape($compinward_no_get)."' and ref_name='Company Inward' and stock_type='Company Inward'"
		);
	break;

	case "ADD":
		$data_sub_insert = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'random_no' => $random_no,
			'random_sc' => $random_sc,
			'compinward_no' => $compinward_no_post,
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
		$insert_id = $db->query_insert("company_inward_sublist", $data_sub_insert);

		$data_stock_in = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'random_no' => $random_no,
			'random_sc' => $random_sc,
			'invoice_no' => $compinward_no_post,
			'ref_name' => 'Company Inward',
			'insert_id' => $insert_id,
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
			'stock_type' => 'Company Inward',
			'sess_user_type_id' => $sess_user_type_id,
			'sess_user_id' => $sess_user_id,
			'sess_ipaddress' => $sess_ipaddress,
			'acc_year' => $acc_year
		];
		$db->query_insert("stock_in", $data_stock_in);
		include("../company_inward/company_inward_sublist.php");
	break;

	case "EDIT":
		$sub_id = $_GET['sub_id'] ?? '';
		$data_edit = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'category_id' => $item['category_id'] ?? '',
			'group_id' => $item['group_id'] ?? '',
			'item_id' => $_POST['item_id'] ?? '',
			'qty' => $_POST['qty'] ?? '',
			'rate' => $_POST['rate'] ?? '',
			'sess_user_id' => $sess_user_id,
			'sess_user_type_id' => $sess_user_type_id,
			'tax_id' => $_POST['tax_id'] ?? '',
			'tax_per' => $_POST['tax_per'] ?? '',
			'tax_amount' => $_POST['tax_amount'] ?? '',
			'amount' => $_POST['amount'] ?? '',
			'rd_amt' => $_POST['rd_amt'] ?? '',
			'sess_ipaddress' => $sess_ipaddress
		];
		$where_edit = "random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and compinward_no='".$db->escape($compinward_no_post)."' and sub_id='".$db->escape($sub_id)."'";
		$db->query_update("company_inward_sublist", $data_edit, $where_edit);

		$data_stock_in = $data_edit;
		$db->query_update(
			"stock_in",
			$data_stock_in,
			"random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and invoice_no='".$db->escape($compinward_no_post)."' and insert_id='".$db->escape($sub_id)."' and ref_name='Company Inward' and stock_type='Company Inward'"
		);
		include("../company_inward/company_inward_sublist.php");
	break;

	case "DELETE_SUB":
		$del_id = $_GET['del_id'] ?? '';
		$random_no_get = $_GET['random_no'] ?? '';
		$random_sc_get = $_GET['random_sc'] ?? '';
		$compinward_no_get = $_GET['compinward_no'] ?? '';

		$data_del = [
			'delete_status' => '1',
			'sess_user_type_id' => $sess_user_type_id,
			'sess_user_id' => $sess_user_id,
			'sess_ipaddress' => $sess_ipaddress
		];
		$where_del = "random_no='".$db->escape($random_no_get)."' and random_sc='".$db->escape($random_sc_get)."' and sub_id='".$db->escape($del_id)."' and compinward_no='".$db->escape($compinward_no_get)."'";
		$db->query_update("company_inward_sublist", $data_del, $where_del);

		$db->query_update(
			"stock_in",
			$data_del,
			"random_no='".$db->escape($random_no_get)."' and random_sc='".$db->escape($random_sc_get)."' and insert_id='".$db->escape($del_id)."' and invoice_no='".$db->escape($compinward_no_get)."' and ref_name='Company Inward' and stock_type='Company Inward'"
		);
		include("../company_inward/company_inward_sublist.php");
	break;

	case "CANCEL_DELETE":
		$random_no_post = $_POST['random_no'] ?? '';
		$random_sc_post = $_POST['random_sc'] ?? '';
		$db->query_delete("company_inward_sublist", "random_no='".$db->escape($random_no_post)."' and random_sc='".$db->escape($random_sc_post)."'");
		$db->query_delete(
			"stock_in",
			"random_no='".$db->escape($random_no_post)."' and random_sc='".$db->escape($random_sc_post)."' and ref_name='Company Inward' and stock_type='Company Inward'"
		);
	break;
}
$db->close();
?>