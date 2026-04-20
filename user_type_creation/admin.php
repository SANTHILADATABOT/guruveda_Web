<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title"><h1>User Type Creation<small> List</small></h1></div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                
            </div>
        </div>
    </div>
    <div class="col-sm-1">
        <a href="index1.php?filename=user_type_creation/create"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> Create</button></a>
    </div>
</div>
<div class="content mt-3">
	<div class="animated fadeIn">
		<div class="row">
            <div class="col-md-12">
                <div class="card">
				    <div class="card-body">
                        <table id="bootstrap-data-table" class="table" width="100%">
                            <thead>
                                <tr>
                                    <th width="4%">SNo</th>
                                    <th width="43%">User Type</th>
                                    <th width="43%">Status</th>
                                    <th width="10%"><div align="center">Action</div></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i=0;
                                $sql = "SELECT * FROM user_type where delete_status!='1' order by user_type_id ASC";
                                $rows = $db->fetch_all_array($sql);
                                foreach($rows as $record)
                                {?>
                                    <tr>
                                        <td><?php echo $i=$i+1;?></td>
                                        <td><?php echo $record['user_type'];?></td>
                                        <td><?php if($record['status']=='1') {echo "Active";} else { echo "Inactive";}?></td>
                                        <td align="center">
                                        	<?php if($record['user_type_id']>'5'){?>
                                                <a href="index1.php?filename=user_type_creation/update&update_id=<?php echo $record['user_type_id'];?>"><i class="fa fa-edit fa-pencil-square-o"></i></a>
                                                <a href="#" title="Delete" onClick="usertype_delete('<?php echo $record['user_type_id']; ?>');"><i class="fa fa-delete fa-trash-o"></i></a>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php
                                }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>