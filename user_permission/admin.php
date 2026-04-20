<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title"><h1>User Permission<small> List</small></h1></div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="page-header float-right">
            <div class="page-title">
                
            </div>
        </div>
    </div>
    <div class="col-sm-1">
        <a href="index1.php?filename=user_permission/create"><button type="submit" class="btn btn-success btn-sm"><i class="fa fa-plus-square"></i> Create</button></a>
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
                                    <th width="23%">User Type</th>
                                    <th width="16%"><div align="center">Action</div></th>
                                </tr>
                            </thead>
                            <tbody>
								<?php $sql = "SELECT * FROM user_permission_main order by main_id ASC";
                                $rows = $db->fetch_all_array($sql);
                                foreach($rows as $record)
                                {?>
                                    <tr>
                                        <td><?php echo $i=$i+1; ?></td>
                                        <td><?php echo $record['user_name']; ?></td>
                                        <td align="center">
                                        	<a href="index1.php?filename=user_permission/create&edit_id=<?php echo $record['main_id'];?>&user_id=<?php echo $record['user_id']; ?>"><i class="fa fa-edit fa-pencil-square-o"></i></a>
                                        	<a href="#" title="Delete" onClick="user_permission_delete('<?php echo $record['main_id']; ?>','<?php echo $record['user_id']; ?>');"><i class="fa fa-delete fa-trash-o"></i></a>
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