<style>
.count {line-height: 50px;color:black;margin-left:30px;font-size:30px;}
#mul 
{
	display:none;
}
#bar 
{
	display:none;
}
#mul3 
{
	display:none;
}
#bar3 
{
	display:none;
}
.btn 
{
    border: none;
    outline: none;
    padding: 10px 16px;    
    cursor: pointer;
    font-size: 18px;
}

p.leave.padleft {
    padding-left: 42px;
}
/* Style the active class, and buttons on mouse-over */

.btn.week.active 
{
    background-color: #ccc;
}
</style>

<?PHP 
 $current_date=date('Y-m-d');
$attendance_count=$db->query_first("select count(*) as attcount from attendance_entry where entry_date='".$db->escape($current_date)."'");
$daily_count=$db->query_first("select count(*) as dailycount from daily_expense where entry_date='".$db->escape($current_date)."'");
$log_count=$db->query_first("select count(*) as logcount from log_book where entry_date='".$db->escape($current_date)."'");

?>
<div id="right-panel" class="right-panel">
<div id="page-wrapper">                   
	<div class="col-lg-2 col-xs-6">			
		<div class="small-box bg-aqua">
		<div class="inner"><Span><img src="assets/img/attendance.png" style="width:50px; height:50px; float:left;"/></Span>
		<h3 class="count"><?php echo $attendance_count['attcount'] ?? 0;?></h3>

		<p class="ty">Attendance</p>
		</div>
		<div class="icon">
		<i class="accessible-icon"></i>
		</div>
		<a href="index1.php?filename=attendance_report/admin" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
		</div>
	</div>      
	
	<!--<div class="col-lg-2 col-xs-6">-->
	<!--	<div class="small-box bg-green">-->
	<!--	<div class="inner"><span><img src="assets/img/expenses.png" style="width:50px; height:50px; float:left;"/></span>-->
	<!--	<h3 class="count"><?php echo $daily_count['dailycount'] ?? 0;?></h3>-->
	<!--	<p class="tu">Expenses</p>-->
	<!--	</div>-->
	<!--	<div class="icon">-->
	<!--	<i class="ion ion-stats-bars"></i>-->
	<!--	</div>-->
	<!--	<a href="index1.php?filename=daily_expenses/admin" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
	<!--	</div>-->
	<!--</div>            -->
	<!--<div class="col-lg-2 col-xs-6">-->
		<!-- small box -->
	<!--	<div class="small-box bg-yellow">-->
	<!--	<div class="inner"><span><img src="assets/img/log-book.png" style="width:50px; height:50px; float:left;"></span>-->
	<!--	<h3 class="count"><?php echo $log_count['logcount'] ?? 0;?></h3>-->

	<!--	<p class="leave padleft">Log Book</p>-->
	<!--	</div>-->
	<!--	<div class="icon">-->
	<!--	<i class="ion ion-person-add"></i>-->
	<!--	</div>-->
	<!--	<a href="index1.php?filename=log_book/admin" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
	<!--	</div>-->
	<!--</div>        -->
	<div class="col-md-4"  style=" height: 678px; " >
	</div>
	<div class="col-md-8 chart">
	</div>
</div>	
</div>	

