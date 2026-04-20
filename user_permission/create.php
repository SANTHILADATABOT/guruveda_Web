<style>
.style {font-size:13px;}
</style>
<script>
/*DASH BOARD*/
function dashboard_select_All(source)
{
	checkboxes = document.getElementsByName('dashboard');
	for(var j in checkboxes)
		checkboxes[j].checked = source.checked;
}
function get_dashboard_check_values()
{
    var answers = [];
    jQuery.each(jQuery('.dashboard_field:checked'), function() {
        answers.push(jQuery(this).val()); 
    });
	document.getElementById('dashboard_ent').value=answers;
	return false;
}

/*ADMIN*/
function admin_select_All(source)
{
	checkboxes = document.getElementsByName('admin');
	for(var j in checkboxes)
		checkboxes[j].checked = source.checked;
}
function get_admin_check_values()
{
	document.getElementById("admin_user_form").checked = true;
	var answers = [];
    jQuery.each(jQuery('.admin_field:checked'), function() {
        answers.push(jQuery(this).val()); 
    });
	if(answers!='2') { document.getElementById("admin_user_form").checked = true; }
	else{document.getElementById("admin_user_form").checked = false; answers="";}
	document.getElementById('admin_ent').value=answers;
	return false;
}

/*MASTER*/
function master_select_All(source)
{
	checkboxes = document.getElementsByName('master');
	for(var j in checkboxes)
		checkboxes[j].checked = source.checked;
}
function get_master_check_values()
{
	document.getElementById("master_user_form").checked = true;
    var answers = [];
    jQuery.each(jQuery('.master_field:checked'), function() {
        answers.push(jQuery(this).val()); 
    });
	if(answers!='3') { document.getElementById("master_user_form").checked = true; }
	else{document.getElementById("master_user_form").checked = false; answers="";}
	document.getElementById('master_ent').value=answers;
	return false;
}

/*INWARD*/
function inward_select_All(source)
{
	checkboxes = document.getElementsByName('inward');
	for(var j in checkboxes)
		checkboxes[j].checked = source.checked;
}
function get_inward_check_values()
{
	document.getElementById("inward_user_form").checked = true;
    var answers = [];
    jQuery.each(jQuery('.inward_field:checked'), function() {
        answers.push(jQuery(this).val()); 
    });
	if(answers!='4') { document.getElementById("inward_user_form").checked = true; }
	else{document.getElementById("inward_user_form").checked = false; answers="";}
	document.getElementById('inward_ent').value=answers;
	return false;
}

/*SALES*/
function sales_select_All(source)
{
	checkboxes = document.getElementsByName('sales');
	for(var j in checkboxes)
		checkboxes[j].checked = source.checked;
}
function get_sales_check_values()
{
	document.getElementById("sales_user_form").checked = true;
    var answers = [];
    jQuery.each(jQuery('.sales_field:checked'), function() {
        answers.push(jQuery(this).val()); 
    });
	if(answers!='5') { document.getElementById("sales_user_form").checked = true; }
	else{document.getElementById("sales_user_form").checked = false; answers="";}
	document.getElementById('sales_ent').value=answers;
	return false;
}


/*OTHERS*/

function others_select_All(source)
{
	checkboxes = document.getElementsByName('others');
	for(var j in checkboxes)
		checkboxes[j].checked = source.checked;
}

function get_others_check_values()
{
	document.getElementById("others_user_form").checked = true;
    var answers = [];
    jQuery.each(jQuery('.others_field:checked'), function() {
        answers.push(jQuery(this).val()); 
    });
	if(answers!='8') { document.getElementById("others_user_form").checked = true; }
	else{document.getElementById("others_user_form").checked = false; answers="";}
	document.getElementById('others_ent').value=answers;
	return false;
}

/*REPORTS*/
function reports_select_All(source)
{
	checkboxes = document.getElementsByName('reports');
	for(var j in checkboxes)
		checkboxes[j].checked = source.checked;
}
function get_reports_check_values()
{
	document.getElementById("reports_user_form").checked = true;
    var answers = [];
    jQuery.each(jQuery('.reports_field:checked'), function() {
        answers.push(jQuery(this).val()); 
    });
	if(answers!='6') { document.getElementById("reports_user_form").checked = true; }
	else{document.getElementById("reports_user_form").checked = false; answers="";}
	document.getElementById('reports_ent').value=answers;
	return false;
}

/*BACK UP*/
function backup_select_All(source)
{
	checkboxes = document.getElementsByName('backup');
	for(var j in checkboxes)
		checkboxes[j].checked = source.checked;
}
function get_backup_check_values()
{
    var answers = [];
    jQuery.each(jQuery('.backup_field:checked'), function() {
        answers.push(jQuery(this).val()); 
    });
	document.getElementById('backup_ent').value=answers;
	return false;
}
</script>
<?php
$user=$db->query_first("select user_type from user_type where user_type_id='".$db->escape($_GET['user_id'] ?? '')."'");
$user_login=$user['user_type'] ?? '';

$sql="select * from user_permissions ";
$rs=$db->query($sql);
while($rsdata=$db->fetch_array($rs))
{
	$user_screen=$rsdata['user_screen'];
}

$sql11="select * from  user_permission_main where main_id='".$db->escape($_GET['edit_id'] ?? '')."'";
$rs1=$db->query($sql11);
while($rsdatas=$db->fetch_array($rs1))
{
	$user_name11=$rsdatas['user_name'];
}

function admin_screen_name1($user_screen,$user_login)
{
	global $db;
	 $sql_user="select * from user_permissions where box_name='".$db->escape($user_screen)."' and user_type_id='".$db->escape($user_login)."'";
	$rs_user=$db->query($sql_user);
	while($rsdata_user=$rs_user->fetch_object())
	{ 
		$permission=$rsdata_user->permission;
	}
	return $permission;
}

if(!function_exists('db_num_rows')) {
	function db_num_rows($result) {
		return ($result && $result instanceof mysqli_result) ? $result->num_rows : 0;
	}
}
?>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title"><h1>User Creation<small> Create</small></h1></div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right"><li><a href="#">Home</a></li><li><a href="#">Admin</a></li><li class="active">User Creation</li></ol>
            </div>
        </div>
    </div>
    <div class="col-sm-1">
        <a href="index1.php?filename=user_creation/admin"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-toggle-left"></i> Back</button></a>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body card-block">
                        <form class="form-horizontal" id="user_permission_form" method="POST">
                            <div class="row form-group">
                               <table width="100%">
                                <tr>
                                    <td width="18" height="30" align="left" class="style1">&nbsp;</td>
                                    <td width="126" align="left" class="style1">User Type<span class="style2">*</span></td>
                                    <td width="1171" colspan="3" class="field">
                                    <select name="user_name" id="user_name" class="form-control" autofocus style="width:200px;height:30px;border:1px solid #a1a1a1;">
                                        <?php
                                        $sql="select * from user_type where delete_status!='1' ORDER BY user_type ASC ";
                                        $rs=->query($sql);
                                        while($rsdata=$rs->fetch_object())
                                        {
                                            $usertype=$rsdata->user_type;
                                            $user_type_id=$rsdata->user_type_id;
                                            ?>
                                            <option value="<?php echo $usertype;?>"<?php if($user_type_id==$_GET['user_id']){echo "Selected";}?>><?php echo $rsdata->user_type;?></option>
                                            <?php
                                        }?>
                                    </select>
                                    </td>
                                </tr>
                            </table>
<!------------------------------------------------------------------------DASH BOARD------------------------------------------------------------------------->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="2" height="30" align="left" class="style">&nbsp;&nbsp;<span class="style1">&nbsp;&nbsp;</span></td>
        <?php $sql_subscreen=$sql="select * from user_permissions where box_name='1' and user_type_id='$user_login'";
        $rs_subscreen=->query($sql_subscreen);
        $rscount_subscreen=db_num_rows($rs_subscreen);
        while($rsdata_subscreen=$rs_subscreen->fetch_object())
        { 
            $dashboard_permission=$rsdata_subscreen->permission;
        }?>
        <td width="99%" colspan="2" align="left" class="style" style="color:#CC3399">DASH BOARD <input type="checkbox" name="dashboard_user_form" id="dashboard_user_form" onclick="dashboard_select_All(this);get_dashboard_check_values();" class="dashboard_field same_field" value="1" <?php if($dashboard_permission=='1'){?>checked<?php }else{?><?php }?>/></td>
    </tr>
</table>
<?php
$sql_subscreen=$sql="select * from user_rights where form_id='1'";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
$columns_counter=0; 
echo "<table width='100%' border='0' cellspacing='0' cellpadding='3'>";
echo '<tr>';
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{ 
    $user_screen=$rsdata_subscreen->user_screen;
    $form_id=$rsdata_subscreen->form_id;
    $user_id=admin_screen_name1($user_screen,$user_login);
    if(($user_id=='1')&&($user_screen!=''))
    {
        echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='dashboard' onClick='get_dashboard_check_values();' id='dashboard' class='rights dashboard_field' value='".$user_screen."' checked>".$user_screen."</td>";
    }
    elseif($user_screen!='')
    {
        echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='dashboard' onClick='get_dashboard_check_values();' id='dashboard' class='rights dashboard_field' value='".$user_screen."' >".$user_screen."</td>";
    }
    $columns_counter++; 
    if($columns_counter==4)
    { 
        echo '</tr><tr>'; //close and open a row if $columns_counter=3; 
        $columns_counter=0; 
    } 
} 
echo "</tr></table>";  
?>
<?php 
$dashboard_count=1;
$sql_subscreen=$sql="select box_name from user_permissions where form_id='1' and permission='1' and user_type_id='$user_login'";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{
    if($dashboard_count!=$rscount_subscreen)
        $dashboard_box_name.=$rsdata_subscreen->box_name.',';
    else if($dashboard_count==$rscount_subscreen)
        $dashboard_box_name.=$rsdata_subscreen->box_name;
    $dashboard_count++;
}?>
<input type="hidden" name="dashboard_ent" id="dashboard_ent"  value="<?php echo $dashboard_box_name;?>" />
</br>
<!----------------------------------------------------------------------------ADMIN--------------------------------------------------------------------------->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="2" height="30" align="left" class="style">&nbsp;&nbsp;<span class="style1">&nbsp;&nbsp;</span></td>
        <?php 
		$sql_subscreen=$sql="select * from user_permissions where box_name='2' and user_type_id='$user_login'";
       	$rs_subscreen=->query($sql_subscreen);
        $rscount_subscreen=db_num_rows($rs_subscreen);
        while($rsdata_subscreen=$rs_subscreen->fetch_object())
        { 
            $admin_permission=$rsdata_subscreen->permission;
        }?>
        <td width="99%" colspan="2" align="left" class="style" style="color:#CC3399">ADMIN <input type="checkbox" name="admin_user_form" id="admin_user_form" onclick="admin_select_All(this);get_admin_check_values();" class="admin_field same_field" value="2" <?php if($admin_permission=='1'){?>checked<?php }else{?><?php }?>/></td>
    </tr>
</table>
<?php
$sql_subscreen="select * from user_rights where form_id='2' ";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
$columns_counter=0;
echo "<table width='100%' border='0' cellspacing='0' cellpadding='3'>";
echo '<tr>';
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{
   	$user_screen=$rsdata_subscreen->user_screen;
    $form_id=$rsdata_subscreen->form_id;
    $user_id=admin_screen_name1($user_screen,$user_login);
    if(($user_id=='1')&&($user_screen!=''))
    {
        echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='admin' onClick='get_admin_check_values();' id='admin' class='rights admin_field' value='".$user_screen."' checked >".$user_screen."</td>";
    }
    elseif($user_screen!='')
    {
        echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='admin' onClick='get_admin_check_values();' id='admin' class='rights admin_field' value='".$user_screen."'>".$user_screen."</td>";
    }		
    $columns_counter++; 
    if($columns_counter==4)
    { 
        echo '</tr><tr>'; //close and open a row if $columns_counter=4; 
        $columns_counter=0; 
    } 
} 
echo "</tr></table>";  
?>
<?php
$admin_count=1;
$sql_subscreen=$sql="select box_name from user_permissions where form_id='2' and permission='1' and user_type_id='$user_login'";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{
	if($admin_count!=$rscount_subscreen)
    	$admin_box_name.=$rsdata_subscreen->box_name.',';
	else if($admin_count==$rscount_subscreen)
    	$admin_box_name.=$rsdata_subscreen->box_name;
	$admin_count++;
}?>
<input type="hidden" name="admin_ent" id="admin_ent" value="<?php echo $admin_box_name;?>"/>
</br>

<!----------------------------------------------------------------------MASTER ENTRY------------------------------------------------------------------------->
<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
    <tr>
    	<td colspan="3" height="10"></td>
    </tr>
    <tr>  
        <td width="2%" height="27" align="left" class="style">&nbsp;&nbsp;<span class="style1">&nbsp;&nbsp;</span></td>
        <?php 
        $sql_subscreen=$sql="select * from user_permissions where box_name='3' and user_type_id='$user_login'";
        $rs_subscreen=->query($sql_subscreen);
        $rscount_subscreen=db_num_rows($rs_subscreen);
        while($rsdata_subscreen=$rs_subscreen->fetch_object())
        { 
            $master_permission=$rsdata_subscreen->permission;
        }?>
        <td width="99%" colspan="2" align="left" class="style" style="color:#CC3399">MASTER ENTRY <input type="checkbox" name="master_user_form" id="master_user_form" onclick="master_select_All(this);get_master_check_values();" class="master_field same_field" value="3" <?php if($master_permission=='1'){?> checked <?php }else{?><?php } ?>/></td>
    </tr>
</table>
<?php
$sql_subscreen=$sql="select * from user_rights where form_id='3'";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
$columns_counter=0; 
echo "<table width='100%' border='0' cellspacing='0' cellpadding='3'>";
echo '<tr>';
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{ 
    $user_screen=$rsdata_subscreen->user_screen;
    $form_id=$rsdata_subscreen->form_id;
    $user_id=admin_screen_name1($user_screen,$user_login);
    if(($user_id=='1')&&($user_screen!=''))
    {
		echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='master' onClick='get_master_check_values(),master_main_check(this.id);' id='master' class='rights master_field' value='".$user_screen."' checked>".$user_screen."</td>";
    }
    elseif($user_screen!='')
    {
        echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='master' onClick='get_master_check_values(),master_main_check(this.id);' id='master' class='rights master_field'  value='".$user_screen."' >".$user_screen."</td>";
    }
    $columns_counter++; 
    if($columns_counter==4)
    {
        echo '</tr><tr>';
        $columns_counter=0;
    } 
} 
echo "</tr></table>";
?>
<?php
$master_count=1;
$sql_subscreen=$sql="select box_name from user_permissions where form_id='3' and permission='1' and user_type_id='$user_login' ";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{
	if($master_count!=$rscount_subscreen)
    	$master_box_name.=$rsdata_subscreen->box_name.',';
	else if($master_count==$rscount_subscreen)
    	$master_box_name.=$rsdata_subscreen->box_name;
	$master_count++;
}?>
<input type="hidden" name="master_ent" id="master_ent" value="<?php echo $master_box_name;?>"/>
</br>
</br>
<!---------------------------------------------------------------------INWARD ENTRY------------------------------------------------------------------------->
<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
    <tr>
    	<td colspan="3" height="10"></td>
    </tr>
    <tr>  
        <td width="2%" height="27" align="left" class="style">&nbsp;&nbsp;<span class="style1">&nbsp;&nbsp;</span></td>
        <?php 
        $sql_subscreen=$sql="select * from user_permissions where box_name='4' and user_type_id='$user_login' ";
        $rs_subscreen=->query($sql_subscreen);
        $rscount_subscreen=db_num_rows($rs_subscreen);
        while($rsdata_subscreen=$rs_subscreen->fetch_object())
        { 
            $inward_permission=$rsdata_subscreen->permission;
        }?>
        <td width="99%" colspan="2" align="left" class="style" style="color:#CC3399">INWARD <input type="checkbox" name="inward_user_form" id="inward_user_form" onclick="inward_select_All(this);get_inward_check_values();" class="inward_field same_field" value="4" <?php if($inward_permission=='1'){?> checked <?php }else{?><?php } ?>/></td>
    </tr>
</table>
<?php
$sql_subscreen=$sql="select * from user_rights where form_id='4'";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
$columns_counter=0; 
echo "<table width='100%' border='0' cellspacing='0' cellpadding='3'>";
echo '<tr>';
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{ 
    $user_screen=$rsdata_subscreen->user_screen;
    $form_id=$rsdata_subscreen->form_id;
    $user_id=admin_screen_name1($user_screen,$user_login);
    if(($user_id=='1')&&($user_screen!=''))
    {
		echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='inward' onClick='get_inward_check_values(),inward_main_check(this.id);' id='inward' class='rights inward_field' value='".$user_screen."' checked>".$user_screen."</td>";
    }
    elseif($user_screen!='')
    {
        echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='inward' onClick='get_inward_check_values(),inward_main_check(this.id);' id='inward' class='rights inward_field' value='".$user_screen."' >".$user_screen."</td>";
    }
    $columns_counter++; 
    if($columns_counter==4)
    {
        echo '</tr><tr>';
        $columns_counter=0;
    } 
} 
echo "</tr></table>";
?>
<?php
$inward_count=1;
$sql_subscreen=$sql="select box_name from user_permissions where form_id='4' and permission='1' and user_type_id='$user_login'";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{
	if($inward_count!=$rscount_subscreen)
    	$inward_box_name.=$rsdata_subscreen->box_name.',';
	else if($inward_count==$rscount_subscreen)
    	$inward_box_name.=$rsdata_subscreen->box_name;
	$purchase_count++;
}?>
<input type="hidden" name="inward_ent" id="inward_ent" value="<?php echo $inward_box_name;?>"/>
</br>
<!---------------------------------------------------------------------SALES ENTRY------------------------------------------------------------------------>
<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
    <tr>
    	<td colspan="3" height="10"></td>
    </tr>
    <tr>  
        <td width="2%" height="27" align="left" class="style">&nbsp;&nbsp;<span class="style1">&nbsp;&nbsp;</span></td>
        <?php 
        $sql_subscreen=$sql="select * from user_permissions where box_name='5' and user_type_id='$user_login' ";
        $rs_subscreen=->query($sql_subscreen);
        $rscount_subscreen=db_num_rows($rs_subscreen);
        while($rsdata_subscreen=$rs_subscreen->fetch_object())
        { 
            $sales_permission=$rsdata_subscreen->permission;
        }?>
        <td width="99%" colspan="2" align="left" class="style" style="color:#CC3399">SALES <input type="checkbox" name="sales_user_form" id="sales_user_form" onclick="sales_select_All(this);get_sales_check_values();" class="sales_field same_field" value="5" <?php if($sales_permission=='1'){?> checked <?php }else{?><?php } ?>/></td>
    </tr>
</table>
<?php
$sql_subscreen=$sql="select * from user_rights where form_id='5'";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
$columns_counter=0; 
echo "<table width='100%' border='0' cellspacing='0' cellpadding='3'>";
echo '<tr>';
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{ 
    $user_screen=$rsdata_subscreen->user_screen;
    $form_id=$rsdata_subscreen->form_id;
    $user_id=admin_screen_name1($user_screen,$user_login);
    if(($user_id=='1')&&($user_screen!=''))
    {
		echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='sales' onClick='get_sales_check_values(),sales_main_check(this.id);' id='sales' class='rights sales_field' value='".$user_screen."' checked>".$user_screen."</td>";
    }
    elseif($user_screen!='')
    {
        echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='sales' onClick='get_sales_check_values(),sales_main_check(this.id);' id='sales' class='rights sales_field' value='".$user_screen."' >".$user_screen."</td>";
    }
    $columns_counter++; 
    if($columns_counter==4)
    {
        echo '</tr><tr>';
        $columns_counter=0;
    } 
} 
echo "</tr></table>";
?>
<?php
$sales_count=1;
$sql_subscreen=$sql="select box_name from user_permissions where form_id='5' and permission='1' and user_type_id='$user_login'";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{
	if($sales_count!=$rscount_subscreen)
    	$sales_box_name.=$rsdata_subscreen->box_name.',';
	else if($sales_count==$rscount_subscreen)
    	$sales_box_name.=$rsdata_subscreen->box_name;
	$sales_count++;
}?>
<input type="hidden" name="sales_ent" id="sales_ent" value="<?php echo $sales_box_name;?>"/>
</br>
<!------------------------------------------------------------------------REPORTS----------------------------------------------------------------------------->
<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
    <tr>
    	<td colspan="3" height="10"></td>
    </tr>
    <tr>  
        <td width="2%" height="27" align="left" class="style">&nbsp;&nbsp;<span class="style1">&nbsp;&nbsp;</span></td>
        <?php 
        $sql_subscreen=$sql="select * from user_permissions where box_name='6' and user_type_id='$user_login'";
        $rs_subscreen=->query($sql_subscreen);
        $rscount_subscreen=db_num_rows($rs_subscreen);
        while($rsdata_subscreen=$rs_subscreen->fetch_object())
        { 
            $reports_permission=$rsdata_subscreen->permission;
        }?>
        <td width="99%" colspan="2" align="left" class="style" style="color:#CC3399">REPORTS <input type="checkbox" name="reports_user_form" id="reports_user_form" onclick="reports_select_All(this);get_reports_check_values();" class="reports_field same_field" value="6" <?php if($reports_permission=='1'){?> checked <?php }else{?><?php } ?>/></td>
    </tr>
</table>
<?php
$sql_subscreen=$sql="select * from user_rights where form_id='6'";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
$columns_counter=0; 
echo "<table width='100%' border='0' cellspacing='0' cellpadding='3'>";
echo '<tr>';
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{ 
    $user_screen=$rsdata_subscreen->user_screen;
    $form_id=$rsdata_subscreen->form_id;
    $user_id=admin_screen_name1($user_screen,$user_login);
    if(($user_id=='1')&&($user_screen!=''))
    {
		echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='reports' onClick='get_reports_check_values();' id='reports' class='rights reports_field' value='".$user_screen."' checked>".$user_screen."</td>";
    }
    elseif($user_screen!='')
    {
        echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='reports' onClick='get_reports_check_values();' id='reports' class='rights reports_field' value='".$user_screen."' >".$user_screen."</td>";
    }
    $columns_counter++; 
    if($columns_counter==4)
    {
        echo '</tr><tr>';
        $columns_counter=0;
    } 
} 
echo "</tr></table>";
?>
<?php
$reports_count=1;
$sql_subscreen=$sql="select box_name from user_permissions where form_id='6' and permission='1' and user_type_id='$user_login'";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{
	if($reports_count!=$rscount_subscreen)
    	$reports_box_name.=$rsdata_subscreen->box_name.',';
	else if($reports_count==$rscount_subscreen)
    	$reports_box_name.=$rsdata_subscreen->box_name;
	$reports_count++;
}?>
<input type="hidden" name="reports_ent" id="reports_ent" value="<?php echo $reports_box_name;?>"/>
</br>


<!------------------------------------------------------------------------Others----------------------------------------------------------------------------->
<table width="100%" border="0" cellpadding="0" cellspacing="0"> 
    <tr>
    	<td colspan="3" height="10"></td>
    </tr>
    <tr>  
        <td width="2%" height="27" align="left" class="style">&nbsp;&nbsp;<span class="style1">&nbsp;&nbsp;</span></td>
        <?php 
        $sql_subscreen=$sql="select * from user_permissions where box_name='8' and user_type_id='$user_login'";
        $rs_subscreen=->query($sql_subscreen);
        $rscount_subscreen=db_num_rows($rs_subscreen);
        while($rsdata_subscreen=$rs_subscreen->fetch_object())
        { 
            $others_permission=$rsdata_subscreen->permission;
        }?>
        <td width="99%" colspan="2" align="left" class="style" style="color:#CC3399">OTHERS <input type="checkbox" name="others_user_form" id="others_user_form" onclick="others_select_All(this);get_others_check_values();" class="others_field same_field" value="8" <?php if($others_permission=='1'){?> checked <?php }else{?><?php } ?>/></td>
    </tr>
</table>
<?php
$sql_subscreen=$sql="select * from user_rights where form_id='8'";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
$columns_counter=0; 
echo "<table width='100%' border='0' cellspacing='0' cellpadding='3'>";
echo '<tr>';
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{ 
    $user_screen=$rsdata_subscreen->user_screen;
    $form_id=$rsdata_subscreen->form_id;
    $user_id=admin_screen_name1($user_screen,$user_login);
    if(($user_id=='1')&&($user_screen!=''))
    {
		echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='others' onClick='get_others_check_values();' id='others' class='rights others_field' value='".$user_screen."' checked>".$user_screen."</td>";
    }
    elseif($user_screen!='')
    {
        echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='others' onClick='get_others_check_values();' id='others' class='rights others_field' value='".$user_screen."' >".$user_screen."</td>";
    }
    $columns_counter++; 
    if($columns_counter==4)
    {
        echo '</tr><tr>';
        $columns_counter=0;
    } 
} 
echo "</tr></table>";
?>
<?php
$others_count=1;
$sql_subscreen=$sql="select box_name from user_permissions where form_id='8' and permission='1' and user_type_id='$user_login'";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{
	if($others_count!=$rscount_subscreen)
    	$others_box_name.=$rsdata_subscreen->box_name.',';
	else if($others_count==$rscount_subscreen)
    	$others_box_name.=$rsdata_subscreen->box_name;
	$others_count++;
}?>
<input type="hidden" name="others_ent" id="others_ent" value="<?php echo $others_box_name;?>"/>
</br>


<!------------------------------------------------------------------------BACK UP---------------------------------------------------------------------------->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    	<td colspan="3" height="10"></td>
    </tr>
    <tr>
        <td width="2" height="30" align="left" class="style">&nbsp;&nbsp;<span class="style1">&nbsp;&nbsp;</span></td>
        <?php $sql_subscreen=$sql="select * from user_permissions where box_name='7' and user_type_id='$user_login'";
        $rs_subscreen=->query($sql_subscreen);
        $rscount_subscreen=db_num_rows($rs_subscreen);
        while($rsdata_subscreen=$rs_subscreen->fetch_object())
        { 
            $backup_permission=$rsdata_subscreen->permission;
        }?>
        <td width="99%" colspan="2" align="left" class="style" style="color:#CC3399">BACK UP <input type="checkbox" name="backup_user_form" id="backup_user_form" onclick="backup_select_All(this);get_backup_check_values();" class="backup_field same_field" value="7" <?php if($backup_permission=='1'){?>checked<?php }else{?><?php }?>/></td>
    </tr>
</table>
<?php
$sql_subscreen=$sql="select * from user_rights where form_id='7'";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
$columns_counter=0; 
echo "<table width='100%' border='0' cellspacing='0' cellpadding='3'>";
echo '<tr>';
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{ 
    $user_screen=$rsdata_subscreen->user_screen;
    $form_id=$rsdata_subscreen->form_id;
    $user_id=admin_screen_name1($user_screen,$user_login);
    if(($user_id=='1')&&($user_screen!=''))
    {
        echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='backup' onClick='get_backup_check_values();' id='backup' class='rights backup_field' value='".$user_screen."' checked>".$user_screen."</td>";
    }
    elseif($user_screen!='')
    {
        echo "<td width='15%' class='small_text' style='padding-left:25px;font-family:verdana; font-size:12px;'><input type='checkbox' name='backup' onClick='get_backup_check_values();' id='backup' class='rights backup_field' value='".$user_screen."' >".$user_screen."</td>";
    }
    $columns_counter++; 
    if($columns_counter==4)
    { 
        echo '</tr><tr>'; //close and open a row if $columns_counter=3; 
        $columns_counter=0; 
    } 
} 
echo "</tr></table>";  
?>
<?php 
$backup_count=1;
$sql_subscreen=$sql="select box_name from user_permissions where form_id='7' and permission='1' and user_type_id='$user_login'";
$rs_subscreen=->query($sql_subscreen);
$rscount_subscreen=db_num_rows($rs_subscreen);
while($rsdata_subscreen=$rs_subscreen->fetch_object())
{
	if($backup_count!=$rscount_subscreen)
    	$backup_box_name.=$rsdata_subscreen->box_name.',';
	else if($backup_count==$rscount_subscreen)
    	$backup_box_name.=$rsdata_subscreen->box_name;
	$backup_count++;
}?>
<input type="hidden" name="backup_ent" id="backup_ent"  value="<?php echo $backup_box_name;?>" />
</br>
<!---------------------------------------------------------------------END----------------------------------------------------------------------------------->
                            </div>
							<div class="card-footer">
                                <button type="button" class="btn btn-primary btn-sm" onClick="user_permission_add(user_name.value,dashboard_ent.value,admin_ent.value,master_ent.value,inward_ent.value,sales_ent.value,reports_ent.value,backup_ent.value,others_ent.value)"><i class="fa fa-dot-circle-o"></i> Submit</button>
                                <a href="index1.php?filename=user_permission/admin" style="float:right;"><button type="button" class="btn btn-secondary btn-sm">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>