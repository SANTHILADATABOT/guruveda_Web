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

$update_id = $_GET['update_id'] ?? '';
$record1 = $db->query_first("select * from attendance_entry where att_id='".$db->escape($update_id)."'");
if($record1) {
	$attendance_no = $record1['attendance_no'] ?? '';
	$expense_type = $record1['expense_type'] ?? '';
	$staff_name = $record1['staff_name'] ?? '';
	$attendance_type = $record1['attendance_type'] ?? '';
	$attendance_time = $record1['attendance_time'] ?? '';
	$entry_date = $record1['entry_date'] ?? '';
} else {
	$attendance_no = '';
	$expense_type = '';
	$staff_name = '';
	$attendance_type = '';
	$attendance_time = '';
	$entry_date = '';
}
?>




<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title"><h1>Attendance Creation<small>Update</small></h1></div>
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
                                    <label>Attendance No&nbsp;:&nbsp;</label>
                                    <label><span style="font-weight:bold;color:#F00;"><?php echo $attendance_no; ?></span></label>
                                    <input type="hidden" class="form-control" id="att_no" name="att_no" value="<?php echo $attendance_no; ?>">
                                </div>
                            </div>

                        	<div class="row form-group">
                                <div class="col-md-4">
                                    <label>Entry Date&nbsp;:&nbsp;<span style="font-weight:bold;"><?php echo date("d-m-Y",strtotime($entry_date)); ?></span></label>
                                   
                                </div>
                            </div>
                             <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Staff Name<span style="color:red;">*</span></label><br>
                                     <label><div style="font-weight:bold;"><?php echo get_sales_ref_name($staff_name);?></div></</label>
                                </div>
                            </div>
                           
                            <div class="row form-group" >
                                <div class="col-md-4" id="travel">
                                    <label>Time</label>
           							 
                					<input type="time"  class="form-control numeric" style="font-weight:bold" name="entry_time" id="entry_time"  value="<?php echo $attendance_time;?>" tabindex="8">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Attendance Type<span style="color:red;">*</span></label><br>
                                  	<label><div style="font-weight:bold;"><?php echo get_attendance_type($attendance_type);?></div></label>
                                </div>
                            </div>
							 

                            <div class="card-footer">
                                <button type="button"  class="btn btn-primary btn-sm" tabindex="4" onClick="update_attendance_creation(entry_time.value,'<?php echo $_GET['update_id'];?>','<?php echo $staff_name;?>','<?php echo $entry_date;?>')"><i class="fa fa-dot-circle-o"></i>&nbsp;Update</button>
                                <a href="index1.php?filename=attendance_creation/admin" style="float:right;"><button type="button" class="btn btn-secondary btn-sm">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
