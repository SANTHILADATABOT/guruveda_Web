<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
            	<h1>Log Book Report</h1>
            </div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
              
            </div>
        </div>
    </div>
   
</div>

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
    $val = "SELECT MIN(user_id) as user_id, staff_name 
                        FROM user_creation 
                        WHERE TRIM(staff_name) != '' 
                        and delete_status = 0
                        GROUP BY staff_name 
                        ORDER BY staff_name ASC";
    $staff_rows = $db->fetch_all_array($val);
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
                                <label>&nbsp;</label><br/>
                                <button type="button" id="button" class="btn btn-primary btn-sm" onClick="log_list_filter(from_date.value,to_date.value,staff_id.value)">Go</button>      
                            </div>
                            <div class="col-md-1">
                                <label>&nbsp;</label><br/>
                                <button type="button" id="button" class="btn btn-primary btn-sm" onclick="print_log_list('log_book/list_print.php')"><i class="fa fa-print" ></i>PRINT</button>
                            </div>                     
                        </div>
                        <div id="daily_expense_list_div">
                       		 <?php include("log_book_list.php");?>
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

function files_print(url)
{
	onmouseover= window.open(url,'onmouseover','height=450,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}   

function log_list_filter(from_date,to_date,staff_id)
{
	var sendInfo = {			
		from_date: from_date,
		to_date: to_date,
		staff_id: staff_id,
	};
	
	$.ajax({
		type: "POST",
		url: "log_book/log_book_list.php?",
		data: sendInfo,
		success: function(data) {
			$("#daily_expense_list_div").html(data);
		},
		error: function() {
			alert('error handing here');
		}
	});	
}

function print_log_list(url) 
{
    var from_date =document.getElementById("from_date").value;
    var to_date   =document.getElementById("to_date").value;
    var staff_id=document.getElementById("staff_id").value;
    window.open(url+'?from_date='+from_date+'&to_date='+to_date+'&staff_id='+staff_id,'onmouseover','height=580,width=950,scrollbars=yes,resizable=no,left=250,top=70,toolbar=no,location=no,directories=no,status=no,menubar=no');
}

</script>