<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title"><h1>User Creation<small> Create</small></h1></div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right"><li><a href="#">Home</a></li><li><a href="#">Admin</a></li><li class="active">User Creation</li></ol>
            </div>
        </div>
    </div>
    <div class="col-sm-1">
        <a href="index1.php?filename=user_creation/admin"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-toggle-left"></i> Back</button></a>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body card-block">
                        <form name="user_creation_form" id="user_creation_form">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="company" class="form-control-label">User Type <span class="star">*</span></label>
                                    <select name="user_type" id="user_type" class="form-control" >
                                        <option value="">Select</option>
                                        <?php $sql = "SELECT * FROM user_type where delete_status!='1' order by user_type ASC";
                                        $rows = $db->fetch_all_array($sql);
                                        foreach($rows as $fetch_sql) {?>
                                            <option value="<?php echo htmlspecialchars($fetch_sql['user_type_id'] ?? '', ENT_QUOTES);?>"><?php echo htmlspecialchars($fetch_sql['user_type'] ?? '', ENT_QUOTES);?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="col col-md-4">
                                	<label for="company" class="form-control-label">Staff Name <span class="star">*</span></label>
                                    <div id="staff_name_creation_div">
                                    	<input type="text" id="staff_name" name="staff_name" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                             <div class="col col-md-4">
                                	<label for="company" class="form-control-label">User Name <span class="star">*</span></label>
                                    <input type="text" id="user_name" name="user_name" class="form-control">
                                    </div>
                                <div class="col col-md-4">
                                	<label for="company" class="form-control-label">Password <span class="star">*</span></label>
                                    <input type="password" id="password" name="password" class="form-control">
                                </div>
                                <div class="col col-md-4">
                                	<label for="company" class="form-control-label">Confirm Password <span class="star">*</span></label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-4">
                                    <label for="select" class="form-control-label">Status</label>
                                    <select name="user_status" id="user_status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">InActive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="button" class="btn btn-primary btn-sm" onClick="user_creation_submit(user_type.value,staff_name.value,user_name.value,password.value,confirm_password.value,user_status.value)"><i class="fa fa-dot-circle-o"></i> Submit</button>
                                <a href="index1.php?filename=user_creation/admin" style="float:right;"><button type="button" class="btn btn-secondary btn-sm">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>