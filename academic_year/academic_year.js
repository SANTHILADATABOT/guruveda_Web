// ADD
function add_academicyear(from_academic,to_academic)
{ 
	if((from_academic))
	{
		var sendInfo={
			from_academic: from_academic,
			to_academic: to_academic,
		};
		$.ajax({
			type: "POST",
			url: "model/academic_year.php?action=ADD",
			data: sendInfo,
			success: function(data) {
				
				window.location.href = "index1.php?filename=academic_year/admin";
			},
			error: function() {
				alert('error handing here');
			}
		});
	}
	else { validate_academic_year(from_academic); }
}

// UPDATE
function update_academicyear(from_academic,to_academic,update_id)
{ 
   if((from_academic))
   {
	   	var sendInfo = {
           from_academic: from_academic,
           to_academic: to_academic,
	};
	   
	$.ajax({
    type: "POST",
    url: "model/academic_year.php?action=UPDATE&update_id="+update_id,
    data: sendInfo,
    success: function(data) {
		window.location.href = "index1.php?filename=academic_year/admin";
		
    },
    error: function() {
        alert('error handing here');
    }
	});
   } else { validate_academicyear(from_academic); }
}

/*// DELETE
function delete_academicyear(accountyear_id)
{ 
	if (confirm("Are you sure?")) {
	$.ajax({
    type: "POST",
    url: "model/academic_year.php?action=delete&delete_id="+accountyear_id,
    success: function(data) {
		$("#curd_message").html(data); 
		$("#curd_message").delay(5000).fadeOut();
		$( "#academicyear_list" ).load( "index1.php?fopen=academic_year/admin #example" );
		window.location.reload(true);
		hide_dialog();
    },
    error: function() {
        alert('error handing here');
    }
	});
	}
}*/

//Validate
function validate_academic_year(from_academic)
{
	if(from_academic==='') { $("#from_academic").addClass('errorClass'); return false;} else {$("#from_academic").addClass('successClass');}
	
	if(from_academic <= 0) { $("#from_academic").addClass('errorClass'); return false;} else {$("#from_academic").addClass('successClass');}
	
}

//to calculate next year
function get_year()
{
	
	var year = parseInt(jQuery("#from_academic").val());
	if(year>0)
	{
	jQuery("#to_academic").val(year+1);
	}
	else
	{
		jQuery("#to_academic").val("");
	}
}

//to validate existing year
function get_academic_year(from_academic)
{
	$.ajax({
		type: "POST",
		url: "academic_year/checkitem_dba.php?from_academic="+from_academic,
		success: function(data) {
			
			if(data!='0'){document.getElementById("from_academic_year_div").innerHTML="Academic Year Already Exists."; return false;} 
			else{document.getElementById("from_academic_year_div").innerHTML=""}
		},
		error: function() {
			alert('error handing here');
		}
	});   
}

//to set status as Zero
function status_academic_year_update_wrong(id,value)
{
	
	jQuery.ajax({
		type: "POST",
	    url:"model/academic_year.php?action=status_zero",
		data: "id="+id+"&value="+value,
		success: function(msg){
		 window.location.reload(true);
	}
	});
}		

//to set status as One
function status_academic_year_update_tick(id,value)
{
	jQuery.ajax({
		type: "POST",
	    url:"model/academic_year.php?action=status_one",
		data: "id="+id+"&value="+value,
		success: function(msg)
		{
			if(msg=="Updated")
			{
				window.location.reload(true);
			}
			else
			{
				alert("Already Another Academic Year is in Active");
			}
		}
	});
}		