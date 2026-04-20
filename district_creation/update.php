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
$record1 = $db->query_first("select * from district_creation where district_id='".$db->escape($update_id)."'");
if($record1) {
	$state_id = $record1['state_id'] ?? '';
	$district_name = $record1['district_name'] ?? '';
	$description = $record1['description'] ?? '';
} else {
	$state_id = '';
	$district_name = '';
	$description = '';
}?>
<div class="breadcrumbs">
	<div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title"><h1>District Creation<small> Update</small></h1></div>
        </div>
	</div>
	<div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right"><li><a href="#">Home</a></li><li><a href="#">Master</a></li><li class="active">District Creation</li></ol>
            </div>
        </div>
	</div>
	<div class="col-sm-1">
		<a href="index1.php?filename=district_creation/admin"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-toggle-left"></i> Back</button></a>
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
                                    <label>State Name<span style="color:red;">*</span></label>
                                    <select name="state_id" id="state_id" class="form-control" tabindex="1" autofocus>
                                        <?php $val = "select * from  state_creation where delete_status!='1' order by state_name ASC";
                                        $rows = $db->fetch_all_array($val);
                                        foreach($rows as $fet_get_report) {?>
                                            <option value="<?php echo htmlspecialchars($fet_get_report['state_id'] ?? '', ENT_QUOTES);?>" <?php if($state_id==($fet_get_report['state_id'] ?? '')){echo "selected";}?>><?php echo ucfirst($fet_get_report['state_name'] ?? '');?></option>
                                            <?php
                                        }?>
                                    </select> 
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>District Name<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="district_name" name="district_name" tabindex="2" value="<?php echo $district_name; ?>">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Description </label>
                                    <textarea class="form-control" id="description" name="description" tabindex="3" value="<?php echo $description; ?>"></textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="button" tabindex="4" class="btn btn-primary btn-sm" onClick="update_district_creation(state_id.value,district_name.value,description.value,'<?php echo $_GET['update_id'];?>')"><i class="fa fa-dot-circle-o"></i> Update</button>
                                <a href="index1.php?filename=district_creation/admin" style="float:right;"><button type="button" class="btn btn-secondary btn-sm">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>