<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
require("../model/config.inc.php"); 
require("../model/Database.class.php"); 
require_once("../include/common_function.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();


$state_name_get = $_GET['state_name'] ?? '';
$update_id_get = $_GET['update_id'] ?? '';

if($state_name_get!='' && $update_id_get!='')
{ 
	$sql = "select * from state_creation where state_name='".$db->escape($state_name_get)."' and state_id!='".$db->escape($update_id_get)."' and delete_status!='1'";
	$rs = $db->query($sql);
	$sql_cnt = ($rs && $rs instanceof mysqli_result) ? $rs->num_rows : 0;
}
elseif($state_name_get!='' && $update_id_get=='')
{ 
	$sql = "select * from state_creation where state_name ='".$db->escape($state_name_get)."' and delete_status!='1'";
	$rs = $db->query($sql);
	$sql_cnt = ($rs && $rs instanceof mysqli_result) ? $rs->num_rows : 0;
}
else {
	$sql_cnt = 0;
}

if($sql_cnt!=0)
{ echo '<span style="color:red;">'."Already Exist".'</span>'; }
else if($state_name_get=='')
{ echo ""; }
?>