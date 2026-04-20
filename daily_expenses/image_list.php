<?php 
error_reporting(0);

require("../model/config.inc.php"); 
require("../model/Database.class.php"); 
include_once("../include/common_function.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect(); 
     $image_path = 'https://gvm.santhila.com/storage/expense_image/';
?>

<style type="text/css">
.top{ border-top: 1px solid #ccc;}
.bottom{ border-bottom: 1px solid #ccc;}
.top1{ border-top: 2px solid #ddd;}
.title{font-family:calibri; font-family:calibri; font-size:24px; color:#333; }
.address{font-family:calibri; font-family:calibri; font-size:18px; color:#333; }
.main{font-family:calibri; font-family:calibri; font-size:16px; font-weight:600; color:#333; }
.main2{font-family:calibri; font-family:calibri; font-size:16px; color:#333; font-weight:600;}
.data{font-family:calibri; font-family:calibri; font-size:16px; color:#111; }
</style>

  <?php
  
   $id = $_GET['id'] ?? '';
   $sql = "select * from daily_expense where  exp_id='".$db->escape($id)."'";
    $rs = $db->query($sql);
	
   		$rsdata = $db->fetch_array($rs);
  		if($rsdata) {
   				$s_photo = $rsdata['profile_image'] ?? '';
   				$e_photo = $rsdata['profile_image_2'] ?? '';
				$lat = $rsdata['latitude'] ?? '';
			 ?>
			 <center>
            <?php if($s_photo!='') { ?>
                <img src="<?php echo htmlspecialchars($image_path.$s_photo, ENT_QUOTES); ?>" width="480" height="480"/>
                <?php } else { ?>
                 <img src="../images/images.jpg" width="480" height="480"/>
                
               <?php }?>
               </center>
               <?php } else { ?>
               <center>
                 <img src="../images/images.jpg" width="480" height="480"/>
               </center>
               <?php } ?>
                 
