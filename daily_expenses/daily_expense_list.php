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
if($exp_type_id!=""){ $exp_type_id1 = "expense_type='$exp_type_id'";}else{$exp_type_id1='';}
if($staff_id!=""){ $staff_id1 = "user_id='$staff_id'";}else{$staff_id1='';}

$all_value10 = $from_date1.",".$to_date1.",".$staff_id1.",".$exp_type_id1;
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
                                    <th width="22%">Expense Type</th>
                                    <th width="14%">Amount</th>
                                    <!-- <th width="14%">Image Upload</th>-->
                                     <th width="15%">View Image</th>
                                      <th width="21%" ><div align="center">Location</div></th>
                                       <th width="21%" ><div align="center">Remarks</div></th>
                                    <!-- <th width="13%"><div align="center">Action</div></th> -->
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
                                $sql = "SELECT * FROM daily_expense where $get_query delete_status!='1' and user_id='$sess_staff_id'";
                                else
                                $sql = "SELECT * FROM daily_expense where $get_query delete_status!='1'";
                                $rows = $db->fetch_all_array($sql);
                                foreach($rows as $record)
                                { 
                                  
                                
                                 $staff_latitude=$record['latitude'];
                                $staff_longitude=$record['longitude'];
                                
                                ?>
                                    <tr>
                                        <td><?php echo $i=$i+1;?></td>
                                        <td><?php echo get_user_name($record['user_id']);?></td>
                                        <td><?php echo get_expense_type($record['expense_type']);?></td>
                                        <td><?php echo number_format($record['amount'],2);?></td>
                                        <!--<td align="center"><a href="javascript:expense_image_upload('daily_expenses/fab_sup_file_upload.php?update_id=<?php echo $record['exp_id'];?>&expense_no=<?php echo $record['expense_no'];?>');" title="Upload"><img src="img/upload.jpg" height="25px" width="25px;"></a></td>
                                        -->
                                         <td align="center">
                                            <?php   if(($record['profile_image']!='') || ($record['profile_image_2']!='')) { ?>
                                           <a   href="javascript:machinerie_print('daily_expenses/image_list.php?invoice_no=<?php echo $record['expense_no']; ?>&random_no=<?php echo $record['random_no'] ?>&random_sc=<?php echo $record['random_sc'];?>&id=<?php echo $record['exp_id'];?>')" style="float:center"><img  align="center" src="images/view-icon.png" width="30" height="30" border="0" /></a>
                                           <?php } ?></td>
                                           
                                         <td><?php if(($staff_longitude!='')&&($staff_latitude!='')) {?>
                                        <div align="center">
                                         <a onclick="print_map('daily_expenses/map.php?staff_latitude=<?php echo $staff_latitude; ?>&staff_longitude=<?php echo $staff_longitude; ?>');" target="new">
                                        <img src="images/map.png" height="30" width="30">
                                        </a></div><?php }?>
                                        </td>
                                         <td><?php echo $record['description'];?></td>
                                       <!--  <td align="center">
                                            <a href="index1.php?filename=daily_expenses/update&update_id=<?php echo $record['exp_id'];?>"><i class="fa fa-edit fa-pencil-square-o"></i></a>&nbsp;&nbsp;
                                            <a href="#" title="Delete" onClick="expense_delete('<?php echo $record['exp_id']; ?>');"><i class="fa fa-delete fa-trash-o"></i></a>
                                        </td> -->
                                            
                                    </tr>
                                    <?php
                                } ?>
                             </tbody>
                        </table>
                        
