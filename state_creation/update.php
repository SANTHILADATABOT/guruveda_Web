<?php
date_default_timezone_set("Asia/Kolkata");
error_reporting(0);
ob_start();
session_start();
require("../model/config.inc.php");
require("../model/Database.class.php");
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
$db->connect();

$update_id = $_GET['update_id'] ?? '';
$record1 = $db->query_first("select * from state_creation where state_id='".$db->escape($update_id)."'");
if($record1) {
	$state_name = $record1['state_name'] ?? '';
	$state_code = $record1['state_code'] ?? '';
	$description = $record1['description'] ?? '';
} else {
	$state_name = '';
	$state_code = '';
	$description = '';
}?>

<div class="breadcrumbs">
	<div class="col-sm-4">
		<div class="page-header float-left">
            <div class="page-title"><h1>State Creation<small> Update</small></h1></div>
        </div>
	</div>
	<div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right"><li><a href="#">Home</a></li><li><a href="#">Master</a></li><li class="active">State Creation</li></ol>
            </div>
        </div>
	</div>
	<div class="col-sm-1">
		<a href="index1.php?filename=state_creation/admin"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-toggle-left"></i> Back</button></a>
	</div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
	    <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body card-block">
                        <form name="state_create_form" id="state_create_form">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>State Name <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="state_name" name="state_name" tabindex="1" autofocus onKeyUp="get_validation_state_name(state_name.value);" value="<?php echo $state_name; ?>" >
                                    <span id="state_span"></span>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>State Code <span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="state_code" name="state_code" tabindex="2" onKeyPress="if((event.keyCode &lt; 46)||(event.keyCode &gt; 57)) event.returnValue = false;" value="<?php echo $state_code; ?>">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Description </label>
                                    <textarea class="form-control" id="description" name="description" tabindex="3"><?php echo $description; ?></textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="button" tabindex="4" class="btn btn-primary btn-sm" onClick="update_state_creation(state_name.value,state_code.value,description.value,'<?php echo $_GET['update_id'];?>')"><i class="fa fa-dot-circle-o"></i> Update</button>
                                <a href="index1.php?filename=state_creation/admin" style="float:right;"><button type="button" class="btn btn-secondary btn-sm">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>