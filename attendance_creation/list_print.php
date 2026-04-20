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
$from_date =$_GET['from_date'];
$to_date   =$_GET['to_date'];
$staff_id =$_GET['staff_id'];
$att_type_id =$_GET['att_type_id'];

   
if($from_date!=""){ $from_date1 = "entry_date>='$from_date'";}else{$from_date1="entry_date='$cur_date'";}
if($to_date!=""){ $to_date1 = "entry_date<='$to_date'";}else{$to_date1='';}
if($staff_id!=""){ $staff_id1 = "staff_name='$staff_id'";}else{$staff_id1='';}
if($att_type_id!=""){ $att_type_id1 = "attendance_type='$att_type_id'";}else{$att_type_id1='';}

$get_query ='';
$all_value10 = $from_date1.",".$to_date1.",".$staff_id1.",".$att_type_id1;
$all_array10 = explode(',',$all_value10);
foreach($all_array10 as $value10)
{ 
  if($value10!='')
  {
    $get_query.= $value10." AND "; 
  }
}
?>

<script>
$(function () {
  $('#bootstrap-data-table').DataTable()
})

</script>
<html class="no-js" lang="">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
<div class="padd_div">
  <div class="col-md-12 header" style="text-align: center;">
      <br>
      <h2 >Guruveda Marketing</h2>
      <hr>

  </div>
</div>

<div class="padd_div">
  <div class="col-md-12 header" style="text-align: center;">
      <h4>Daily Attendance Report</h4>
  </div>
</div>
<div>
  <table id="bootstrap-data-table" class="table" width="100%">
    <tr>
      <td width="50%" align="center" class="style2">From Date : <strong><?php if($_GET['from_date']==''){ echo "All";} else { echo date("d-m-Y",strtotime($_GET['from_date'])); }?></strong></td>
      <td width="50%" align="center" class="style2">To Date : <strong><?php if($_GET['to_date']==''){ echo "All";} else { echo date("d-m-Y",strtotime($_GET['to_date'])); }?></strong></td>
    </tr>
    <tr>
      <td width="50%" align="center" class="style2">Staff Name : <strong><?php if($_GET['staff_id']==''){ echo "All";} else { echo get_user_name($_GET['staff_id']); }?></strong></td>
      <td width="50%" align="center" class="style2">Attendance Type : <strong><?php if($_GET['att_type_id']==''){ echo "All";} else { echo get_attendance_type($_GET['att_type_id']); }?></strong></td>
    </tr>
  </table>
  <br>
</div>
            <table id="bootstrap-data-table" class="table" width="100%" border="1" style="border-collapse:collapse;">
              <thead>
                <tr>
                  <th width="4%">S.No</th>
                  <th width="19%">Staff Name</th>
                  <th width="17%">Date</th>
                  <th width="23%">Attendance Type</th>
                  <th width="21%">Attendance Time</th>
                  <th width="21%" ><div align="center">Remarks</div></th>
                 </tr>
              </thead>
              <tbody>
    <?php 
      $i=0;
    
      $sql = "SELECT * FROM  attendance_entry where $get_query delete_status!='1'";    
      $rows = $db->fetch_all_array($sql);
      foreach($rows as $record)
      {  
    ?>
                <tr>
                  <td><?php echo $i=$i+1;?></td>
                  <td><?php echo get_user_name($record['staff_name']);?></td>
                  <td align="center"><?php echo date("d-m-Y",strtotime($record['entry_date']));?></td>
                  <td align="center"><?php echo get_attendance_type($record['attendance_type']);if($record['attendance_type']=='3'){ if($record['shop_name']){ echo "(".get_sub_dealer_name($record['shop_name']).")";}else{ echo " ";}}?></td>
                  <td align="center"><?php echo $record['attendance_time'];?></td>
                  <td><?php echo $record['description'];?></td>
                   <!-- <td style="color:#00F; font-weight:bold"><?php echo $record['description'];?></td> -->
                </tr>
              <?php
      } ?>
       </tbody>
  </table>
  </body>
</html>