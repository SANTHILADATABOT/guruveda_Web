<?php
$sql = "SELECT * FROM sub_screen where screen_id=$_GET[update_id] ";
$rows = $db->fetch_all_array($sql);
foreach($rows as $record)
{
	$screen_name=$record['screen_name'];
	$sub_screen=$record['sub_screen'];
	$status=$record['status'];
}?>
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title"><h1>User Screen</h1></div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right"><li><a href="#">Home</a></li><li><a href="#">Admin</a></li><li class="active">User Screen </li></ol>
            </div>
        </div>
    </div>
    <div class="col-sm-1">
        <a href="index1.php?filename=user_screen/admin"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-toggle-left"></i> Back</button></a>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>User Screen</strong><small> Update</small></div>
                    <div class="card-body card-block">
                        <form name="user_screen_form" id="user_screen_form">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="company" class="form-control-label">User Screen</label>
                                    <select name="user_screen" id="user_screen" class="form-control">
                                        <option value="Admin" <?php if($screen_name=='Admin') { echo"selected";}?>>Admin</option>
                                        <option value="Master" <?php if($screen_name=='Master') { echo"selected";}?>>Master</option>
                                        <option value="Sales" <?php if($screen_name=='Inward') { echo"Inward";}?>>Inward</option>
                                        <option value="Sales" <?php if($screen_name=='Sales') { echo"Sales";}?>>Sales</option>
                                        <option value="Report" <?php if($screen_name=='Report') { echo"selected";}?>>Report</option>
                                         <option value="Others" <?php if($screen_name=='Others') { echo"selected";}?>>Others</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                               <div class="col col-md-4">
                                    <label for="company" class="form-control-label">Sub User Screen</label>
                                    <input type="text" id="sub_screen_name" name="sub_screen_name" class="form-control" value="<?php echo $sub_screen;?>">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-4"><label for="select" class="form-control-label">Status</label>
                                    <select name="user_screen_status" id="user_screen_status" class="form-control">
                                        <option value="1" <?php if($status=='1'){ echo "selected";}?>>Active</option>
                                        <option value="0" <?php if($status=='0'){ echo "selected";}?>>InActive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="button" class="btn btn-primary btn-sm" onClick="user_screen_update(user_screen.value,sub_screen_name.value,user_screen_status.value,'<?php echo $_GET['update_id'];?>')"><i class="fa fa-dot-circle-o"></i> Update</button>
                                <a href="index1.php?filename=user_screen/admin" style="float:right;"><button type="button" class="btn btn-secondary btn-sm">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>