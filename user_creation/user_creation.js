// Add
function user_creation_submit(user_type,staff_name,user_name,password,confirm_password,user_status)
{
	if((user_type)&&(staff_name)&&(user_name)&&(password)&&(confirm_password))
	{
		if(password==confirm_password){
			var sendInfo = {
				user_type: user_type,
				staff_name:staff_name,
				user_name: user_name,
				password: password,
				confirm_password: confirm_password,
				user_status: user_status,
			};
			$.ajax({
				type: "POST",
				url: "model/user_creation.php?action=SUBMIT",
				data: sendInfo,
				success: function(data){
    if(data.trim() === "SUCCESS"){
        window.location.href = 'index1.php?filename=user_creation/admin';
    } 
    else {
        console.log("data***",data);
        alert("SERVER MESSAGE: " + data);  // <-- YOU WILL SEE REAL ERROR
    }
},

			});
		}
		else
		{ alert("Enter the Same Pasword"); }
	}
	else { validate_user_creation(user_type,staff_name,user_name,password,confirm_password); }
}
//Update
function user_creation_update(user_type,staff_name,user_name,password,confirm_password,user_status,update_id)
{
	if((user_type)&&(staff_name)&&(user_name)&&(password)&&(confirm_password))
	{
		if(password==confirm_password){
			var sendInfo = {
				user_type: user_type,
				staff_name:staff_name,
				user_name: user_name,
				password: password,
				confirm_password: confirm_password,
				user_status: user_status,
				update_id: update_id,
			};
			$.ajax({
				type: "POST",
				url: "model/user_creation.php?action=UPDATE&update_id="+update_id,
				data: sendInfo,
				success: function(data){
					window.location.href = 'index1.php?filename=user_creation/admin';
				},
				error: function() {
					alert('error handing here');
				}
			});
			}
		else
		{ alert("Enter the Same Pasword"); }
	}
	else { validate_user_creation(user_type,staff_name,user_name,password,confirm_password); }
}

//DELETE
function usercreation_delete(delete_id)
{ 
	if(confirm("Are you sure?"))
	{
		$.ajax({
			type: "POST",
			url: "model/user_creation.php?action=DELETE&delete_id="+delete_id,
			success: function(data) {
				window.location.href = 'index1.php?filename=user_creation/admin';
			},
			error: function() {
				alert('error handing here');
			}
		});
	}
}

//VALIDATE
function validate_user_creation(user_type,staff_name,user_name,password,confirm_password)
{
	if(user_type==='') {$("#user_type").addClass('errorClass'); $("#user_type").focus(); return false;} else {$("#user_type").addClass('successClass');}

	if(staff_name==='') {$("#staff_name").addClass('errorClass'); $("#staff_name").focus(); return false;} else {$("#staff_name").addClass('successClass');}

	if(user_name==='') {$("#user_name").addClass('errorClass'); $("#user_name").focus(); return false;} else {$("#user_name").addClass('successClass');}

	if(password==='') {$("#password").addClass('errorClass'); $("#password").focus(); return false;} else {$("#password").addClass('successClass');}

	if(confirm_password==='') {$("#confirm_password").addClass('errorClass'); $("#confirm_password").focus(); return false;} else {$("#confirm_password").addClass('successClass');}
}

//User Status Update
function user_creation_status_update(user_id,user_status)
{
	if(confirm("Are you sure?"))
	{
		$.ajax({
			type: "POST",
			url: "model/user_creation.php?action=STATUS&user_id="+user_id+"&user_status="+user_status,
			success: function(data) {
				window.location.href = 'index1.php?filename=user_creation/admin';
			},
			error: function() {
				alert('error handing here');
			}
		});
	}
}

//user name
function get_user_name(user_type)
{
	$.ajax({
		type: "POST",
		url: "user_creation/staff_name.php?user_type="+user_type,
		success: function(data) {
			$("#staff_name_creation_div").html(data);
		},
		error: function() {
			alert('error handing here');
		}
	});	
}
