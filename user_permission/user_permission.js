// ADD
function user_permission_add(user_name,dashboard_ent,admin_ent,master_ent,inward_ent,sales_ent,reports_ent,backup_ent,others_ent)
{
	if(user_name)
	{
		var sendInfo = {
			user_name: user_name,
			dashboard_ent: dashboard_ent,
			admin_ent: admin_ent,
			master_ent: master_ent,
			inward_ent: inward_ent,
			sales_ent: sales_ent,
			reports_ent: reports_ent,
			backup_ent: backup_ent,
			others_ent: others_ent,
		};
		$.ajax({
			type: "POST",
			url: "model/user_permission.php?action=Add",
			data: sendInfo,
			success: function(data) {
				window.location.href = 'index1.php?filename=user_permission/admin';
			},
			error: function() {
				alert('error handing here');
			}
		});
	} 
}

// DELETE
function user_permission_delete(main_id,user_id)
{ 
	if (confirm("Are you sure?"))
	{
		$.ajax({
		type: "POST",
		url: "model/user_permission.php?action=delete&delete_id="+main_id+'&user_id='+user_id,
		success: function(data) {
			window.location.href = 'index1.php?filename=user_permission/admin';
		},
		error: function() {
			alert('error handing here');
		}
		});
	}
}