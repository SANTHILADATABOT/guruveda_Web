<script>
function machinerie_print(url)
{
onmouseover= window.open(url,'','height=700,width=1000,scrollbars=yes,left=150,top=80,toolbar=no,location=no,directories=no,status=no,menubar=no');
}

function print_map(url)
{
	onmouseover= window.open(url,'onmouseover','height=600,width=1200,scrollbars=yes,resizable=no,left=50,top=50,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
</script>
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
$exp_type_id=$_POST['exp_type_id'];
$staff_id=$_POST['staff_id'];

if($from_date!=""){ $from_date1 = "entry_date>='$from_date'";}else{$from_date1="entry_date='$cur_date'";}
if($to_date!=""){ $to_date1 = "entry_date<='$to_date'";}else{$to_date1='';}
if($staff_id!=""){ $staff_id1 = "sess_user_id='$staff_id'";}else{$staff_id1='';}

$all_value10 = $from_date1.",".$to_date1.",".$staff_id1;
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
</script>

<table id="bootstrap-data-table" class="table" width="100%">
                            <thead>
                                <tr>
									<th width="2%">SNo</th>
									<th width="20%">Staff Name</th>
									<th width="10%">Opening KM</th>
									<th width="10%">Closing KM</th>
									<th width="10%">Total</th>
									<th width="10%">Litres</th>
									<th width="10%">Amount</th>
									<th width="10%">View Image</th>
									<th width="10%" ><div align="center">Location</div></th>
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
								if($sess_user_type_id == '3')
                                $sql = "SELECT * FROM log_book where $get_query log_id!='' and staff_id='$sess_staff_id'";
								else
                                $sql = "SELECT * FROM log_book where $get_query log_id!=''";
                                $rows = $db->fetch_all_array($sql);
								
                                foreach($rows as $record)
                                { 
								
								 $staff_latitude=$record['latitude'];
								$staff_longitude=$record['longitude'];
								
								?>
                                    <tr>
                                        <td><?php echo $i=$i+1;?></td>
                                        <td><?php echo get_user_name($record['sess_user_id']);?></td>
                                        <td><?php echo $record['opening_km'];?></td>
                                      <td><?php echo $record['closing_km'];?></td>
									  <td><?php echo $record['total_km'];?></td>
									  <td><?php echo $record['litres'];?></td>
                                        <td><?php echo number_format($record['amount'],2);?></td>
                                  
                                         <td align="center">
                                           <a   href="javascript:files_print('log_book/image_list.php?log_id=<?php echo $record['log_id']; ?>')" style="float:center"><img  align="center" src="images/view-icon.png" width="30" height="30" border="0" /></a></td>
                                           
                                         <td><?php if(($staff_longitude!='')&&($staff_latitude!='')) {?>
                                        <div align="center">
                                        <a onclick="print_map('log_book/map.php?staff_latitude=<?php echo $staff_latitude; ?>&staff_longitude=<?php echo $staff_longitude; ?>');" target="new">
                                        <img src="images/map.png" height="30" width="30">
                                        </a></div><?php }?>
                                        </td>
                                         <td><?php echo $record['description'];?></td>
                                    
                                            
                                    </tr>
                                    <?php
								} ?>
                             </tbody>
                        </table>
                        
