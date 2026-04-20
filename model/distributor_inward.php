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
function get_distributor_inward_model_sales_invoice(string $acc_year): string
{
	global $db;
	$date = date("Y");
	$st_date = substr($date, 2);
	$month = date("m");
	$datee = $st_date.$month;
	$sql = "select max(distinward_no) as set_inv from distributor_inward_main where acc_year='".$db->escape($acc_year)."' and main_delete_status!='1'";
	$rs = $db->query($sql);
	$distinward_no = '';
	if ($rs && $rs instanceof mysqli_result && $rs->num_rows !== 0)
	{
		while($rsdata = $rs->fetch_object())
		{
			$set_inv = $rsdata->set_inv ?? '';
			$pur_array = explode('-', $set_inv);
			$inv_no = ($pur_array[2] ?? 0) + 1;
			$distinward_no = 'DIN-'.$datee.'-'.str_pad((string)$inv_no, 4, '0', STR_PAD_LEFT);
		}
	}
	else
	{
		$inv_no = 1;
		$distinward_no = 'DIN-'.$datee.'-'.str_pad((string)$inv_no, 4, '0', STR_PAD_LEFT);
	}
	return $distinward_no;
}

$action = $_GET['action'] ?? '';
$cur_date = date('Y-m-d');
$random_no = $_POST['random_no'] ?? '';
$random_sc = $_POST['random_sc'] ?? '';
$ledger_type = $_POST['ledger_type'] ?? '';
$ledger_id = $_POST['ledger_id'] ?? '';
$distinward_no_post = $_POST['distinward_no'] ?? '';
$acc_year = $_POST['acc_year'] ?? '';

switch ($action) {
    case "SUBMIT":
		$distinward_no = get_distributor_inward_model_sales_invoice($acc_year);

		$data_main = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'random_no' => $random_no,
			'random_sc' => $random_sc,
			'distinward_no' => $distinward_no,
			'ledger_type' => $ledger_type,
			'ledger_id' => $ledger_id,
			'total_qty' => $_POST['total_qty'] ?? '',
			'total_amount' => $_POST['total_amount'] ?? '',
			'sess_user_type_id' => $sess_user_type_id,
			'sess_user_id' => $sess_user_id,
			'sess_ipaddress' => $sess_ipaddress,
			'acc_year' => $acc_year
		];
		$db->query_insert("distributor_inward_main", $data_main);

		$data_sub = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'ledger_id' => $ledger_id,
			'distinward_no' => $distinward_no,
			'ledger_type' => $ledger_type
		];
		$db->query_update("distributor_inward_sublist", $data_sub, "random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."'");

		$data_stock_out = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'ledger_id' => $ledger_id,
			'invoice_no' => $distinward_no,
			'ledger_type' => $ledger_type
		];
		$db->query_update(
			"stock_out",
			$data_stock_out,
			"random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and ref_name='Company Inward' and stock_type='Distributor Inward'"
		);
	break;

	case "UPDATE":
		$update_id = $_GET['update_id'] ?? '';
		$data_main = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'ledger_id' => $ledger_id,
			'total_qty' => $_POST['total_qty'] ?? '',
			'sess_user_id' => $sess_user_id,
			'total_amount' => $_POST['total_amount'] ?? '',
			'sess_user_type_id' => $sess_user_type_id,
			'sess_ipaddress' => $sess_ipaddress,
			'ledger_type' => $ledger_type
		];
		$where_main = "random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and distinward_no='".$db->escape($distinward_no_post)."' and distinward_id ='".$db->escape($update_id)."'";
		$db->query_update("distributor_inward_main", $data_main, $where_main);

		$data_sub = [
			'ledger_id' => $ledger_id,
			'entry_date' => $_POST['entry_date'] ?? '',
			'ledger_type' => $ledger_type
		];
		$where_sub = "random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and distinward_no='".$db->escape($distinward_no_post)."'";
		$db->query_update("distributor_inward_sublist", $data_sub, $where_sub);

		$db->query_update(
			"stock_out",
			$data_sub,
			"ref_name='Company Inward' and random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and invoice_no='".$db->escape($distinward_no_post)."' and stock_type='Distributor Inward'"
		);
	break;

	case "DELETE":
		$delete_id = $_GET['delete_id'] ?? '';
		$random_no_get = $_GET['random_no'] ?? '';
		$random_sc_get = $_GET['random_sc'] ?? '';
		$distinward_no_get = $_GET['distinward_no'] ?? '';

		$db->query_update(
			"distributor_inward_main",
			['main_delete_status' => '1'],
			"random_no='".$db->escape($random_no_get)."' and random_sc='".$db->escape($random_sc_get)."' and distinward_id='".$db->escape($delete_id)."'"
		);

		$db->query_update(
			"distributor_inward_sublist",
			['delete_status' => '1'],
			"random_no='".$db->escape($random_no_get)."' and random_sc='".$db->escape($random_sc_get)."' and distinward_no='".$db->escape($distinward_no_get)."'"
		);

		$db->query_update(
			"stock_out",
			['delete_status' => '1'],
			"random_no='".$db->escape($random_no_get)."' and random_sc='".$db->escape($random_sc_get)."' and invoice_no='".$db->escape($distinward_no_get)."' and ref_name='Company Inward' and stock_type='Distributor Inward'"
		);
	break;

	case "ADD":
		$data_sub_insert = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'random_no' => $random_no,
			'random_sc' => $random_sc,
			'distinward_no' => $distinward_no_post,
			'ledger_type' => $ledger_type,
			'ledger_id' => $ledger_id,
			'category_id' => $item['category_id'] ?? '',
			'group_id' => $item['group_id'] ?? '',
			'item_id' => $_POST['item_id'] ?? '',
			'stock' => $_POST['stock'] ?? '',
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
		$insert_id = $db->query_insert("distributor_inward_sublist", $data_sub_insert);

		$data_stock_out = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'random_no' => $random_no,
			'random_sc' => $random_sc,
			'invoice_no' => $distinward_no_post,
			'ref_name' => 'Company Inward',
			'stock_type' => 'Distributor Inward',
			'ledger_type' => $ledger_type,
			'ledger_id' => $ledger_id,
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
			'sess_user_type_id' => $sess_user_type_id,
			'sess_user_id' => $sess_user_id,
			'sess_ipaddress' => $sess_ipaddress,
			'acc_year' => $acc_year
		];
		$db->query_insert("stock_out", $data_stock_out);

		include("../distributor_inward/distributor_inward_sublist.php");
	break;

	case "EDIT":
		$sub_id = $_GET['sub_id'] ?? '';
		$data_edit = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'ledger_id' => $item['ledger_id'] ?? '',
			'rate' => $_POST['rate'] ?? '',
			'category_id' => $item['category_id'] ?? '',
			'group_id' => $item['group_id'] ?? '',
			'item_id' => $_POST['item_id'] ?? '',
			'stock' => $_POST['stock'] ?? '',
			'sess_user_type_id' => $sess_user_type_id,
			'sess_user_id' => $sess_user_id,
			'qty' => $_POST['qty'] ?? '',
			'sess_ipaddress' => $sess_ipaddress,
			'tax_id' => $_POST['tax_id'] ?? '',
			'tax_per' => $_POST['tax_per'] ?? '',
			'tax_amount' => $_POST['tax_amount'] ?? '',
			'amount' => $_POST['amount'] ?? '',
			'rd_amt' => $_POST['rd_amt'] ?? '',
			'ledger_type' => $ledger_type
		];
		$where_edit = "random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and distinward_no='".$db->escape($distinward_no_post)."' and sub_id='".$db->escape($sub_id)."'";
		$db->query_update("distributor_inward_sublist", $data_edit, $where_edit);

		$data_stock_out = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'ledger_id' => $ledger_id,
			'category_id' => $item['category_id'] ?? '',
			'group_id' => $item['group_id'] ?? '',
			'item_id' => $_POST['item_id'] ?? '',
			'qty' => $_POST['qty'] ?? '',
			'rate' => $_POST['rate'] ?? '',
			'sess_user_id' => $sess_user_id,
			'tax_id' => $_POST['tax_id'] ?? '',
			'tax_per' => $_POST['tax_per'] ?? '',
			'tax_amount' => $_POST['tax_amount'] ?? '',
			'amount' => $_POST['amount'] ?? '',
			'rd_amt' => $_POST['rd_amt'] ?? '',
			'sess_user_type_id' => $sess_user_type_id,
			'sess_ipaddress' => $sess_ipaddress,
			'ledger_type' => $ledger_type
		];
		$where_stock_out = "random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and invoice_no='".$db->escape($distinward_no_post)."' and insert_id='".$db->escape($sub_id)."' and ref_name='Company Inward' and stock_type='Distributor Inward'";
		$db->query_update("stock_out", $data_stock_out, $where_stock_out);

		include("../distributor_inward/distributor_inward_sublist.php");
	break;

	case "DELETE_SUB":
		$del_id = $_GET['del_id'] ?? '';
		$random_no_get = $_GET['random_no'] ?? '';
		$random_sc_get = $_GET['random_sc'] ?? '';
		$distinward_no_get = $_GET['distinward_no'] ?? '';

		$data_del = [
			'delete_status' => '1',
			'sess_user_type_id' => $sess_user_type_id,
			'sess_user_id' => $sess_user_id,
			'sess_ipaddress' => $sess_ipaddress
		];
		$where_del = "random_no='".$db->escape($random_no_get)."' and random_sc='".$db->escape($random_sc_get)."' and sub_id='".$db->escape($del_id)."' and distinward_no='".$db->escape($distinward_no_get)."'";
		$db->query_update("distributor_inward_sublist", $data_del, $where_del);

		$db->query_update(
			"stock_out",
			$data_del,
			"random_no='".$db->escape($random_no_get)."' and random_sc='".$db->escape($random_sc_get)."' and insert_id='".$db->escape($del_id)."' and invoice_no='".$db->escape($distinward_no_get)."' and ref_name='Company Inward' and stock_type='Distributor Inward'"
		);
		include("../distributor_inward/distributor_inward_sublist.php");
	break;

	case "CANCEL_DELETE":
		$random_no_post = $_POST['random_no'] ?? '';
		$random_sc_post = $_POST['random_sc'] ?? '';
		$db->query_delete("distributor_inward_sublist", "random_no='".$db->escape($random_no_post)."' and random_sc='".$db->escape($random_sc_post)."'");

		$db->query_delete(
			"stock_out",
			"random_no='".$db->escape($random_no_post)."' and random_sc='".$db->escape($random_sc_post)."' and ref_name='Company Inward' and stock_type='Distributor Inward'"
		);
	break;
}
$db->close();
?>