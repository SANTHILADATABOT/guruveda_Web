<?php
session_start();
require("model/config.inc.php"); 
require("model/Database.class.php"); 
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();

$sess_user_id = $_SESSION['sess_user_id'] ?? '';
if($sess_user_id) {
	$data = ['login_status' => '0'];
	$db->query_update("user_creation", $data, "user_id='".$db->escape($sess_user_id)."'");
}

$_SESSION['sess_user_type_id'] = "";
$_SESSION['sess_user_id'] = "";
$_SESSION['sess_ipaddress'] = "";

session_destroy(); //destroy the session
header("location:index.php"); //to redirect back to "index.php" after logging out
exit();
?>
