<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
ob_start();
session_start();
if($_POST['from_date']!='')
{
	include("../include/common_function.php");
	require("../model/config.inc.php");
	require("../model/Database.class.php");
	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
	$db->connect();
}
$cur_date=date('Y-m-d');
$from_date=$_POST['from_date'];
$to_date=$_POST['to_date'];
$staff_id=$_POST['staff_id'];
  $att_type_id=$_POST['att_type_id'];

if($from_date!=""){ $from_date1 = "entry_date>='$from_date'";}else{$from_date1="entry_date='$cur_date'";}
if($to_date!=""){ $to_date1 = "entry_date<='$to_date'";}else{$to_date1='';}
if($staff_id!=""){ $staff_id1 = "staff_name='$staff_id'";}else{$staff_id1='';}
if($att_type_id!=""){ $att_type_id1 = "attendance_type='$att_type_id'";}else{$att_type_id1='';}

$all_value10 = $from_date1.",".$to_date1.",".$staff_id1.",".$att_type_id1;
$all_array10 = explode(',',$all_value10);
foreach($all_array10 as $value10)
{ 
	if($value10!='')
	{
		$get_query.= $value10." AND ";
		
		
	}
	
	
}?>
<script>
$(function () {
	$('#bootstrap-data-table').DataTable()
})

function print_map(url)
{
	onmouseover= window.open(url,'onmouseover','height=600,width=1200,scrollbars=yes,resizable=no,left=50,top=50,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
</script>

<table id="bootstrap-data-table" class="table" width="100%">
                            <thead>
                                <tr>
                                    <th width="4%">S.No</th>
                                    <th width="19%">Staff Name</th>
                                    <th width="17%">Date</th>
                                    <th width="23%">Attendance Type</th>
                                    <th width="21%">Attendance Time</th>
                                    <th width="21%" ><div align="center">Location</div></th>
                                    <th width="21%" ><div align="center">Remarks</div></th>
                                   <!--  <th width="16%"><div align="center">Action</div></th> -->
                                </tr>
                            </thead>
                        	<tbody>
								<?php 
$sess_staff_id=$_SESSION['sess_staff_id'];
$sess_user_type_id=$_SESSION['sess_user_type_id'];
$sess_user_id=$_SESSION['sess_user_id'];
$sess_ipaddress=$_SESSION['sess_ipaddress'];

                                $i=0;
								if($sess_user_type_id == '3')
                                 $sql = "SELECT * FROM  attendance_entry where $get_query delete_status!='1' and staff_name = '$sess_staff_id'";
								 else
								  $sql = "SELECT * FROM  attendance_entry where $get_query delete_status!='1'";
                                $rows = $db->fetch_all_array($sql);
                                foreach($rows as $record)
                                {  
								 $staff_latitude=$record['staff_latitude'];
								$staff_longitude=$record['staff_longitude'];
								?>
                                    <tr>
                                        <td><?php echo $i=$i+1;?></td>
                                        <td><?php echo get_user_name($record['staff_name']);?></td>
                                        <td><?php echo date("d-m-Y",strtotime($record['entry_date']));?></td>
                                        <td><?php echo get_attendance_type($record['attendance_type']);if($record['attendance_type']=='3'){ if($record['shop_name']){ echo "(".get_sub_dealer_name($record['shop_name']).")";}else{ echo " ";}}?></td>
                                        <td style="color:#00F; font-weight:bold"><?php echo $record['attendance_time'];?></td>
                                        <td><?php if(($staff_longitude!='')&&($staff_latitude!='')) {?>
                                        <div align="center">
                                        <a onclick="print_map('attendance_creation/map.php?staff_latitude=<?php echo $staff_latitude; ?>&staff_longitude=<?php echo $staff_longitude; ?>');" target="new">
                                        <img src="images/map.png" height="30" width="30">
                                        </a></div><?php }?>
                                        </td>
                                        <td style="color:#00F; font-weight:bold"><?php echo $record['description'];?></td>
                                      	<!-- <td align="center"><a href="index1.php?filename=attendance_creation/update&update_id=<?php echo $record['att_id'];?>"><i class="fa fa-edit fa-pencil-square-o"></i></a>&nbsp;&nbsp;
                                        	<a href="#" title="Delete" onClick="attendance_delete('<?php echo $record['att_id']; ?>');"><i class="fa fa-delete fa-trash-o"></i></a></td> -->
                                            
                                    </tr>
                                    <?php
								} ?>
                             </tbody>
                        </table>