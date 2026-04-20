// JavaScript Document

function get_travel(value)
{
	if(value==1)
	{
	document.getElementById("travel").style.display="block";
	}
	else
	{
		document.getElementById("travel").style.display="none";
	}
}

function add_expense_creation(random_no,random_sc,exp_no,exp_date,exp_type_id,travel_exp,exp_amount,description)
{

	if(exp_type_id=='1')
	{
		if(travel_exp==''){$("#travel_exp").addClass('errorClass'); $("#travel_exp").focus(); return false;} else {$("#travel_exp").addClass('successClass');}
	}
	
	
	if((exp_type_id)&&(exp_amount))
	{
		
		var sendInfo = {
			
			random_no: random_no,
			random_sc: random_sc,
			exp_no: exp_no,
			exp_date:exp_date,
			exp_type_id:exp_type_id,
			travel_exp:travel_exp,
			exp_amount: exp_amount,
			description: description,
					};
		$.ajax({
    		type: "POST",
			url: "model/daily_expense_creation.php?action=ADD",
			data: sendInfo,
			success: function(data){
				window.location.href = 'index1.php?filename=daily_expenses/admin';
   		},
			error: function() {
				alert('error handing here');
			}
		});
	}
	else
	{ validate_expense(exp_type_id,exp_amount); }
}


function update_daily_expenses(exp_date,exp_type_id,travel_exp,exp_amount,description,update_id)
{
	if(exp_type_id=='1')
	{
		if(travel_exp==''){$("#travel_exp").addClass('errorClass'); $("#travel_exp").focus(); return false;} else {$("#travel_exp").addClass('successClass');}
	}
	
	
	if((exp_type_id)&&(exp_amount))
	{
		var sendInfo = {
			
			exp_date:exp_date,
			exp_type_id:exp_type_id,
			travel_exp:travel_exp,
			exp_amount: exp_amount,
			description: description,
					};
		$.ajax({
    		type: "POST",
			url: "model/daily_expense_creation.php?action=UPDATE&update_id="+update_id,
			data: sendInfo,
			success: function(data){
				window.location.href = 'index1.php?filename=daily_expenses/admin';
   		},
			error: function() {
				alert('error handing here');
			}
		});
	}
	else
	{ validate_expense(exp_type_id,exp_amount); }
}

function daily_expense_list_filter(from_date,to_date,staff_id,exp_type_id)
{
	
	
	var sendInfo = {
			
			from_date: from_date,
			to_date: to_date,
			exp_type_id: exp_type_id,
			staff_id: staff_id,
	};
	
	$.ajax({
    		type: "POST",
			url: "daily_expenses/daily_expense_list.php?",
			data: sendInfo,
			success: function(data){
				
				$("#daily_expense_list_div").html(data);
				
   		},
			error: function() {
				alert('error handing here');
			}
		});
	
	
}

function validate_expense(exp_type_id,exp_amount)
{
	if(exp_type_id==''){$("#exp_type_id").addClass('errorClass'); $("#exp_type_id").focus(); return false;} else {$("#exp_type_id").addClass('successClass');}

	if(exp_amount==''){$("#exp_amount").addClass('errorClass'); $("#exp_amount").focus(); return false;} else {$("#exp_amount").addClass('successClass');}
}


function expense_delete(delete_id)
{ 
	if(confirm("Are you sure?"))
	{
		$.ajax({
			type: "POST",
			url: "model/daily_expense_creation.php?action=DELETE&delete_id="+delete_id,
			success: function(data) {
				window.location.href = 'index1.php?filename=daily_expenses/admin';
			},
			error: function() {
				alert('error handing here');
			}
		});
	}
}


function print_expenses_list(url) 
{
	var from_date =document.getElementById("from_date").value;
	var to_date	  =document.getElementById("to_date").value;
	var staff_id=document.getElementById("staff_id").value;
	var exp_type_id=document.getElementById("exp_type_id").value;
	window.open(url+'?from_date='+from_date+'&to_date='+to_date+'&staff_id='+staff_id+'&exp_type_id='+exp_type_id,'onmouseover','height=580,width=950,scrollbars=yes,resizable=no,left=250,top=70,toolbar=no,location=no,directories=no,status=no,menubar=no');
}
