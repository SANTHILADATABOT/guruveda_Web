<?php 
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
ob_start();
session_start();
include("../include/common_function.php");
require("../model/config.inc.php");
 require("../model/Database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE); 
$db->connect();

$cur_date=date('Y-m-d');

$from_month=$_GET['from_month'] ?? '';
$staff_id=$_GET['staff_id'] ?? '';
if($staff_id!=""){ $staff_id1 = "staff_name='$staff_id'";}else{$staff_id1='';}
if($staff_id1!=""){ $staff_id2 = "user_id='$staff_id'";}else{$staff_id2='';}

$get_query= '';
$all_value10 = $staff_id1;
$all_array10 = explode(',',$all_value10);
foreach($all_array10 as $value10) { 
  if($value10!='') {
    $get_query.= $value10." AND ";
  }
}

$all_value101 = $staff_id2;
$all_array101 = explode(',',$all_value101);
foreach($all_array101 as $value101) { 
  if($value101!='') {
    $get_query1.= $value101." AND ";
  }
}
?>

<script>
$(function () {
  $('#bootstrap-data-table').DataTable()
})

</script>

<div class="padd_div">
  <div class="col-md-12 header" style="text-align: center;">
      <br>
      <h2 >Guruveda Marketing</h2>
      <hr>

  </div>
</div>

<div class="padd_div">
  <div class="col-md-12 header" style="text-align: center;">
      <h4>Monthly Attendance Report</h4>
  </div>
</div>
<div>
  <table id="bootstrap-data-table" class="table" width="100%">
    <tr>
      <td width="50%" align="center" class="style2">From Month : <strong><?php if($_GET['from_month']==''){ echo "All";} else { echo date("F Y",strtotime($_GET['from_month'])); }?></strong></td>
      <td width="50%" align="center" class="style2">Staff Name : <strong><?php if($_GET['staff_id']==''){ echo "All";} else { echo get_user_name($_GET['staff_id']); }?></strong></td>
    </tr>
  </table>
  <br>
</div>
            <table id="bootstrap-data-table" class="table" width="100%" border="1" style="border-collapse:collapse;">
              <thead>
                <tr>
                  <th width="4%">SNo</th>
                  <th width="15%">Staff name</th>
                  <th width="15%"  style="text-align:center;">Actual Days</th>
                  <th width="10%"  style="text-align:center;">T.W.Off</th>
                  <th width="15%"  style="text-align:center;">Worked Days</th>
                  <th width="15%"  style="text-align:center;">Leave Taken</th>
                 </tr>
              </thead>
              <tbody>
      <?php
      $i=0;
      $month=date('m');
      $year=date('Y');
      $month_padded=sprintf("%02d", $i);
      $new_date=$year."-".$month_padded;
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
      for ($i = 0; $i < ((strtotime($todt) - strtotime($fromdt)) / 86400); $i++) {
        if(date('l',strtotime($fromdt) + ($i * 86400)) == 'Sunday') {
          $num_sundays++;
        }    
      }

      //------------------------------------Finding sundays in month end --------------------------
      $days=cal_days_in_month(CAL_GREGORIAN,$month,$year);
      $sql = "SELECT * FROM `user_creation` WHERE $get_query1 `delete_status`!='1' and user_type_id not in(1) ";
      $rows = $db->fetch_all_array($sql);
      $i=0;
      foreach($rows as $record)
      {
        $staff_name = $record['user_id'];
        $sql_attendance = "SELECT * FROM  attendance_entry where staff_name='".$db->escape($staff_name)."' and DATE_FORMAT(entry_date,'%Y-%m') = '".$db->escape($from_month)."' and delete_status!='1' and attendance_type='7'";
        $rs_attendance = $db->query($sql_attendance);
        $sql_query3=($rs_attendance && $rs_attendance instanceof mysqli_result) ? $rs_attendance->num_rows : 0;
        $from_month_split=explode("-",$from_month);
        $d=cal_days_in_month(CAL_GREGORIAN,$from_month_split[1],$from_month_split[0]);
        
        $working_days = $sql_query3;
        $dateDiff=$d-$working_days-$num_sundays;
        ?>
          <tr>
            <td><?php echo $i=$i+1;?></td>
            <td><?php echo $record['staff_name'];?></td>
            <td align="center"><?php echo $d; ?></td>
            <td align="center"><?php echo $num_sundays; ?></td>
            <td align="center"><?php echo $working_days;?></td>
            <td align="center"><?php echo $dateDiff;?></td>
        </tr>
  <?php 
      $staff_name1 =$record['staff_name'];
  } ?>
       </tbody>
  </table>