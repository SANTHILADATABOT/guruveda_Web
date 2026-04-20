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

function get_user_permission_user_id($user_name)
{
	global $db;
	$sql_user = "select * from user_type where user_type='".$db->escape($user_name)."'";
	$rs_user = $db->query($sql_user);
	$user_type_id = '';
	if($rs_user && $rs_user instanceof mysqli_result) {
		while($rsdata = $rs_user->fetch_object())
		{  
			$user_type_id = $rsdata->user_type_id ?? '';
		}
	}
	return $user_type_id;
} 

$action = $_GET['action'] ?? '';
$delete_id = $_GET['delete_id'] ?? '';
$table1 = "user_permissions";
$table2 = "user_permission_main";

$user_name = $_POST['user_name'] ?? '';
$user_id = get_user_permission_user_id($user_name);

$create_date=date('Y-m-d');

$dashboard_ent = $_POST['dashboard_ent'] ?? '';
$admin_ent = $_POST['admin_ent'] ?? '';
$master_ent = $_POST['master_ent'] ?? '';
$inward_ent = $_POST['inward_ent'] ?? '';
$sales_ent = $_POST['sales_ent'] ?? '';
$reports_ent = $_POST['reports_ent'] ?? '';
$backup_ent = $_POST['backup_ent'] ?? '';
$others_ent = $_POST['others_ent'] ?? '';

function get_checks_permis_permis($user_name, $val)
{
	global $db;
	$sql_user = "select * from user_permissions where box_name='".$db->escape($val)."' and user_type_id='".$db->escape($user_name)."'";
	$rs_user = $db->query($sql_user);
	$rs_count = ($rs_user && $rs_user instanceof mysqli_result) ? $rs_user->num_rows : 0;
	return $rs_count;
} 

function get_checks_permis_permis_data($user_name)
{
	global $db;
	$sql_user = "select * from user_permission_main where user_name='".$db->escape($user_name)."'";
	$rs_user = $db->query($sql_user);
	$rs_count = ($rs_user && $rs_user instanceof mysqli_result) ? $rs_user->num_rows : 0;
	return $rs_count;
}
/********************************** ADD QUERY ***************************************/
switch ($action) {
	case "Add":
		$data_upd = ['permission' => '0'];
		$db->query_update("user_permissions", $data_upd, "user_type_id='".$db->escape($user_name)."'");
		
		if(($dashboard_ent!=''))
		{
			$dashboard_ent_exp=explode(",",$dashboard_ent);
			foreach($dashboard_ent_exp as $val)
			{
				$check=get_checks_permis_permis($user_name,$val);
				if($check=='0')
				{
					$data = [
						'user_type_id' => $user_name,
						'box_name' => $val,
						'form_id' => '1',
						'permission' => '1',
						'entry_date' => $create_date,
						'user_id' => $user_id,
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_insert("user_permissions", $data);
				}
				else
				{
					$data = [
						'permission' => '1',
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_update("user_permissions", $data, "user_type_id='".$db->escape($user_name)."' and box_name='".$db->escape($val)."' and form_id='1'");
				}
			}
		}

		if(($admin_ent!=''))
		{ 
			$admin_ent_exp=explode(",",$admin_ent);
			foreach($admin_ent_exp as $val)
			{
				$check=get_checks_permis_permis($user_name,$val);
				if($check=='0')
				{
					$data = [
						'user_type_id' => $user_name,
						'box_name' => $val,
						'form_id' => '2',
						'permission' => '1',
						'entry_date' => $create_date,
						'user_id' => $user_id,
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_insert("user_permissions", $data);
				}
				else
				{
					$data = [
						'permission' => '1',
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_update("user_permissions", $data, "user_type_id='".$db->escape($user_name)."' and box_name='".$db->escape($val)."' and form_id='2'");
				}
			}
		}

		if(($master_ent!=''))
		{
			$master_ent_exp=explode(",",$master_ent);
			foreach($master_ent_exp as $val)
			{
				$check=get_checks_permis_permis($user_name,$val);
				if($check=='0')
				{
					$data = [
						'user_type_id' => $user_name,
						'box_name' => $val,
						'form_id' => '3',
						'permission' => '1',
						'entry_date' => $create_date,
						'user_id' => $user_id,
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_insert("user_permissions", $data);
				}
				else
				{
					$data = [
						'permission' => '1',
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_update("user_permissions", $data, "user_type_id='".$db->escape($user_name)."' and box_name='".$db->escape($val)."' and form_id='3'");
				}
			}
		}

		if(($inward_ent!=''))
		{
			$inward_ent_exp=explode(",",$inward_ent);
			foreach($inward_ent_exp as $val)
			{
				 $check=get_checks_permis_permis($user_name,$val);
				if($check=='0')
				{
					$data = [
						'user_type_id' => $user_name,
						'box_name' => $val,
						'form_id' => '4',
						'permission' => '1',
						'entry_date' => $create_date,
						'user_id' => $user_id,
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_insert("user_permissions", $data);
				}
				else
				{
					$data = [
						'permission' => '1',
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_update("user_permissions", $data, "user_type_id='".$db->escape($user_name)."' and box_name='".$db->escape($val)."' and form_id='4'");
				}
			}
		}

		if(($sales_ent!=''))
		{
			$sales_ent_exp=explode(",",$sales_ent);
			foreach($sales_ent_exp as $val)
			{
				 $check=get_checks_permis_permis($user_name,$val);
				if($check=='0')
				{
					$data = [
						'user_type_id' => $user_name,
						'box_name' => $val,
						'form_id' => '5',
						'permission' => '1',
						'entry_date' => $create_date,
						'user_id' => $user_id,
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_insert("user_permissions", $data);
				}
				else
				{
					$data = [
						'permission' => '1',
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_update("user_permissions", $data, "user_type_id='".$db->escape($user_name)."' and box_name='".$db->escape($val)."' and form_id='5'");
				}
			}
		}

	
		if(($reports_ent!=''))
		{
			$reports_ent_exp=explode(",",$reports_ent);
			foreach($reports_ent_exp as $val)
			{
				 $check=get_checks_permis_permis($user_name,$val);
				if($check=='0')
				{
					$data = [
						'user_type_id' => $user_name,
						'box_name' => $val,
						'form_id' => '6',
						'permission' => '1',
						'entry_date' => $create_date,
						'user_id' => $user_id,
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_insert("user_permissions", $data);
				}
				else
				{
					$data = [
						'permission' => '1',
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_update("user_permissions", $data, "user_type_id='".$db->escape($user_name)."' and box_name='".$db->escape($val)."' and form_id='6'");
				}
			}
		}
		
		
		
		if(($others_ent!=''))
		{
			$others_ent_exp=explode(",",$others_ent);
			foreach($others_ent_exp as $val)
			{
				 $check=get_checks_permis_permis($user_name,$val);
				if($check=='0')
				{
					$data = [
						'user_type_id' => $user_name,
						'box_name' => $val,
						'form_id' => '8',
						'permission' => '1',
						'entry_date' => $create_date,
						'user_id' => $user_id,
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_insert("user_permissions", $data);
				}
				else
				{
					$data = [
						'permission' => '1',
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_update("user_permissions", $data, "user_type_id='".$db->escape($user_name)."' and box_name='".$db->escape($val)."' and form_id='8'");
				}
			}
		}
		

		if(($backup_ent!=''))
		{
			$backup_ent_exp=explode(",",$backup_ent);
			foreach($backup_ent_exp as $val)
			{
				$check=get_checks_permis_permis($user_name,$val);
				if($check=='0')
				{
					$data = [
						'user_type_id' => $user_name,
						'box_name' => $val,
						'form_id' => '7',
						'permission' => '1',
						'entry_date' => $create_date,
						'user_id' => $user_id,
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_insert("user_permissions", $data);
				}
				else
				{
					$data = [
						'permission' => '1',
						'sess_user_type_id' => $sess_user_type_id,
						'sess_user_id' => $sess_user_id,
						'sess_ipaddress' => $sess_ipaddress
					];
					$db->query_update("user_permissions", $data, "user_type_id='".$db->escape($user_name)."' and box_name='".$db->escape($val)."' and form_id='7'");
				}
			}
		}

		$check_data=get_checks_permis_permis_data($user_name);
		if($check_data=='0')
		{
			$data = [
				'user_name' => $user_name,
				'entry_date' => $create_date,
				'user_id' => $user_id,
				'sess_user_type_id' => $sess_user_type_id,
				'sess_user_id' => $sess_user_id,
				'sess_ipaddress' => $sess_ipaddress
			];
			$db->query_insert("user_permission_main", $data);
		}
		else
		{
			$data = [
				'sess_user_type_id' => $sess_user_type_id,
				'sess_user_id' => $sess_user_id,
				'sess_ipaddress' => $sess_ipaddress
			];
			$db->query_update("user_permission_main", $data, "user_name='".$db->escape($user_name)."'");
		}
		echo "<script>alert('Successfully Added/Updated')</script>";
	break;

	case "delete":
    	$where = "main_id='".$db->escape($delete_id)."'";
		$db->query_delete($table2, $where);
		$main_id = $_POST['main_id'] ?? '';
		$user_id_del = $_GET['user_id'] ?? '';
		$db->query_delete("user_permission_main", "main_id='".$db->escape($main_id)."'");
		$db->query_delete("user_permissions", "user_id='".$db->escape($user_id_del)."'");
		echo "<span class=text-success>Successfully Deleted</span>";
	break;
}
$db->close();
?>
