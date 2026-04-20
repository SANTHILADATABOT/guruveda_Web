<?php

date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
require("../model/config.inc.php"); 
require("../model/Database.class.php"); 
require_once("../include/common_function.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();

$staff_name = $_POST['staff_name'] ?? '';
$entry_date = $_POST['entry_date'] ?? ''; 

if($staff_name!='')
{
	
	$office_out = $db->query("select * from attendance_entry where staff_name='".$db->escape($staff_name)."' and entry_date='".$db->escape($entry_date)."' and attendance_type='2'");
	
	$office_out_count = ($office_out && $office_out instanceof mysqli_result) ? $office_out->num_rows : 0;
	
	if($office_out_count==0)
	{
	
		$insql = $db->query("select * from attendance_entry where staff_name='".$db->escape($staff_name)."' and entry_date='".$db->escape($entry_date)."'");

		$count = ($insql && $insql instanceof mysqli_result) ? $insql->num_rows : 0;



		if($count!=0)
		{
			$time_get = [];
			$insql = $db->query("select * from attendance_entry where staff_name='".$db->escape($staff_name)."' and entry_date='".$db->escape($entry_date)."' and attendance_type IN (1,2,5,6)");
			if($insql && $insql instanceof mysqli_result) {
				while($time = $db->fetch_array($insql))
				{
					if($time) {
						$time_get[] = $time['attendance_type'] ?? '';
					}
				}
			}


			$count_site = $db->query("select * from attendance_entry where staff_name='".$db->escape($staff_name)."' and entry_date='".$db->escape($entry_date)."' and type_id='2' order by att_id desc limit 1");
	
			$count_site1 = ($count_site && $count_site instanceof mysqli_result) ? $count_site->num_rows : 0;
	
			if($count_site1!=0)
			{
	
				$insql2 = $db->query_first("select * from attendance_entry where staff_name='".$db->escape($staff_name)."' and entry_date='".$db->escape($entry_date)."' and type_id='2' order by att_id desc limit 1");
	
				if($insql2 && isset($insql2['attendance_type'])) {
					$time_get[] = $insql2['attendance_type'];
				}
	
			}
	
	
			$time_get1 = implode(",",$time_get);

?>

<select name="att_type_id"   id="att_type_id" class="form-control" tabindex="1" autofocus> 												   
<option value="">Select</option>
     <?php 
	
	  $val = "select * from  attendance_type_live where live_id NOT IN (".$db->escape($time_get1).")";
       $rows = $db->fetch_all_array($val);
       foreach($rows as $fet_get_report) {?>
         <option value="<?php echo htmlspecialchars($fet_get_report['live_id'] ?? '', ENT_QUOTES);?>,<?php echo htmlspecialchars($fet_get_report['att_id'] ?? '', ENT_QUOTES);?>"><?php echo ucfirst($fet_get_report['attendance_type'] ?? '');?></option>
        <?php
         
	   
		 }?>
         </select> 
   <?php 
}	 else

	{?>

		<select name="att_type_id"   id="att_type_id" class="form-control" tabindex="1" autofocus> 												   
		<option value="">Select</option>
    	 <?php 
	
	
	  	$val = "select * from  attendance_type_live";
     	 $rows = $db->fetch_all_array($val);
     	 foreach($rows as $fet_get_report) {?>
        	<option value="<?php echo htmlspecialchars($fet_get_report['live_id'] ?? '', ENT_QUOTES);?>,<?php echo htmlspecialchars($fet_get_report['att_id'] ?? '', ENT_QUOTES);?>"><?php echo ucfirst($fet_get_report['attendance_type'] ?? '');?></option>
        <?php
         
	   
		 }?>
         </select> 
   <?php 
   }
}
	
	else
	{?>
		<select name="att_type_id"   id="att_type_id" class="form-control" tabindex="1" autofocus> 												   
			<option value="">Select</option>
		</select>
<?php }

}?>
   
