<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title"><h1>User Screen</h1></div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right"><li><a href="#">Home</a></li><li><a href="#">Admin</a></li><li class="active">User Screen Add</li></ol>
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
                    <div class="card-header"><strong>User Screen</strong><small> Form</small></div>
                  	<div class="card-body card-block">
                        <form name="user_screen_form" id="user_screen_form">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="company" class="form-control-label">User Screen</label>
                                    <select name="user_screen" id="user_screen" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Master">Master</option>
                                        <option value="Inward">Inward</option>
                                        <option value="Sales">Sales</option>
                                        <option value="Report">Report</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-4">
                                    <label for="company" class="form-control-label">Sub User Screen</label>
                                    <input type="text" id="sub_screen_name" name="sub_screen_name" class="form-control">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-4"><label for="select" class="form-control-label">Status</label>
                                    <select name="user_screen_status" id="user_screen_status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">InActive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="button" class="btn btn-primary btn-sm" onClick="user_screen_submit(user_screen.value,sub_screen_name.value,user_screen_status.value)"><i class="fa fa-dot-circle-o"></i> Submit</button>
                                <a href="index1.php?filename=user_screen/admin" style="float:right;"><button type="button" class="btn btn-secondary btn-sm">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>