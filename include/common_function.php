<?php
//user type name
function get_user_type($user_type_id)
{
	global $db;
	$user_type = $db->query_first("SELECT user_type FROM user_type where user_type_id='".$db->escape($user_type_id)."'");
	if($user_type && isset($user_type['user_type'])) {
		return ucfirst($user_type['user_type']);
	}
	return '';
}

//user name
function get_user_name($sales_ref_id)
{
	global $db;
	$sales_ref_name = $db->query_first("SELECT staff_name FROM user_creation where user_id='".$db->escape($sales_ref_id)."'");
	if($sales_ref_name && isset($sales_ref_name['staff_name'])) {
		return ucfirst($sales_ref_name['staff_name']);
	}
	return '';
}
//staff_name
function get_staff_name($staff_id)
{
	global $db;
	$staff_user_name = $db->query_first("SELECT staff_name FROM user_creation where staff_id='".$db->escape($staff_id)."'");
	if($staff_user_name && isset($staff_user_name['staff_name'])) {
		return ucfirst($staff_user_name['staff_name']);
	}
	return '';
}

//stateName
function get_state_name($state_id)
{
	global $db;
	$state_name = $db->query_first("select state_name from state_creation where state_id='".$db->escape($state_id)."'");
	if($state_name && isset($state_name['state_name'])) {
		return ucfirst($state_name['state_name']);
	}
	return '';
}

//district Name
function get_district_name($district_id)
{
	global $db;
	$district_name = $db->query_first("select district_name from district_creation where district_id='".$db->escape($district_id)."'");
	if($district_name && isset($district_name['district_name'])) {
		return ucfirst($district_name['district_name']);
	}
	return '';
}

//area name
function get_area_name($area_id)
{
	global $db;
	$area_result = $db->query_first("SELECT area_name FROM area_creation where area_id='".$db->escape($area_id)."'");
	if($area_result && isset($area_result['area_name'])) {
		return ucfirst($area_result['area_name']);
	}
	return '';
}

//dealer name
function get_dealer_name($dealer_id)
{
	global $db;
	$dealer = $db->query_first("SELECT dealer_name FROM dealer_creation where dealer_id='".$db->escape($dealer_id)."'");
	if($dealer && isset($dealer['dealer_name'])) {
		return ucfirst($dealer['dealer_name']);
	}
	return '';
}

//sub dealer name
function get_sub_dealer_name($sub_dealer_id)
{
	global $db;
	$sub_dealer = $db->query_first("SELECT sub_dealer_name FROM sub_dealer_creation where sub_dealer_id='".$db->escape($sub_dealer_id)."'");
	if($sub_dealer && isset($sub_dealer['sub_dealer_name'])) {
		return ucfirst($sub_dealer['sub_dealer_name']);
	}
	return '';
}

//distributor name
function get_distributor_name($distributor_id)
{
	global $db;
	$distributor_name = $db->query_first("SELECT distributor_name FROM distributor_creation where distributor_id='".$db->escape($distributor_id)."'");
	if($distributor_name && isset($distributor_name['distributor_name'])) {
		return ucfirst($distributor_name['distributor_name']);
	}
	return '';
}

//sales Ref name
function get_sales_ref_name($sales_ref_id)
{
	global $db;
	$sales_ref_name = $db->query_first("SELECT sales_ref_name FROM sales_ref_creation where sales_ref_id='".$db->escape($sales_ref_id)."'");
	if($sales_ref_name && isset($sales_ref_name['sales_ref_name'])) {
		return ucfirst($sales_ref_name['sales_ref_name']);
	}
	return '';
}

//customer Name
function get_customer_name($customer_id)
{
	global $db;
	$cust_name = $db->query_first("select customer_name from customer_creation where customer_id='".$db->escape($customer_id)."'");
	if($cust_name && isset($cust_name['customer_name'])) {
		return ucfirst($cust_name['customer_name']);
	}
	return '';
}

//expense type
function get_expense_type($exp_type_id)
{
	global $db;
	$expense_type = $db->query_first("select expense_name from daily_expense_type where expense_type_id='".$db->escape($exp_type_id)."'");
	if($expense_type && isset($expense_type['expense_name'])) {
		return ucfirst($expense_type['expense_name']);
	}
	return '';
}
//Leave type
function get_leave_type($leave_type_id)
{
	global $db;
	$leave_type = $db->query_first("select leave_type from leave_type where id='".$db->escape($leave_type_id)."'");
	if($leave_type && isset($leave_type['leave_type'])) {
		return ucfirst($leave_type['leave_type']);
	}
	return '';
}
//Attendance type
function get_attendance_type($attendance_type_id)
{
	global $db;
	$attendance_type = $db->query_first("select attendance_type from attendance_type_live where live_id='".$db->escape($attendance_type_id)."'");
	if($attendance_type && isset($attendance_type['attendance_type'])) {
		return ucfirst($attendance_type['attendance_type']);
	}
	return '';
}

//tax Name
function get_tax_name($tax_id)
{
	global $db;
	$tax = $db->query_first("select tax_name from tax_creation where tax_id='".$db->escape($tax_id)."'");
	if($tax && isset($tax['tax_name'])) {
		return ucfirst($tax['tax_name']);
	}
	return '';
}

//category Name
function get_category_name($category_id)
{
	global $db;
	$category_name = $db->query_first("select category_name from category_creation where category_id='".$db->escape($category_id)."'");
	if($category_name && isset($category_name['category_name'])) {
		return ucfirst($category_name['category_name']);
	}
	return '';
}

//group Name
function get_group_name($group_id)
{
	global $db;
	$group_name = $db->query_first("select group_name from group_creation where group_id='".$db->escape($group_id)."'");
	if($group_name && isset($group_name['group_name'])) {
		return ucfirst($group_name['group_name']);
	}
	return '';
}

//Item Name
function get_item_name($item_id)
{
	global $db;
	$item = $db->query_first("select item_name from item_creation where item_id='".$db->escape($item_id)."'");
	if($item && isset($item['item_name'])) {
		return $item['item_name'];
	}
	return '';
}


//Academic Year
function get_academic_year(): string
{
	$fulldate=date("Y-m-d");
	$fyear=date("Y");
	$current_date=$fulldate;
	$cur_year=$fyear;
	
	$acc_from=$cur_year."-04-01"; 
	if($acc_from<=$current_date)
	{ 
		$fyear=date("Y");
		$eyear=date("Y")+1;
	}
	if($acc_from>$current_date)
	{
		$fyear=date("Y")-1;
		$eyear=date("Y");
	}
	$start_year=$fyear."-04-01"; 
	$end_year=$eyear."-03-31"; 
	$month=date("m");
	
	$curyear=date('Y');
	$curmon=date('m');
	$next_year=$curyear+1;
	
	$date=date("Y");
	$st_date=substr($date,2);
	$month=date("m");	   
	$datee=$st_date.$month;
	
	if(($curmon>=4)&&($curyear==$curyear-1)||($curmon<=3)&&($curyear==$curyear))
	{
		$academic=$curyear-1;
	}
	else
	{
		$academic=$curyear;
	}
	$academic1=$academic+1;
	return $academic."-".$academic1;
}

//Indian Currency Format
function indian_number_format($num): string
{
	if($num=='0' || $num=='')
	{
		$ren="0.00";
		//$ren="";
		return $ren;
	}
	else
	{
		$nums_arr = explode('.',$num);
		$num = $nums_arr[0];
		//$num = "".$num;
		if( strlen($num) < 4)
		{
			if(isset($nums_arr[1]) && ($nums_arr[1]!='')&&(strlen($nums_arr[1])==2))
				return $num.".".$nums_arr[1];
			else if(isset($nums_arr[1]) && ($nums_arr[1]!='')&&(strlen($nums_arr[1])==1))
				return $num.".".$nums_arr[1]."0";
			else
				return $num.".00";
		}
		$tail = substr($num,-3);
		$head = substr($num,0,-3);
		$head = preg_replace("/\B(?=(?:\d{2})+(?!\d))/",",",$head);
		if(!isset($nums_arr[1]) || $nums_arr[1]=='')
			return $head.",".$tail.".00";		
		elseif( strlen($nums_arr[1])==2)
			return $head.",".$tail.'.'.$nums_arr[1];
		elseif( strlen($nums_arr[1])==1)
			return $head.",".$tail.'.'.$nums_arr[1]."0";
	}
	return "0.00";
}?>
