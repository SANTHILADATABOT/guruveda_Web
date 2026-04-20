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
$cur_date = date('Y-m-d');
$random_no = $_POST['random_no'] ?? '';
$random_sc = $_POST['random_sc'] ?? '';
$distinward_no = $_POST['distinward_no'] ?? '';
$acc_year = $_POST['acc_year'] ?? '';

switch ($action) {
	case "UPDATE":
		$value = $_POST['hiddenval'] ?? '';
		$val = array_filter(explode(",", $value));
		foreach($val as $new)
		{
			$newval = explode("@@@", $new);
			$sub_id = $newval[0] ?? '';
			$qty = $newval[1] ?? '';
			$tax_amount = $newval[2] ?? '';
			$amount = $newval[3] ?? '';
			$rd_amt = $newval[4] ?? '';

			$db->query_update(
				"distributor_inward_sublist",
				[
					'approve_qty' => $qty,
					'approve_tax_amount' => $tax_amount,
					'approve_amount' => $amount,
					'approve_rd_amt' => $rd_amt
				],
				"random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and distinward_no='".$db->escape($distinward_no)."' and sub_id='".$db->escape($sub_id)."'"
			);

			$inward = $db->query_first("select * from distributor_inward_sublist where sub_id='".$db->escape($sub_id)."'") ?? [];

			$data_stock_in = [
				'entry_date' => $cur_date,
				'random_no' => $random_no,
				'random_sc' => $random_sc,
				'invoice_no' => $distinward_no,
				'ref_name' => 'Distributor Inward',
				'stock_type' => 'Distributor Inward',
				'ledger_type' => $inward['ledger_type'] ?? '',
				'ledger_id' => $inward['ledger_id'] ?? '',
				'insert_id' => $sub_id,
				'category_id' => $inward['category_id'] ?? '',
				'group_id' => $inward['group_id'] ?? '',
				'item_id' => $inward['item_id'] ?? '',
				'qty' => $qty,
				'rate' => $_POST['rate'] ?? '',
				'tax_id' => $_POST['tax_id'] ?? '',
				'tax_per' => $_POST['tax_per'] ?? '',
				'tax_amount' => $tax_amount,
				'amount' => $amount,
				'rd_amt' => $rd_amt,
				'sess_user_type_id' => $sess_user_type_id,
				'sess_user_id' => $sess_user_id,
				'sess_ipaddress' => $sess_ipaddress,
				'acc_year' => $acc_year
			];
			$db->query_insert("stock_in", $data_stock_in);
		}
		$update_id = $_GET['update_id'] ?? '';
		$db->query_update(
			"distributor_inward_main",
			[
				'approve_date' => $cur_date,
				'approve_qty' => $_POST['tot_qty'] ?? '',
				'approve_amt' => $_POST['tot_amount'] ?? '',
				'approve_status' => '1'
			],
			"random_no='".$db->escape($random_no)."' and random_sc='".$db->escape($random_sc)."' and distinward_no='".$db->escape($distinward_no)."' and distinward_id ='".$db->escape($update_id)."'"
		);
	break;
}
$db->close();
?>