<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
ob_start();
session_start();

require("config.inc.php"); 
require("Database.class.php"); 
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect(); 
$sess_user_type_id=$_SESSION['sess_user_type_id'];
$sess_user_id=$_SESSION['sess_user_id'];
$sess_ipaddress=$_SESSION['sess_ipaddress'];

$item=$db->fetch_array($db->query("select * from item_creation where item_id='$_POST[item_id]'"));

//Invoice
function get_sales_delivery_model_sales_invoice($acc_year)
{
	global $db;
	$date=date("Y");
	$st_date=substr($date,2);
	$month=date("m");	   
	$datee=$st_date.$month;
	$sql="select max(delivery_no) as set_inv from sales_order_delivery_main where acc_year='$acc_year' and main_delete_status!='1'";
	$rs=$db->query($sql);
	$rscount=($rs && $rs instanceof mysqli_result) ? $rs->num_rows : 0;
	if($rscount!=0)
	{
		while($rsdata=$rs->fetch_object())
		{			
			$set_inv=$rsdata->set_inv;
			$pur_array=explode('-',$set_inv);
			$inv_no=$pur_array[2]+1;
			$delivery_no='SDE-'.$datee.'-'.str_pad($inv_no, 4, '0', STR_PAD_LEFT);
		}
	}
	else
	{
		$inv_no=0001;
		$delivery_no='SDE-'.$datee.'-'.$inv_no;
	}
	
	return $delivery_no;
}

$action = $_GET['action'];
$cur_date=date('Y-m-d');

switch ($action) {
  case "SUBMIT":
		$delivery_no=get_sales_delivery_model_sales_invoice($_POST[acc_year]);
		$salesno=explode("@@",$_POST['salesorder_no']);

		$Insql=$db->query("insert into sales_order_delivery_main(entry_date,random_no,random_sc,delivery_no,stock_type,cust_type,distributor_id,ledger_id,
		total_qty,total_amount,description,sess_user_type_id,sess_user_id,sess_ipaddress,acc_year)values
		('$_POST[entry_date]','$_POST[random_no]','$_POST[random_sc]','$delivery_no','$_POST[sales_type]','$_POST[cust_type]','$_POST[distributor_id]',
		'$_POST[ledger_id]','$_POST[total_qty]','$_POST[total_amount]','$_POST[description]','$sess_user_type_id','$sess_user_id','$sess_ipaddress',
		'$_POST[acc_year]')");

		$Insql=$db->query("update sales_order_delivery_sublist set delivery_no='$delivery_no',entry_date='$_POST[entry_date]',stock_type='$_POST[stock_type]',
		cust_type='$_POST[cust_type]',distributor_id='$_POST[distributor_id]',sess_user_type_id='$sess_user_type_id',ledger_id='$_POST[ledger_id]',
		sess_user_id='$sess_user_id',sess_ipaddress='$sess_ipaddress' where random_no='$_POST[random_no]' and random_sc='$_POST[random_sc]'");

		$Insql=$db->query("update stock_out set delivery_no='$delivery_no',entry_date='$_POST[entry_date]',ledger_type='$_POST[stock_type]',
		ledger_id='$_POST[distributor_id]',sess_user_id='$sess_user_id',sess_ipaddress='$sess_ipaddress',sess_user_type_id='$sess_user_type_id' where 
		random_no='$_POST[random_no]' and random_sc='$_POST[random_sc]' and ref_name='Distributor Inward' and stock_type='Sales Delivery'");		
	break;

	case "UPDATE":		 
	  	$salesno=explode("@@",$_POST['salesorder_no']);
		$Insql=$db->query("update sales_order_delivery_main set entry_date='$_POST[entry_date]',total_amount='$_POST[total_amount]',
		total_qty='$_POST[total_qty]',sess_user_type_id='$sess_user_type_id',sess_user_id='$sess_user_id',sess_ipaddress='$sess_ipaddress' where 
		random_no='$_POST[random_no]' and random_sc='$_POST[random_sc]' and delivery_no='$_POST[delivery_no]' and delivery_id ='$_GET[update_id]'");

		$Insql=$db->query("update sales_order_delivery_sublist set entry_date='$_POST[entry_date]',stock_type='$_POST[stock_type]',
		cust_type='$_POST[cust_type]',distributor_id='$_POST[distributor_id]',sess_user_type_id='$sess_user_type_id',ledger_id='$_POST[ledger_id]',
		sess_user_id='$sess_user_id',sess_ipaddress='$sess_ipaddress' where random_no='$_POST[random_no]' and random_sc='$_POST[random_sc]' and 
		delivery_no='$_POST[delivery_no]'");

		$Insql=$db->query("update stock_out set entry_date='$_POST[entry_date]',ledger_type='$_POST[stock_type]',ledger_id='$_POST[distributor_id]',
		sess_user_id='$sess_user_id',sess_ipaddress='$sess_ipaddress',sess_user_type_id='$sess_user_type_id' where  random_no='$_POST[random_no]' and 
		random_sc='$_POST[random_sc]' and delivery_no='$_POST[delivery_no]' and ref_name='Distributor Inward' and stock_type='Sales Delivery'");
	break;

	case "DELETE":
		$Insql=$db->query("update sales_order_delivery_main set main_delete_status='1' where random_no='$_GET[random_no]' and random_sc='$_GET[random_sc]' 
		and delivery_id='$_GET[delete_id]'");

		$sql=$db->query("select * from sales_order_delivery_sublist where random_no='$_GET[random_no]' and random_sc='$_GET[random_sc]' and 
		delivery_no='$_GET[delivery_no]' and delete_status!='1' order by sub_id ASC");
        while($row=$db->fetch_array($sql))
		{
			$order=$db->fetch_array($db->query("select delivery_qty as qty from sales_order_sublist where sub_id='$row[sales_sub_id]' and 
			salesorder_no='$row[salesorder_no]' and random_no='$row[sales_random_no]' and random_sc='$row[sales_random_sc]'"));

			$bal_qty=$order[delivery_qty]-$row[qty];

			$Insql=$db->query("update sales_order_sublist set delivery_qty='$sal[qty]',delivery_status='0',delivery_date='' where 
			sub_id='$row[sales_sub_id]' and salesorder_no='$row[salesorder_no]' and random_no='$row[sales_random_no]' and random_sc='$row[sales_random_sc]'");

			$Insql=$db->query("update sales_order_main set delivery_status='0',delivery_date='' where salesorder_no='$row[salesorder_no]' and 
			random_no='$row[sales_random_no]' and random_sc='$row[sales_random_sc]'");
		}

		$Insql=$db->query("update sales_order_delivery_sublist set delete_status='1' where random_no='$_GET[random_no]' and random_sc='$_GET[random_sc]' 
		and delivery_no='$_GET[delivery_no]'");

		$Insql=$db->query("update stock_out set delete_status='1',sess_user_type_id='$sess_user_type_id',sess_user_id='$sess_user_id',
		sess_ipaddress='$sess_ipaddress' where random_no='$_GET[random_no]' and random_sc='$_GET[random_sc]' and 
		invoice_no='$_GET[delivery_no]'");
	break;

	case "ADD":
	 	$salesno=explode("@@",$_POST['salesorder_no']);
		$Insql=$db->query("insert into sales_order_delivery_sublist (entry_date,random_no,random_sc,delivery_no,sales_type,salesorder_no,sales_random_no,
		sales_random_sc,stock_type,cust_type,distributor_id,ledger_id,category_id,group_id,item_id,stock,qty,rate,tax_id,tax_per,tax_amount,amount,rd_amt,
		sess_user_type_id,sess_user_id,sess_ipaddress,acc_year)values
		('$_POST[entry_date]','$_POST[random_no]','$_POST[random_sc]','$_POST[delivery_no]','$_POST[sales_type]','$salesno[2]','$salesno[0]','$salesno[1]',
		'$_POST[stock_type]','$_POST[cust_type]','$_POST[distributor_id]','$_POST[ledger_id]','$item[category_id]','$item[group_id]','$_POST[item_id]',
		'$_POST[stock]','$_POST[qty]','$_POST[rate]','$_POST[tax_id]','$_POST[tax_per]','$_POST[tax_amount]',
		'$_POST[amount]','$_POST[rd_amt]','$sess_user_type_id','$sess_user_id','$sess_ipaddress','$_POST[acc_year]')");
		$insert_id=$db->link_id->insert_id;
		
		//if($_POST['stock_type']=='Distributor'){ $ref_name='Distributor Inward';} else if($_POST['stock_type']=='Company'){ $ref_name='Company Inward';}
		
		$Insql=$db->query("insert into stock_out(insert_id,entry_date,random_no,random_sc,invoice_no,distributor_id,ledger_id,sales_type,category_id,
		group_id,item_id,qty,rate,tax_id,tax_per,tax_amount,amount,rd_amt,sess_user_type_id,sess_user_id,sess_ipaddress,acc_year,ref_name,stock_type)values
		('$insert_id','$_POST[entry_date]','$_POST[random_no]','$_POST[random_sc]','$_POST[delivery_no]','$_POST[distributor_id]','$_POST[ledger_id]',
		'$_POST[sales_type]','$item[category_id]','$item[group_id]','$_POST[item_id]','$_POST[qty]','$_POST[rate]','$_POST[tax_id]','$_POST[tax_per]',
		'$_POST[tax_amount]','$_POST[amount]','$_POST[rd_amt]','$sess_user_type_id','$sess_user_id','$sess_ipaddress','$_POST[acc_year]','Distributor Inward',
		'Sales Delivery')");

		include("../sales_order_delivery/sales_order_delivery_sublist.php");
	break;

	case "EDIT":
		$Insql=$db->query("update sales_order_delivery_sublist set entry_date='$_POST[entry_date]',stock_type='$_POST[stock_type]',tax_id='$_POST[tax_id]',
		cust_type='$_POST[cust_type]',distributor_id='$_POST[distributor_id]',sess_user_type_id='$sess_user_type_id',ledger_id='$_POST[ledger_id]',
		category_id='$item[category_id]',group_id='$item[group_id]',item_id='$_POST[item_id]',tax_amount='$_POST[tax_amount]',stock='$_POST[stock]',
		qty='$_POST[qty]',rate='$_POST[rate]',tax_per='$_POST[tax_per]',amount='$_POST[amount]',sess_user_id='$sess_user_id',rd_amt='$_POST[rd_amt]',
		sess_ipaddress='$sess_ipaddress' where random_no='$_POST[random_no]' and random_sc='$_POST[random_sc]' and delivery_no='$_POST[delivery_no]' and 
		sub_id='$_GET[sub_id]'");

		//if($_POST['stock_type']=='Distributor'){ $ref_name='Distributor Inward';} else if($_POST['stock_type']=='Company'){ $ref_name='Company Inward';}

		$Insql=$db->query("update stock_out set entry_date='$_POST[entry_date]',ledger_type='$_POST[stock_type]',ledger_id='$_POST[distributor_id]',
		category_id='$item[category_id]',group_id='$item[group_id]',item_id='$_POST[item_id]',qty='$_POST[qty]',rate='$_POST[rate]',tax_id='$_POST[tax_id]',
		tax_per='$_POST[tax_per]',tax_amount='$_POST[tax_amount]',amount='$_POST[amount]',sess_user_id='$sess_user_id',sess_ipaddress='$sess_ipaddress',
		rd_amt='$_POST[rd_amt]',sess_user_type_id='$sess_user_type_id' where random_no='$_POST[random_no]' and random_sc='$_POST[random_sc]' and 
		invoice_no='$_POST[delivery_no]' and insert_id='$_GET[sub_id]' and ref_name='Distributor Inward' and stock_type='Sales Delivery'");

		$delivery=$db->fetch_array($db->query("select * from sales_order_delivery_sublist where sub_id='$_GET[sub_id]' and random_no='$_POST[random_no]' and 
		random_sc='$_POST[random_sc]' and delivery_no='$_POST[delivery_no]' and delete_status!='1'"));
		if($delivery[sales_type]=="WITH SO")
		{
			$sal=$db->fetch_array($db->query("select sum(qty) as qty from sales_order_delivery_sublist where salesorder_no='$delivery[salesorder_no]' and 
			sales_random_no='$delivery[sales_random_no]' and sales_random_sc='$delivery[sales_random_sc]' and sales_sub_id='$delivery[sales_sub_id]' and 
			delete_status!='1'"));

			$Insql=$db->query("update sales_order_sublist set delivery_qty='$sal[qty]' where salesorder_no='$delivery[salesorder_no]' and 
			random_no='$delivery[sales_random_no]' and random_sc='$delivery[sales_random_sc]' and sub_id='$delivery[sales_sub_id]'");

			$order=$db->fetch_array($db->query("select qty from sales_order_sublist where sub_id='$delivery[sales_sub_id]' and delete_status!='1' and 
			salesorder_no='$delivery[salesorder_no]' and random_no='$delivery[sales_random_no]' and random_sc='$delivery[sales_random_sc]'"));

			if($order[qty]==$sal[qty])
			{
				$Insql=$db->query("update sales_order_sublist set delivery_status='1',delivery_date='$_POST[entry_date]' where 
				sub_id='$delivery[sales_sub_id]' and salesorder_no='$delivery[salesorder_no]' and random_no='$delivery[sales_random_no]' and 
				random_sc='$delivery[sales_random_sc]'");
			}
			else
			{
				$Insql=$db->query("update sales_order_sublist set delivery_status='0',delivery_date='' where 
				sub_id='$delivery[sales_sub_id]' and salesorder_no='$delivery[salesorder_no]' and random_no='$delivery[sales_random_no]' and 
				random_sc='$delivery[sales_random_sc]'");
			}
			$del=$db->fetch_array($db->query("select sum(qty) as qty from sales_order_delivery_sublist where salesorder_no='$delivery[salesorder_no]' and 
			sales_random_no='$delivery[sales_random_no]' and sales_random_sc='$delivery[sales_random_sc]' and delete_status!='1'"));

			$main=$db->fetch_array($db->query("select total_qty from sales_order_main where salesorder_no='$delivery[salesorder_no]' and 
			random_no='$delivery[sales_random_no]' and random_sc='$delivery[sales_random_sc]' and main_delete_status!='1'"));

			if($del[qty]==$main[total_qty])
			{
				$Insql=$db->query("update sales_order_main set delivery_status='1',delivery_date='$_POST[entry_date]' where 
				salesorder_no='$delivery[salesorder_no]' and random_no='$delivery[sales_random_no]' and random_sc='$delivery[sales_random_sc]'");
			}
			else
			{
				$Insql=$db->query("update sales_order_main set delivery_status='0',delivery_date='' where salesorder_no='$delivery[salesorder_no]' and 
				random_no='$delivery[sales_random_no]' and random_sc='$delivery[sales_random_sc]'");
			}
		}

		$_GET[sub_id]="";

		include("../sales_order_delivery/sales_order_delivery_sublist.php");
	break;

	case "DELETE_SUB":
		$Insql=$db->query("update sales_order_delivery_sublist set delete_status='1',sess_user_type_id='$sess_user_type_id',sess_user_id='$sess_user_id',
		sess_ipaddress='$sess_ipaddress' where random_no='$_GET[random_no]' and random_sc='$_GET[random_sc]' and sub_id='$_GET[del_id]' and 
		delivery_no='$_GET[delivery_no]'");

		$Insql=$db->query("update stock_out set delete_status='1',sess_user_type_id='$sess_user_type_id',sess_user_id='$sess_user_id',
		sess_ipaddress='$sess_ipaddress' where random_no='$_GET[random_no]' and random_sc='$_GET[random_sc]' and insert_id='$_GET[del_id]' and 
		invoice_no='$_GET[delivery_no]' and ref_name='Distributor Inward' and stock_type='Sales Delivery'");

		$delivery=$db->fetch_array($db->query("select * from sales_order_delivery_sublist where sub_id='$_GET[del_id]' and random_no='$_GET[random_no]' and 
		random_sc='$_GET[random_sc]' and delivery_no='$_GET[delivery_no]'"));
		if($delivery[sales_type]=="WITH SO")
		{
			$order=$db->fetch_array($db->query("select delivery_qty from sales_order_sublist where sub_id='$delivery[sales_sub_id]' and 
			salesorder_no='$delivery[salesorder_no]' and random_no='$delivery[sales_random_no]' and random_sc='$delivery[sales_random_sc]'"));

			$update_qty = $order[delivery_qty]-$delivery[qty];

			$Insql=$db->query("update sales_order_sublist set delivery_status='0',delivery_date='',delivery_qty='$update_qty' where 
			sub_id='$delivery[sales_sub_id]' and salesorder_no='$delivery[salesorder_no]' and random_no='$delivery[sales_random_no]' and 
			random_sc='$delivery[sales_random_sc]'");

			$Insql=$db->query("update sales_order_main set delivery_status='0',delivery_date='' where salesorder_no='$delivery[salesorder_no]' and 
			random_no='$delivery[sales_random_no]' and random_sc='$delivery[sales_random_sc]'");
		}

		include("../sales_order_delivery/sales_order_delivery_sublist.php");
	break;
	
	case "WITHSO_ADD":
		$salesno=explode("@@",$_POST['salesorder_no']);
		$value=$_POST['hiddenval'];
		$val=explode(",",$value);
		foreach($val as $new)
		{
			$newval=explode("@@@",$new);
			$sample_val=$sub_id."@@@".$qty."@@@".$tax_amount."@@@".$amount."@@@".$rd_amt;
			$sub_id=$newval[0];
			$qty=$newval[1];
			$tax_amount=$newval[2];
			$amount=$newval[3];
			$rd_amt=$newval[4];
			$order=$db->fetch_array($db->query("select * from sales_order_sublist where sub_id='$sub_id'"));

			$Insql=$db->query("insert into sales_order_delivery_sublist(entry_date,random_no,random_sc,delivery_no,stock_type,cust_type,sales_type,
			salesorder_no,sales_random_no,sales_random_sc,sales_sub_id,distributor_id,ledger_id,category_id,group_id,item_id,qty,rate,tax_id,tax_per,
			tax_amount,amount,rd_amt,sess_user_type_id,sess_user_id,sess_ipaddress,acc_year)values
			('$_POST[entry_date]','$_POST[random_no]','$_POST[random_sc]','$_POST[delivery_no]','$_POST[stock_type]','$_POST[cust_type]','$_POST[sales_type]',
			'$salesno[2]','$salesno[0]','$salesno[1]','$sub_id','$_POST[distributor_id]','$_POST[ledger_id]','$order[category_id]','$order[group_id]',
			'$order[item_id]','$qty','$order[rate]','$order[tax_id]','$order[tax_per]','$tax_amount','$amount','$rd_amt','$sess_user_type_id',
			'$sess_user_id','$sess_ipaddress','$_POST[acc_year]')");

			$insert_id=$db->link_id->insert_id;
				
			//if($_POST['stock_type']=='Distributor'){ $ref_name='Distributor Inward';} else if($_POST['stock_type']=='Company'){ $ref_name='Company Inward';}

			$Insql=$db->query("insert into stock_out(insert_id,entry_date,random_no,random_sc,invoice_no,ledger_type,ledger_id,category_id,group_id,
			item_id,qty,rate,tax_id,tax_per,tax_amount,amount,rd_amt,sess_user_type_id,sess_user_id,sess_ipaddress,acc_year,ref_name,stock_type)values
			('$insert_id','$_POST[entry_date]','$_POST[random_no]','$_POST[random_sc]','$_POST[delivery_no]','$_POST[stock_type]','$_POST[distributor_id]',
			'$order[category_id]','$order[group_id]','$order[item_id]','$qty','$order[rate]','$order[tax_id]','$order[tax_per]','$tax_amount','$amount',
			'$rd_amt','$sess_user_type_id','$sess_user_id','$sess_ipaddress','$_POST[acc_year]','Distributor Inward','Sales Delivery')");

			$update_qty=$order[delivery_qty]+$qty;

			$Insql=$db->query("update sales_order_sublist set delivery_qty='$update_qty' where sub_id='$sub_id' and salesorder_no='$salesno[2]' and 
			random_no='$salesno[0]' and random_sc='$salesno[1]'");

			$delivery=$db->fetch_array($db->query("select sum(qty) as delivery_qty from sales_order_delivery_sublist where sales_sub_id='$sub_id' and 
			salesorder_no='$salesno[2]' and sales_random_no='$salesno[0]' and sales_random_sc='$salesno[1]' and delete_status!='1'"));

			if($delivery[delivery_qty]==$order[qty])
			{
				$Insql=$db->query("update sales_order_sublist set delivery_status='1',delivery_date='$_POST[entry_date]' where sub_id='$sub_id' and 
				salesorder_no='$salesno[2]' and random_no='$salesno[0]' and random_sc='$salesno[1]'");
			}

			$order_main=$db->fetch_array($db->query("select total_qty from sales_order_main where salesorder_no='$salesno[2]' and 
			random_no='$salesno[0]' and random_sc='$salesno[1]'"));
			$del_main=$db->fetch_array($db->query("select sum(qty) as del_qty from sales_order_delivery_sublist where salesorder_no='$salesno[2]' and 
			sales_random_no='$salesno[0]' and sales_random_sc='$salesno[1]' and delete_status!='1'"));

			if($del_main[del_qty]==$order_main[total_qty])
			{
				$Insql=$db->query("update sales_order_main set delivery_status='1',delivery_date='$_POST[entry_date]' where salesorder_no='$salesno[2]' and 
				random_no='$salesno[0]' and random_sc='$salesno[1]'");
			}
		}
		include("../sales_order_delivery/sales_order_delivery_sublist.php");
	break;
}
$db->close();
?>
