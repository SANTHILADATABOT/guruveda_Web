// Add
function user_screen_submit(user_screen,sub_screen_name,user_screen_status)
{
	if((user_screen)&&(sub_screen_name))
	{
		var sendInfo = {
        	user_screen: user_screen,
			sub_screen_name: sub_screen_name,
			user_screen_status: user_screen_status,
		};
		$.ajax({
    		type: "POST",
			url: "model/user_screen.php?action=SUBMIT",
			data: sendInfo,
			success: function(data){
				window.location.href = 'index1.php?filename=user_screen/admin';
    		},
			error: function() {
				alert('error handing here');
			}
		});
	
	}
	else { validate_userscreen(user_screen,sub_screen_name); }
}
//Update
function user_screen_update(user_screen,sub_screen_name,user_screen_status,update_id)
{
	if((user_screen)&&(sub_screen_name))
	{
		var sendInfo = {
        	user_screen: user_screen,
			sub_screen_name: sub_screen_name,
			user_screen_status: user_screen_status,
			update_id: update_id,
		};
		$.ajax({
    		type: "POST",
			url: "model/user_screen.php?action=UPDATE&update_id="+update_id,
			data: sendInfo,
			success: function(data){
				window.location.href = 'index1.php?filename=user_screen/admin';
    		},
			error: function() {
				alert('error handing here');
			}
		});
	
	}
	else { validate_userscreen(user_screen,sub_screen_name); }
}

//DELETE
function userscreen_delete(delete_id)
{ 
	if(confirm("Are you sure?"))
	{
		$.ajax({
			type: "POST",
			url: "model/user_screen.php?action=DELETE&delete_id="+delete_id,
			success: function(data) {
				window.location.href = 'index1.php?filename=user_screen/admin';
			},
			error: function() {
				alert('error handing here');
			}
		});
	}
}

//VALIDATE
function validate_userscreen(user_screen,sub_screen_name)
{
	if(user_screen==='') {$("#user_screen").addClass('errorClass'); $("#user_screen").focus(); return false;}
	else {$("#user_screen").addClass('successClass');}
	
	if(sub_screen_name==='') {$("#sub_screen_name").addClass('errorClass'); $("#sub_screen_name").focus(); return false;}
	else {$("#sub_screen_name").addClass('successClass');}
}

