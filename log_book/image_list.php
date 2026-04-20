<?php 
error_reporting(0);

require("../model/config.inc.php"); 
require("../model/Database.class.php"); 
include_once("../include/common_function.php"); 

$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect(); 
      $image_path = 'https://gvm.santhila.com/storage/log_image/';
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
   $log_id = $_GET['log_id'] ?? '';
   $sql="select * from log_book where  log_id='".$db->escape($log_id)."'";
    $rs=$db->query($sql);
	
   		while($rsdata=$db->fetch_array($rs))
  			{
   				$image_name=$rsdata['image_name'] ?? '';
   				$closing_km_img=$rsdata['closing_km_img'] ?? '';
				
			?>
	<table width="100%" style="border:none;" align="center">
    <tr>
   
        <td align="center">
            <?php if($image_name != '')
			{  ?>
                <img src="<?php echo $image_path.$image_name  ?>" width="480" height="480"/>
            <?php } else { ?>
                    <img src="../images/images.jpg" width="480" height="480"/>
            <?php } ?>
        </td>        
                
	
        <td align="center">	
            <?php	if($closing_km_img != '')
			{  ?>
                <img src="<?php echo $image_path.$closing_km_img  ?>" width="480" height="480"/>
            <?php } else { ?>
                    <img src="../images/images.jpg" width="480" height="480"/>
            <?php } ?> 
          </td>
            </tr> 
         <?php } ?>   
          
			   </table>
                 
