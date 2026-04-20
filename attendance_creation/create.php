<script src="js/jquery-1.12.3.js"></script>
<?php 
include("../include/common_function.php");
ob_start();
session_start();
require("../model/config.inc.php");
require("../model/Database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

$sess_user_type_id = $_SESSION['sess_user_type_id'] ?? '';
$sess_staff_id = $_SESSION['sess_staff_id'] ?? '';
$sess_user_id = $_SESSION['sess_user_id'] ?? '';
$date=date("Y");
$st_date=substr($date,2);
$month=date("m");
$datee=$st_date.$month;


if(!isset($_GET['attendance_no']))
{
	$rs1 = $db->query("select attendance_no from  attendance_entry  order by att_id desc");
	$res1 = $db->fetch_array($rs1);
	if($res1)
	{
		$pur_array=explode('-',$res1['attendance_no']);

		$year1=$pur_array[1];
		$year2=substr($year1, 0, 2);
		$year='20'.$year2;
		$reg_no=$pur_array[2];
	}
	if($reg_no=='')
		$reg_nos='ATN-'.$datee.'-0001';
	elseif($year!=date("Y"))
		$reg_nos='ATN-'.$datee.'-0001';
	else
	{
		$reg_no+=1;
		$reg_nos='ATN-'.$datee.'-'.str_pad($reg_no, 4, '0', STR_PAD_LEFT);
	}
}
$date=date("Y");
$month=date("m");
$year=date("d");
$hour=date("h");
$minute=date("i");
$second=date("s");
$random_sc = date('dmyhis');
$random_no = rand(00000, 99999);
?>

<input type="hidden" name="random_no" id="random_no" value="<?php echo $random_no;?>"/> 
<input type="hidden" name="random_sc" id="random_sc" value="<?php echo $random_sc;?>"/>

<body onLoad="startTime_new()">
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title"><h1>Attendance Creation<small>Entry</small></h1></div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right"><li><a href="#">Home</a></li><li><a href="#">Admin</a></li><li class="active">Attendance Creation</li></ol>	
            </div>
        </div>
    </div>
    <div class="col-sm-1">
    	<a href="index1.php?filename=attendance_creation/admin"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-toggle-left"></i> Back</button></a>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
    	<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body card-block">
                        <form name="attendance_form" id="attendance_form">
                        
                        <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Attendance No:</label>
                                    <label><span style="font-weight:bold;color:#F00;"><?php echo $reg_nos; ?></span></label>
                                    <input type="hidden" class="form-control" id="att_no" name="att_no" value="<?php echo $reg_nos; ?>">
                                </div>
                            </div>

                        	<div class="row form-group">
                                <div class="col-md-4">
                                    <label>Entry Date<span style="color:red;">*</span></label>
                                    <input type="date" class="form-control" id="att_date" name="att_date" tabindex="2" value="<?php echo date("Y-m-d");?>">
                                </div>
                            </div>
                             <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Staff Name<span style="color:red;">*</span></label>
                                    <select name="staff_id"   id="staff_id" class="form-control" tabindex="1" autofocus onChange="get_attendance(this.value,att_date.value)" > 									 				                                      
                                     <option value="">Select</option>
                                         <?php $val = "select * from  sales_ref_creation  order by sales_ref_name ASC";
                                        $rows = $db->fetch_all_array($val);
                                        foreach($rows as $fet_get_report) {?>
                                           <option value="<?php echo htmlspecialchars($fet_get_report['sales_ref_id'] ?? '', ENT_QUOTES);?>"><?php echo ucfirst($fet_get_report['sales_ref_name'] ?? '');?></option>
                                            <?php
                                        }?>
                                    </select> 
                                </div>
                            </div>
                           
                            <div class="row form-group" >
                                <div class="col-md-4" id="travel">
                                    <label>Time</label>
           							 <strong><div id="txt_new" style="font-size:18px"> </div></strong>
                						<input type="hidden"  class="form-control numeric" name="entry_time" id="entry_time"  value="" tabindex="8">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Attendance Type<span style="color:red;">*</span></label>
                                   <div id="att_type_id_div">
                                    <select name="att_type_id"   id="att_type_id" class="form-control" tabindex="1" autofocus> 												                                      <option value="">Select</option>
                                         
                                    </select> 
                                    </div>
                                </div>
                            </div>
							 

                            <div class="card-footer">
                                <button type="button"  class="btn btn-primary btn-sm" tabindex="4" onClick="add_attendance_creation(random_no.value,random_sc.value,att_no.value,att_date.value,staff_id.value,entry_time.value,att_type_id.value)"><i class="fa fa-dot-circle-o"></i>&nbsp;Submit</button>
                                <a href="index1.php?filename=attendance_creation/admin" style="float:right;"><button type="button" class="btn btn-secondary btn-sm">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>