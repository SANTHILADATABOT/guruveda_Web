// JavaScript Document

//add Attendance
function add_attendance_creation(random_no,random_sc,att_no,att_date,staff_id,entry_time,att_type_id)
{
	
	
	if((staff_id)&&(att_type_id))
	{
		
		var sendInfo = {
			
			random_no: random_no,
			random_sc: random_sc,
			att_no: att_no,
			att_date:att_date,
			staff_id:staff_id,
			entry_time:entry_time,
			att_type_id: att_type_id,
			
					};
		$.ajax({
    		type: "POST",
			url: "model/attendance_creation.php?action=ADD",
			data: sendInfo,
			success: function(data){
				alert(data);
				
				window.location.href = 'index1.php?filename=attendance_creation/admin';
   		},
			error: function() {
				alert('error handing here');
			}
		});
	}
	else
	{
		attendance_validate(staff_id,att_type_id);
	}
}

//Update Attendance
function update_attendance_creation(entry_time,update_id,staff_name,entry_date)
{
	alert(staff_name);
	alert(entry_date);
	
	$.ajax({
    		type: "POST",
			url: "model/attendance_creation.php?action=UPDATE&update_id="+update_id,
			data: "entry_time="+entry_time+"&staff_name="+staff_name+"&entry_date="+entry_date,
			success: function(data){
				
				window.location.href = 'index1.php?filename=attendance_creation/admin';
				
				
   		},
			error: function() {
				alert('error handing here');
			}
		});
}

//filter select box
function get_attendance(staff_name,entry_date)
{
	if(staff_name!='')
	{
	
	var sendInfo = {
			
			staff_name: staff_name,
			entry_date: entry_date,
	};
	
	$.ajax({
    		type: "POST",
			url: "attendance_creation/attendance_type_filter.php?",
			data: sendInfo,
			success: function(data){
				
				$("#att_type_id_div").html(data);
				
   		},
			error: function() {
				alert('error handing here');
			}
		});
	}
	
}

//delete attendance
function attendance_delete(delete_id)
{
	if(confirm("Are you sure?"))
	{
	
	$.ajax({
    		type: "POST",
			url: "model/attendance_creation.php?action=DELETE&delete_id="+delete_id,
			success: function(data){
				
				window.location.href = 'index1.php?filename=attendance_creation/admin';
				
   		},
			error: function() {
				alert('error handing here');
			}
		});
	}
}

//attendance filter

function attendance_list_filter(from_date,to_date,staff_id,att_type_id)
{
	
	var sendInfo = {
			
			from_date: from_date,
			to_date: to_date,
			staff_id: staff_id,
			att_type_id: att_type_id,
	};
	
	$.ajax({
    		type: "POST",
			url: "attendance_creation/attendance_creation_list.php?",
			data: sendInfo,
			success: function(data){
				
				$("#attendance_creation_list_div").html(data);
				
   		},
			error: function() {
				alert('error handing here');
			}
		});
	
	
}
//validate Attendance
function attendance_validate(staff_id,att_type_id)
{
	if(staff_id==''){$("#staff_id").addClass('errorClass'); $("#staff_id").focus(); return false;} else {$("#staff_id").addClass('successClass');}
	if(att_type_id==''){$("#att_type_id").addClass('errorClass'); $("#att_type_id").focus(); return false;} else {$("#att_type_id").addClass('successClass');}
}

//for running time clock
function startTime_new() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime_new(m);
    s = checkTime_new(s);
    document.getElementById('txt_new').innerHTML =
    h + ":" + m + ":" + s;
	document.getElementById("entry_time").value =  h + ":" + m + ":" + s;
    var t = setTimeout(startTime_new, 500);
}
function checkTime_new(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}


  
function print_list(url) 
{
	var from_date =document.getElementById("from_date").value;
	var to_date	  =document.getElementById("to_date").value;
	var staff_id=document.getElementById("staff_id").value;
	var att_type_id=document.getElementById("att_type_id").value;
	window.open(url+'?from_date='+from_date+'&to_date='+to_date+'&staff_id='+staff_id+'&att_type_id='+att_type_id,'onmouseover','height=580,width=950,scrollbars=yes,resizable=no,left=250,top=70,toolbar=no,location=no,directories=no,status=no,menubar=no');
}