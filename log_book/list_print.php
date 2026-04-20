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
$from_date=$_GET['from_date'];
$to_date=$_GET['to_date'];
$staff_id=$_GET['staff_id'];

if($from_date!=""){ $from_date1 = "entry_date>='$from_date'";}else{$from_date1="entry_date='$cur_date'";}
if($to_date!=""){ $to_date1 = "entry_date<='$to_date'";}else{$to_date1='';}
if($staff_id!=""){ $staff_id1 = "sess_user_id='$staff_id'";}else{$staff_id1='';}

$get_query= '';
$all_value10 = $from_date1.",".$to_date1.",".$staff_id1;
$all_array10 = explode(',',$all_value10);
foreach($all_array10 as $value10) { 
  if($value10!='') {
    $get_query.= $value10." AND ";   
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
    <h4>Log Book Report</h4>
  </div>
</div>
<div>
  <table id="bootstrap-data-table" class="table" width="100%">
    <tr>
      <td width="33%" align="center" class="style2">From Date : <strong><?php if($_GET['from_date']==''){ echo "All";} else { echo date("d-m-Y",strtotime($_GET['from_date'])); }?></strong></td>
      <td width="33%" align="center" class="style2">To Date : <strong><?php if($_GET['to_date']==''){ echo "All";} else { echo date("d-m-Y",strtotime($_GET['to_date'])); }?></strong></td>
      <td width="34%" align="center" class="style2">Staff Name : <strong><?php if($_GET['staff_id']==''){ echo "All";} else { echo get_user_name($_GET['staff_id']); }?></strong></td>
    </tr>
  </table>
  <br>
</div>
            <table id="bootstrap-data-table" class="table" width="100%" border='1' style="border-collapse:collapse;">
              <thead>
                <tr>
                  <th width="2%">SNo</th>
                  <th width="20%">Staff Name sd</th>
                  <th width="10%">Opening KM</th>
                  <th width="10%">Closing KM</th>
                  <th width="10%">Total</th>
                  <th width="10%">Litres</th>
                  <th width="10%">Amount</th>
                  <th width="10%" ><div align="center">Remarks</div></th>
                 </tr>
              </thead>
              <tbody>
  <?php 
        $sess_staff_id=$_SESSION['sess_staff_id'];
        $sess_user_type_id=$_SESSION['sess_user_type_id'];
        $sess_user_id=$_SESSION['sess_user_id'];
        $sess_ipaddress=$_SESSION['sess_ipaddress'];
        $i=0;
        if($sess_user_type_id == '3'){
          $sql = "SELECT * FROM log_book where $get_query log_id!='' and sess_user_id='$sess_staff_id'";
        } else{
          $sql = "SELECT * FROM log_book where $get_query log_id!=''";
        }
        $rows = $db->fetch_all_array($sql);
        foreach($rows as $record)
        { ?>
                  <tr>
                    <td><?php echo $i=$i+1;?></td>
                    <td><?php echo get_user_name($record['sess_user_id']);?></td>
                    <td><?php echo $record['opening_km'];?></td>
                    <td><?php echo $record['closing_km'];?></td>
                    <td><?php echo $record['total_km'];?></td>
                    <td><?php echo $record['litres'];?></td>
                    <td><?php echo number_format($record['amount'],2);?></td>
                    <td><?php echo $record['description'];?></td>
                  </tr>
   <?php
        } ?>
       </tbody>
  </table>