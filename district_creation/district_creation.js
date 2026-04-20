//add
function add_district_creation(state_id,district_name,description)
{
	if((state_id)&&(district_name))
	{
		var sendInfo = {
			state_id:state_id,
			district_name:district_name,
			description:description,
					};
		$.ajax({
    		type: "POST",
			url: "model/district_creation.php?action=ADD",
			data: sendInfo,
			success: function(data){
				window.location.href = 'index1.php?filename=district_creation/admin';
   		},
			error: function() {
				alert('error handing here');
			}
		});
	}
	else
	{ validate_district_creation(state_id,district_name); }
}

//update
function update_district_creation(state_id,district_name,description,update_id)
{
	if((state_id)&&(district_name))
	{
		var sendInfo = {
			state_id:state_id,
			district_name:district_name,
			description:description,
		};
		$.ajax({
    		type: "POST",
			url: "model/district_creation.php?action=UPDATE&update_id="+update_id,
			data: sendInfo,
			success: function(data){
				window.location.href = 'index1.php?filename=district_creation/admin';
				  		},
			error: function() {
				alert('error handing here');
			}
		});
	}
	else
	{ validate_state(state_name,state_code); }
}

//validate
function validate_district_creation(state_id,district_name)
{
	if(state_id==''){$("#state_id").addClass('errorClass'); $("#state_id").focus(); return false;} else {$("#state_id").addClass('successClass');}

	if(district_name==''){$("#district_name").addClass('errorClass'); $("#district_name").focus(); return false;} else {$("#district_name").addClass('successClass');}
}

//DELETE
function district_creation_delete(delete_id)
{ 
	if(confirm("Are you sure?"))
	{
		$.ajax({
			type: "POST",
			url: "model/district_creation.php?action=DELETE&delete_id="+delete_id,
			success: function(data) {
				window.location.href = 'index1.php?filename=district_creation/admin';
			},
			error: function() {
				alert('error handing here');
			}
		});
	}
}