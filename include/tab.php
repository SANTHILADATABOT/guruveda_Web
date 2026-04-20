<?php 
$path = $_SERVER['QUERY_STRING'];
$path2 = explode("&", $path);
$path1=$path2[0];
/* ----------------------------   Admin  -------------------------------*/

if(($path == 'filename=user_type_creation/admin')||($path == 'filename=user_type_creation/create')||($path1 == 'filename=user_type_creation/update')){
	$admin = 'open show';
	$admin_show='show';
	$admin1 = 'style="background-color:#ffc107;"';
	$admina = 'style="color:#fff;"';
}
elseif(($path == 'filename=user_creation/admin')||($path == 'filename=user_creation/create')||($path1 == 'filename=user_creation/update')){
	$admin = 'open show';
	$admin_show='show';
	$admin_list = 'style="display: block;"';
	$admin3 = 'style="background-color:#ffc107;"';
	$adminc = 'style="color:#fff;"';
}
elseif(($path == 'filename=user_screen/admin')||($path == 'filename=user_screen/create')||($path1 == 'filename=user_screen/update')){
	$admin = 'open show';
	$admin_show='show';
	$admin_list = 'style="display: block;"';
	$admin4 = 'style="background-color:#ffc107;"';
	$admind = 'style="color:#fff;"';
}
elseif(($path == 'filename=user_permission/admin')||($path == 'filename=user_permission/create')||($path1 == 'filename=user_permission/create')){
	$admin = 'open show';
	$admin_show='show';
	$admin_list = 'style="display: block;"';
	$admin5 = 'style="background-color:#ffc107;"';
	$admine = 'style="color:#fff;"';
}
elseif(($path == 'filename=company_creation/admin')||($path == 'filename=company_creation/create')||($path1 == 'filename=company_creation/update')){
	$admin = 'open show';
	$admin_show='show';
	$admin_list = 'style="display: block;"';
	$admin6 = 'style="background-color:#ffc107;"';
	$adminf = 'style="color:#fff;"';
}
/* ----------------------------Others-------------------------------*/
elseif(($path == 'filename=leave_creation/admin')||($path == 'filename=leave_creation/create')||($path1 == 'filename=leave_creation/update')){
	$other = 'open show';
	$other_show='show';
	$other_list = 'style="display: block;"';
	$other1 = 'style="background-color:#ffc107;"';
	$othera = 'style="color:#fff;"';
}
elseif(($path == 'filename=leave_creation/leave_approval')){
	$other = 'open show';
	$other_show='show';
	$other_list = 'style="display: block;"';
	$other2 = 'style="background-color:#ffc107;"';
	$otherb = 'style="color:#fff;"';
}
elseif(($path == 'filename=daily_expenses/admin')||($path == 'filename=daily_expenses/create')||($path1 == 'filename=daily_expenses/update')){
	$other = 'open show';
	$other_show='show';
	$other_list = 'style="display: block;"';
	$other3 = 'style="background-color:#ffc107;"';
	$otherc = 'style="color:#fff;"';
}
elseif(($path == 'filename=attendance_creation/admin')||($path == 'filename=attendance_creation/create')||($path1 == 'filename=attendance_creation/update')){
	$other = 'open show';
	$other_show='show';
	$other_list = 'style="display: block;"';
	$other4 = 'style="background-color:#ffc107;"';
	$otherd = 'style="color:#fff;"';
}
elseif(($path == 'filename=log_book/admin')||($path == 'filename=log_book/create')||($path1 == 'filename=log_book/update')){
	$other = 'open show';
	$other_show='show';
	$other_list = 'style="display: block;"';
	$other5 = 'style="background-color:#ffc107;"';
	$othere = 'style="color:#fff;"';
}
/* ----------------------------   Master  -------------------------------*/
elseif(($path == 'filename=academic_year/admin')||($path == 'filename=academic_year/create')||($path1 == 'filename=academic_year/update')){
	$master = 'open show';
	$master_show='show';
	$master_list = 'style="display: block;"';
	$master1 = 'style="background-color:#ffc107;"';
	$mastera = 'style="color:#fff;"';
}
elseif(($path == 'filename=state_creation/admin')||($path == 'filename=state_creation/create')||($path1 == 'filename=state_creation/update')){
	$master = 'open show';
	$master_show='show';
	$master_list = 'style="display: block;"';
	$master2 = 'style="background-color:#ffc107;"';
	$masterb = 'style="color:#fff;"';
}
elseif(($path == 'filename=district_creation/admin')||($path == 'filename=district_creation/create')||($path1 == 'filename=district_creation/update')){
	$master = 'open show';
	$master_show='show';
	$master_list = 'style="display: block;"';
	$master3 = 'style="background-color:#ffc107;"';
	$masterc = 'style="color:#fff;"';
}
elseif(($path == 'filename=area_creation/admin')||($path == 'filename=area_creation/create')||($path1 == 'filename=area_creation/update')){
	$master = 'open show';
	$master_show='show';
	$master_list = 'style="display: block;"';
	$master4 = 'style="background-color:#ffc107;"';
	$masterd = 'style="color:#fff;"';
}
elseif(($path == 'filename=dealer_creation/admin')||($path == 'filename=dealer_creation/create')||($path1 == 'filename=dealer_creation/update')){
$master = 'open show';
	$master_show='show';
	$master_list = 'style="display: block;"';
	$master5 = 'style="background-color:#ffc107;"';
	$mastere = 'style="color:#fff;"';
}
elseif(($path == 'filename=sub_dealer_creation/admin')||($path == 'filename=sub_dealer_creation/create')||($path1 == 'filename=sub_dealer_creation/update')){
$master = 'open show';
	$master_show='show';
	$master_list = 'style="display: block;"';
	$master6 = 'style="background-color:#ffc107;"';
	$masterf = 'style="color:#fff;"';
}
elseif(($path == 'filename=distributor_creation/admin')||($path == 'filename=distributor_creation/create')||($path1 == 'filename=distributor_creation/update')){
	$master = 'open show';
	$master_show='show';
	$master_list = 'style="display: block;"';
	$master7 = 'style="background-color:#ffc107;"';
	$masterg = 'style="color:#fff;"';
}
elseif(($path == 'filename=salesref_creation/admin')||($path == 'filename=salesref_creation/create')||($path1 == 'filename=salesref_creation/update')){
	$master = 'open show';
	$master_show='show';
	$master_list = 'style="display: block;"';
	$master8 = 'style="background-color:#ffc107;"';
	$masterh = 'style="color:#fff;"';
}
elseif(($path == 'filename=customer_creation/admin')||($path == 'filename=customer_creation/create')||($path1 == 'filename=customer_creation/update')){
	$master = 'open show';
	$master_show='show';
	$master_list = 'style="display: block;"';
	$master9 = 'style="background-color:#ffc107;"';
	$masteri = 'style="color:#fff;"';
}
elseif(($path == 'filename=tax_creation/admin')||($path == 'filename=tax_creation/create')||($path1 == 'filename=tax_creation/update')){
	$master = 'open show';
	$master_show='show';
	$master_list = 'style="display: block;"';
	$master10 = 'style="background-color:#ffc107;"';
	$masterj = 'style="color:#fff;"';
}
elseif(($path == 'filename=category_creation/admin')||($path == 'filename=category_creation/create')||($path1 == 'filename=category_creation/update')){
	$master = 'open show';
	$master_show='show';
	$master_list = 'style="display: block;"';
	$master11 = 'style="background-color:#ffc107;"';
	$masterk = 'style="color:#fff;"';
}
elseif(($path == 'filename=group_creation/admin')||($path == 'filename=group_creation/create')||($path1 == 'filename=group_creation/update')){
	$master = 'open show';
	$master_show='show';
	$master_list = 'style="display: block;"';
	$master12 = 'style="background-color:#ffc107;"';
	$masterl = 'style="color:#fff;"';
}
elseif(($path == 'filename=item_creation/admin')||($path == 'filename=item_creation/create')||($path1 == 'filename=item_creation/update')){
	$master = 'open show';
	$master_show='show';
	$master_list = 'style="display: block;"';
	$master13 = 'style="background-color:#ffc107;"';
	$masterm = 'style="color:#fff;"';
}
elseif(($path == 'filename=area_assign/admin')||($path == 'filename=area_assign/create')||($path1 == 'filename=area_assign/update')){
	$master = 'open show';
	$master_show='show';
	$master_list = 'style="display: block;"';
	$master14 = 'style="background-color:#ffc107;"';
	$mastern = 'style="color:#fff;"';
}
elseif(($path == 'filename=daily_expenses/admin')||($path == 'filename=daily_expenses/create')||($path1 == 'filename=daily_expenses/update')){
	$exp = 'open show';
	$exp_show='show';
	$expense1 = 'style="background-color:#ffc107;"';
	$expensea = 'style="color:#fff;"';
}
elseif(($path == 'filename=leave_creation/admin')||($path == 'filename=leave_creation/create')){
	$leave = 'open show';
	$leave_show='show';
	$leave_list = 'style="display: block;"';
	$leave1 = 'style="background-color:#ffc107;"';
	$leavea = 'style="color:#fff;"';
}
elseif(($path == 'filename=leave_creation/leave_approval')||($path == 'filename=leave_creation/create')){
	$leave = 'open show';
	$leave_show='show';
	$leave_list = 'style="display: block;"';
	$leave2 = 'style="background-color:#ffc107;"';
	$leaveb = 'style="color:#fff;"';
}
elseif(($path == 'filename=attendance_creation/admin')||($path == 'filename=leave_creation/create')){
	$attendance = 'open show';
	$attendance_show='show';
	$attendance_list = 'style="display: block;"';
	$attendance1 = 'style="background-color:#ffc107;"';
	$attendancea = 'style="color:#fff;"';
}

/* ----------------------------Inward-------------------------------*/
elseif(($path == 'filename=company_inward/admin')||($path == 'filename=company_inward/create')||($path1 == 'filename=company_inward/update')){
	$inward = 'open show';
	$inward_show='show';
	$inward_list = 'style="display: block;"';
	$inward1 = 'style="background-color:#ffc107;"';
	$inwarda = 'style="color:#fff;"';
}
elseif(($path == 'filename=distributor_inward/admin')||($path == 'filename=distributor_inward/create')||($path1 == 'filename=distributor_inward/update')){
	$inward = 'open show';
	$inward_show='show';
	$inward_list = 'style="display: block;"';
	$inward2 = 'style="background-color:#ffc107;"';
	$inwardb = 'style="color:#fff;"';
}
elseif(($path == 'filename=distributor_inward_approval/admin')||($path == 'filename=distributor_inward_approval/create')||($path1 == 'filename=distributor_inward_approval/update')){
	$inward = 'open show';
	$inward_show='show';
	$inward_list = 'style="display: block;"';
	$inward3 = 'style="background-color:#ffc107;"';
	$inwardc = 'style="color:#fff;"';
}

/* ----------------------------Sales-------------------------------*/
elseif(($path == 'filename=sales_order_entry/admin')||($path == 'filename=sales_order_entry/create')||($path1 == 'filename=sales_order_entry/update')){
$sales = 'open show';
	$sales_show='show';
	$sales_list = 'style="display: block;"';
	$sales1 = 'style="background-color:#ffc107;"';
	$salesa = 'style="color:#fff;"';
}
elseif(($path == 'filename=sales_order_delivery/admin')||($path == 'filename=sales_order_delivery/create')||($path1 == 'filename=sales_order_delivery/update')){
	$sales = 'open show';
	$sales_show='show';
	$sales_list = 'style="display: block;"';
	$sales2 = 'style="background-color:#ffc107;"';
	$salesb = 'style="color:#fff;"';
}
elseif(($path == 'filename=sales_return/admin')||($path == 'filename=sales_return/create')||($path1 == 'filename=sales_return/update')){
	$sales = 'open show';
	$sales_show='show';
	$sales_list = 'style="display: block;"';
	$sales3 = 'style="background-color:#ffc107;"';
	$salesc = 'style="color:#fff;"';
}

elseif(($path == 'filename=sales_description/admin')){
	$sales = 'open show';
	$sales_show='show';
	$sales_list = 'style="display: block;"';
	$sales4 = 'style="background-color:#ffc107;"';
	$salesd = 'style="color:#fff;"';
}



/* ----------------------------Report-------------------------------*/
elseif(($path == 'filename=stock_report/admin_category')||($path1 == 'filename=stock_report/admin_group')||($path1 == 'filename=stock_report/admin_item')){
	$report = 'open show';
	$report_show='show';
	$report_list = 'style="display: block;"';
	$report1 = 'style="background-color:#ffc107;"';
	$reporta = 'style="color:#fff;"';
}
elseif(($path == 'filename=sales_report/admin_category')||($path == 'filename=sales_report/admin_group')||($path1 == 'filename=sales_report/admin_item')){
	$report = 'open show';
	$report_show='show';
	$report_list = 'style="display: block;"';
	$report2 = 'style="background-color:#ffc107;"';
	$reportb = 'style="color:#fff;"';
}
elseif(($path == 'filename=daily_sales_ref_report/admin')){
	$report = 'open show';
	$report_show='show';
	$report_list = 'style="display: block;"';
	$report3 = 'style="background-color:#ffc107;"';
	$reportc = 'style="color:#fff;"';
}
elseif(($path == 'filename=sub_dealer_sales_report/admin')){
	$report = 'open show';
	$report_show='show';
	$report_list = 'style="display: block;"';
	$report8 = 'style="background-color:#ffc107;"';
	$reporty = 'style="color:#fff;"';
}
elseif(($path == 'filename=attendance_report/admin')){
	$report = 'open show';
	$report_show='show';
	$report_list = 'style="display: block;"';
	$report4 = 'style="background-color:#ffc107;"';
	$reportd = 'style="color:#fff;"';
}
elseif(($path == 'filename=dist_wise_stock_report/admin_category')){
	$report = 'open show';
	$report_show='show';
	$report_list = 'style="display: block;"';
	$report5 = 'style="background-color:#ffc107;"';
	$reporte = 'style="color:#fff;"';
}
else{
$openclass = '';
}
/* ---------------------------------------------------------------------------------------------------------------------------------------------------------*/


?>