//add
function add_state_creation(state_name,state_code,description)
{
	
	if((state_name)&&(state_code))
	{
		var sendInfo = {
			state_name:state_name,
			state_code:state_code,
			description:description,
		};
		$.ajax({
    		type: "POST",
			url: "model/state_creation.php?action=ADD",
			data: sendInfo,
			success: function(data){
				window.location.href = 'index1.php?filename=state_creation/admin';
   			},
			error: function() {
				alert('error handing here');
			}
		});
	}
	else
	{ validate_state(state_name,state_code); }
}

//update
function update_state_creation(state_name,state_code,description,update_id)
{
	if((state_name)&&(state_code))
	{
		var sendInfo = {
			state_name:state_name,
			state_code:state_code,
			description:description,
		};
		$.ajax({
    		type: "POST",
			url: "model/state_creation.php?action=UPDATE&update_id="+update_id,
			data: sendInfo,
			success: function(data){
				window.location.href = 'index1.php?filename=state_creation/admin';
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
function validate_state(state_name,state_code)
{
	if(state_name==''){$("#state_name").addClass('errorClass'); $("#state_name").focus(); return false;} else {$("#state_name").addClass('successClass');}

	if(state_code==''){$("#state_code").addClass('errorClass'); $("#state_code").focus(); return false;} else {$("#state_code").addClass('successClass');}
}

//DELETE
function state_creation_delete(delete_id)
{ 
	if(confirm("Are you sure?"))
	{
		$.ajax({
			type: "POST",
			url: "model/state_creation.php?action=DELETE&delete_id="+delete_id,
			success: function(data) {
				window.location.href = 'index1.php?filename=state_creation/admin';
			},
			error: function() {
				alert('error handing here');
			}
		});
	}
}