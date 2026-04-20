<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
ob_start();
ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();
require("model/config.inc.php");
require("model/Database.class.php");
require("include/common_function.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();

$comp = $db->query_first("select * from company_details where id='1'");
?>
<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo isset($comp['company_name']) ? strtoupper($comp['company_name']) : '';?></title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <!--<link rel="shortcut icon" href="favicon.ico">-->
    <body>
        <?php
		error_reporting(0);
		$sess_user_type_id = $_SESSION['sess_user_type_id'] ?? '';
		$sess_user_id = $_SESSION['sess_user_id'] ?? '';
		$sess_staff_id = $_SESSION['sess_staff_id'] ?? '';
		$sess_ipaddress = $_SESSION['sess_ipaddress'] ?? '';
		if(($sess_user_id!='')&&($sess_user_type_id!=''))
        {
            include("include/header.php");
			$content = $_GET['filename'] ?? '';
			if($content) {
				include($content.'.php');
			}
			include("include/footer.php"); 
        }
        else
        {
            echo "<script>alert('Session Invalid!!!');</script>";
            echo "<script>window.location.href='index.php'</script>";
        }?>
        </div>
    </body>
</html>