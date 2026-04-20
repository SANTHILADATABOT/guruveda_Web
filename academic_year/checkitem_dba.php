<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
ob_start();
session_start();
require("../model/config.inc.php"); 
require("../model/Database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect(); 

$from_academic = $_GET['from_academic'] ?? '';
$sql_query = "SELECT * FROM account_year WHERE from_year='".$db->escape($from_academic)."' ";
$rs=$db->query($sql_query);
$num = ($rs && $rs instanceof mysqli_result) ? $rs->num_rows : 0;
echo $num;
?>