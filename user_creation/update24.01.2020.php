<?php
$update_id = $_GET['update_id'] ?? '';
$sql = "SELECT * FROM user_creation where user_id='".$db->escape($update_id)."' ";
$rows = $db->fetch_all_array($sql);
foreach($rows as $record)
{
	$user_type=$record['user_type_id'] ?? '';
	$staff_id=$record['staff_id'] ?? '';
	$staff_name=$record['staff_name'] ?? '';
	$user_name=$record['user_name'] ?? '';
	$password=base64_decode($record['password'] ?? '');
	$confirm_password=base64_decode($record['confirm_password'] ?? '');
	$user_status=$record['user_status'] ?? '';
}?>
<div class="breadcrumbs">
	<div class="col-sm-4">
		<div class="page-header float-left">
			<div class="page-title"><h1>User Creation<small> Update</small></h1></div>
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
                                    <select name="user_type" id="user_type" class="form-control"  onChange="get_user_name(this.value)">
                                        <option value="">Select</option>
                                        <?php $sql="SELECT * FROM user_type where delete_status!='1' order by user_type ASC";
                                        $types = $db->fetch_all_array($sql);
                                        foreach($types as $fetch_sql)
                                        {?>
                                            <option value="<?php echo htmlspecialchars($fetch_sql['user_type_id'] ?? '', ENT_QUOTES)?>"<?php if($user_type==($fetch_sql['user_type_id'] ?? '')){ echo "selected";} ?>><?php echo htmlspecialchars($fetch_sql['user_type'] ?? '', ENT_QUOTES);?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="col col-md-4">
                                    <label for="company" class="form-control-label">Staff Name <span class="star">*</span></label>
                                        <div id="staff_name_creation_div">
                                        <?php if($user_type==2){?>
                                            <select name="staff_name" id="staff_name" class="form-control">
                                                <?php $sql1="SELECT * FROM distributor_creation where delete_status!='1' order by distributor_name ASC";
                                                $rows1 = $db->fetch_all_array($sql1);
                                                foreach($rows1 as $row1)
                                                {?>
                                                    <option value="<?php echo htmlspecialchars($row1['distributor_id'] ?? '', ENT_QUOTES);?>" <?php if(($row1['distributor_id'] ?? '')==$staff_id){echo "selected"; }?>><?php echo htmlspecialchars($row1['distributor_name'] ?? '', ENT_QUOTES);?></option>
                                                    <?php
                                                }?>
                                            </select>
                                            <?php
                                        }
                                        elseif($user_type==3){?>
                                            <select name="staff_name" id="staff_name" class="form-control">
                                                <?php $sql2="SELECT * FROM sales_ref_creation where delete_status!='1' order by sales_ref_name ASC";
                                                $rows2 = $db->fetch_all_array($sql2);
                                                foreach($rows2 as $row2)
                                                {?>
                                                    <option value="<?php echo htmlspecialchars($row2['sales_ref_id'] ?? '', ENT_QUOTES);?>" <?php if(($row2['sales_ref_id'] ?? '')==$staff_id){ echo "selected"; } ?>><?php echo htmlspecialchars($row2['sales_ref_name'] ?? '', ENT_QUOTES);?></option>
                                                    <?php
                                                }?>
                                            </select>
                                            <?php
                                        }
                                        elseif($user_type==4){?>
                                            <select name="staff_name" id="staff_name" class="form-control">
                                                <?php $sql3="SELECT * FROM dealer_creation where delete_status!='1' order by dealer_name ASC";
                                                $rows3 = $db->fetch_all_array($sql3);
                                                foreach($rows3 as $row3)
                                                {?>
                                                 <option value="<?php echo htmlspecialchars($row3['dealer_id'] ?? '', ENT_QUOTES);?>" <?php if(($row3['dealer_id'] ?? '')==$staff_id){ echo "selected"; } ?>><?php echo htmlspecialchars($row3['dealer_name'] ?? '', ENT_QUOTES);?></option>
                                                    <?php
                                                }?>
                                            </select>
                                            <?php
                                        }
                                        elseif($user_type==5){?>
                                            <select name="staff_name" id="staff_name" class="form-control">
                                                <?php $sql4="SELECT * FROM sub_dealer_creation where delete_status!='1' order by sub_dealer_name ASC";
                                                $rows4 = $db->fetch_all_array($sql4);
                                                foreach($rows4 as $row4)
                                                {?>
                                                 <option value="<?php echo htmlspecialchars($row4['sub_dealer_id'] ?? '', ENT_QUOTES);?>" <?php if(($row4['sub_dealer_id'] ?? '')==$staff_id){ echo "selected"; } ?>><?php echo htmlspecialchars($row4['sub_dealer_name'] ?? '', ENT_QUOTES);?></option>
                                                    <?php
                                                }?>
                                            </select>
                                            <?php
                                        }
                                        else
                                        {?>
                                            <input type="text" id="staff_name" name="staff_name" class="form-control"  value="<?php echo $staff_name;?>" >
                                            <?php
                                        }?>
                                    </div>
                                </div>
							</div>

                            <div class="row form-group">
                                <div class="col col-md-4">
                                    <label for="company" class="form-control-label">User Name <span class="star">*</span></label>
                                    <input type="text" id="user_name" name="user_name" class="form-control" value="<?php echo $user_name;?>">
                                </div>
                                <div class="col col-md-4">
                                    <label for="company" class="form-control-label">Password <span class="star">*</span></label>
                                    <input type="password" id="password" name="password" class="form-control" value="<?php echo $password; ?>">
                                </div>
                                <div class="col col-md-4">
                                    <label for="company" class="form-control-label">Confirm Password <span class="star">*</span></label>
                                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-4">
                                    <label for="select" class="form-control-label">Status</label>
                                    <select name="user_status" id="user_status" class="form-control">
                                        <option value="1" <?php if($user_status=='1') { echo "selected";}?>>Active</option>
                                        <option value="0" <?php if($user_status=='0') { echo "selected";}?>>InActive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="button" class="btn btn-primary btn-sm" onClick="user_creation_update(user_type.value,staff_name.value,user_name.value,password.value,confirm_password.value,user_status.value,'<?php echo $_GET['update_id'];?>')"><i class="fa fa-dot-circle-o"></i> Update</button>
                                <a href="index1.php?filename=user_creation/admin" style="float:right;"><button type="button" class="btn btn-secondary btn-sm">Cancel</button></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>