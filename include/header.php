<link rel="stylesheet" href="assets/css/normalize.css">
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/themify-icons.css">
<!--<link rel="stylesheet" href="assets/css/flag-icon.min.css">-->
<link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
<link rel="stylesheet" href="assets/scss/style.css">
<link rel="stylesheet" href="assets/css/lib/chosen/chosen.min.css">
<link rel="stylesheet" href="assets/css/lib/datatable/dataTables.bootstrap.min.css">
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/font.css" type="text/css"/>
<link rel="stylesheet" href="assets/css/style3.css" type="text/css">
<link rel="stylesheet" href="assets/css/hover.css">
<link rel="stylesheet" href="assets/scss/style.scss">



<style>
.star{color:#f00;}

a.navbar-brand.borclr {
    border-bottom: none;
     padding-right: 19px;
}
h3.menu-title.chngclr {
    border-bottom: none;
}

ul.sub-menu.children.dropdown-menu.show.bgclrdrop {
    background-color: #b3dae8;
    padding-top: 20px;
    padding-bottom: 20px;
}
p.clrpad {
    color: black;
    font-weight: bold;
    padding-left: 20px;
    font-size: 14px;
}
i.fa.fa-dot-circle-o.padleft {
    left: 8px !important;;
}

a.padrmve {
    padding: 3px 0 2px 7px !important;
}



</style>
<?php
include("tab.php");
ob_start();
session_start();
$user_type_id=$_SESSION['sess_user_type_id'];
$user_id=$_SESSION['sess_user_id'];
$ipaddress=$_SESSION['sess_ipaddress'];
  
function get_header_permission($user_type_id, $pur_party_name)
{
	global $db;
	$sql_user1 = "select permission from user_permissions where box_name='".$db->escape($pur_party_name)."' and user_id='".$db->escape($user_type_id)."'";
	$rs_user1 = $db->query($sql_user1);
	$permission2 = '';
	if($rs_user1 && $rs_user1 instanceof mysqli_result) {
		while($rsdata_user2 = $rs_user1->fetch_object())
		{ 
			$permission2 = $rsdata_user2->permission ?? '';
		}
	}
	return $permission2;
}

if(($user_id!='')&&($user_type_id!=''))
{?>
<aside id="left-panel" class="left-panel bg-clr"  style="background-color: #0b3444;">
	<nav class="navbar navbar-expand-sm navbar-default" >
		<div class="navbar-header">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
<a class="navbar-brand borclr"><img src="images/l3.png" style="width:100%;margin-bottom: 13px;margin-top: 31px;" class="img-responsive web" ></a>
		</div>
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <h3 class="menu-title chngclr"><p style="font-size: 19px;color: #5bdede;font-weight: bold;padding-bottom: 14px;padding-top: 30px;border-bottom: 1px solid grey;margin-bottom: 20px;">Entries</p></h3>
                
              
                <li>
                <?php $admin_rights=get_header_permission($user_type_id,'2'); if($admin_rights=='1'){?>
                <a href="index1.php?filename=dashboard/admin"><i class="menu-icon fa fa-laptop"></i><p style="color: #fff;font-size:14px;font-weight:600 !important;padding-bottom: 15px;padding-top: 2px;">Dashboard</p></a>
                <?php }?>
                </li>
              
              
                
                    <li class="menu-item-has-children dropdown <?php echo $admin;?>">
                        <?php $admin_rights=get_header_permission($user_type_id,'2'); if($admin_rights=='1'){?>
                            <a href="#" class="dropdown-toggle " data-toggle="dropdown"  aria-haspopup="true" ><i class="menu-icon fa fa-laptop"></i><p style="color: #fff;font-size:14px;padding-bottom: 15px;padding-top: 2px;font-weight:600 !important">Admin</p></a>
                            <ul class="sub-menu children dropdown-menu bgclrdrop <?php echo $admin_show;?> "> 
                                <?php $usertype_rights=get_header_permission($user_type_id,'User Type Creation'); if($usertype_rights=='1'){?>
                                     <li <?php echo $admin1; ?>><i class="fa fa-dot-circle-o padleft"></i><a href="index1.php?filename=user_type_creation/admin" class="padrmve"<?php echo $admina; ?>><p class="clrpad">User Type Creation</p></a></li> 
                                <?php }?>
                                <?php $usercreation_rights=get_header_permission($user_type_id,'User Creation'); if($usercreation_rights=='1'){?>
                                	<li <?php echo $admin3; ?>><i class="fa fa-dot-circle-o padleft"></i><a href="index1.php?filename=user_creation/admin" class="padrmve" <?php echo $adminc; ?>><p class="clrpad">User Creation</p></a></li>
                                <?php }?>
<!--                                <li <?php echo $admin4; ?>><i class="fa fa-dot-circle-o padleft"></i><a href="index1.php?filename=user_screen/admin" class="padrmve"<?php echo $admind; ?>><p class="clrpad">User Screen</p></a></li>
-->                                <?php $userpermisssion_rights=get_header_permission($user_type_id,'User Permission'); if($userpermisssion_rights=='1'){?>
<!--                                	<li <?php echo $admin5; ?>><i class="fa fa-dot-circle-o padleft"></i><a href="index1.php?filename=user_permission/admin" class="padrmve" <?php echo $admine; ?>><p class="clrpad">User Permission</p></a></li>
-->                                <?php }?>
                           	</ul>
                        <?php }?>
                    </li>
                </li>

                <!--<li class="menu-item-has-children dropdown <?php echo $master;?>">
                    <?php $master_rights=get_header_permission($user_type_id,'3'); if($master_rights=='1'){?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-gear"></i><p style="color: #fff;font-size:14px;font-weight:bold;padding-bottom: 15px;padding-top: 2px;padding-top: 2px;font-weight:600 !important">Master</p></a>
                        <ul class="sub-menu children dropdown-menu bgclrdrop <?php echo $master_show;?>">
                        	<?php $academicyear_rights=get_header_permission($user_type_id,'Academic Year Creation'); if($academicyear_rights=='1'){?>
                            	<li <?php echo $master1; ?>><i class="fa fa-dot-circle-o padleft"></i><a href="index1.php?filename=academic_year/admin" class="padrmve" <?php echo $mastera; ?>><p class="clrpad">Academic Year Creation</p></a></li>
                            <?php }?>
                            <?php $state_rights=get_header_permission($user_type_id,'State Creation'); if($state_rights=='1'){?>
                            	<li <?php echo $master2; ?>><i class="fa fa-dot-circle-o padleft"></i><a href="index1.php?filename=state_creation/admin" class="padrmve" <?php echo $masterb; ?>><p class="clrpad">State Creation</p></a></li>
                            <?php }?>
                            <?php $district_rights=get_header_permission($user_type_id,'District Creation'); if($district_rights=='1'){?>
                            	<li <?php echo $master3; ?>><i class="fa fa-dot-circle-o padleft"></i><a href="index1.php?filename=district_creation/admin" class="padrmve" <?php echo $masterc; ?>><p class="clrpad">District Creation</p></a></li>
                            <?php }?>
                        </ul>
                    <?php }?>
                </li>-->
      <!--changes_made start--> 
      
             <li class="menu-item-has-children dropdown <?php echo $other;?>">
             <?php $other_rights=get_header_permission($user_type_id,'8'); if($other_rights=='1'){?>
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-gear"></i><p style="color: #fff;font-size:14px;font-weight:bold;padding-bottom: 15px;padding-top: 2px;font-weight:600 !important">Reports</p></a>
              
            <ul class="sub-menu children dropdown-menu bgclrdrop <?php echo $other_show;?>">
            
              <?php $expense_rights=get_header_permission($user_type_id,'Attendance'); if($expense_rights=='1'){?>
              <li <?php echo $other4; ?>><i class="fa fa-dot-circle-o padleft"></i><a href="index1.php?filename=attendance_creation/admin" class="padrmve" <?php echo $othercd; ?>><p class="clrpad">Daily Attendance View</p></a></li>
             <?php } ?>
			 
              <?php $salesrefreport_rights=get_header_permission($user_type_id,'Attendance Report'); if($salesrefreport_rights=='1'){?>
               <li <?php echo $report4; ?>><i class="fa fa-dot-circle-o padleft"></i><a href="index1.php?filename=attendance_report/admin" class="padrmve" <?php echo $reportd; ?>> <p class="clrpad">Monthly Attendance Report </p></a></li>
               <?php }?>
            
              <?php $expense_rights=get_header_permission($user_type_id,'Daily Expense'); if($expense_rights=='1'){?>
              <li <?php echo $other3; ?>><i class="fa fa-dot-circle-o padleft"></i><a href="index1.php?filename=daily_expenses/admin" class="padrmve" <?php echo $otherc; ?>><p class="clrpad" >Expense View</p></a></li>  <?php }?>
                         
                         
			 <?php $expense_rights=get_header_permission($user_type_id,'Log Book'); if($expense_rights=='1'){?>
              <li <?php echo $other5; ?>><i class="fa fa-dot-circle-o padleft"></i><a href="index1.php?filename=log_book/admin" class="padrmve" <?php echo $otherce; ?>><p class="clrpad">Log Book View</p></a></li>
             <?php } ?>
			 </ul>
			 <?php }?>   
                </li>
			                
				<?php $dbbackup_rights=get_header_permission($user_type_id,'7'); if($dbbackup_rights=='1'){?>
                    <li><a href="#" onClick="get_db_backup();"><i class="menu-icon fa fa-download"></i><p style="color: #fff;font-size:14px;font-weight:600 !important; padding-bottom: 15px;padding-top: 2px;">DB Back Up</p> </a></li>
                    <?php
                }?>
                
                <li><a href="index1.php?filename=mobile_app/admin" ><i class="menu-icon fa fa-mobile"></i> <p style="color: #fff;font-size:14px;font-weight:600 !important;padding-bottom: 15px;padding-top: 2px;">Mobile App </p></a></li>
                
                <li><a href="#" onClick="logout_form()"><i class="menu-icon fa fa fa-power-off"></i><p style="color: #fff;font-size:14px;font-weight:600 !important;padding-bottom: 15px;padding-top: 2px;">Log Out </p></a></li>
            </ul>
        </div>
    </nav>
</aside>
<?php 
}
else
{
echo "<script>alert('Session Invalid!!!');</script>";
echo "<script>window.location.href='index.php'</script>";
}?>

 


<!-------------------------------------------------------------------------------------------------------------------------------->
<script>
function get_db_backup()
{
if (confirm("Are you sure! Want to take Backup?"))
{
jQuery.ajax({
type: "GET",
url:"backup/db_backup.php",
data: "",
success: function(msg){
jQuery("#db_backup_div").html(msg);
}
});
alert("DataBase BackUP Successfully Downloaded");
}
}

function logout_form()
{
if (confirm("Are you sure! Want to logout?"))
{
window.location.href="logout.php"; 
}
}
</script>
