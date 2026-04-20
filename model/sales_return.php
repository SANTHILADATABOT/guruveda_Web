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
$ledger_id = $_POST['ledger_id'] ?? '';
$ledger = $db->query_first("select acc_group_id from account_ledger_creation where acc_ledger_id='".$db->escape($ledger_id)."'");

function get_sales_return_model_invoice(string $acc_year): string
{
	global $db;
	$date=date("Y");
	$st_date=substr($date,2);
	$month=date("m");
	$datee=$st_date.$month;
	$sql="select max(salesreturn_no) as set_inv from sales_return_main where acc_year='".$db->escape($acc_year)."' and main_delete_status!='1'";
	$rs=$db->query($sql);
	$rscount=($rs && $rs instanceof mysqli_result) ? $rs->num_rows : 0;
	if($rscount!=0)
	{
		while($rsdata=$rs->fetch_object())
		{
			$set_inv=$rsdata->set_inv ?? '';
			$pur_array=explode('-',$set_inv);
			$inv_no=($pur_array[2] ?? 0)+1;
			$salesreturn_no='SR-'.$datee.'-'.str_pad((string)$inv_no, 4, '0', STR_PAD_LEFT);
		}
	}
	else
	{
		$inv_no=1;
		$salesreturn_no='SR-'.$datee.'-'.str_pad((string)$inv_no, 4, '0', STR_PAD_LEFT);
	}

	return $salesreturn_no;
}

$action = $_GET['action'] ?? '';
$cur_date=date('Y-m-d');

switch ($action) {
    case "SUBMIT":
		$acc_year = $_POST['acc_year'] ?? '';
		$invoice=get_sales_return_model_invoice($acc_year);
		$deliv=explode("@@", $_POST['invoice_no'] ?? '');
		$deliv_random_no = $deliv[0] ?? '';
		$deliv_random_sc = $deliv[1] ?? '';
		$deliv_no = $deliv[2] ?? '';

		$data_main = [
			'entry_date' => $_POST['entry_date'] ?? '',
			'random_no' => $_POST['random_no'] ?? '',
			'random_sc' => $_POST['random_sc'] ?? '',
			'salesreturn_no' => $invoice,
			'delivery_no' => $deliv_no,
			'delivery_random_no' => $deliv_random_no,
			'delivery_random_sc' => $deliv_random_sc,
			'distributor_id' => $_POST['distributor_id'] ?? '',
			'sub_dealer_id' => $_POST['sub_dealer_id'] ?? '',
			'total_qty' => $_POST['tot_qty'] ?? '',
			'tot_return_qty' => $_POST['tot_rqty'] ?? '',
			'total_amount' => $_POST['tot_amt'] ?? '',
			'sess_user_type_id' => $sess_user_type_id,
			'sess_user_id' => $sess_user_id,
			'sess_ipaddress' => $sess_ipaddress,
			'acc_year' => $acc_year,
			'description' => $_POST['description'] ?? ''
		];
		$insert_id=$db->query_insert("sales_return_main", $data_main);

		$db->query_update(
			"sales_order_delivery_main",
			[
				'return_status' => '1',
				'return_date' => $_POST['entry_date'] ?? '',
				'tot_return_qty' => $_POST['tot_rqty'] ?? '',
				'total_return_amount' => $_POST['tot_amt'] ?? '',
				'salesreturn_no' => $invoice,
				'return_random_no' => $_POST['random_no'] ?? '',
				'return_random_sc' => $_POST['random_sc'] ?? '',
				'return_id' => $insert_id
			],
			"random_no='".$db->escape($deliv_random_no)."' and random_sc='".$db->escape($deliv_random_sc)."' and delivery_no='".$db->escape($deliv_no)."'"
		);

		$hidden = array_filter(explode(",", $_POST['hiddenval'] ?? ''));
		foreach($hidden as $new)
		{
			$newval=explode("@@@",$new);
			$sub_id=$newval[0] ?? '';
			$qty=$newval[1] ?? '';
			$rate=$newval[2] ?? '';
			$amount=$newval[3] ?? '';
			$item_id=$newval[4] ?? '';
			$rqty=$newval[5] ?? '';
			$item=$db->query_first("select * from item_creation where item_id='".$db->escape($item_id)."'");

			$data_sub = [
				'entry_date' => $_POST['entry_date'] ?? '',
				'random_no' => $_POST['random_no'] ?? '',
				'random_sc' => $_POST['random_sc'] ?? '',
				'salesreturn_no' => $invoice,
				'distributor_id' => $_POST['distributor_id'] ?? '',
				'sub_dealer_id' => $_POST['sub_dealer_id'] ?? '',
				'category_id' => $item['category_id'] ?? '',
				'group_id' => $item['group_id'] ?? '',
				'item_id' => $item_id,
				'qty' => $qty,
				'rqty' => $rqty,
				'rate' => $rate,
				'amount' => $amount,
				'sess_user_type_id' => $sess_user_type_id,
				'sess_user_id' => $sess_user_id,
				'sess_ipaddress' => $sess_ipaddress,
				'acc_year' => $acc_year
			];
			$return_sub_id=$db->query_insert("sales_return_sublist", $data_sub);

			$db->query_update(
				"sales_order_delivery_sublist",
				[
					'return_status' => '1',
					'return_date' => $_POST['entry_date'] ?? '',
					'return_qty' => $rqty,
					'return_amount' => $amount,
					'salesreturn_no' => $invoice,
					'return_random_no' => $_POST['random_no'] ?? '',
					'return_random_sc' => $_POST['random_sc'] ?? '',
					'return_sub_id' => $return_sub_id
				],
				"random_no='".$db->escape($deliv_random_no)."' and random_sc='".$db->escape($deliv_random_sc)."' and delivery_no='".$db->escape($deliv_no)."' and sub_id='".$db->escape($sub_id)."'"
			);

			$data_stock = [
				'entry_date' => $_POST['entry_date'] ?? '',
				'random_no' => $_POST['random_no'] ?? '',
				'random_sc' => $_POST['random_sc'] ?? '',
				'invoice_no' => $invoice,
				'ref_name' => 'Distributor Inward',
				'stock_type' => 'Sales Return',
				'ledger_id' => $_POST['distributor_id'] ?? '',
				'insert_id' => $return_sub_id,
				'category_id' => $item['category_id'] ?? '',
				'group_id' => $item['group_id'] ?? '',
				'item_id' => $item_id,
				'qty' => $rqty,
				'rate' => $rate,
				'amount' => $amount,
				'sess_user_type_id' => $sess_user_type_id,
				'sess_user_id' => $sess_user_id,
				'sess_ipaddress' => $sess_ipaddress,
				'acc_year' => $acc_year
			];
			$db->query_insert("stock_in", $data_stock);
		}
	break;

	case "UPDATE":
		$deliv=explode("@@", $_POST['invoice_no'] ?? '');
		$deliv_no = $deliv[0] ?? '';
		$deliv_random_no = $deliv[1] ?? '';
		$deliv_random_sc = $deliv[2] ?? '';

		$db->query_update(
			"sales_return_main",
			[
				'entry_date' => $_POST['entry_date'] ?? '',
				'total_qty' => $_POST['tot_rqty'] ?? '',
				'total_amount' => $_POST['tot_amt'] ?? '',
				'sess_user_type_id' => $sess_user_type_id,
				'sess_user_id' => $sess_user_id,
				'sess_ipaddress' => $sess_ipaddress,
				'description' => $_POST['description'] ?? ''
			],
			"salesreturn_no='".$db->escape($_POST['salesreturn_no'] ?? '')."' and random_no='".$db->escape($_POST['random_no'] ?? '')."' and random_sc='".$db->escape($_POST['random_sc'] ?? '')."' and salesreturn_id='".$db->escape($_GET['update_id'] ?? '')."'"
		);

		$db->query_update(
			"sales_order_delivery_main",
			[
				'return_status' => '1',
				'return_date' => $_POST['entry_date'] ?? '',
				'tot_return_qty' => $_POST['tot_rqty'] ?? '',
				'total_return_amount' => $_POST['tot_amt'] ?? '',
				'salesreturn_no' => $_POST['salesreturn_no'] ?? '',
				'return_random_no' => $_POST['random_no'] ?? '',
				'return_random_sc' => $_POST['random_sc'] ?? ''
			],
			"random_no='".$db->escape($deliv_random_no)."' and random_sc='".$db->escape($deliv_random_sc)."' and delivery_no='".$db->escape($deliv_no)."'"
		);

		$hidden = array_filter(explode(",", $_POST['hiddenval'] ?? ''));
		foreach($hidden as $new)
		{
			$newval=explode("@@@",$new);
			$sub_id=$newval[0] ?? '';
			$qty=$newval[1] ?? '';
			$rate=$newval[2] ?? '';
			$amount=$newval[3] ?? '';
			$item_id=$newval[4] ?? '';
			$rqty=$newval[5] ?? '';
			$item=$db->query_first("select * from item_creation where item_id='".$db->escape($item_id)."'");

			$sales_ret=$db->query_first("select * from sales_order_delivery_sublist where sub_id='".$db->escape($sub_id)."'");
			$return_sub_id = $sales_ret['return_sub_id'] ?? '';

			$db->query_update(
				"sales_return_sublist",
				[
					'entry_date' => $_POST['entry_date'] ?? '',
					'amount' => $amount,
					'rqty' => $rqty,
					'sess_user_type_id' => $sess_user_type_id,
					'sess_user_id' => $sess_user_id,
					'sess_ipaddress' => $sess_ipaddress
				],
				"salesreturn_no='".$db->escape($_POST['salesreturn_no'] ?? '')."' and random_no='".$db->escape($_POST['random_no'] ?? '')."' and random_sc='".$db->escape($_POST['random_sc'] ?? '')."' and sub_id='".$db->escape($return_sub_id)."'"
			);

			$db->query_update(
				"sales_order_delivery_sublist",
				[
					'return_status' => '1',
					'return_date' => $_POST['entry_date'] ?? '',
					'return_qty' => $rqty,
					'return_amount' => $amount,
					'salesreturn_no' => $_POST['salesreturn_no'] ?? '',
					'return_random_no' => $_POST['random_no'] ?? '',
					'return_random_sc' => $_POST['random_sc'] ?? ''
				],
				"random_no='".$db->escape($deliv_random_no)."' and random_sc='".$db->escape($deliv_random_sc)."' and delivery_no='".$db->escape($deliv_no)."' and sub_id='".$db->escape($sub_id)."'"
			);

			$db->query_update(
				"stock_in",
				[
					'entry_date' => $_POST['entry_date'] ?? '',
					'qty' => $rqty,
					'sess_user_id' => $sess_user_id,
					'amount' => $amount,
					'sess_user_type_id' => $sess_user_type_id,
					'sess_ipaddress' => $sess_ipaddress
				],
				"random_no='".$db->escape($_POST['random_no'] ?? '')."' and random_sc='".$db->escape($_POST['random_sc'] ?? '')."' and invoice_no='".$db->escape($_POST['salesreturn_no'] ?? '')."' and insert_id='".$db->escape($sub_id)."' and ref_name='Distributor Inward'"
			);
		}
	break;

	case "DELETE":
		$get_random_no = $_GET['random_no'] ?? '';
		$get_random_sc = $_GET['random_sc'] ?? '';
		$get_salesreturn_no = $_GET['salesreturn_no'] ?? '';

		$db->query_update(
			"sales_return_main",
			['main_delete_status' => '1'],
			"random_no='".$db->escape($get_random_no)."' and random_sc='".$db->escape($get_random_sc)."' and salesreturn_id='".$db->escape($_GET['delete_id'] ?? '')."'"
		);

		$db->query_update(
			"sales_return_sublist",
			['delete_status' => '1'],
			"random_no='".$db->escape($get_random_no)."' and random_sc='".$db->escape($get_random_sc)."' and salesreturn_no='".$db->escape($get_salesreturn_no)."'"
		);

		$db->query_update(
			"stock_in",
			['delete_status' => '1'],
			"random_no='".$db->escape($get_random_no)."' and random_sc='".$db->escape($get_random_sc)."' and invoice_no='".$db->escape($get_salesreturn_no)."'"
		);

		$db->query_update(
			"sales_order_delivery_sublist",
			[
				'return_status' => '0',
				'return_sub_id' => '',
				'return_date' => '',
				'salesreturn_no' => '',
				'return_random_no' => '',
				'return_random_sc' => '',
				'return_qty' => '',
				'return_amount' => ''
			],
			"random_no='".$db->escape($_GET['delivery_random_no'] ?? '')."' and random_sc='".$db->escape($_GET['delivery_random_sc'] ?? '')."' and delivery_no='".$db->escape($_GET['delivery_no'] ?? '')."'"
		);

		$db->query_update(
			"sales_order_delivery_main",
			[
				'return_status' => '0',
				'return_date' => '',
				'salesreturn_no' => '',
				'return_id' => '',
				'return_random_no' => '',
				'return_random_sc' => '',
				'tot_return_qty' => '',
				'total_return_amount' => ''
			],
			"random_no='".$db->escape($_GET['delivery_random_no'] ?? '')."' and random_sc='".$db->escape($_GET['delivery_random_sc'] ?? '')."' and delivery_no='".$db->escape($_GET['delivery_no'] ?? '')."'"
		);

		echo "<span class=text-danger>Deleted</span>";
	break;
}
$db->close();
?>