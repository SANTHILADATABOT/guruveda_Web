<script src="js/jquery-1.12.3.js"></script>
<?php 
include("../include/common_function.php");
ob_start();
session_start();
$sess_user_type_id=$_SESSION['sess_user_type_id'] ?? '';
$sess_staff_id=$_SESSION['sess_staff_id'] ?? '';
$sess_user_id=$_SESSION['sess_user_id'] ?? '';
$date=date("Y");
$st_date=substr($date,2);
$month=date("m");
$datee=$st_date.$month;


if(!isset($_GET['expense_no']))
{
	$rs1=$db->query("select expense_no from  daily_expense  order by exp_id desc");
	if($res1=$db->fetch_array($rs1))
	{
		$pur_array=explode('-',$res1['expense_no'] ?? '');

		$year1=$pur_array[1] ?? '';
		$year2=substr($year1, 0, 2);
		$year='20'.$year2;
		$reg_no=$pur_array[2] ?? '';
	}
	if(empty($reg_no))
		$reg_nos='DE-'.$datee.'-0001';
	elseif(($year ?? '')!=date("Y"))
		$reg_nos='DE-'.$datee.'-0001';
	else
	{
		$reg_no+=1;
		$reg_nos='DE-'.$datee.'-'.str_pad($reg_no, 4, '0', STR_PAD_LEFT);
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
                        <form name="daily_expense_form" id="daily_expense_form">
                        
                        <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Expense No:</label>
                                    <label><span style="font-weight:bold;color:#F00;"><?php echo $reg_nos; ?></span></label>
                                    <input type="hidden" class="form-control" id="exp_no" name="exp_no" value="<?php echo $reg_nos; ?>">
                                </div>
                            </div>

                        	<div class="row form-group">
                                <div class="col-md-4">
                                    <label>Expense Date<span style="color:red;">*</span></label>
                                    <input type="date" class="form-control" id="exp_date" name="exp_date" tabindex="2" value="<?php echo date("Y-m-d");?>">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Expense Type<span style="color:red;">*</span></label>
                                    <select name="exp_type_id"   id="exp_type_id" class="form-control" tabindex="1" autofocus onChange="get_travel(this.value)"> 									 <option value="">Select</option>
                                         <?php $val = "select * from  daily_expense_type  order by expense_name ASC";
                                        $rows = $db->fetch_all_array($val);
                                        foreach($rows as $fet_get_report)
                                        {?>
                                           <option value="<?php echo htmlspecialchars($fet_get_report['expense_type_id'] ?? '', ENT_QUOTES);?>"><?php echo ucfirst($fet_get_report['expense_name'] ?? '');?></option>
                                            <?php
                                        }?>
                                    </select> 
                                </div>
                            </div>
							 <div class="row form-group" >
                                <div class="col-md-4" id="travel" style="display:none">
                                    <label> Travel Expense Type<span style="color:red;">*</span></label>
                                    <select name="travel_exp"   id="travel_exp" class="form-control" tabindex="1" autofocus> 
                                        <option value="">Select</option>
                                         <option value="bike">Bike</option>
                                         <option value="bus">Bus</option>
                                         <option value="train">Train</option>
                                         <option value="car">Car</option>
                                        
                                    </select> 
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Amount<span style="color:red;">*</span></label>
                                    <input type="text" class="form-control" id="exp_amount" name="exp_amount" tabindex="2">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label>Description </label>
                                    <textarea class="form-control" id="description" name="description" tabindex="3" ></textarea>
                                </div>
                            </div>
                           

                            <div class="card-footer">
                                <button type="button"  class="btn btn-primary btn-sm" tabindex="4" onClick="add_expense_creation(random_no.value,random_sc.value,exp_no.value,exp_date.value,exp_type_id.value,travel_exp.value,exp_amount.value,description.value)"><i class="fa fa-dot-circle-o"></i>&nbsp;Submit</button>
                                <a href="index1.php?filename=daily_expenses/admin" style="float:right;"><button type="button" class="btn btn-secondary btn-sm">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>               
  function expense_image_upload(url)
{
onmouseover= window.open(url,'','height=400,width=700,scrollbars=yes,left=350,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}   

function uploaded_files_print(url)
{
	onmouseover= window.open(url,'onmouseover','height=450,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}           

</script>
