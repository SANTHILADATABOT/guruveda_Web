<script>
function winprint(){
	window.print();
	//window.history.back();
}
//window.onload = function() { window.print(); }
</script>
<style type="text/css">
.style1 {font-weight:normal;font-family:calibri;font-size: 12px;}
.style2 {font-weight:normal;font-family:calibri;font-size: 14px;}
.style3 {font-weight:bold; text-align:right;font-family:calibri;font-size: 14px;}
.style4 {font-weight:bold; font-family:calibri;font-size: 14px;}
.style5 {font-family:calibri;font-weight: bold;font-size: 16px;}
.style6 {font-family:calibri;font-weight: bold;font-size: 18px;}
.top{ border-top: solid 1px; border-top-color:#BFBFBF;}
.bottom{ border-bottom: solid 1px; border-bottom-color:#BFBFBF;}
.style7 {font-weight:bold;font-family:Bookman Old Style;font-size: 12px;}
</style>
<?php 
error_reporting(0);
session_start();
require_once("../model/config.inc.php");
require_once("../model/Database.class.php");
require_once("../include/common_function.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();
$cur_date=date('Y-m-d');

$from_month=$_GET['from_month'] ?? '';
$from_month_dis=$_GET['from_month'] ?? '';
$staff_id=$_GET['staff_id'] ?? '';
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
$comp=$db->query_first("select * from company_details where id='1'");
?>
<table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="850px" align="center">
    <tr>
        <td width="190" rowspan="2" align="center" class="style6"><?php if($comp[image_name]!='') {?><img src="../company_images/<?php echo $comp[image_name]; ?>" width="170" height="85"><?php }?></td>
    </tr>
    <tr>
        <td height="117" align="center" class="style7"><span style="font-size:30px;">
            <strong><?php echo $comp[company_name];?></strong></span><br>
            <sup><span style="font-size:14px;"><?php echo $comp[bill_name];?></span></sup><br>
            <?php echo $comp[address];?><br>
            <?php echo "Tel: ".$comp[phone_no].",".$comp[mobile_no]."&nbsp;&nbsp;&nbsp;Email: ".$comp[email_id];?><br>
          <span style="text-transform:uppercase; font-size:16px;"> <?php echo "GSTIN No:  ".$comp[gst_no];?></span>
        </td>
        <td height="117" valign="top" align="right" class="style7">Report on : <?php echo date('d-m-Y',strtotime(date('Y-m-d')));?>&nbsp;</td>
    </tr>
    <tr>
        <td height="19" valign="top" align="right" class="style2">&nbsp;</td>
        <td height="19" align="center" class="style7" style="font-size:14px;">MONTHLY ATTENDANCE REPORT </td>
        <td height="19" valign="top" align="right" class="style2">&nbsp;</td>
    </tr>
</table>

<table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="850px" align="center">
    <tr>
        <!--<td width="422" height="30" align="left" class="style2">From Month:<strong>&nbsp; <?php if($from_month!=""){echo date("m",strtotime($cur_date));} else {echo date("m",strtotime($from_month_dis));} ?></strong> &nbsp;</td>-->
        <td width="422" align="right" class="style2">Staff Name :<strong> <?php if($staff_id!=""){echo get_user_name($staff_id);} else {echo "All";} ?></strong></td>
    </tr>
</table>
<table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="850px" align="center">
    <thead>
        <tr>
          <th width="4%">SNo</th>
            <th width="15%">Staff name</th>
            <th width="15%"  style="text-align:right">Actual Days</th>
            <th width="10%"  style="text-align:right">T.W.Off</th>
            <th width="15%"  style="text-align:right">Worked Days</th>
            <th width="15%"  style="text-align:right">Leave Taken</th>
           <!--  <th width="20%"  align="right" class="top bottom style4">Total Late Hours</th> -->
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
 	$sql = "SELECT * FROM `user_creation` WHERE $get_query1 `delete_status`!='1' and user_type_id not in(1)";
	$rows = $db->fetch_all_array($sql);
	foreach($rows as $record)
	{
		$staff_name = $record['user_id'];
		//$legacy query placeholder for late hours calculation
		
	$sql_attendance = "SELECT * FROM  attendance_entry where staff_name='".$db->escape($staff_name)."' and DATE_FORMAT(entry_date,'%Y-%m') = '".$db->escape($from_month)."' and delete_status!='1' and attendance_type='7'";
	$rs_attendance = $db->query($sql_attendance);
	$sql_query3=($rs_attendance && $rs_attendance instanceof mysqli_result) ? $rs_attendance->num_rows : 0;
		$from_month_split=explode("-",$from_month);
		$d=cal_days_in_month(CAL_GREGORIAN,$from_month_split[1],$from_month_split[0]);
		
		  $working_days = $sql_query3;
		$dateDiff=$d-$working_days-$num_sundays;
	 
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
         
	<?php }
	?>
    </tbody>
    </table>