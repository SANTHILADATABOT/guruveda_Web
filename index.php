<script src="assets/js/jquery.min.js"></script>
<?php
































error_reporting(0);
date_default_timezone_set("Asia/Kolkata");
ob_start();
ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start(); 
require_once("model/config.inc.php"); 
require_once("model/Database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();

if(isset($_POST["Login"]) && $_POST["Login"]=="Login") 
{
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';

	$username = isset($_POST["username"]) ? $_POST["username"] : '';
	$password = isset($_POST["password"]) ? base64_encode($_POST["password"]) : '';
	$sql = "SELECT * FROM user_creation where user_name='".$db->escape($username)."' and password='".$db->escape($password)."' and delete_status!='1' and user_status!='0'";
	$rs = $db->query($sql);
	$rscount = ($rs && $rs instanceof mysqli_result) ? $rs->num_rows : 0;
if($rscount!=0)
	{
		while($record2 = $db->fetch_array($rs))
		{
			if($record2) {
				$_SESSION['sess_user_type_id'] = $record2['user_type_id'] ?? '';
				$_SESSION['sess_user_id'] = $record2['user_id'] ?? '';
				$_SESSION['sess_staff_id'] = $record2['staff_id'] ?? '';
				$_SESSION['sess_ipaddress'] = $ipaddress;
				if($_SESSION['sess_user_type_id'] == 1){?>
				<script>window.location.href="index1.php?filename=dashboard/admin";</script>
				<?php }else if($_SESSION['sess_user_type_id'] == 2) { ?>
	            <script>window.location.href="index1.php?filename=sales_order_entry/admin";</script>
	            <?php }else { ?>
				<script>window.location.href="index1.php?filename=attendance_creation/admin";</script>
				<?php }
			}
		}
	}
}
$comp = $db->query_first("select * from company_details where id='1'");
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo isset($comp['company_name']) ? strtoupper($comp['company_name']) : '';?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="all,follow">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <style>
            .web{width:40%;}
            .web1{width:100%;height:120px;margin:-10px 50px -10px 20px;}
            .web2{height:70px;width:100%;}
            .web3{height:150px;width:80%;margin:10px 50px 30px 20px;}
            .web4{width:100%;height:100px;margin:-10px 50px -10px 20px;}
            .web5{overflow:hidden;}
			.btm {
				    position: fixed;
                    left: 0;
                    right: 0;
                    bottom: 0;
					margin-left:0px;
					margin-right:0px;
			}
        </style>
    </head>
    <body class="web5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-6 col-4">
				
                    <center><img src="images/l4.png" style="margin-top:50px; width:26%;margin-bottom: 18px;" class=""></center>
                </div>
            </div>
        </div>
	    <!--<center><h2 class="logo-name"><?php echo strtoupper($comp['company_name'] ?? '');?></h2></center>-->
        <div class="container container-style">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-4"></div> 
                <div class="col-md-4 col-sm-6 col-4 log-bg">
                    <center><h3 class="log-head">Login</h3></center>
                    <hr>
                    <form method="post">
                        <div class="form-group col-md-12 col-sm-6 col-4">
                            <label><i class="fa fa-user"></i> &nbsp; Username</label>
                            <input type="text" id="username" name="username" class="form-control" autofocus>
                        </div>
                        <div class="form-group col-md-12 col-sm-6 col-4">
                            <label><i class="fa fa-lock"></i> &nbsp; Password</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                        <div class="form-group col-md-12 col-sm-6 col-4" align="center">
                            <button type="submit" class="btn btn-primary" name="Login" id="Login" value="Login">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
            
            
        </div>
        
         
    </body>
</html>