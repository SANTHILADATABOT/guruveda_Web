<script src="js/jquery-1.12.3.js"></script>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Monthly Attendance Reports<small> List</small></h1>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                
            </div>
        </div>
    </div>
    <!--<div class="col-sm-1"></div>-->
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
                                <label>From Month</label>
                                <input type="month" class="form-control numeric" name="from_month" id="from_month"  value="<?php echo date("Y-m") ?>">
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
                                <button type="button" id="button" class="btn btn-primary btn-sm" onClick="get_attandance_list_filter(from_month.value,staff_id.value)" >Go</button>      
                            </div> 
                             <div class="col-md-3" style="text-align: right;">
                                <label>&nbsp;</label><br/>
                                <button type="button" id="button" class="btn btn-primary btn-sm" onclick="print_monthly_list('attendance_report/list_print.php')"><i class="fa fa-print" ></i>PRINT</button>
                            </div>

                        </div>
                        <div id="get_attandance_list_div">
                            <?php include("attendance_report_list.php");?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function get_attandance_list_filter(from_month,staff_id)
{
	
	jQuery.ajax({
		type: "POST",
		url: "attendance_report/attendance_report_list.php",
		data: "from_month="+from_month+"&staff_id="+staff_id,
		success: function(data) {
			
			jQuery("#get_attandance_list_div").html(data);
		}
	});
}
function attandance_list(url)
{
	onmouseover= window.open(url,'onmouseover','height=600,width=900,scrollbars=yes,resizable=no,left=200,top=150,toolbar=no,location=no,directories=no,status=no,menubar=no');
}

  
function print_monthly_list(url) 
{
    //alert(url);
    var from_month =document.getElementById("from_month").value;
    var staff_id=document.getElementById("staff_id").value;
    window.open(url+'?from_month='+from_month+'&staff_id='+staff_id,'onmouseover','height=580,width=950,scrollbars=yes,resizable=no,left=250,top=70,toolbar=no,location=no,directories=no,status=no,menubar=no');
}

</script>
