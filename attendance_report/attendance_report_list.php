<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
ob_start();
session_start();
if($_POST['from_month']!='')
{
	include("../include/common_function.php");
	require("../model/config.inc.php");
	require("../model/Database.class.php");
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
	$db->connect();
}
$from_month=$_POST['from_month'] ?? '';
$staff_id=$_POST['staff_id'] ?? '';
if($staff_id!=""){ $staff_id1 = "staff_name='$staff_id'";}else{$staff_id1='';}
if($staff_id1!=""){ $staff_id2 = "user_id='$staff_id'";}else{$staff_id2='';}

$all_value10 = $staff_id1;
$all_array10 = explode(',',$all_value10);
foreach($all_array10 as $value10)
{ 
	if($value10!='')
	{
		$get_query.= $value10." AND ";
	}
}
	$all_value101 = $staff_id2;
$all_array101 = explode(',',$all_value101);
foreach($all_array101 as $value101)
{ 
	if($value101!='')
	{
		$get_query1.= $value101." AND ";
	}
}
?>
<script>
$(function () {
	$('#bootstrap-data-table').DataTable()
})
</script>
<table border="0" cellspacing="0" width="100%">
<!--	<tr>
		<td colspan="8" align="center"></td>
		<td width="7%" style="padding-right:20px;padding-bottom: 3px;">
            <a onclick="javascript:attandance_list('attendance_report/attendance_report_print.php?from_month=<?php echo $_POST['from_month']; ?>&staff_id=<?php echo $_POST['staff_id']; ?>')" style="float:right"><img  align="right" src="images/printg.png" width="20" height="20" border="0" title="PRINT"></a>
		</td>
	</tr>-->
</table>
<table id="bootstrap-data-table" class="table" width="100%">
    <thead>
        <tr>
            <th width="4%">SNo</th>
            <th width="15%">Staff name</th>
            <th width="15%"  style="text-align:right">Actual Days</th>
            <th width="10%"  style="text-align:right">T.W.Off</th>
            <th width="15%"  style="text-align:right">Worked Days</th>
            <th width="15%"  style="text-align:right">Leave Taken</th>
           <!--  <th width="20%"  style="text-align:right">Total Late Hours</th> -->
        </tr>
    </thead>
    <tbody>
    <?php 
	$i=0;
	$month=date('m');
	$year=date('Y');
	$month_padded=sprintf("%02d", $j);
	$new_date=$year."-".$month_padded;
	//DATE_FORMAT(entry_date,'%Y-%m')='$new_date';
	if($from_month =="")
	{
		$from_month=date('Y-m');
		}
//------------------------------------finding sundays in month --------------------------
$months =date('m ',strtotime($from_month));  
$years=date('Y');                                      
$monthName = date("F", mktime(0, 0, 0, $months));
$fromdt=date('Y-m-01 ',strtotime("First Day Of  $monthName $years")) ;
$todt=date('Y-m-d ',strtotime("Last Day of $monthName $years"));

$num_sundays='';                
for ($i = 0; $i < ((strtotime($todt) - strtotime($fromdt)) / 86400); $i++)
{
    if(date('l',strtotime($fromdt) + ($i * 86400)) == 'Sunday')
    {
            $num_sundays++;
    }    
}

//------------------------------------Finding sundays in month end --------------------------
    $days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
 	$sql = "SELECT * FROM `user_creation` WHERE $get_query1 `delete_status`!='1' and user_type_id not in(1) ";
	$rows = $db->fetch_all_array($sql);
	foreach($rows as $record)
	{
		$staff_name = $record['user_id'];
		/* Legacy code omitted */
		//echo "SELECT * FROM  attendance_entry where staff_name='$staff_name' and DATE_FORMAT(entry_date,'%Y-%m') = '$from_month' and delete_status!='1' and type_id='1'";
		$sql_attendance = "SELECT * FROM  attendance_entry where staff_name='".$db->escape($staff_name)."' and DATE_FORMAT(entry_date,'%Y-%m') = '".$db->escape($from_month)."' and delete_status!='1' and attendance_type='7'";
		$rs_attendance = $db->query($sql_attendance);
		$sql_query3=($rs_attendance && $rs_attendance instanceof mysqli_result) ? $rs_attendance->num_rows : 0;
		$from_month_split=explode("-",$from_month);
		$d=cal_days_in_month(CAL_GREGORIAN,$from_month_split[1],$from_month_split[0]);
		
		  $working_days = $sql_query3;
		$dateDiff=$d-$working_days-$num_sundays;
		/* Legacy code omitted */
		
		?>
			<tr>
            <td><?php echo $j=$j+1;?></td>
            <td><?php echo $record['staff_name'];?></td>
            <td align="right"><?php echo $d; ?></td>
            <td align="right"><?php echo $num_sundays; ?></td>
            <td align="right"><?php echo $working_days;?></td>
            <td align="right"><?php echo $dateDiff;?></td>
            <!-- <td align="right"><?php echo $late_hours[0] ;?></td> -->
        </tr>
         <?php 
		  $staff_name1 =$record['staff_name'];
	}
	?>
    </tbody>
    </table>