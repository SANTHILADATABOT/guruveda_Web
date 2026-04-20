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
$record1 = $db->query_first("select * from daily_expense where exp_id='".$db->escape($update_id)."'");
if($record1) {
	$entry_date = $record1['entry_date'] ?? '';
	$expense_type = $record1['expense_type'] ?? '';
	$amount = $record1['amount'] ?? '';
	$description = $record1['description'] ?? '';
	$exp_no = $record1['expense_no'] ?? '';
	$sub_exp = $record1['sub_expense_type'] ?? '';
} else {
	$entry_date = '';
	$expense_type = '';
	$amount = '';
	$description = '';
	$exp_no = '';
	$sub_exp = '';
}?>



<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title"><h1>Daily Expenses Creation<small> Create</small></h1></div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right"><li><a href="#">Home</a></li><li><a href="#">Admin</a></li><li class="active">Daily Expenses Creation</li></ol>	
            </div>
        </div>
    </div>
    <div class="col-sm-1">
    	<a href="index1.php?filename=daily_expenses/admin"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-toggle-left"></i> Back</button></a>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
    	<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body card-block">
                        <form name="daily_expense_form" id="state_create_form">
                        
                        <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Expense No:</label>
                                    <label><span style="font-weight:bold;color:#F00;"><?php echo $exp_no; ?></span></label>
                                    
                                </div>
                            </div>

                        	<div class="row form-group">
                                <div class="col-md-4">
                                    <label>Expense Date<span style="color:red;">*</span></label>
                                    <input type="date" class="form-control" id="exp_date" name="exp_date" tabindex="2" value="<?php echo $entry_date;?>">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Expense Type<span style="color:red;">*</span></label>
                                    <select name="exp_type_id"   id="exp_type_id" class="form-control" tabindex="1" autofocus onChange="get_travel(this.value)"> 									 <option value="">Select</option>
                                         <?php $val = "select * from  daily_expense_type  order by expense_name ASC";
                                        $rows = $db->fetch_all_array($val);
                                        foreach($rows as $fet_get_report) {?>
                                           <option value="<?php echo htmlspecialchars($fet_get_report['expense_type_id'] ?? '', ENT_QUOTES);?>" <?php if($expense_type==($fet_get_report['expense_type_id'] ?? '')){?> selected <?php }?>><?php echo ucfirst($fet_get_report['expense_name'] ?? '');?></option>
                                            <?php
                                        }?>
                                    </select> 
                                </div>
                            </div>
                            <?php if($sub_exp!='')
							{?>
                            	
                               
							 <div class="row form-group" >
                                <div class="col-md-4" id="travel">
                                    <label> Travel Expense Type<span style="color:red;">*</span></label>
                                    <select name="travel_exp"   id="travel_exp" class="form-control" tabindex="1" autofocus> 
                                        <option value="">Select</option>
                                         <option value="bike" <?php if($sub_exp=='bike'){?> selected <?php }?>>Bike</option>
                                         <option value="bus" <?php if($sub_exp=='bus'){?> selected <?php }?>>Bus</option>
                                         <option value="train" <?php if($sub_exp=='train'){?> selected <?php }?>>Train</option>
                                         <option value="car" <?php if($sub_exp=='car'){?> selected <?php }?>>Car</option>
                                        
                                    </select> 
                                </div>
                            </div>
                             <?php }else {
								 ?>
                                 <input type="hidden" id="travel_exp" name="travel_exp" value="">
                                 
                                 <?php }?>
                             
							
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Amount<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="exp_amount" name="exp_amount" tabindex="2" value="<?php echo $amount?>">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Description </label>
                                    <textarea class="form-control" id="description" name="description" tabindex="3" ><?php echo $description;?></textarea>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="button"  class="btn btn-primary btn-sm" tabindex="4" onClick="update_daily_expenses(exp_date.value,exp_type_id.value,travel_exp.value,exp_amount.value,description.value,'<?php echo $_GET['update_id'];?>')"><i class="fa fa-dot-circle-o"></i>&nbsp;Update</button>
                                <a href="index1.php?filename=daily_expenses/admin" style="float:right;"><button type="button" class="btn btn-secondary btn-sm">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

