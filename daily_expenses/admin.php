<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
            	<h1>Daily Expense Report</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                <!--<ol class="breadcrumb text-right"><li>Home</li><li>Master</li><li class="active">Daily Expense</li></ol>	-->
            </div>
        </div>
    </div>
    <div class="col-sm-1">
       <!-- <a href="index1.php?filename=daily_expenses/create"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> Create</button></a>-->
    </div>
</div>
<br>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                    <div class="row form-group">
                            <div class="col-md-2">
                                <label>From Date</label>
                                <input type="date" style="width:170px;" class="form-control" id="from_date" name="from_date" value="<?php echo date('Y-m-d');?>">
                            </div>
                            <div class="col-md-2">
                                <label>To Date</label>
                                <input type="date" style="width:170px;" class="form-control" id="to_date" name="to_date" value="<?php echo date('Y-m-d');?>">
                            </div>
                            <div class="col-md-3">
                            	<label>Staff Name</label>
                               <select name="staff_id" id="staff_id" class="form-control" tabindex="1"> 									 
    <option value="">Select</option>
    <?php 
    $sql_staff = "SELECT MIN(user_id) as user_id, staff_name 
                        FROM user_creation 
                        WHERE TRIM(staff_name) != '' 
                        and delete_status = 0
                        GROUP BY staff_name 
                        ORDER BY staff_name ASC";
    $staff_rows = $db->fetch_all_array($sql_staff);
    foreach($staff_rows as $fet_get_report) {
    ?>
        <option value="<?php echo htmlspecialchars($fet_get_report['user_id'] ?? '', ENT_QUOTES); ?>">
            <?php echo ucfirst($fet_get_report['staff_name'] ?? ''); ?>
        </option>
    <?php
    }
    ?>
</select>
                            </div>
                            
                            <div class="col-md-3">
                            	<label>Expense Type</label>
                               <select name="exp_type_id"   id="exp_type_id" class="form-control" tabindex="1" > 									 
                               <option value="">Select</option>
                                         <?php $val = "select * from  daily_expense_type  order by expense_name ASC";
                                        $types = $db->fetch_all_array($val);
                                        foreach($types as $fet_get_report)
                                        {?>
                                           <option value="<?php echo htmlspecialchars($fet_get_report['expense_type_id'] ?? '', ENT_QUOTES);?>"><?php echo ucfirst($fet_get_report['expense_name'] ?? '');?></option>
                                            <?php
                                        }?>
                                    </select> 
                            </div>
                            <div class="col-md-1">
                                <label>&nbsp;</label><br/>
                                <button type="button" id="button" class="btn btn-primary btn-sm" onClick="daily_expense_list_filter(from_date.value,to_date.value,staff_id.value,exp_type_id.value)">Go</button>      
                            </div>
                            <div class="col-md-1">
                                <label>&nbsp;</label><br/>
                                <button type="button" id="button" class="btn btn-primary btn-sm" onclick="print_expenses_list('daily_expenses/list_print.php')"><i class="fa fa-print" ></i>PRINT</button>
                            </div>                     
                        </div>
                        <div id="daily_expense_list_div">
                       		 <?php include("daily_expense_list.php");?>
                        </div>
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