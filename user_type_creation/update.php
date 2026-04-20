<?php
$sql = "SELECT * FROM user_type where user_type_id=$_GET[update_id] ";
$rows = $db->fetch_all_array($sql);
foreach($rows as $record)
{
	$user_type=$record['user_type'];
	$status=$record['status'];
}?>
<div class="breadcrumbs">
	<div class="col-sm-4">
    	<div class="page-header float-left">
            <div class="page-title"><h1>User Type<small> Update</small></h1></div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right"><li><a href="#">Home</a></li><li><a href="#">Admin</a></li><li class="active">User Type</li></ol>
            </div>
        </div>
    </div>
    <div class="col-sm-1">
        <a href="index1.php?filename=user_type_creation/admin"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-toggle-left"></i> Back</button></a>
    </div>
</div>

<div class="content mt-3">
	<div class="animated fadeIn">
		<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body card-block">
                        <form name="user_type_form" id="user_type_form">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="company" class="form-control-label">User Type <span class="star">*</span></label>
                                    <input type="text" id="user_type" name="user_type" class="form-control" value="<?php echo $user_type; ?>">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-4"><label for="select" class="form-control-label">Status</label>
                                <select name="user_type_status" id="user_type_status" class="form-control">
                                    <option value="1" <?php if($status=='1'){ echo "selected";}?>>Active</option>
                                    <option value="0" <?php if($status=='0'){ echo "selected";}?>>InActive</option>
                                </select>
                                </div>
                            </div>

                         <div class="card-footer">
    <button type="button" class="btn btn-primary btn-sm"
        onclick="user_type_update('<?php echo $_GET['update_id']; ?>')">
        <i class="fa fa-dot-circle-o"></i> Update
    </button>

    <a href="index1.php?filename=user_type_creation/admin" style="float:right;">
        <button type="button" class="btn btn-secondary btn-sm">Cancel</button>
    </a>
</div>

                            
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>